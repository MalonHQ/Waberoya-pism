<?php

namespace App\Filament\Lecturer\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationLabel = 'Badili Password';
    protected static ?string $title = 'Badilisha Nenosiri Lako';
    protected static ?string $slug = 'change-password';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.lecturer.pages.change-password';

    public ?string $current_password = '';
    public ?string $new_password = '';
    public ?string $new_password_confirmation = '';

    public function mount(): void
    {
        $this->form->fill();
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

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('updatePassword')
                ->label('Badili Nenosiri')
                ->submit('updatePassword'),
        ];
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
            ->title('Nenosiri limebadilishwa kwa mafanikio!')
            ->success()
            ->send();
    }
}