<?php

namespace App\Filament\Resources\School\RelationManagers\Students\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class StudentForm
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
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->rules([
                            Password::defaults(),
                        ])
                        ->required(fn (string $context): bool => $context === 'create')
                        ->confirmed()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                        ->dehydrated(fn ($state) => filled($state)),
                    TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->revealable()
                        ->same('password')
                        ->required(fn (string $context): bool => $context === 'create')
                        ->dehydrated(fn ($state) => filled($state)),
                    Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->placeholder('Pilih Jenis Kelamin')
                        ->options(Gender::class)
                        ->required(),
                ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
