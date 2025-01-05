<?php

namespace App\Filament\Auth;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Support\Facades\Session;
use App\Models\System\Year;
use App\Helpers\StaticLists;

class Login extends BaseAuth
{
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'user_email' => 'admin@test.ba',
            'user_password' => '12345678',
            'remember' => false,
            'selected_year' => now()->year,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(), 
                $this->getPasswordFormComponent(),
                $this->getYearFormComponent(),
                $this->getRememberFormComponent(),      
            ])
            ->statePath('data');
    }
 
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('user_email')
            ->label(__('E-mail'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('user_password')
            ->label(__('Password'))
            ->password()
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getYearFormComponent(): Component
    {
        return Select::make('selected_year')
            ->label('Godina')
            ->options(Year::all()->pluck('year_index', 'year_index'))
            ->default(now()->year)
            ->required();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        Session::put('selected_year', $data['selected_year'] ?? null);

        return [
            'user_email' => $data['user_email'],
            'password'  => $data['user_password'],
        ];
    }
}