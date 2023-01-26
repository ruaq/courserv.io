{{--
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
--}}

@props([
'metaTitle' => '',
'index' => '',
'umami' => true,
'siteTitle',
'active' => '',
])

<x-layouts.base :metaTitle="$metaTitle" :index="$index" :umami="$umami">

    <div class="min-h-full">
        <div class="py-10">
{{--            <header>--}}
{{--                <div class="mx-auto px-4 sm:px-6 lg:px-8">--}}
{{--                    <h1 class="text-3xl font-bold leading-tight text-gray-900">--}}
{{--                        {{ $siteTitle ?? $metaTitle }}--}}
{{--                    </h1>--}}
{{--                </div>--}}
{{--            </header>--}}
            <main>
                <div class="mx-auto sm:px-6 lg:px-8">
                    <div class="px-4 sm:px-0">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

</x-layouts.base>
