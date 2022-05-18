<?php

namespace App\Http\Livewire;

use App\Models\CourseType as CourseTypeModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CourseType extends Component
{
    use AuthorizesRequests;

    public bool $showEditModal = false;

    public bool $showCategoryInput = false;

    public array $courseTypeCategories;

    public string $new_category = '';

    public Collection $courseTypes;

    public CourseTypeModel $editing;

    protected function rules(): array
    {
        return [
            'editing.name' => 'required|unique:course_types,name,'.$this->editing->id,
            'editing.category' => 'required',
            'new_category' => 'unique:course_types,category',
            'editing.wsdl_id' => 'numeric|nullable',
            'editing.slug' => 'required|unique:course_types,slug,'.$this->editing->id,
            'editing.iframe_url' => 'sometimes|url',
            'editing.units' => 'required|numeric|nullable',
            'editing.units_per_day' => 'required|numeric|nullable',
            'editing.breaks' => 'required|numeric|nullable',
            'editing.seats' => 'required|numeric|nullable',
        ];
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->editing = $this->makeBlankCourseType();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedEditingCategory($value)
    {
        if ($value === 'new_category') {
            $this->showCategoryInput = true;
        } else {
            $this->showCategoryInput = false;
            $this->new_category = '';
        }
    }

    public function updatedEditingWsdlId($value)
    {
        $this->editing->units = CourseTypeModel::WSDL_DATA[$value]['units'];
        $this->editing->units_per_day = CourseTypeModel::WSDL_DATA[$value]['units_per_day'];
        $this->editing->breaks = CourseTypeModel::WSDL_DATA[$value]['breaks'];
        $this->editing->seats = CourseTypeModel::WSDL_DATA[$value]['seats'];
    }

    public function updatedNewCategory($value)
    {
        $this->courseTypeCategories[] = $value;
        sort($this->courseTypeCategories);
        $this->editing->category = $value;
        $this->showCategoryInput = false;
        $this->new_category = '';
    }

    public function create()
    {
        $this->authorize('create', CourseTypeModel::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankCourseType();
            $this->editing['iframe_url'] = '';
        }

        $this->showEditModal = true;
    }

    public function edit(CourseTypeModel $courseType)
    {
        $this->authorize('update', $courseType);

        if ($this->editing->isNot($courseType)) {
            $this->editing = $courseType;
        }
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->authorize('viewAny', CourseTypeModel::class);

        $this->validate();

        $this->editing->save();
        $this->showEditModal = false;
    }

    public function render()
    {
        $this->courseTypes = CourseTypeModel::all();

        return view('livewire.course-type')
            ->layout('layouts.app', [
                'metaTitle' => _i('Course types'),
                'active' => 'coursetype',
            ]);
    }

    protected function makeBlankCourseType(): CourseTypeModel
    {
        $categories = CourseTypeModel::all()->sortBy('category')->pluck('category')->toArray();
        $this->courseTypeCategories = array_unique($categories);

        return new CourseTypeModel();
    }
}
