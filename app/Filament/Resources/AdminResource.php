<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\User;

use Illuminate\Validation\Rules\Password;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hash;

class AdminResource extends Resource
{
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
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required(),
                    TextInput::make('username')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('email')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    Select::make('school_category_id')
                        ->label('Kategori Sekolah')
                        ->relationship(name: 'school_category', titleAttribute: 'name')
                        ->placeholder('Pilih Jenis Sekolah')
                        ->required(),
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->rules([
                            Password::defaults()
                        ])
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(string $context): bool => $context === 'create'),
                    TextInput::make('password_confirmation')
                        ->password()
                        ->revealable()
                        ->rules([
                            Password::defaults()
                        ])
                        ->label('Konfirmasi Password')
                        ->dehydrated(fn($state) => filled($state))
                        ->same('password')
                        ->required(fn(string $context): bool => $context === 'create'),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(
                function ($query) {
                    $query->where('school_category_id', '!=', null);
                }
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('username')
                    ->label('Username')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('school_category.name')
                    ->label('Jenis Sekolah')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
