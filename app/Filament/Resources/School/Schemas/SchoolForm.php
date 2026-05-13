<?php

namespace App\Filament\Resources\School\Schemas;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class SchoolForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name')
                        ->label('Nama')
                        ->rules(['required'])
                        ->required(),
                    Select::make('school_category_id')
                        ->label('Kategori Sekolah')
                        ->relationship(
                            name: 'category',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn ($query) => auth()->user()->school_category_id ? $query->where('id', auth()->user()->school_category_id) : $query
                        )
                        ->default(function () {
                            if (auth()->user()->school_category_id != null) {
                                return auth()->user()->school_category_id;
                            }
                        })
                        ->placeholder('Pilih Jenis Sekolah')
                        ->required(),
                ])->columns(2),
            ]);
    }
}
