<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitResource\Pages;
use App\Filament\Resources\VisitResource\RelationManagers;
use App\Models\Visit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'التقارير';
    protected static ?string $modelLabel = 'تقرير';
    protected static ?string $pluralModelLabel = 'التقارير';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ip_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('browser')
                    ->maxLength(255),
                Forms\Components\TextInput::make('platform')
                    ->label('نظام التشغيل')
                    ->maxLength(255),
                Forms\Components\TextInput::make('device')
                    ->label('نوع الجهاز')
                    ->maxLength(255),
                Forms\Components\TextInput::make('page_url')
                    ->label('رابط الصفحة')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->label('البلد')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('المدينة')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ والوقت')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('عنوان IP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('البلد')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('browser')
                    ->label('المتصفح')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('platform')
                    ->label('نظام التشغيل')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('device')
                    ->label('نوع الجهاز')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('page_url')
                    ->label('الصفحة')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->page_url),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('browser')
                    ->label('تصفية حسب المتصفح')
                    ->options(fn () => Visit::query()->pluck('browser', 'browser')->unique()),
                Tables\Filters\SelectFilter::make('platform')
                    ->label('تصفية حسب نظام التشغيل')
                    ->options(fn () => Visit::query()->pluck('platform', 'platform')->unique()),
                Tables\Filters\SelectFilter::make('device')
                    ->label('تصفية حسب نوع الجهاز')
                    ->options(fn () => Visit::query()->pluck('device', 'device')->unique()),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('من تاريخ'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListVisits::route('/'),
            'create' => Pages\CreateVisit::route('/create'),
            'view' => Pages\ViewVisit::route('/{record}'),
            'edit' => Pages\EditVisit::route('/{record}/edit'),
        ];
    }
}