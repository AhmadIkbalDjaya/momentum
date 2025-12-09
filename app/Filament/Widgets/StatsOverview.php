<?php

namespace App\Filament\Widgets;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Student;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Quiz', function () {
                if (auth()->user()->school_category_id != null) {
                    return Quiz::where('school_category_id', auth()->user()->school_category_id)->count();
                }
                return Quiz::count();
            })
                ->description('Total Quiz Tersedia')
                ->descriptionIcon('heroicon-o-pencil-square')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Siswa', function () {
                if (auth()->user()->school_category_id != null) {
                    return Student::whereHas('school', function ($query) {
                        $query->where('school_category_id', auth()->user()->school_category_id);
                    })->count();
                }
                return Student::count();
            })
                ->description('Total Siswa')
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([12, 13, 14, 15, 14, 16, 17]),
            Stat::make('Soal', function () {
                if (auth()->user()->school_category_id != null) {
                    return Question::whereHas('quiz', function ($query) {
                        $query->where('school_category_id', auth()->user()->school_category_id);
                    })->count();
                }
                return Question::count();
            })
                ->description('Total Pertanyaan')
                ->descriptionIcon('heroicon-o-question-mark-circle')
                ->color('danger')
                ->chart([15, 4, 10, 2, 12, 4, 12]),
        ];
    }
}
