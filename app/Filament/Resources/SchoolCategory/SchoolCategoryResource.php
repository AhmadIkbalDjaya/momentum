<?php

namespace App\Filament\Resources\SchoolCategory;

use App\Filament\Resources\SchoolCategory\Pages\CreateSchoolCategory;
use App\Filament\Resources\SchoolCategory\Pages\EditSchoolCategory;
use App\Filament\Resources\SchoolCategory\Pages\ListSchoolCategories;
use App\Filament\Resources\SchoolCategory\Pages\ViewSchoolCategory;
use App\Filament\Resources\SchoolCategory\Schemas\SchoolCategoryForm;
use App\Filament\Resources\SchoolCategory\Schemas\SchoolCategoryInfolist;
use App\Filament\Resources\SchoolCategory\Tables\SchoolCategoryTable;
use App\Models\SchoolCategory;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SchoolCategoryResource extends Resource
{
    protected static ?string $slug = 'school-categories';

    protected static ?string $label = 'Kategori Sekolah';

    protected static ?string $pluralLabel = 'Kategori Sekolah';

    protected static ?string $navigationLabel = 'Kategori Sekolah';

    protected static ?string $model = SchoolCategory::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Data';

    protected static ?int $navigationSort = 0;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user !== null && $user->school_category_id === null;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function form(Schema $schema): Schema
    {
        return SchoolCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchoolCategoryTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SchoolCategoryInfolist::configure($schema);
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
            'index' => ListSchoolCategories::route('/'),
            'create' => CreateSchoolCategory::route('/create'),
            'view' => ViewSchoolCategory::route('/{record}'),
            'edit' => EditSchoolCategory::route('/{record}/edit'),
        ];
    }
}
