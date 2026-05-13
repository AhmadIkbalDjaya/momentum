<?php

namespace App\Filament\Resources\Student;

use App\Filament\Resources\Student\Schemas\StudentForm;
use App\Filament\Resources\Student\Tables\StudentTable;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $slug = 'students';

    protected static ?string $label = 'Siswa';

    protected static ?string $pluralLabel = 'Siswa';

    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $model = Student::class;

    protected static ?string $navigationGroup = 'Data';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return StudentForm::configure($form);
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
