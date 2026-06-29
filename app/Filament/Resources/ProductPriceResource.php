<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductPriceResource\Pages\CreateProductPrice;
use App\Filament\Resources\ProductPriceResource\Pages\EditProductPrice;
use App\Filament\Resources\ProductPriceResource\Pages\ListProductPrice;
use App\Models\ProductPrice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductPriceResource extends Resource
{
    protected static ?string $model = ProductPrice::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Produk';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Harga')->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\Select::make('marketplace_id')
                    ->label('Marketplace')
                    ->relationship('marketplace', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('seller_name')
                    ->label('Nama Toko')
                    ->maxLength(255)
                    ->placeholder('contoh: Toko Elektronik Jaya'),
                Forms\Components\TextInput::make('product_url')
                    ->label('URL Produk')
                    ->required()
                    ->url()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Detail Harga')->schema([
                Forms\Components\TextInput::make('price')
                    ->label('Harga (Rp)')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('original_price')
                    ->label('Harga Asli (Rp)')
                    ->numeric()
                    ->minValue(0)
                    ->helperText('Harga sebelum diskon'),
                Forms\Components\TextInput::make('discount')
                    ->label('Diskon')
                    ->placeholder('contoh: 50% atau Rp 100.000')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_recommended')
                    ->label('Rekomendasi')
                    ->default(false),
            ])->columns(2),

            Forms\Components\Section::make('Rating & Penjualan')->schema([
                Forms\Components\TextInput::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->step(0.1)
                    ->minValue(0)
                    ->maxValue(5)
                    ->placeholder('0.0 - 5.0'),
                Forms\Components\TextInput::make('sold_count')
                    ->label('Terjual')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Forms\Components\TextInput::make('review_count')
                    ->label('Ulasan')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Forms\Components\DateTimePicker::make('last_updated_at')
                    ->label('Terakhir Update')
                    ->native(false)
                    ->default(now()),
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
                Tables\Columns\TextColumn::make('seller_name')
                    ->label('Toko')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('original_price')
                    ->label('Harga Asli')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp' . number_format($state, 0, ',', '.') : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('discount')
                    ->label('Diskon')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_recommended')
                    ->label('Rekomendasi')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_updated_at')
                    ->label('Update')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('marketplace_id')
                    ->label('Marketplace')
                    ->relationship('marketplace', 'name'),
                Tables\Filters\TernaryFilter::make('is_recommended')
                    ->label('Rekomendasi'),
                Tables\Filters\Filter::make('price_range')
                    ->label('Range Harga')
                    ->form([
                        Forms\Components\TextInput::make('price_from')
                            ->label('Harga Minimal')
                            ->numeric(),
                        Forms\Components\TextInput::make('price_to')
                            ->label('Harga Maksimal')
                            ->numeric(),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['price_from'], fn ($q, $v) => $q->where('price', '>=', $v))
                            ->when($data['price_to'], fn ($q, $v) => $q->where('price', '<=', $v));
                    }),
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
            'index' => ListProductPrice::route('/'),
            'create' => CreateProductPrice::route('/create'),
            'edit' => EditProductPrice::route('/{record}/edit'),
        ];
    }
}
