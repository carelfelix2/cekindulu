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

class MarketplaceResource extends Resource
{
    protected static ?string $model = Marketplace::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->maxLength(255),
            Forms\Components\TextInput::make('title')->maxLength(255),
            Forms\Components\TextInput::make('slug')->maxLength(255),
            Forms\Components\Textarea::make('description')->columnSpanFull(),
            Forms\Components\Textarea::make('content')->columnSpanFull(),
            Forms\Components\TextInput::make('price')->numeric(),
            Forms\Components\TextInput::make('affiliate_url'),
            Forms\Components\TextInput::make('worth_it_score')->numeric(),
            Forms\Components\Toggle::make('is_active'),
            Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('status')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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
