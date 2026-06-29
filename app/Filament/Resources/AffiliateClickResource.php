<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffiliateClickResource\Pages\ListAffiliateClick;
use App\Models\AffiliateClick;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AffiliateClickResource extends Resource
{
    protected static ?string $model = AffiliateClick::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-rays';

    protected static ?string $navigationGroup = 'Afiliasi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Klik')->schema([
                Forms\Components\Select::make('affiliate_link_id')
                    ->label('Link Afiliasi')
                    ->relationship('affiliateLink', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->product->name . ' @ ' . $record->marketplace->name)
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Select::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'name')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Select::make('marketplace_id')
                    ->label('Marketplace')
                    ->relationship('marketplace', 'name')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('ip_address')
                    ->label('IP Address')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Textarea::make('user_agent')
                    ->label('User Agent')
                    ->rows(3)
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('referrer')
                    ->label('Referrer')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('affiliateLink.product.name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('affiliateLink.marketplace.name')
                    ->label('Marketplace')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('referrer')
                    ->label('Referrer')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Klik')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('marketplace_id')
                    ->label('Marketplace')
                    ->relationship('marketplace', 'name'),
                Tables\Filters\Filter::make('created_at')
                    ->label('Rentang Waktu')
                    ->form([
                        Forms\Components\DateTimePicker::make('created_from')
                            ->label('Dari'),
                        Forms\Components\DateTimePicker::make('created_until')
                            ->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn ($q, $v) => $q->where('created_at', '>=', $v))
                            ->when($data['created_until'], fn ($q, $v) => $q->where('created_at', '<=', $v));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAffiliateClick::route('/'),
        ];
    }
}
