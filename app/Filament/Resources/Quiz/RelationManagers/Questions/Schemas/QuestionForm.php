<?php

namespace App\Filament\Resources\Quiz\RelationManagers\Questions\Schemas;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class QuestionForm
{
    public static function configure(Schema $schema, Model $ownerRecord): Schema
    {
        if ($ownerRecord->quiz_type_id == 1) {
            return $schema
                ->columns(1)
                ->components([
                    self::questionEditor(),
                    self::optionsFieldset(),
                    self::correctAnswerRadio(),
                ]);
        } elseif ($ownerRecord->quiz_type_id == 2) {
            return $schema->columns(1)->components([
                self::questionEditor(),
                self::trueFalseAnswerRadio(),
            ]);
        } else {
            return $schema->columns(1)->components([
                self::questionEditor(),
            ]);
        }
    }

    private static function questionEditor(): TinyEditor
    {
        return self::editor('question', 'Soal', 'questions');
    }

    private static function optionsFieldset(): Fieldset
    {
        return Fieldset::make('Masukkan Pilihan')
            ->schema([
                self::optionEditor(0, 'A'),
                self::optionEditor(1, 'B'),
                self::optionEditor(2, 'C'),
                self::optionEditor(3, 'D'),
                self::optionEditor(4, 'E'),
            ])
            ->columns(1);
    }

    private static function optionEditor(int $index, string $label): TinyEditor
    {
        return self::editor("options.$index", "Pilihan $label", 'options');
    }

    private static function editor(string $name, string $label, string $directory): TinyEditor
    {
        return TinyEditor::make($name)
            ->label($label)
            ->fileAttachmentsDisk('public')
            ->fileAttachmentsVisibility('public')
            ->fileAttachmentsDirectory($directory)
            ->profile('custom1')
            ->required();
    }

    private static function correctAnswerRadio(): Radio
    {
        return Radio::make('correct_answer')
            ->label('Jawaban Benar')
            ->options([
                '0' => 'A',
                '1' => 'B',
                '2' => 'C',
                '3' => 'D',
                '4' => 'E',
            ])
            ->inline()
            ->inlineLabel(false)
            ->rules(['required']);
    }

    private static function trueFalseAnswerRadio(): Radio
    {
        return Radio::make('is_correct')
            ->label('Jawaban')
            ->options([
                '0' => 'Salah',
                '1' => 'Benar',
            ])
            ->inline()
            ->inlineLabel(false)
            ->rule(['required']);
    }
}
