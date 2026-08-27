<?php

namespace App\Filament\Lecturer\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\StudentProfile;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    protected static ?string $title = 'Wanafunzi na Alama Zao';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_profile_id')
                    ->options(StudentProfile::with('user')->get()->pluck('user.name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Mwanafunzi'),

                Forms\Components\TextInput::make('ca_marks')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->label('Alama za CA'),

                Forms\Components\TextInput::make('exam_marks')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->label('Alama za Exam'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('studentProfile.user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Mwanafunzi'),

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
                    ->label('Grade'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Weka Alama za Mwanafunzi'),
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
}