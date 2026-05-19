<?php

namespace App\Filament\Resources\QuizRecap\Pages;

use App\Filament\Resources\QuizRecap\QuizRecapResource;
use Filament\Resources\Pages\ManageRecords;

class ManageQuizRecaps extends ManageRecords
{
    protected static string $resource = QuizRecapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
