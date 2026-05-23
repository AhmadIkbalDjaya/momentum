<?php

namespace App\Filament\Resources\SchoolCategory\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchoolCategoryTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->toggleable()
                    ->limit(25),
                TextColumn::make('schools_count')
                    ->label('Total Sekolah')
                    ->counts('schools')
                    ->sortable()
                    ->suffix(' Sekolah'),
                TextColumn::make('quizzes_count')
                    ->label('Total Quiz')
                    ->counts('quizzes')
                    ->sortable()
                    ->suffix(' Quiz'),
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
                //
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
                    ->tooltip('Hapus')
                    ->failureNotificationTitle('Kategori sekolah tidak dapat dihapus')
                    ->failureNotificationBody('Kategori sekolah masih digunakan oleh data lain.'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->missingBulkProcessingFailureNotificationMessage(
                            fn (int $count): string => "{$count} kategori sekolah tidak dapat dihapus karena masih digunakan."
                        ),
                ]),
            ]);
    }
}
