<?php

namespace App\Filament\Resources\Admin\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
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
                            Password::defaults(),
                        ])
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create'),
                    TextInput::make('password_confirmation')
                        ->password()
                        ->revealable()
                        ->rules([
                            Password::defaults(),
                        ])
                        ->label('Konfirmasi Password')
                        ->dehydrated(fn ($state) => filled($state))
                        ->same('password')
                        ->required(fn (string $context): bool => $context === 'create'),
                ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
