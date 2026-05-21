<?php

namespace App\Filament\Resources\Quiz\Pages;

use App\Filament\Resources\Quiz\QuizResource;
use Filament\Resources\Pages\ViewRecord;

class RecapQuiz extends ViewRecord
{
    protected static string $resource = QuizResource::class;

    protected static ?string $title = 'Rekap Quiz';

    protected string $view = 'filament.resources.quiz.pages.recap';

    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.resources.quizzes.index') => 'Quiz',
            null => 'Rekap',
        ];
    }
}
