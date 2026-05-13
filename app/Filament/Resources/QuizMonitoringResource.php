<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizMonitoringResource\Pages;
use App\Models\Quiz;

use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuizMonitoringResource extends Resource
{
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
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->school_category_id != null) {
                    return $query->where('school_category_id', auth()->user()->school_category_id);
                }
                return $query;
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('school_category.name')
                    ->label('Jenis Sekolah')
                    ->sortable(),
                TextColumn::make('quiz_type.description')
                    ->label('Tipe Quiz')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(function ($record): string {
                        $current_time = Carbon::now();
                        $start_time = Carbon::parse($record->start_time);
                        $end_time = Carbon::parse($record->end_time);
                        if ($current_time->lessThan($start_time)) {
                            return 'Belum Berlansung';
                        }
                        if ($current_time->between($start_time, $end_time)) {
                            return 'Sedang Berlansung';
                        }
                        if ($current_time->greaterThan($end_time)) {
                            return 'Telah Berakhir';
                        }
                        return '-';
                    })
                    ->colors([
                        'success' => 'Sedang Berlansung',
                        'warning' => 'Belum Berlansung',
                        'danger' => 'Telah Berakhir',
                        'info' => '-',
                    ])
            ])
            ->filters([
                SelectFilter::make('school_category')
                    ->label("Jenis Sekolah")
                    ->relationship('school_category', 'name'),
                SelectFilter::make('quiz_type_id')
                    ->label("Jenis Quiz")
                    ->relationship('quiz_type', 'description')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuizMonitorings::route('/'),
            'view' => Pages\MonitoringQuiz::route('{record}')
        ];
    }
}
