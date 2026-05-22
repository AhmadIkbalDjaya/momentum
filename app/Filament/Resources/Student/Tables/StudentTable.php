<?php

namespace App\Filament\Resources\Student\Tables;

use App\Models\SchoolCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                TextColumn::make('name')
                    ->label('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('username')
                    ->label('username')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('school.name')
                    ->label('sekolah')
                    ->sortable(),
                TextColumn::make('gender')
                    ->label('jenis kelamin')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->options(fn () => SchoolCategory::pluck('name', 'id')->toArray())
                    ->query(function (Builder $query, array $data) {
                        if (filled($data['value'])) {
                            $query->whereHas('school', function ($query) use ($data) {
                                $query->where('school_category_id', $data['value']);
                            });
                        }
                    }),
            ])
            ->recordActions([
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
