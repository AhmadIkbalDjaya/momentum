<?php

namespace App\Filament\Resources\School\RelationManagers;

use App\Filament\Resources\School\RelationManagers\Students\Schemas\StudentForm;
use App\Filament\Resources\School\RelationManagers\Students\Schemas\StudentInfolist;
use App\Filament\Resources\School\RelationManagers\Students\Tables\StudentsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    protected static ?string $title = 'Siswa';

    protected static ?string $modelLabel = 'Siswa';

    protected static ?string $pluralModelLabel = 'Siswa';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return StudentForm::configure($schema);
    }

    public function infolist(Schema $schema): Schema
    {
        return StudentInfolist::configure($schema);
    }

    public function table(Table $table): Table
    {
        return StudentsTable::configure($table);
    }
}
