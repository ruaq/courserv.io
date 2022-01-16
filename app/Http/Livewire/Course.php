<?php

namespace App\Http\Livewire;

use App\Events\CourseCancelled;
use App\Events\CourseCreated;
use App\Events\CourseRegisterRequired;
use App\Events\CourseUpdated;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Course as CourseModel;
use App\Models\CourseType as CourseTypeModel;
use App\Models\Team as TeamModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * @property mixed $rows
 * @property mixed $rowsQuery
 * @property mixed $teamsRows
 */
class Course extends Component
{
    use WithPerPagePagination;
    use WithSorting;
    use WithCachedRows;

    use AuthorizesRequests;

    protected $queryString = ['sorts'];

    public array $courseTypeCategories;
    public bool $showEditModal = false;
    public bool $showCancelModal = false;
    public bool $registerCourse = false;
    public bool $courseRegistered = false;
    public bool $showRegisterCourse = false;
    public CourseModel $editing;
    public Collection $courseTypes;

    public array $filters = [
        'search' => '',
        'courseType' => '',
        'team' => '',
        'amount-min' => null,
        'amount-max' => null,
        'date-min' => null,
        'date-max' => null,
        'showCancelled' => null,
    ];

    public bool $showFilters = false;

    public array $options = [
        'minDate' => 'today',
        'defaultHour' => '9',
        'dateFormat' => 'Y-m-d H:i',
        'weekNumbers' => true,
        'enableTime' => true,
        'time_24hr' => true,
        'altFormat' => 'j. F Y H:i',
        'altInput' => true,
        'locale' => 'de',
    ];

    public array $search_options = [
        'dateFormat' => 'Y-m-d',
        'weekNumbers' => true,
        'enableTime' => false,
        'altFormat' => 'j. F Y',
        'altInput' => true,
        'locale' => 'de',
    ];

    protected function rules(): array
    {
        return [
            'editing.team_id' => 'required',
            'editing.course_type_id' => 'required',
            'editing.seminar_location' => 'required',
            'editing.start' => 'required',
            'editing.end' => 'required',
            'editing.street' => 'required',
            'editing.zipcode' => 'required',
            'editing.location' => 'required',
            'editing.seats' => 'required',
            'editing.registration_number' => 'sometimes',

//            'editing.name' => 'required|unique:course_types,name,' . optional($this->editing)->id,
//            'new_category' => 'unique:course_types,category',
//            'editing.wsdl_id' => 'numeric|nullable',
//            'editing.units' => 'required|numeric|nullable',
//            'editing.units_per_day' => 'required|numeric|nullable',
//            'editing.breaks' => 'required|numeric|nullable',
//            'editing.seats' => 'required|numeric|nullable',
        ];
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->editing = $this->makeBlankCourse();
    }

    public function updatedEditingStart()
    {
        $this->checkCourseLength();
    }

    public function updatedEditingEnd()
    {
        $this->checkCourseLength();
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function updatedEditingCourseTypeId()
    {
        if ($this->editing->course_type_id) {
            $this->editing->seats = $this->editing->type->seats;

            if ($this->editing->type->wsdl_id) {
                $this->showRegisterCourse = true;
            } else {
                $this->showRegisterCourse = false;
            }
        } else {
            $this->showRegisterCourse = false;
        }
    }

    public function checkCourseLength()
    {
        if (! $this->editing->course_type_id) {
            $this->editing->course_type_id = CourseTypeModel::first()->id;
        }

        if ($this->editing->type->units_per_day) {
            $unit_length = $this->editing->type->units_per_day * 45;
        } else {
            $unit_length = 9 * 45;
        }

        $breaks = $this->editing->type->breaks;
        $length = $unit_length + $breaks;

        if (! isset($this->editing->end) || $this->editing->end->subMinutes($length)->lt($this->editing->start)) {
            $this->editing->end = now();
            $this->editing->end = $this->editing->start->addMinutes($length);
        }
    }

    public function create()
    {
        $this->authorize('create', CourseModel::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankCourse();
        }

        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(CourseModel $course)
    {
        $this->authorize('update', $course);

        $this->registerCourse = false;

        if ($this->editing->isNot($course)) {
            $this->editing = $course;
        }

        if (isset($this->editing->type->wsdl_id)) {
            $this->showRegisterCourse = true;
        }

        if ($this->editing->registration_number) {
            $this->courseRegistered = true;
        }

        $this->showEditModal = true;
    }

    public function cancel()
    {
        $this->authorize('save', $this->editing);

        if (config('app.qsehCodeNumber') && config('app.qsehPassword')) {
            // it's a QSEH course and already registered
            if ($this->editing->registration_number && $this->editing->registration_number != 'queued' && $this->editing->registration_number != 'failed' && $this->editing->type->wsdl_id) {
                event(new CourseCancelled($this->editing));
            }
        }

        $this->editing->cancelled = now();
        $this->editing->save();

        $this->showEditModal = false;
        $this->showCancelModal = false;
        $this->resetPage();
    }

    public function save()
    {
        $this->authorize('save', $this->editing);

        $this->validate();

        $this->editing->save();
        $this->showEditModal = false;

        if (! $this->editing->internal_number) { // new course
            $this->editing->internal_number = 'queued';
            $this->editing->save();
            event(new CourseCreated($this->editing));
        }

        if (config('app.qsehCodeNumber') && config('app.qsehPassword')) {
            if ($this->registerCourse) {
                $this->editing->registration_number = 'queued';
                $this->editing->save();
                event(new CourseRegisterRequired($this->editing));
            }

            // it's a QSEH course and already registered
            if (
                $this->editing->registration_number &&
                $this->editing->registration_number != 'queued' &&
                $this->editing->registration_number != 'failed' &&
                $this->editing->type->wsdl_id
            ) {
                event(new CourseUpdated($this->editing));
            }
        }
    }

    /**
     * @return mixed
     */
    public function getRowsQueryProperty(): mixed
    {
        $query = CourseModel::query()
            ->when(
                ! Auth::user()->isAbleTo('team.*'), // can't see all teams
                fn ($query, $user_teams) => $query
                    ->whereIn('team_id', Auth::user()->teams()->pluck('id'))
            )
            ->when($this->filters['courseType'], fn ($query, $courseType) => $query->where('course_type_id', $courseType))
            ->when($this->filters['team'], fn ($query, $team) => $query->where('team_id', $team))
            ->when($this->filters['amount-min'], fn ($query, $amount) => $query->where('amount', '>=', $amount))
            ->when($this->filters['amount-max'], fn ($query, $amount) => $query->where('amount', '<=', $amount))
            ->when($this->filters['date-min'], fn ($query, $date) => $query->where('start', '>=', Carbon::parse($date)))
            ->when($this->filters['date-max'], fn ($query, $date) => $query->where('start', '<=', Carbon::parse($date)))
            ->when(! $this->filters['showCancelled'], fn ($query, $date) => $query->where('cancelled', '=', null))
            ->when($this->filters['showCancelled'], fn ($query, $date) => $query->where('cancelled', '<>', null))
            ->when(
                $this->filters['search'],
                fn ($query, $search) => $query
                ->where('seminar_location', 'like', '%'.$search.'%')
                ->orWhere('street', 'like', '%'.$search.'%')
                ->orWhere('seminar_location', 'like', '%'.$search.'%')
                ->orWhere('internal_number', 'like', '%'.$search.'%')
                ->orWhere('registration_number', 'like', '%'.$search.'%')
            )
            ->with('type')
            ->with('team');

        return $this->applySorting($query);
    }

    public function getRowsProperty(): mixed
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getTeamsRowsProperty(): \Illuminate\Database\Eloquent\Collection|array
    {
        if (Auth::user()->isAbleTo('team.*')) {
            return TeamModel::all();
        }

        return Auth::user()->teams;
    }

    /**
     * @throws AuthorizationException
     */
    public function render()
    {
        $this->authorize('viewAny', CourseModel::class);

        // if no date is manually set, set it to today
        if ($this->filters['date-min'] === null) {
            $this->filters['date-min'] = today()->format('Y-m-d');
        }

        return view('livewire.course', [
            'courses' => $this->rows,
            'teams' => $this->teamsRows,
        ])
            ->layout('layouts.app', [
                'metaTitle' => _i('Courses'),
                'active' => 'courses',
            ]);
    }

    protected function makeBlankCourse(): CourseModel
    {
        $this->courseTypes = CourseTypeModel::all()->groupBy('category')->toBase();

        $this->registerCourse = false;
        $this->courseRegistered = false;
        $this->showRegisterCourse = false;

        return new CourseModel();
    }
}
