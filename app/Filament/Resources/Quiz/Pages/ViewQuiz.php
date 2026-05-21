<?php

namespace App\Filament\Resources\Quiz\Pages;

use App\Filament\Resources\Quiz\QuizResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewQuiz extends ViewRecord
{
    protected static string $resource = QuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Quiz')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('code')
                            ->label('Code Quiz'),
                        TextEntry::make('school_category.name')
                            ->label('Kategori Sekolah'),
                        TextEntry::make('quiz_type.description')
                            ->label('Jenis Quiz'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'inactive' => 'Tidak Aktif',
                                'upcoming' => 'Belum Berlangsung',
                                'ongoing' => 'Sedang Berlangsung',
                                'ended' => 'Telah Berakhir',
                                default => '-',
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'inactive' => 'gray',
                                'upcoming' => 'warning',
                                'ongoing' => 'success',
                                'ended' => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2),
                Section::make('Waktu & Pengaturan')
                    ->schema([
                        TextEntry::make('start_time')
                            ->label('Waktu Mulai')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('end_time')
                            ->label('Waktu Berakhir')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('duration')
                            ->label('Durasi')
                            ->suffix(' menit'),
                        IconEntry::make('is_active')
                            ->label('Tampilkan Quiz')
                            ->boolean(),
                        IconEntry::make('show_score')
                            ->label('Tampilkan Score')
                            ->boolean(),
                    ])
                    ->columns(2),
                Section::make('Audit')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Diperbarui Pada')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}
