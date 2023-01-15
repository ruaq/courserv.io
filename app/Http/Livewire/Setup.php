<?php

namespace App\Http\Livewire;

use App\Events\GeodataUpdated;
use App\Models\User;
use Artisan;
use Livewire\Component;

class Setup extends Component
{
    public string $name = '';

    public string $email = '';

    public bool $userAdded = false;

    protected array $rules = [
        'name' => 'required',
        'email' => 'required|email',
    ];

    public function register()
    {
        $this->validate();

        abort_unless($this->email === config('app.owner'), 401);

        // check if a user already exists (again)
        $user = User::first();
        abort_if(isset($user), 403);

        // reset and seed database
        $exitCode = Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        abort_unless(! $exitCode, 503);

        // create user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => '',
            'active' => 1,
        ]);

        $user->attachRole('admin');

        event(new GeodataUpdated());

        $this->redirect(route('login'));
    }

    public function render()
    {
        abort_unless(config('app.owner'), 404);

        // check if a user already exists
        $user = User::first();
        abort_if(isset($user), 404);

        return view('livewire.setup')
            ->layout('layouts.auth', ['metaTitle' => 'Setup']);
    }
}
