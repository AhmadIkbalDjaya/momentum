<?php

namespace App\Filament\Resources\School\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchoolTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->school_category_id != null) {
                    return $query->where('school_category_id', auth()->user()->school_category_id);
                }

                return $query;
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Sekolah')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Jenis')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('school_category_id')
                    ->label('Jenis Sekolah')
                    ->options([
                        '1' => 'SMP',
                        '2' => 'SMA',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
