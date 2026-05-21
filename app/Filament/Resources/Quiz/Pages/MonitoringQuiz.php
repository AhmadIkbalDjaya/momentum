<?php

namespace App\Filament\Resources\Quiz\Pages;

use App\Filament\Resources\Quiz\QuizResource;
use Filament\Resources\Pages\ViewRecord;

class MonitoringQuiz extends ViewRecord
{
    protected static string $resource = QuizResource::class;

    protected static ?string $title = 'Monitor Quiz';

    protected string $view = 'filament.resources.quiz.pages.monitoring';

    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.resources.quizzes.index') => 'Quiz',
            null => 'Monitor',
        ];
    }
}
