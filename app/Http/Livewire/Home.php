<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }
    }

    public function render()
    {
        return view('livewire.home')
            ->layout('layouts.app', [
                'metaTitle' => 'Dashboard',
                'active' => 'home',
            ]);
    }
}
