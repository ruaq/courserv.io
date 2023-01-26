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

use App\Models\CourseType;
use App\Models\Location;
use Livewire\Component;

class LocationSearch extends Component
{
    public string $courseType;

    public string $term = '';

    public string $slug;

    public string $redirectUrl;

    public string $error = '';

    protected $listeners = ['located', 'error'];

    public function mount()
    {
        $courseTypes = CourseType::whereSlug($this->slug)->firstOrFail();
        $this->courseType = $courseTypes->name;
        $this->slug = $courseTypes->slug;
        $this->redirectUrl = $courseTypes->iframe_url;
    }

    public function render()
    {
        $locations = Location::search(trim($this->term))->groupBy('location', 'state')->limit(5)->get();

        return view('livewire.location-search', [
            'metaTitle' => $this->courseType.' - '._i('our course dates at a glance'),
            'index' => true,
            'locations' => $locations,
        ])
            ->layout('layouts.booking');
    }

    public function located($lat, $lon)
    {
        return redirect()->to(route('booking.coordinates', [$this->slug, round($lat, 2), round($lon, 2)]));
    }

    public function error($error)
    {
    }
}
