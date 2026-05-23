<?php

namespace App\Filament\Resources\SchoolCategory\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SchoolCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori Sekolah')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->placeholder('-'),
                        TextEntry::make('schools_count')
                            ->label('Total Sekolah')
                            ->counts('schools')
                            ->suffix(' Sekolah'),
                        TextEntry::make('quizzes_count')
                            ->label('Total Quiz')
                            ->counts('quizzes')
                            ->suffix(' Quiz'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
                Section::make('Audit')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Diperbarui Pada')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
