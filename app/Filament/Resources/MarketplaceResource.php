<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarketplaceResource\Pages\CreateMarketplace;
use App\Filament\Resources\MarketplaceResource\Pages\EditMarketplace;
use App\Filament\Resources\MarketplaceResource\Pages\ListMarketplace;
use App\Models\Marketplace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MarketplaceResource extends Resource
{
    protected static ?string $model = Marketplace::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Produk';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Marketplace')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Marketplace')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\FileUpload::make('logo')
                    ->label('Logo Marketplace')
                    ->image()
                    ->directory('marketplaces')
                    ->maxSize(1024)
                    ->imageResizeMode('contain')
                    ->imageResizeTargetWidth('200')
                    ->imageResizeTargetHeight('200'),
                Forms\Components\TextInput::make('base_url')
                    ->label('URL Dasar')
                    ->placeholder('https://www.tokopedia.com')
                    ->url()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
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
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=random'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Marketplace')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_url')
                    ->label('URL')
                    ->limit(30)
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prices_count')
                    ->label('Jumlah Harga')
                    ->counts('prices')
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMarketplace::route('/'),
            'create' => CreateMarketplace::route('/create'),
            'edit' => EditMarketplace::route('/{record}/edit'),
        ];
    }
}
