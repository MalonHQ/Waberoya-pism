<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicYearResource\Pages;
use App\Models\AcademicYear;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Usimamizi wa Chuo';

    protected static ?string $modelLabel = 'Mwaka wa Masomo';

    protected static ?string $pluralModelLabel = 'Miaka ya Masomo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Mwaka wa Masomo')
                    ->placeholder('Mfano: 2025/2026')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Toggle::make('is_active')
                    ->label('Weka uwe Mwaka Active')
                    ->default(true),

                Forms\Components\Repeater::make('semesters')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Jina la Muhula (Semester)')
                            ->placeholder('Mfano: Semester 1')
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Semester'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Mwaka wa Masomo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active Year')
                    ->boolean(),

                Tables\Columns\TextColumn::make('semesters.name')
                    ->label('Semesters')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarehe ya Kuundwa')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicYears::route('/'),
            'create' => Pages\CreateAcademicYear::route('/create'),
            'edit' => Pages\EditAcademicYear::route('/{record}/edit'),
        ];
    }
}