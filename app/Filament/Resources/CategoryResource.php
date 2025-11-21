<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str; // لاستخدام دالة Str::slug

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    // ===============================================
    // تعريب القائمة الجانبية والعناوين
    // ===============================================
    protected static ?string $navigationLabel = 'الأصناف';
    protected static ?string $pluralModelLabel = 'الأصناف';
    protected static ?string $modelLabel = 'صنف';
    
    // أيقونة الأصناف
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 1; // ترتيبها قبل المنتجات

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_ar')
                    ->label('اسم الصنف (عربي)')
                    ->required()
                    ->maxLength(100)
                    // توليد الـ Slug تلقائياً من الاسم العربي
                    ->live(onBlur: true) 
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                Forms\Components\TextInput::make('name_en')
                    ->label('اسم الصنف (إنجليزي)')
                    ->maxLength(100)
                    ->default(null),

                Forms\Components\TextInput::make('slug')
                    ->label('الرابط القصير (Slug)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),

                Forms\Components\Toggle::make('is_active')
                    ->label('نشط / معروض')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('الاسم (عربي)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('الرابط القصير')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}