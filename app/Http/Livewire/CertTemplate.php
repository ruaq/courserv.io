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

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\CertTemplate as CertTemplateModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Str;
use ZipArchive;

class CertTemplate extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;
    use WithPerPagePagination;
    use WithSorting;
    use WithCachedRows;

    public CertTemplateModel $editing;

    public bool $showEditModal = false;

    public $newTemplate;

    public $uploadId;

    protected function rules(): array
    {
        return [
            'editing.title' => 'required',
            'editing.description' => 'sometimes',
            'editing.filename' => 'sometimes',
            'newTemplate' => 'nullable|mimes:docx,odt',
        ];
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->editing = $this->makeBlankModel();
    }

//    public function getRowsQueryProperty(): mixed
//    {
//        $query = CertTemplateModel::query();
    ////            ->when(
    ////                ! Auth::user()->isAbleTo('team.*'), // can't see all teams
    ////                fn ($query, $user_teams) => $query
    ////                    ->whereIn('team_id', Auth::user()->teams()->pluck('id'))
    ////            );
//
//        return $this->applySorting($query);
//    }
//
//    public function getRowsProperty(): mixed
//    {
//        return $this->cache(function () {
//            return $this->applyPagination($this->rowsQuery);
//        });
//    }

    public function updatedNewTemplate()
    {
        $this->correctDocxFile($this->newTemplate->path());

        $this->validateOnly('newTemplate');
    }

    public function create()
    {
        $this->authorize('create', CertTemplateModel::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankModel();
        }
        $this->showEditModal = true;
    }

    public function edit(CertTemplateModel $template)
    {
        $this->authorize('update', $template);

        if ($this->editing->isNot($template)) {
            $this->makeBlankModel();
            $this->editing = $template;
        }
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->authorize('save', $this->editing);

        $this->validate();

        if ($this->newTemplate) {
            if ($this->editing->filename) { // delete old template, if changed
                Storage::disk('certTemplates')->delete($this->editing->filename);
            }
            $this->editing->filename = $this->newTemplate->store('/', 'certTemplates');
            $this->uploadId = time(); // reset upload ID
        }

        $this->editing->save();
        $this->showEditModal = false;
    }

    public function render()
    {
        $this->authorize('viewAny', CertTemplateModel::class);

        $templates = CertTemplateModel::all();

        return view('livewire.cert-template', [
            //            'templates' => $this->rows,
            'templates' => $templates,
        ])
            ->layout('layouts.app', [
                'metaTitle' => _i('Certification Templates'),
                'active' => 'certTemplates',
                'breadcrumb_back' => ['link' => route('certTemplates'), 'text' => _i('Certification Templates')],
                'breadcrumbs' => [['link' => route('certTemplates'), 'text' => _i('Certification Templates')]],
            ]);
    }

    protected function makeBlankModel(): CertTemplateModel
    {
        unset($this->newTemplate);
        $this->uploadId = time(); // set unique ID to clear upload field

        return new CertTemplateModel();
    }

    private function correctDocxFile($tempFile): void
    {
        if (mime_content_type($tempFile) != 'application/octet-stream') { // file isn't incorrect .docx file
            return;
        }

        $str = Str::random();
        $tmpDir = Storage::disk('tmp')->getConfig()['root'].'/'.$str;

        $zip = new ZipArchive();

        if ($zip->open($this->newTemplate->path()) === true) {
            $zip->extractTo($tmpDir);
            $zip->close();
        } else { // wasn't a zip / docx
            Storage::disk('tmp')->deleteDirectory($str);

            return;
        }

        $files = Storage::disk('tmp')->allFiles($str);
        $fileArray = [];
        $i = 3;

        // sort files in the correct order
        foreach ($files as $file) {
            $f = str_replace($str.'/', '', $file);

            if ($f == '[Content_Types].xml') {
                $fileArray[0] = $f;

                continue;
            }

            if ($f == '_rels/.rels') {
                $fileArray[1] = $f;

                continue;
            }

            if ($f == 'word/_rels/document.xml.rels') {
                $fileArray[2] = $f;

                continue;
            }

            $fileArray[$i] = $f;
            $i++;
        }

        ksort($fileArray);

        // replace the uploaded temp file
        $outfile = $tempFile;

        if (file_exists($outfile)) {
            unlink($outfile);
        }

        // make a new file
        chdir($tmpDir);
        $o = new ZipArchive();
        $o->open($outfile, ZipArchive::CREATE);
        foreach ($fileArray as $key => $file) {
            $o->addFile($file);
        }

        $o->close();

        Storage::disk('tmp')->deleteDirectory($str);
    }
}
