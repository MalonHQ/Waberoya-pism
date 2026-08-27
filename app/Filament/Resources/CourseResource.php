<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Usimamizi wa Masomo';

    protected static ?string $modelLabel = 'Kozi';

    protected static ?string $pluralModelLabel = 'Masomo / Kozi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->label('Idara (Department)')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->label('Mwalimu Mfundishaji (Lecturer)')
                    ->relationship('lecturer', 'name', fn ($query) => $query->role('lecturer'))
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Forms\Components\TextInput::make('code')
                    ->label('Kodi ya Somo (Course Code)')
                    ->placeholder('Mfano: CS101')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),

                Forms\Components\TextInput::make('title')
                    ->label('Jina la Somo (Course Title)')
                    ->placeholder('Mfano: Web Development Fundamentals')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('credits')
                    ->label('Idadi ya Credit / Units')
                    ->numeric()
                    ->default(3)
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Maelezo ya Somo')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kodi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Jina la Somo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Idara')
                    ->sortable()
                    ->placeholder('Haina Idara'),

                Tables\Columns\TextColumn::make('lecturer.name')
                    ->label('Mwalimu Mfundishaji')
                    ->sortable()
                    ->placeholder('Hajapangwa'),

                Tables\Columns\TextColumn::make('credits')
                    ->label('Credits')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarehe ya Kuundwa')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\EnrollmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}