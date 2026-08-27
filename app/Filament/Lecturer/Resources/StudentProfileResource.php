<?php

namespace App\Filament\Lecturer\Resources;

use App\Filament\Lecturer\Resources\StudentProfileResource\Pages;
use App\Models\StudentProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class StudentProfileResource extends Resource
{
    protected static ?string $model = StudentProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Wanafunzi Wote';
    protected static ?string $modelLabel = 'Mwanafunzi';
    protected static ?string $pluralModelLabel = 'Wanafunzi';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Taarifa za Mwanafunzi')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Jina Kamili'),
                        TextEntry::make('user.email')
                            ->label('Barua Pepe'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Tarehe Iliyosajiliwa'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Jina la Mwanafunzi'),

                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->sortable()
                    ->label('Barua Pepe (Email)'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tarehe ya Kujiandikisha'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                // Kitufe kinachofungua modal ya ripoti na alama za mwanafunzi huyo pekee kupitia results
                Tables\Actions\Action::make('downloadReport')
                    ->label('Pakua PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->modalHeading(fn (StudentProfile $record) => 'Ripoti na Matokeo: ' . optional($record->user)->name)
                    ->modalContent(fn (StudentProfile $record) => view('filament.lecturer.resources.student-report-modal', [
                        'record' => $record,
                        'results' => $record->results()->with('course')->get(),
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Funga'),
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
            'index' => Pages\ListStudentProfiles::route('/'),
        ];
    }
}