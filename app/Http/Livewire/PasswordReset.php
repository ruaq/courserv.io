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

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use Vinkla\Hashids\Facades\Hashids;

class PasswordReset extends Component
{
    public string $password = '';

    public string $password_confirmation = '';

    public string $hashedId;

    public User $user;

    public Request $request;

    protected $rules = [
        'password' => 'required|min:6|confirmed',
    ];

    public function updated()
    {
        $this->resetErrorBag();
        $this->validate();
    }

    public function mount()
    {
        $user = User::find(Hashids::decode($this->hashedId));
        $this->user = $user[0];

        if (is_null($this->user->reset_valid_until)) {
            return abort(Response::HTTP_FORBIDDEN, _i('The reset link has already been used.'));
        }

        if (Carbon::instance(new \DateTimeImmutable($this->user->reset_valid_until))->isPast()) {
            return abort(Response::HTTP_FORBIDDEN, _i('The reset link has expired.'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword()
    {
        $this->validate();

        $this->user->password = Hash::make($this->password);
        $this->user->reset_valid_until = null;
        $this->user->save();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.password-reset')
            ->layout('layouts.auth', ['metaTitle' => _i('Password reset')]);
    }
}
