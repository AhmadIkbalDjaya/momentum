<?php

namespace App\Filament\Resources\Quiz;

use App\Filament\Resources\Quiz\Pages\CreateQuiz;
use App\Filament\Resources\Quiz\Pages\EditQuiz;
use App\Filament\Resources\Quiz\Pages\ListQuizzes;
use App\Filament\Resources\Quiz\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\Quiz\Schemas\QuizForm;
use App\Filament\Resources\Quiz\Tables\QuizTable;
use App\Models\Quiz;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    protected static ?string $slug = 'quizzes';

    protected static ?string $label = 'Quiz';

    protected static ?string $pluralLabel = 'Quiz';

    protected static ?string $navigationLabel = 'Quiz';

    protected static ?string $model = Quiz::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Quiz';

    protected static ?int $navigationSort = 1;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Schema $schema): Schema
    {
        return QuizForm::configure($schema);
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
            'index' => ListQuizzes::route('/'),
            'create' => CreateQuiz::route('/create'),
            'edit' => EditQuiz::route('/{record}/edit'),
        ];
    }
}
