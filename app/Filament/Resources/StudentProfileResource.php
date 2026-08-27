<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentProfileResource\Pages;
use App\Models\StudentProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudentProfileResource extends Resource
{
    protected static ?string $model = StudentProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Usimamizi wa Wanafunzi';

    protected static ?string $modelLabel = 'Mwanafunzi';

    protected static ?string $pluralModelLabel = 'Wanafunzi (Student Profiles)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Taarifa za Akaunti ya Kuingia (Login Credentials)')
                    ->description('Jaza taarifa za mtumiaji ambazo zitamtambulisha kwenye mfumo')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Jina Kamili')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Barua pepe (Email)')
                            ->email()
                            ->required()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label('Nenosiri (Password)')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Taarifa za Kielimu na Chuo')
                    ->description('Weka namba ya usajili na idara ya mwanafunzi')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->label('Idara / Programu')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('reg_number')
                            ->label('Namba ya Usajili (Reg Number)')
                            ->placeholder('Mfano: TSU/BIT/2025/001')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('gender')
                            ->label('Jinsia')
                            ->options([
                                'Male' => 'Mme',
                                'Female' => 'Mke',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Namba ya Simu')
                            ->tel()
                            ->placeholder('0712345678'),

                        Forms\Components\Textarea::make('address')
                            ->label('Anwani / Makazi')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reg_number')
                    ->label('Namba ya Usajili')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Jina Kamili')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Idara')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Jinsia')
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Simu'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Chuja kwa Idara'),
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
            'index' => Pages\ListStudentProfiles::route('/'),
            'create' => Pages\CreateStudentProfile::route('/create'),
            'edit' => Pages\EditStudentProfile::route('/{record}/edit'),
        ];
    }
}