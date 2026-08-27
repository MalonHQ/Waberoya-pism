<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Wanafunzi na Matokeo Yao';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_profile_id')
                    ->label('Mwanafunzi')
                    ->relationship('studentProfile', 'reg_number')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->reg_number} - " . optional($record->user)->name)
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('semester_id')
                    ->label('Muhula')
                    ->relationship('semester', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->academicYear->name} - {$record->name}")
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Section::make('Alama za Mwanafunzi')
                    ->schema([
                        Forms\Components\TextInput::make('cat_marks')
                            ->label('CAT ( / 40)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(40)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                $cat = floatval($get('cat_marks') ?? 0);
                                $exam = floatval($get('exam_marks') ?? 0);
                                $total = $cat + $exam;
                                $set('total_marks', $total);

                                $grade = match(true) {
                                    $total >= 70 => 'A',
                                    $total >= 60 => 'B',
                                    $total >= 50 => 'C',
                                    $total >= 40 => 'D',
                                    default => 'F',
                                };
                                $set('grade', $grade);
                            }),

                        Forms\Components\TextInput::make('exam_marks')
                            ->label('Exam ( / 60)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(60)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                $cat = floatval($get('cat_marks') ?? 0);
                                $exam = floatval($get('exam_marks') ?? 0);
                                $total = $cat + $exam;
                                $set('total_marks', $total);

                                $grade = match(true) {
                                    $total >= 70 => 'A',
                                    $total >= 60 => 'B',
                                    $total >= 50 => 'C',
                                    $total >= 40 => 'D',
                                    default => 'F',
                                };
                                $set('grade', $grade);
                            }),

                        Forms\Components\TextInput::make('total_marks')
                            ->label('Jumla ( / 100)')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('grade')
                            ->label('Grade')
                            ->readOnly()
                            ->dehydrated(),
                    ])->columns(2),

                Forms\Components\Select::make('status')
                    ->label('Hali')
                    ->options([
                        'enrolled' => 'Anasoma',
                        'completed' => 'Amemaliza',
                        'dropped' => 'Ameacha',
                    ])
                    ->default('enrolled')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('studentProfile.reg_number')
                    ->label('Namba ya Usajili')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('studentProfile.user.name')
                    ->label('Jina la Mwanafunzi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('semester.name')
                    ->label('Muhula'),

                Tables\Columns\TextColumn::make('cat_marks')
                    ->label('CAT')
                    ->sortable(),

                Tables\Columns\TextColumn::make('exam_marks')
                    ->label('Exam')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_marks')
                    ->label('Jumla')
                    ->sortable(),

                Tables\Columns\TextColumn::make('grade')
                    ->label('Grade')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'primary',
                        'C' => 'warning',
                        'D', 'F' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Ongeza Mwanafunzi kwenye Somo'),

                Tables\Actions\Action::make('printReport')
                    ->label('Chapisha / Pakua PDF')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->extraAttributes(['onclick' => 'window.print()']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('downloadStudentReport')
                    ->label('Pakua PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->extraAttributes(['onclick' => 'window.print()']),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}