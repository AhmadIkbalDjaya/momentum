<?php

namespace App\Filament\Resources\SchoolCategory\Schemas;

use App\Models\SchoolCategory;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SchoolCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->unique(table: SchoolCategory::class, column: 'name', ignoreRecord: true),
                    TextInput::make('description')
                        ->label('Deskripsi')
                        ->maxLength(255),
                ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
