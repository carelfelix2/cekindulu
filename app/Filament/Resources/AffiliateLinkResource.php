<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffiliateLinkResource\Pages\CreateAffiliateLink;
use App\Filament\Resources\AffiliateLinkResource\Pages\EditAffiliateLink;
use App\Filament\Resources\AffiliateLinkResource\Pages\ListAffiliateLink;
use App\Models\AffiliateLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AffiliateLinkResource extends Resource
{
    protected static ?string $model = AffiliateLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Afiliasi';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Link Afiliasi')->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('marketplace_id')
                    ->label('Marketplace')
                    ->relationship('marketplace', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('product_price_id')
                    ->label('Harga Produk (Opsional)')
                    ->relationship('productPrice', 'id')
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn ($record) => 'Rp' . number_format($record->price, 0, ',', '.') . ' - ' . ($record->seller_name ?? $record->marketplace->name))
                    ->helperText('Pilih harga spesifik jika link mengarah ke varian tertentu'),
                Forms\Components\TextInput::make('affiliate_url')
                    ->label('URL Afiliasi')
                    ->required()
                    ->url()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('campaign_name')
                    ->label('Nama Campaign')
                    ->maxLength(255)
                    ->placeholder('contoh: promo-ramadhan-2026'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                Forms\Components\TextInput::make('click_count')
                    ->label('Jumlah Klik')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Jumlah klik akan bertambah secara otomatis'),
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
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('marketplace.name')
                    ->label('Marketplace')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('campaign_name')
                    ->label('Campaign')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('affiliate_url')
                    ->label('URL Afiliasi')
                    ->limit(30)
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('click_count')
                    ->label('Klik')
                    ->sortable()
                    ->numeric(),
                Tables\Columns\TextColumn::make('clicks_count')
                    ->label('Total Klik (Log)')
                    ->counts('clicks')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
                Tables\Filters\SelectFilter::make('marketplace_id')
                    ->label('Marketplace')
                    ->relationship('marketplace', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAffiliateLink::route('/'),
            'create' => CreateAffiliateLink::route('/create'),
            'edit' => EditAffiliateLink::route('/{record}/edit'),
        ];
    }
}
