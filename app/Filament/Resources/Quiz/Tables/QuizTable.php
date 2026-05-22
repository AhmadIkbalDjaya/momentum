<?php

namespace App\Filament\Resources\Quiz\Tables;

use App\Filament\Resources\Quiz\QuizResource;
use App\Models\Quiz;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuizTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->school_category_id != null) {
                    return $query->bySchoolCategory(auth()->user()->school_category_id);
                }

                return $query;
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('code')
                    ->label('code')
                    ->searchable(),
                TextColumn::make('school_category.name')
                    ->label('Jenis Sekolah')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('quiz_type.description')
                    ->label('Tipe Quiz')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'inactive' => 'Tidak Aktif',
                            'upcoming' => 'Belum Berlangsung',
                            'ongoing' => 'Sedang Berlangsung',
                            'ended' => 'Telah Berakhir',
                            default => '-',
                        };
                    })
                    ->colors([
                        'gray' => 'inactive',
                        'warning' => 'upcoming',
                        'success' => 'ongoing',
                        'danger' => 'ended',
                    ]),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('school_category')
                    ->label('Jenis Sekolah')
                    ->relationship('school_category', 'name'),
                SelectFilter::make('quiz_type_id')
                    ->label('Jenis Quiz')
                    ->relationship('quiz_type', 'description'),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'inactive' => 'Tidak Aktif',
                        'upcoming' => 'Belum Berlangsung',
                        'ongoing' => 'Sedang Berlangsung',
                        'ended' => 'Telah Berakhir',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $status = $data['value'] ?? null;

                        if (blank($status)) {
                            return $query;
                        }

                        $now = now();

                        return match ($status) {
                            'inactive' => $query->where(function (Builder $query) {
                                $query
                                    ->where('is_active', false)
                                    ->orWhereNull('is_active');
                            }),
                            'upcoming' => $query
                                ->where('is_active', true)
                                ->where('start_time', '>', $now),
                            'ongoing' => $query
                                ->where('is_active', true)
                                ->where('start_time', '<=', $now)
                                ->where('end_time', '>=', $now),
                            'ended' => $query
                                ->where('is_active', true)
                                ->where('end_time', '<', $now),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->tooltip('Lihat'),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit'),
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus'),
                Action::make('recap')
                    ->label('Recap')
                    ->icon('heroicon-o-book-open')
                    ->url(fn (Quiz $record): string => QuizResource::getUrl('recap', ['record' => $record]))
                    ->color('info')
                    ->iconButton()
                    ->tooltip('Recap'),
                Action::make('monitoring')
                    ->label('Monitoring')
                    ->icon('heroicon-o-video-camera')
                    ->url(fn (Quiz $record): string => QuizResource::getUrl('monitoring', ['record' => $record]))
                    ->color('success')
                    ->iconButton()
                    ->tooltip('Monitoring'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
