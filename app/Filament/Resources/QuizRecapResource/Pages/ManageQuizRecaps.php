<?php

namespace App\Filament\Resources\QuizRecapResource\Pages;

use App\Filament\Resources\QuizRecapResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageQuizRecaps extends ManageRecords
{
    protected static string $resource = QuizRecapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
