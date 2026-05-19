<?php

namespace App\Filament\Resources\QuizRecap;

use App\Filament\Resources\QuizRecap\Pages\ManageQuizRecaps;
use App\Filament\Resources\QuizRecap\Pages\ViewQuizRecap;
use App\Filament\Resources\QuizRecap\Schemas\QuizRecapForm;
use App\Filament\Resources\QuizRecap\Tables\QuizRecapTable;
use App\Models\Quiz;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class QuizRecapResource extends Resource
{
    protected static ?string $slug = 'quiz-recaps';

    protected static ?string $model = Quiz::class;

    protected static ?string $label = 'Recap';

    protected static ?string $navigationLabel = 'Recap';

    protected static string|\UnitEnum|null $navigationGroup = 'Quiz';

    protected static ?int $navigationSort = 2;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    public static function form(Schema $schema): Schema
    {
        return QuizRecapForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuizRecapTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageQuizRecaps::route('/'),
            'view' => ViewQuizRecap::route('{record}'),
        ];
    }
}
