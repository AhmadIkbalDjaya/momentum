<?php

namespace App\Filament\Resources\School\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
                TextColumn::make('students_count')
                    ->label('Total Siswa')
                    ->counts('students')
                    ->sortable()
                    ->suffix(' Siswa'),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                ViewAction::make()
                    ->iconButton()
                    ->tooltip('Lihat'),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit'),
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
