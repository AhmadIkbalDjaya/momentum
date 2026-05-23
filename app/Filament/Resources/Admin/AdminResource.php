<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\Pages\CreateAdmin;
use App\Filament\Resources\Admin\Pages\EditAdmin;
use App\Filament\Resources\Admin\Pages\ListAdmins;
use App\Filament\Resources\Admin\Schemas\AdminForm;
use App\Filament\Resources\Admin\Tables\AdminTable;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AdminResource extends Resource
{
    /**
     * Keep URL paths stable after moving the class under Resources/Admin (otherwise Filament
     * would derive admin/admins from the nested namespace).
     */
    protected static ?string $slug = 'admins';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->school_category_id == null;
    }

    protected static ?string $label = 'Admin';

    protected static ?string $pluralLabel = 'Admin';

    protected static ?string $navigationLabel = 'Admin';

    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 3;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Schema $schema): Schema
    {
        return AdminForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminTable::configure($table);
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
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }
}
