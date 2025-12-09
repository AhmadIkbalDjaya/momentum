<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizRecapResource\Pages;
use App\Models\Quiz;

use Illuminate\Database\Eloquent\Builder;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuizRecapResource extends Resource
{
    protected static ?string $model = Quiz::class;
    protected static ?string $label = 'Recap';
    protected static ?string $navigationLabel = 'Recap';
    protected static ?string $navigationGroup = 'Quiz';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->school_category_id != null) {
                    return $query->where('school_category_id', auth()->user()->school_category_id);
                }
                return $query;
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('school_category.name')
                    ->label('Jenis Sekolah')
                    ->sortable(),
                TextColumn::make('quiz_type.description')
                    ->label('Tipe Quiz')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuizRecaps::route('/'),
            'view' => Pages\ViewQuizRecap::route('{record}')
        ];
    }

}
