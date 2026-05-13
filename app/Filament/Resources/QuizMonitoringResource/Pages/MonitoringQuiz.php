<?php

namespace App\Filament\Resources\QuizMonitoringResource\Pages;

use App\Filament\Resources\QuizMonitoringResource;
use Filament\Resources\Pages\ViewRecord;

class MonitoringQuiz extends ViewRecord
{
    protected static string $resource = QuizMonitoringResource::class;

    protected static ?string $title = 'Monitor Quiz';

    protected static string $view = 'filament.resources.quiz-monitoring-resource.pages.monitoring-quiz';
}
