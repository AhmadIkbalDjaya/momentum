<?php

namespace App\Filament\Resources\School;

use App\Filament\Resources\School\Schemas\SchoolForm;
use App\Filament\Resources\School\Tables\SchoolTable;
use App\Models\School;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class SchoolResource extends Resource
{
    protected static ?string $slug = 'schools';

    protected static ?string $label = 'Sekolah';

    protected static ?string $pluralLabel = 'Sekolah';

    protected static ?string $navigationLabel = 'Sekolah';

    protected static ?string $model = School::class;

    protected static ?string $navigationGroup = 'Data';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return SchoolForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return SchoolTable::configure($table);
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
            'index' => Pages\ListSchools::route('/'),
        ];
    }
}
