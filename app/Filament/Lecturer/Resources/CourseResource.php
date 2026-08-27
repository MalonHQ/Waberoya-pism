<?php

namespace App\Filament\Lecturer\Resources;

use App\Filament\Lecturer\Resources\CourseResource\Pages;
use App\Filament\Lecturer\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Masomo Yangu';
    protected static ?string $modelLabel = 'Somo';
    protected static ?string$pluralModelLabel = 'Masomo';

    // Hii inachuja ili mwalimu aone masomo YAKE tu aliyopangiwa
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->label('Nambari ya Somo (Code)'),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Jina la Somo'),

                Forms\Components\TextInput::make('credits')
                    ->numeric()
                    ->required()
                    ->label('Credits'),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Maelezo (Description)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->label('Nambari ya Somo'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Jina la Somo'),

                Tables\Columns\TextColumn::make('credits')
                    ->sortable()
                    ->label('Credits'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Tarehe Iliyowekwa'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}