<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\CertTemplate as CertTemplateModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

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
            $this->editing = $template;
        }
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->authorize('save', $this->editing);

        $this->validate();

        if ($this->newTemplate) {
            $this->editing->filename = $this->newTemplate->store('/', 'certTemplates');
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
            ]);
    }

    protected function makeBlankModel(): CertTemplateModel
    {
        unset($this->newTemplate);

        return new CertTemplateModel();
    }
}
