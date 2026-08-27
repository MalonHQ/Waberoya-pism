<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Usimamizi wa Wanafunzi';

    protected static ?string $modelLabel = 'Usajili wa Somo';

    protected static ?string $pluralModelLabel = 'Usajili wa Kozi (Enrollments)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('semester_id')
                    ->label('Muhula (Semester)')
                    ->relationship('semester', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->academicYear->name} - {$record->name}")
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('department_filter')
                    ->label('Chuja kwa Idara/Programu')
                    ->options(\App\Models\Department::pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->dehydrated(false)
                    ->placeholder('Chagua idara kwanza...'),

                Forms\Components\Select::make('student_profile_id')
                    ->label('Mwanafunzi (Reg Number & Jina)')
                    ->options(function (Forms\Get $get) {
                        $departmentId = $get('department_filter');
                        $query = \App\Models\StudentProfile::query();
                        
                        if ($departmentId) {
                            $query->where('department_id', $departmentId);
                        }
                        
                        return $query->with('user')->get()->mapWithKeys(function ($student) {
                            $userName = $student->user ? $student->user->name : 'Bila Jina';
                            return [$student->id => "{$student->reg_number} - {$userName}"];
                        });
                    })
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('course_id')
                    ->label('Somo / Kozi')
                    ->relationship('course', 'title')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->code} - {$record->title}")
                    ->searchable(['code', 'title'])
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Hali ya Usajili')
                    ->options([
                        'enrolled' => 'Anasoma (Enrolled)',
                        'completed' => 'Amemaliza (Completed)',
                        'dropped' => 'Ameacha (Dropped)',
                    ])
                    ->default('enrolled')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('studentProfile.reg_number')
                    ->label('Namba ya Usajili')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('studentProfile.user.name')
                    ->label('Jina la Mwanafunzi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('course.code')
                    ->label('Kodi ya Somo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('semester.name')
                    ->label('Muhula')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('grade')
                    ->label('Grade')
                    ->colors([
                        'success' => 'A',
                        'primary' => 'B',
                        'warning' => 'C',
                        'danger' => ['D', 'F'],
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Hali')
                    ->colors([
                        'success' => 'enrolled',
                        'warning' => 'completed',
                        'danger' => 'dropped',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('semester_id')
                    ->relationship('semester', 'name')
                    ->label('Chuja kwa Muhula'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}