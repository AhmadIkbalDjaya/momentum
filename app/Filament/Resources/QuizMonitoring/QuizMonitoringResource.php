<?php

namespace App\Filament\Resources\QuizMonitoring;

use App\Filament\Resources\QuizMonitoring\Pages\ManageQuizMonitorings;
use App\Filament\Resources\QuizMonitoring\Pages\MonitoringQuiz;
use App\Filament\Resources\QuizMonitoring\Schemas\QuizMonitoringForm;
use App\Filament\Resources\QuizMonitoring\Tables\QuizMonitoringTable;
use App\Models\Quiz;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class QuizMonitoringResource extends Resource
{
    protected static ?string $slug = 'quiz-monitorings';

    protected static ?string $model = Quiz::class;

    protected static ?string $label = 'Monitoring';

    protected static ?string $navigationLabel = 'Monitoring';

    protected static string|\UnitEnum|null $navigationGroup = 'Quiz';

    protected static ?int $navigationSort = 3;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-video-camera';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return QuizMonitoringForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuizMonitoringTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageQuizMonitorings::route('/'),
            'view' => MonitoringQuiz::route('{record}'),
        ];
    }
}
