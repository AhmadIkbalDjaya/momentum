<?php

namespace App\Filament\Resources\QuizMonitoring\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuizMonitoringTable
{
    public static function configure(Table $table): Table
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
                TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(function ($record): string {
                        $current_time = Carbon::now();
                        $start_time = Carbon::parse($record->start_time);
                        $end_time = Carbon::parse($record->end_time);
                        if ($current_time->lessThan($start_time)) {
                            return 'Belum Berlansung';
                        }
                        if ($current_time->between($start_time, $end_time)) {
                            return 'Sedang Berlansung';
                        }
                        if ($current_time->greaterThan($end_time)) {
                            return 'Telah Berakhir';
                        }

                        return '-';
                    })
                    ->colors([
                        'success' => 'Sedang Berlansung',
                        'warning' => 'Belum Berlansung',
                        'danger' => 'Telah Berakhir',
                        'info' => '-',
                    ]),
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
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
