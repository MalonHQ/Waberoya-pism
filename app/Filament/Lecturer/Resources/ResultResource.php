<?php

namespace App\Filament\Lecturer\Resources;

use App\Filament\Lecturer\Resources\ResultResource\Pages;
use App\Filament\Lecturer\Resources\ResultResource\RelationManagers;
use App\Models\Result;
use App\Models\StudentProfile;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResultResource extends Resource
{
    protected static ?string $model = Result::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Matokeo';
    protected static ?string $modelLabel = 'Tokeo';
    protected static ?string $pluralModelLabel = 'Matokeo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_profile_id')
                    ->options(StudentProfile::with('user')->get()->pluck('user.name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Mwanafunzi'),

                Forms\Components\Select::make('course_id')
                    ->options(Course::pluck('title', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Somo'),

                Forms\Components\TextInput::make('ca_marks')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->label('Alama za CA (Continuous Assessment)'),

                Forms\Components\TextInput::make('exam_marks')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->label('Alama za Mtihani (Exam)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('studentProfile.user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Mwanafunzi'),

                Tables\Columns\TextColumn::make('course.title')
                    ->searchable()
                    ->sortable()
                    ->label('Somo'),

                Tables\Columns\TextColumn::make('ca_marks')
                    ->sortable()
                    ->label('CA'),

                Tables\Columns\TextColumn::make('exam_marks')
                    ->sortable()
                    ->label('Exam'),

                Tables\Columns\TextColumn::make('total_marks')
                    ->sortable()
                    ->label('Jumla'),

                Tables\Columns\TextColumn::make('grade')
                    ->sortable()
                    ->label('Daraja (Grade)'),

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
            'index' => Pages\ListResults::route('/'),
            'create' => Pages\CreateResult::route('/create'),
            'edit' => Pages\EditResult::route('/{record}/edit'),
        ];
    }
}