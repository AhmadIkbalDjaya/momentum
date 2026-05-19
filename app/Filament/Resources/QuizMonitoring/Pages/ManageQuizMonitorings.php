<?php

namespace App\Filament\Resources\QuizMonitoring\Pages;

use App\Filament\Resources\QuizMonitoring\QuizMonitoringResource;
use Filament\Resources\Pages\ManageRecords;

class ManageQuizMonitorings extends ManageRecords
{
    protected static string $resource = QuizMonitoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
