<?php

namespace App\Filament\Resources\QuizRecap;

use App\Filament\Resources\QuizRecap\Schemas\QuizRecapForm;
use App\Filament\Resources\QuizRecap\Tables\QuizRecapTable;
use App\Models\Quiz;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class QuizRecapResource extends Resource
{
    protected static ?string $slug = 'quiz-recaps';

    protected static ?string $model = Quiz::class;

    protected static ?string $label = 'Recap';

    protected static ?string $navigationLabel = 'Recap';

    protected static ?string $navigationGroup = 'Quiz';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return QuizRecapForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return QuizRecapTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuizRecaps::route('/'),
            'view' => Pages\ViewQuizRecap::route('{record}'),
        ];
    }
}
