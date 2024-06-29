<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Filament\Resources\QuizResource\RelationManagers\QuestionsRelationManager;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResource extends Resource
{
    protected static ?string $label = "Quiz";
    protected static ?string $pluralLabel = "Quiz";
    protected static ?string $navigationLabel = "Quiz";
    protected static ?string $model = Quiz::class;
    protected static ?string $navigationGroup = "Quiz";
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make("name")->label("Name")
                        ->required(),
                    TextInput::make("code")->label("Code Kuiz")
                        ->required()
                        ->unique(table: Quiz::class, column: "code", ignoreRecord: true),
                    Select::make("school_category_id")
                        ->label("Kategori Sekolah")
                        // ->rules(["required|exists:school_categories,id"])
                        ->relationship(name: 'school_category', titleAttribute: 'name')
                        ->placeholder("Pilih Jenis Sekolah")
                        ->required(),
                    Select::make("quiz_type_id")
                        ->label("Jenis Quiz")
                        // ->rules(["required|exists:quiz_types,id"])
                        ->relationship(name: 'quiz_type', titleAttribute: 'description')
                        ->placeholder("Pilih Jenis Quiz")
                        ->required()
                        ->disabledOn("edit"),
                    Fieldset::make("Waktu Ujian")->schema([
                        DateTimePicker::make("start_time")
                            ->label("Waktu Mulai")
                            ->required()
                            ->before("end_time"),
                        DateTimePicker::make("end_time")
                            ->label("Waktu Berakhir")
                            ->required()
                            ->after("start_time"),
                        TextInput::make("duration")
                            ->label("Durasi (menit)")
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                    ])->columns(3),
                    Select::make("is_active")
                        ->label("Tampilkan Quiz")
                        ->options([
                            "0" => "Sembunyikan",
                            "1" => "Tampilkan",
                        ])
                        ->default("0"),
                    Select::make("show_score")
                        ->label("Tampilkan Score")
                        ->options([
                            "0" => "Sembunyikan",
                            "1" => "Tampilkan",
                        ])
                        ->default("0")
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
                    ->label("Nama")
                    ->sortable()
                    ->searchable(),
                TextColumn::make("code")
                    ->label("code")
                    ->searchable(),
                TextColumn::make("school_category.name")
                    ->label("Jenis Sekolah")
                    ->sortable(),
                TextColumn::make("quiz_type.description")
                    ->label("Tipe Quiz")
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
