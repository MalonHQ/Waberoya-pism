<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultResource\Pages;
use App\Models\Result;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ResultResource extends Resource
{
    protected static ?string $model = Result::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Usimamizi wa Masomo';

    protected static ?string $navigationLabel = 'Matokeo (Results)';

    // 1. Inachuja Query kulingana na nani kamelogin (Admin anaona zote, Lecturer anaona za kwake tu)
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Kama mtumiaji ni lecturer, tunaonesha matokeo ya masomo yaliyochini yake tu
        if ($user && $user->hasRole('lecturer')) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form
            ->schema([
                // Mwanafunzi: Anachuja wale tu wenye role ya 'student'
                Forms\Components\Select::make('student_profile_id')
                    ->label('Mwanafunzi')
                    ->relationship(
                        name: 'studentProfile',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn ($query) => $query->whereHas('user', fn ($q) => $q->role('student'))
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user?->name . ' (' . $record->user?->email . ')')
                    ->required()
                    ->searchable()
                    ->preload(),

                // Somo: Admin anaona masomo yote, lakini Lecturer anaona yale tu aliyopangiwa (user_id yake)
                Forms\Components\Select::make('course_id')
                    ->label('Somo (Course)')
                    ->relationship(
                        name: 'course',
                        titleAttribute: 'title',
                        modifyQueryUsing: function ($query) use ($user) {
                            if ($user && $user->hasRole('lecturer')) {
                                $query->where('user_id', $user->id);
                            }
                        }
                    )
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('ca_marks')
                    ->label('Alama za CA (Test/Mazoezi)')
                    ->numeric()
                    ->default(0)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        self::calculateTotalAndGrade($get, $set);
                    }),

                Forms\Components\TextInput::make('exam_marks')
                    ->label('Alama za Mtihani (Exam)')
                    ->numeric()
                    ->default(0)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        self::calculateTotalAndGrade($get, $set);
                    }),

                Forms\Components\TextInput::make('total_marks')
                    ->label('Jumla Kuu')
                    ->numeric()
                    ->readOnly()
                    ->default(0),

                Forms\Components\TextInput::make('grade')
                    ->label('Daraja (Grade)')
                    ->readOnly(),

                Forms\Components\Select::make('status')
                    ->label('Hali ya Matokeo')
                    ->options([
                        'pending' => 'Nasubiri (Pending)',
                        'approved' => 'Imeidhinishwa (Approved)',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('studentProfile.user.name')
                    ->label('Mwanafunzi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('course.title')
                    ->label('Somo (Course)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_marks')
                    ->label('Jumla (Total)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('grade')
                    ->label('Daraja')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'A', 'B' => 'success',
                        'C', 'D' => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Hali')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                    ])
                    ->label('Chuja kwa Hali'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                // Kitufe cha Haraka cha Kuidhinisha Matokeo (Kwa Admin pekee au kama anaruhusiwa)
                Tables\Actions\Action::make('approve')
                    ->label('Idhinisha')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Result $record) => $record->update(['status' => 'approved']))
                    ->visible(fn (Result $record) => $record->status === 'pending' && auth()->user()->hasRole('admin')),
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
            'index' => Pages\ListResults::route('/'),
            'create' => Pages\CreateResult::route('/create'),
            'edit' => Pages\EditResult::route('/{record}/edit'),
        ];
    }

    // Function ya Kujumlisha na Kukokotoa Grade yenyewe (Auto-calculate)
    protected static function calculateTotalAndGrade(Forms\Get $get, Forms\Set $set): void
    {
        $ca = (float) $get('ca_marks') ?: 0;
        $exam = (float) $get('exam_marks') ?: 0;
        $total = $ca + $exam;

        $set('total_marks', $total);

        // Mfano wa Grading System
        if ($total >= 70) {
            $set('grade', 'A');
        } elseif ($total >= 60) {
            $set('grade', 'B');
        } elseif ($total >= 50) {
            $set('grade', 'C');
        } elseif ($total >= 40) {
            $set('grade', 'D');
        } else {
            $set('grade', 'F');
        }
    }
}