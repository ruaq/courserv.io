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

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Fcaptcha extends Component
{
    /**
     * @var bool
     */
    public $solved = false;

    /**
     * @var string[]
     */
    protected $listeners = ['captchaSolved', 'removeCaptcha'];

    public function removeCaptcha()
    {
        if (config('fcaptcha.secret') && config('fcaptcha.sitekey')) {
            return;
        }

        $this->emit('destroyCaptcha');
        $this->emitUp('captchaSolved');
        $this->solved = true;
    }

    public function captchaSolved($solution)
    {
        $response = Http::post('https://api.friendlycaptcha.com/api/v1/siteverify', [
            'solution' => $solution,
            'secret' => config('fcaptcha.secret'),
            'sitekey' => config('fcaptcha.sitekey'),
        ]);

        if (! $response->json('success')) {
            foreach ($response->json('errors') as $error) {
                $this->addError('validation', $error); //ddd($response->json('errors'));
            }
            $this->emit('resetCaptcha');

            return;
        }

        $this->emitUp('captchaSolved');
        $this->solved = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.fcaptcha');
    }
}
