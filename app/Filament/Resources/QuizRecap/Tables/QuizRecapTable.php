<?php

namespace App\Filament\Resources\QuizRecap\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuizRecapTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->school_category_id != null) {
                    return $query->bySchoolCategory(auth()->user()->school_category_id);
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
                SelectFilter::make('school_category')
                    ->label('Jenis Sekolah')
                    ->relationship('school_category', 'name'),
                SelectFilter::make('quiz_type_id')
                    ->label('Jenis Quiz')
                    ->relationship('quiz_type', 'description'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
            ]);
    }
}
