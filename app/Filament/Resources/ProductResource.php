<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProduct;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Produk';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Produk')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->required()
                    ->default('draft'),
                Forms\Components\TextInput::make('worth_it_score')
                    ->label('Worth It Score')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(70)
                    ->suffix('%')
                    ->helperText('Skor 0-100, semakin tinggi semakin worth it'),
                Forms\Components\TextInput::make('admin_score_adjustment')
                    ->label('Penyesuaian Skor Admin')
                    ->numeric()
                    ->default(0)
                    ->helperText('Nilai tambahan/kurang dari admin (bisa negatif)'),
                Forms\Components\TextInput::make('lowest_price')
                    ->label('Harga Terendah (Rp)')
                    ->numeric()
                    ->minValue(0)
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Diisi otomatis berdasarkan harga termurah dari marketplace'),
            ])->columns(2),

            Forms\Components\Section::make('Deskripsi')->schema([
                Forms\Components\Textarea::make('short_description')
                    ->label('Deskripsi Singkat')
                    ->rows(2)
                    ->helperText('Ringkasan singkat untuk tampilan kartu produk'),
                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi Lengkap')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'orderedList', 'bulletList',
                        'h2', 'h3', 'blockquote',
                    ])
                    ->columnSpanFull(),
            ])->columns(1),

            Forms\Components\Section::make('Kelebihan & Kekurangan')->schema([
                Forms\Components\Repeater::make('pros')
                    ->label('Kelebihan (Pros)')
                    ->simple(
                        Forms\Components\TextInput::make('pro')
                            ->label('Kelebihan')
                            ->required(),
                    )
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Kelebihan'),
                Forms\Components\Repeater::make('cons')
                    ->label('Kekurangan (Cons)')
                    ->simple(
                        Forms\Components\TextInput::make('con')
                            ->label('Kekurangan')
                            ->required(),
                    )
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Kekurangan'),
            ])->columns(2),

            Forms\Components\Section::make('Spesifikasi')->schema([
                Forms\Components\Repeater::make('specifications')
                    ->label('Spesifikasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Nama Spesifikasi')
                            ->required(),
                        Forms\Components\TextInput::make('value')
                            ->label('Nilai')
                            ->required(),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Spesifikasi')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Media')->schema([
                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->directory('products/thumbnails')
                    ->maxSize(1024)
                    ->imageResizeMode('contain')
                    ->imageResizeTargetWidth('400')
                    ->imageResizeTargetHeight('400'),
            ])->columns(1),

            Forms\Components\Section::make('Pengaturan')->schema([
                Forms\Components\Toggle::make('is_featured')
                    ->label('Produk Unggulan')
                    ->default(false),
                Forms\Components\Toggle::make('is_trending')
                    ->label('Produk Trending')
                    ->default(false),
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
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=random'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('worth_it_score')
                    ->label('Skor')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->color(fn ($state): string => match(true) {
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('lowest_price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp' . number_format($state, 0, ',', '.') : '-')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_trending')
                    ->label('Trending')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'secondary',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('prices_count')
                    ->label('Harga')
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
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Produk Unggulan'),
                Tables\Filters\TernaryFilter::make('is_trending')
                    ->label('Produk Trending'),
                Tables\Filters\Filter::make('worth_it_score')
                    ->label('Min. Skor')
                    ->form([
                        Forms\Components\TextInput::make('min_score')
                            ->label('Skor Minimal')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['min_score'], fn ($q, $v) => $q->where('worth_it_score', '>=', $v));
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
            'index' => ListProduct::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
