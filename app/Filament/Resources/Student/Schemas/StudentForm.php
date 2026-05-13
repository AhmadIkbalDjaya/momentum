<?php

namespace App\Filament\Resources\Student\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Validation\Rules\Password;

class StudentForm
{
    public static function configure(Form $form): Form
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
                        ->placeholder('Pilih Jenis Jelamin')
                        ->options(Gender::class)
                        ->required(),
                    Select::make('school_id')
                        ->label('Sekolah')
                        ->placeholder('Pilih Sekolah')
                        ->relationship(
                            name: 'school',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn ($query) => auth()->user()->school_category_id ? $query->where('school_category_id', auth()->user()->school_category_id) : $query
                        )
                        ->searchable('name')
                        ->preload()
                        ->required(),
                ])->columns(2),
            ]);
    }
}
