<?php

namespace App\Filament\Resources\QuizMonitoring;

use App\Filament\Resources\QuizMonitoring\Schemas\QuizMonitoringForm;
use App\Filament\Resources\QuizMonitoring\Tables\QuizMonitoringTable;
use App\Models\Quiz;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class QuizMonitoringResource extends Resource
{
    protected static ?string $slug = 'quiz-monitorings';

    protected static ?string $model = Quiz::class;

    protected static ?string $label = 'Monitoring';

    protected static ?string $navigationLabel = 'Monitoring';

    protected static ?string $navigationGroup = 'Quiz';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return QuizMonitoringForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return QuizMonitoringTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuizMonitorings::route('/'),
            'view' => Pages\MonitoringQuiz::route('{record}'),
        ];
    }
}
