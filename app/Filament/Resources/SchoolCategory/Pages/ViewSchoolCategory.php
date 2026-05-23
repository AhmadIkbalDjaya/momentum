<?php

namespace App\Filament\Resources\SchoolCategory\Pages;

use App\Filament\Resources\SchoolCategory\SchoolCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSchoolCategory extends ViewRecord
{
    protected static string $resource = SchoolCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
