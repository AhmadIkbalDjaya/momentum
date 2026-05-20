<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Quiz\QuizResource;
use App\Filament\Resources\QuizRecap\QuizRecapResource;
use App\Models\Quiz;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

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
                    return QuizRecapResource::getEloquentQuery()->bySchoolCategory(auth()->user()->school_category_id)->limit(5);
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
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'inactive' => 'Tidak Aktif',
                            'upcoming' => 'Belum Berlangsung',
                            'ongoing' => 'Sedang Berlangsung',
                            'ended' => 'Telah Berakhir',
                            default => '-',
                        };
                    })
                    ->colors([
                        'gray' => 'inactive',
                        'warning' => 'upcoming',
                        'success' => 'ongoing',
                        'danger' => 'ended',
                    ]),
            ])
            ->recordActions([
                Action::make('detail')
                    ->url(fn (Quiz $record): string => QuizResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
