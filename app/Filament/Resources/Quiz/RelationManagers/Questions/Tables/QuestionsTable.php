<?php

namespace App\Filament\Resources\Quiz\RelationManagers\Questions\Tables;

use App\Models\Option;
use App\Models\Question;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class QuestionsTable
{
    public static function configure(Table $table, Model $ownerRecord): Table
    {
        return $table
            ->recordTitleAttribute('Soal')
            ->columns([
                self::questionNumberColumn(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                self::createAction($ownerRecord),
            ])
            ->recordActions([
                self::viewAction($ownerRecord),
                self::editAction($ownerRecord),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function questionNumberColumn(): TextColumn
    {
        return TextColumn::make('question')
            ->getStateUsing(function (Model $record, stdClass $rowLoop) {
                return "Soal No.$rowLoop->iteration";
            })
            ->label('Soal No.')
            ->searchable();
    }

    private static function viewAction(Model $ownerRecord): ViewAction
    {
        return ViewAction::make()
            ->label('Detail')
            ->modalHeading('Detail Soal')
            ->infolist([
                Section::make('Soal')
                    ->schema([
                        TextEntry::make('question')
                            ->label('Soal')
                            ->html()
                            ->columnSpanFull(),
                    ]),
                ...($ownerRecord->quiz_type_id == 3 ? [] : [
                    Section::make('Pilihan Jawaban')
                        ->schema([
                            RepeatableEntry::make('options')
                                ->label('Pilihan')
                                ->schema([
                                    TextEntry::make('option')
                                        ->label('Jawaban')
                                        ->hiddenLabel()
                                        ->html()
                                        ->columnSpanFull(),
                                    IconEntry::make('is_correct')
                                        ->label('Jawaban Benar')
                                        ->boolean(),
                                ])
                                ->columns(2),
                        ]),
                ]),
            ]);
    }

    private static function createAction(Model $ownerRecord): CreateAction
    {
        return CreateAction::make()
            ->using(function (array $data, string $model) use ($ownerRecord): Model {
                return self::createQuestion($data, $model, $ownerRecord);
            });
    }

    private static function editAction(Model $ownerRecord): EditAction
    {
        return EditAction::make()
            ->mutateRecordDataUsing(function (array $data) use ($ownerRecord): array {
                return self::mutateRecordData($data, $ownerRecord);
            })
            ->using(function (Model $record, array $data) use ($ownerRecord): Model {
                return self::updateQuestion($record, $data, $ownerRecord);
            });
    }

    private static function createQuestion(array $data, string $model, Model $ownerRecord): Model
    {
        if ($ownerRecord->quiz_type_id == 1) {
            return self::createMultipleChoiceQuestion($data, $model, $ownerRecord);
        } elseif ($ownerRecord->quiz_type_id == 2) {
            return self::createTrueFalseQuestion($data, $model, $ownerRecord);
        }

        return Question::create([
            'quiz_id' => $ownerRecord->id,
            'question' => $data['question'],
        ]);
    }

    private static function createMultipleChoiceQuestion(array $data, string $model, Model $ownerRecord): Model
    {
        return DB::transaction(function () use ($data, $model, $ownerRecord) {
            $question = self::createQuestionRecord($data, $model, $ownerRecord);

            for ($i = 0; $i < 5; $i++) {
                self::createOption($question, $data['options'][$i], $data['correct_answer'] == $i);
            }

            return $question;
        });
    }

    private static function createTrueFalseQuestion(array $data, string $model, Model $ownerRecord): Model
    {
        return DB::transaction(function () use ($data, $model, $ownerRecord) {
            $question = self::createQuestionRecord($data, $model, $ownerRecord);

            for ($i = 0; $i < 2; $i++) {
                self::createOption($question, $i == 0 ? 'Salah' : 'Benar', $i == $data['is_correct']);
            }

            return $question;
        });
    }

    private static function createQuestionRecord(array $data, string $model, Model $ownerRecord): Model
    {
        return $model::create([
            'quiz_id' => $ownerRecord->id,
            'question' => $data['question'],
        ]);
    }

    private static function createOption(Model $question, string $option, bool $isCorrect): Option
    {
        $newOption = Option::create([
            'question_id' => $question->id,
            'option' => $option,
            'is_correct' => $isCorrect,
        ]);

        if ($isCorrect) {
            $question->update([
                'correct_answer_id' => $newOption->id,
            ]);
        }

        return $newOption;
    }

    private static function mutateRecordData(array $data, Model $ownerRecord): array
    {
        if ($ownerRecord->quiz_type_id == 1) {
            return self::mutateMultipleChoiceData($data);
        } elseif ($ownerRecord->quiz_type_id == 2) {
            return self::mutateTrueFalseData($data);
        }

        return $data;
    }

    private static function mutateMultipleChoiceData(array $data): array
    {
        $options = Option::where('question_id', $data['id'])->orderBy('id')->get();

        foreach ($options as $index => $option) {
            $data['options'][$index] = $option->option;
            if ($option->is_correct) {
                $data['correct_answer'] = $index;
            }
        }

        return $data;
    }

    private static function mutateTrueFalseData(array $data): array
    {
        $option = Option::where('question_id', $data['id'])
            ->isCorrect()
            ->first();

        $data['is_correct'] = $option->option == 'Benar' ? 1 : 0;

        return $data;
    }

    private static function updateQuestion(Model $record, array $data, Model $ownerRecord): Model
    {
        if ($ownerRecord->quiz_type_id == 1) {
            return self::updateMultipleChoiceQuestion($record, $data);
        } elseif ($ownerRecord->quiz_type_id == 2) {
            return self::updateTrueFalseQuestion($record, $data);
        }

        $record->update([
            'question' => $data['question'],
        ]);

        return $record;
    }

    private static function updateMultipleChoiceQuestion(Model $record, array $data): Model
    {
        DB::transaction(function () use ($record, $data) {
            $record->update([
                'question' => $data['question'],
                'correct_answer_id' => null,
            ]);

            Option::where('question_id', $record->id)->delete();

            for ($i = 0; $i < 5; $i++) {
                self::createOption($record, $data['options'][$i], $data['correct_answer'] == $i);
            }
        });

        return $record;
    }

    private static function updateTrueFalseQuestion(Model $record, array $data): Model
    {
        DB::transaction(function () use ($record, $data) {
            $record->update([
                'question' => $data['question'],
                'correct_answer_id' => null,
            ]);

            foreach ($record->options as $index => $option) {
                $option->update([
                    'is_correct' => $index == $data['is_correct'],
                ]);

                if ($index == $data['is_correct']) {
                    $record->update([
                        'correct_answer_id' => $option->id,
                    ]);
                }
            }
        });

        return $record;
    }
}
