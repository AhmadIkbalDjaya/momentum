<?php

namespace App\Filament\Resources\Quiz\Schemas;

use App\Models\Quiz;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class QuizForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name')->label('Name')
                        ->required(),
                    TextInput::make('code')->label('Code Kuiz')
                        ->required()
                        ->unique(table: Quiz::class, column: 'code', ignoreRecord: true),
                    Select::make('school_category_id')
                        ->label('Kategori Sekolah')
                        ->relationship(name: 'school_category', titleAttribute: 'name', modifyQueryUsing: fn ($query) => auth()->user()->school_category_id ? $query->where('id', auth()->user()->school_category_id) : $query)
                        ->default(function () {
                            if (auth()->user()->school_category_id != null) {
                                return auth()->user()->school_category_id;
                            }
                        })
                        ->placeholder('Pilih Jenis Sekolah')
                        ->required(),
                    Select::make('quiz_type_id')
                        ->label('Jenis Quiz')
                        ->relationship(name: 'quiz_type', titleAttribute: 'description')
                        ->placeholder('Pilih Jenis Quiz')
                        ->required()
                        ->disabledOn('edit'),
                    Fieldset::make('Waktu Ujian')->schema([
                        DateTimePicker::make('start_time')
                            ->label('Waktu Mulai')
                            ->required()
                            ->before('end_time'),
                        DateTimePicker::make('end_time')
                            ->label('Waktu Berakhir')
                            ->required()
                            ->after('start_time'),
                        TextInput::make('duration')
                            ->label('Durasi (menit)')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                    ])->columns(3),
                    Select::make('is_active')
                        ->label('Tampilkan Quiz')
                        ->options([
                            '0' => 'Sembunyikan',
                            '1' => 'Tampilkan',
                        ])
                        ->default('0'),
                    Select::make('show_score')
                        ->label('Tampilkan Score')
                        ->options([
                            '0' => 'Sembunyikan',
                            '1' => 'Tampilkan',
                        ])
                        ->default('0'),
                ])->columns(2),
            ]);
    }
}
