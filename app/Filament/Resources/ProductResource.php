<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    // تعريب اسم الواجهة في لوحة التحكم
    protected static ?string $navigationLabel = 'المنتجات';
    protected static ?string $pluralModelLabel = 'المنتجات';
    protected static ?string $modelLabel = 'منتج';

    // أيقونة مناسبة للمنتجات
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_ar')
                    ->label('اسم المنتج (عربي)')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('name_en')
                    ->label('اسم المنتج (إنجليزي)')
                    ->maxLength(100)
                    ->default(null),

                // حقل اختيار الصنف (مرتبط بعلاقة category)
                Forms\Components\Select::make('category_id')
                    ->label('الصنف')
                    ->relationship('category', 'name_ar')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(50) // Limit the number of options loaded initially
                    ->getSearchResultsUsing(fn (string $search): array => \App\Models\Category::query()
                        ->where('name_ar', 'like', "%{$search}%")
                        ->orWhere('name_en', 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('name_ar', 'id')
                        ->toArray())
                    ->required(),

                Forms\Components\Textarea::make('description_ar')
                    ->label('الوصف (عربي)')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description_en')
                    ->label('الوصف (إنجليزي)')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('price')
                    ->label('السعر')
                    ->required()
                    ->numeric()
                    ->prefix('ريال'),

                Forms\Components\FileUpload::make('image_url')
                    ->label('صورة المنتج')
                    ->image()
                    ->disk('public')
                    ->directory('products'),

                Forms\Components\Toggle::make('is_active')
                    ->label('نشط؟')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('الاسم (عربي)')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name_en')
                    ->label('الاسم (إنجليزي)')
                    ->searchable(),

                // عرض اسم الصنف في الجدول
                Tables\Columns\TextColumn::make('category.name_ar')
                    ->label('الصنف')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image_url')
                    ->label('الصورة'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تعديل')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
