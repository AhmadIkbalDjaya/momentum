<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\QuizRecapResource;
use App\Filament\Resources\QuizResource;
use App\Models\Quiz;

use Filament\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Carbon;

class LatestQuizzes extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    public static ?int $sort = 4;
    protected static ?string $heading = 'Quiz Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                if (auth()->user()->school_category_id != null) {
                    return QuizRecapResource::getEloquentQuery()->where('school_category_id', auth()->user()->school_category_id)->limit(5);
                }
                return QuizRecapResource::getEloquentQuery()->limit(5);
            })
            ->paginated(false)
            ->defaultPaginationPageOption(2)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama'),
                TextColumn::make('school_category.name')
                    ->label('Jenis Sekolah'),
                TextColumn::make('quiz_type.description')
                    ->label('Tipe Quiz'),
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
                    ])
            ])
            ->actions([
                Tables\Actions\Action::make('detail')
                    ->url(fn(Quiz $record): string => QuizResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
