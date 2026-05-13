<?php

namespace App\Filament\Resources\Student\Tables;

use App\Models\SchoolCategory;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->school_category_id != null) {
                    return $query->whereHas('school', function ($query) {
                        $query->where('school_category_id', auth()->user()->school_category_id);
                    });
                }

                return $query;
            })
            ->columns([
                TextColumn::make('name')->label('name')->sortable()->searchable(),
                TextColumn::make('username')->label('username')->sortable()->searchable(),
                TextColumn::make('school.name')->label('sekolah')->sortable(),
                TextColumn::make('gender')->label('jenis kelamin')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('school_category_id')
                    ->label('Jenis Sekolah')
                    ->options(fn () => SchoolCategory::pluck('name', 'id')->toArray())
                    ->query(function (Builder $query, array $data) {
                        if (filled($data['value'])) {
                            $query->whereHas('school', function ($query) use ($data) {
                                $query->where('school_category_id', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
