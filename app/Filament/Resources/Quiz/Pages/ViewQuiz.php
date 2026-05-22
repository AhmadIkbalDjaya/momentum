<?php

namespace App\Filament\Resources\Quiz\Pages;

use App\Filament\Resources\Quiz\QuizResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewQuiz extends ViewRecord
{
    protected static string $resource = QuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
