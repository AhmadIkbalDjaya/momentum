<?php

namespace App\Filament\Resources\QuizMonitoringResource\Pages;

use App\Filament\Resources\QuizMonitoringResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageQuizMonitorings extends ManageRecords
{
    protected static string $resource = QuizMonitoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
