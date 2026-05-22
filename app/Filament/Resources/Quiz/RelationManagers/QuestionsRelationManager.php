<?php

namespace App\Filament\Resources\Quiz\RelationManagers;

use App\Filament\Resources\Quiz\RelationManagers\Questions\Schemas\QuestionForm;
use App\Filament\Resources\Quiz\RelationManagers\Questions\Tables\QuestionsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $title = 'Daftar Soal Quiz';

    protected static ?string $modelLabel = 'Soal';

    public function form(Schema $schema): Schema
    {
        return QuestionForm::configure($schema, $this->getOwnerRecord());
    }

    public function table(Table $table): Table
    {
        return QuestionsTable::configure($table, $this->getOwnerRecord());
    }
}
