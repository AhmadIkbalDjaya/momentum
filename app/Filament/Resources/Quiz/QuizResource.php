<?php

namespace App\Filament\Resources\Quiz;

use App\Filament\Resources\Quiz\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\Quiz\Schemas\QuizForm;
use App\Filament\Resources\Quiz\Tables\QuizTable;
use App\Models\Quiz;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    protected static ?string $slug = 'quizzes';

    protected static ?string $label = 'Quiz';

    protected static ?string $pluralLabel = 'Quiz';

    protected static ?string $navigationLabel = 'Quiz';

    protected static ?string $model = Quiz::class;

    protected static ?string $navigationGroup = 'Quiz';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return QuizForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return QuizTable::configure($table);
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
