<?php

namespace App\Filament\Resources\Student;

use App\Filament\Resources\Student\Pages\CreateStudent;
use App\Filament\Resources\Student\Pages\EditStudent;
use App\Filament\Resources\Student\Pages\ListStudents;
use App\Filament\Resources\Student\Schemas\StudentForm;
use App\Filament\Resources\Student\Tables\StudentTable;
use App\Models\Student;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $slug = 'students';

    protected static ?string $label = 'Siswa';

    protected static ?string $pluralLabel = 'Siswa';

    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $model = Student::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Data';

    protected static ?int $navigationSort = 2;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    public static function form(Schema $schema): Schema
    {
        return StudentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}
