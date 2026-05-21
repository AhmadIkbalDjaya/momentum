<?php

namespace App\Filament\Resources\School\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SchoolInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sekolah')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Sekolah'),
                        TextEntry::make('category.name')
                            ->label('Jenis Sekolah'),
                        TextEntry::make('students_count')
                            ->label('Total Siswa')
                            ->counts('students')
                            ->suffix(' Siswa'),
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
