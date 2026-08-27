<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Usimamizi wa Mfumo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Jina Kamili')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label('Barua Pepe (Email)')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                // Jicho la kuona/kuficha password lipo hapa:
                Forms\Components\TextInput::make('password')
                    ->label('Nenosiri (Password)')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),

                // Dropdown ya wazi kabisa yenye Admin, Lecturer, Student
                Forms\Components\Select::make('role')
                    ->label('Nafasi (Role)')
                    ->options([
                        'admin' => 'Admin',
                        'lecturer' => 'Lecturer',
                        'student' => 'Student',
                    ])
                    ->native(false)
                    ->required()
                    ->default(fn (?User $record) => $record?->roles->pluck('name')->first()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Jina')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Nafasi (Role)')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => ucfirst($state ?? 'Mgeni'))
                    ->color(fn ($state): string => match (strtolower($state ?? '')) {
                        'admin' => 'danger',
                        'lecturer' => 'warning',
                        'student' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarehe ya Usajili')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}