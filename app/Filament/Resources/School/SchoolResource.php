<?php

namespace App\Filament\Resources\School;

use App\Filament\Resources\School\Pages\CreateSchool;
use App\Filament\Resources\School\Pages\EditSchool;
use App\Filament\Resources\School\Pages\ListSchools;
use App\Filament\Resources\School\Pages\ViewSchool;
use App\Filament\Resources\School\RelationManagers\StudentsRelationManager;
use App\Filament\Resources\School\Schemas\SchoolForm;
use App\Filament\Resources\School\Schemas\SchoolInfolist;
use App\Filament\Resources\School\Tables\SchoolTable;
use App\Models\School;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SchoolResource extends Resource
{
    protected static ?string $slug = 'schools';

    protected static ?string $label = 'Sekolah';

    protected static ?string $pluralLabel = 'Sekolah';

    protected static ?string $navigationLabel = 'Sekolah';

    protected static ?string $model = School::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Data';

    protected static ?int $navigationSort = 1;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    public static function form(Schema $schema): Schema
    {
        return SchoolForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchoolTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SchoolInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchools::route('/'),
            'create' => CreateSchool::route('/create'),
            'view' => ViewSchool::route('/{record}'),
            'edit' => EditSchool::route('/{record}/edit'),
        ];
    }
}
