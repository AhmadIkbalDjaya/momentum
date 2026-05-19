<?php

namespace App\Filament\Resources\School\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SchoolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
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
                ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
