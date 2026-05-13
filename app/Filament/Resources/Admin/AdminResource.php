<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\Schemas\AdminForm;
use App\Filament\Resources\Admin\Tables\AdminTable;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
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

    protected static ?string $navigationGroup = 'Data';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return AdminForm::configure($form);
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
