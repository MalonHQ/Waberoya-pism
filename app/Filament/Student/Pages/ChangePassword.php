<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationLabel = 'Badili Password';
    protected static ?string $title = 'Badilisha Nenosiri Lako';
    protected static ?string $slug = 'change-password';
    protected static ?int $navigationSort = 3; // Inaweka hii kuwa ya mwisho kwenye menyu

    protected static string $view = 'filament.student.pages.change-password';

    public ?string $current_password = '';
    public ?string $new_password = '';
    public ?string $new_password_confirmation = '';

    public function mount(): void
    {
        // 
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('current_password')
                    ->label('Password ya Sasa')
                    ->password()
                    ->revealable()
                    ->required()
                    ->currentPassword(),

                TextInput::make('new_password')
                    ->label('Password Mpya')
                    ->password()
                    ->revealable()
                    ->required()
                    ->rule(Password::default())
                    ->same('new_password_confirmation')
                    ->live(onBlur: true),

                TextInput::make('new_password_confirmation')
                    ->label('Thibitisha Password Mpya')
                    ->password()
                    ->revealable()
                    ->required(),
            ]);
    }

    public function updatePassword(): void
    {
        $data = $this->form->getState();

        $user = auth()->user();

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        $this->form->fill();

        Notification::make()
            ->title('Nenosiri limebadilishwa mafanikio!')
            ->success()
            ->send();
    }
}