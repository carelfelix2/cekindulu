<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\UserMembership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Membership';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Transaksi')->schema([
                Forms\Components\TextInput::make('invoice_number')
                    ->label('Invoice')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Select::make('membership_plan_id')
                    ->label('Paket')
                    ->relationship('membershipPlan', 'name')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('amount')
                    ->label('Jumlah')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 0, ',', '.')),
                Forms\Components\TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('status')
                    ->label('Status')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\DateTimePicker::make('paid_at')
                    ->label('Dibayar Pada')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->label('Batas Pembayaran')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Textarea::make('admin_notes')
                    ->label('Catatan Admin')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Bukti Pembayaran')->schema([
                Forms\Components\ViewField::make('payment_proof_preview')
                    ->label('Preview Bukti Transfer')
                    ->view('filament.components.payment-proof-view'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('membershipPlan.name')
                    ->label('Paket')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'expired' => 'secondary',
                        'cancelled' => 'secondary',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('membership_plan_id')
                    ->label('Paket')
                    ->relationship('membershipPlan', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Transaction $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Approve Transaksi')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui transaksi ini? Membership akan aktif secara otomatis.')
                    ->action(function (Transaction $record) {
                        $record->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        // Create user membership record
                        UserMembership::create([
                            'user_id' => $record->user_id,
                            'membership_plan_id' => $record->membership_plan_id,
                            'transaction_id' => $record->id,
                            'started_at' => now(),
                            'ends_at' => now()->addDays($record->membershipPlan->duration_days),
                            'is_active' => true,
                        ]);

                        Notification::make()
                            ->title('Transaksi berhasil diapprove')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Transaction $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Reject Transaksi')
                    ->modalDescription('Apakah Anda yakin ingin menolak transaksi ini?')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Transaction $record, array $data) {
                        $record->update([
                            'status' => 'failed',
                            'admin_notes' => $data['admin_notes'],
                        ]);

                        Notification::make()
                            ->title('Transaksi ditolak')
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'view' => Pages\ViewTransaction::route('/{record}'),
        ];
    }
}
