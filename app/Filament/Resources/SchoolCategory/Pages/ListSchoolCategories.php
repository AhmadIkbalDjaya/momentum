<?php

namespace App\Filament\Resources\SchoolCategory\Pages;

use App\Filament\Resources\SchoolCategory\SchoolCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSchoolCategories extends ListRecords
{
    protected static string $resource = SchoolCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
