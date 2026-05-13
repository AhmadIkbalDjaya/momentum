<?php

namespace App\Filament\Resources;

use App\Enums\Gender;
use App\Filament\Resources\StudentResource\Pages;
use App\Models\SchoolCategory;
use App\Models\Student;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;

class StudentResource extends Resource
{
    protected static ?string $label = 'Siswa';

    protected static ?string $pluralLabel = 'Siswa';

    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $model = Student::class;

    protected static ?string $navigationGroup = 'Data';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required(),
                    TextInput::make('username')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->rules([
                            Password::defaults(),
                        ])
                        ->required(fn (string $context): bool => $context === 'create')
                        ->confirmed()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                        ->dehydrated(fn ($state) => filled($state)),
                    TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->revealable()
                        ->same('password')
                        ->required(fn (string $context): bool => $context === 'create')
                        ->dehydrated(fn ($state) => filled($state)),
                    Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->placeholder('Pilih Jenis Jelamin')
                        ->options(Gender::class)
                        ->required(),
                    Select::make('school_id')
                        ->label('Sekolah')
                        ->placeholder('Pilih Sekolah')
                        ->relationship(
                            name: 'school',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn ($query) => auth()->user()->school_category_id ? $query->where('school_category_id', auth()->user()->school_category_id) : $query
                        )
                        ->searchable('name')
                        ->preload()
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->school_category_id != null) {
                    return $query->whereHas('school', function ($query) {
                        $query->where('school_category_id', auth()->user()->school_category_id);
                    });
                }

                return $query;
            })
            ->columns([
                TextColumn::make('name')->label('name')->sortable()->searchable(),
                TextColumn::make('username')->label('username')->sortable()->searchable(),
                TextColumn::make('school.name')->label('sekolah')->sortable(),
                TextColumn::make('gender')->label('jenis kelamin')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('school_category_id')
                    ->label('Jenis Sekolah')
                    ->options(fn () => SchoolCategory::pluck('name', 'id')->toArray())
                    ->query(function (Builder $query, array $data) {
                        if (filled($data['value'])) {
                            $query->whereHas('school', function ($query) use ($data) {
                                $query->where('school_category_id', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
