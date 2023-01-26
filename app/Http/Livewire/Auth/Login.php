<?php

/*
| Copyright 2023 courservio.de
|
| Licensed under the EUPL, Version 1.2 or – as soon they
| will be approved by the European Commission - subsequent
| versions of the EUPL (the "Licence");
| You may not use this work except in compliance with the
| Licence.
| You may obtain a copy of the Licence at:
|
| https://joinup.ec.europa.eu/software/page/eupl
|
| Unless required by applicable law or agreed to in
| writing, software distributed under the Licence is
| distributed on an "AS IS" basis,
| WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
| express or implied.
| See the Licence for the specific language governing
| permissions and limitations under the Licence.
*/

namespace App\Http\Livewire\Auth;

use App\Events\UserForgotPassword;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    use WithRateLimiting;

    public bool $showForgotModal = false;

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    public $solved = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    protected $listeners = ['captchaSolved'];

    public function captchaSolved()
    {
        $this->solved = true;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated($propertyName)
    {
        $this->resetErrorBag();
        $this->validateOnly($propertyName);
    }

    public function forgot()
    {
        $this->validateOnly('email');

        if ($user = User::whereEmail($this->email)->first()) {
            event(new UserForgotPassword($user));
        }

        $this->showForgotModal = false;
    }

    public function login()
    {
        $this->validate();

        try {
            $this->rateLimit(3, 120);
        } catch (TooManyRequestsException $exception) {
            $this->addError('captcha', _n(
                'Too many login attempts. Please try again in a second.',
                'Too many login attempts. Please try again in %s seconds.',
                $exception->secondsUntilAvailable,
                $exception->secondsUntilAvailable
            ));

            return;
        }

        if (! $this->solved) {
            $this->emit('resetCaptcha');
            $this->addError('captcha', _i('Captcha not solved!'));

            return;
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        if (! Auth::user()->active) {
            Auth::logout();
            $this->addError('email', trans('auth.inactive'));

            return;
        }

        session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth', ['metaTitle' => 'Login']);
    }
}
