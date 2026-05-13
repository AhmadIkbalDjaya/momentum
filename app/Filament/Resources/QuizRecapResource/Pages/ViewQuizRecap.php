<?php

namespace App\Filament\Resources\QuizRecapResource\Pages;

use App\Filament\Resources\QuizRecapResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuizRecap extends ViewRecord
{
    protected static string $resource = QuizRecapResource::class;

    protected static ?string $title = 'Rekap Quiz';

    protected static string $view = 'filament.resources.quiz-recap-resource.pages.recap-quiz-page';
}
