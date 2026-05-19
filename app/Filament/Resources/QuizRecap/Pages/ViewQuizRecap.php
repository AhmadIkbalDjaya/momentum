<?php

namespace App\Filament\Resources\QuizRecap\Pages;

use App\Filament\Resources\QuizRecap\QuizRecapResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuizRecap extends ViewRecord
{
    protected static string $resource = QuizRecapResource::class;

    protected static ?string $title = 'Rekap Quiz';

    protected string $view = 'filament.resources.quiz-recap-resource.pages.recap-quiz-page';
}
