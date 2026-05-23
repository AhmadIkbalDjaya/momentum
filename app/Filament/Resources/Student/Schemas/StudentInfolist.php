<?php

namespace App\Filament\Resources\Student\Schemas;

use App\Enums\Gender;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Siswa')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('username')
                            ->label('Username'),
                        TextEntry::make('school.name')
                            ->label('Sekolah'),
                        TextEntry::make('gender')
                            ->label('Jenis Kelamin')
                            ->formatStateUsing(fn (Gender $state): ?string => $state->getLabel()),
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
