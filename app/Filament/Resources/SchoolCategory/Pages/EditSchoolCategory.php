<?php

namespace App\Filament\Resources\SchoolCategory\Pages;

use App\Filament\Resources\SchoolCategory\SchoolCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSchoolCategory extends EditRecord
{
    protected static string $resource = SchoolCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->tooltip('Hapus')
                ->failureNotificationTitle('Kategori sekolah tidak dapat dihapus')
                ->failureNotificationBody('Kategori sekolah masih digunakan oleh data lain.'),
        ];
    }
}
