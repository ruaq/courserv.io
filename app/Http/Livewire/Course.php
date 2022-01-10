<?php

namespace App\Http\Livewire;

use App\Events\CourseCancelled;
use App\Events\CourseCreated;
use App\Events\CourseUpdated;
use App\Models\Course as CourseModel;
use App\Models\CourseType as CourseTypeModel;
use App\Models\Team as TeamModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Course extends Component
{
    use AuthorizesRequests;

    public array $courseTypeCategories;
    public bool $showEditModal = false;
    public bool $showCancelModal = false;
    public bool $registerCourse = false;
    public bool $courseRegistered = false;
    public bool $showRegisterCourse = false;
    public CourseModel $editing;
    public Collection $courses;
    public Collection $courseTypes;
    public $teams;

    public array $options = [
        'minDate' => 'today',
        'defaultHour' => '9',
        'dateFormat' => 'Y-m-d H:i',
        'weekNumbers' => true,
        'enableTime' => true,
        'time_24hr' => true,
        'altFormat' =>  'j. F Y H:i',
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
        if (!$this->editing->course_type_id) {
            $this->editing->course_type_id = CourseTypeModel::first()->id;
        }

        if ($this->editing->type->units_per_day) {
            $unit_length = $this->editing->type->units_per_day * 45;
        } else {
            $unit_length = 9 * 45;
        }

        $breaks = $this->editing->type->breaks;
        $length = $unit_length + $breaks;

        if (!isset($this->editing->end) || $this->editing->end->subMinutes($length)->lt($this->editing->start)) {
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
    }

    public function save()
    {
        $this->authorize('save', $this->editing);

        $this->validate();

        if (config('app.qsehCodeNumber') && config('app.qsehPassword')) {
            if ($this->registerCourse) {
                event(new CourseCreated($this->editing));
                $this->editing->registration_number = 'queued';
            }

            // it's a QSEH course and already registered
            if ($this->editing->registration_number && $this->editing->registration_number != 'queued' && $this->editing->registration_number != 'failed' && $this->editing->type->wsdl_id) {
                event(new CourseUpdated($this->editing));
            }
        }

        $this->editing->save();
        $this->showEditModal = false;
    }

    /**
     * @throws AuthorizationException
     */
    public function render()
    {
        $this->authorize('viewAny', CourseModel::class);

        if (Auth::user()->isAbleTo('course.view')) {
            $this->courses = CourseModel::all();
            $this->teams = TeamModel::all();
        } else {
            $user_teams = Auth::user()->teams()->pluck('id');

            $this->teams = Auth::user()->teams;

            // get all authorized teams
            $auth_teams = [];
            foreach ($user_teams as $team) {
                if (Auth::user()->isAbleTo('course.*', $team)) {
                    $auth_teams[] = $team;
                }
            }

            $this->courses = CourseModel::whereIn('team_id', $auth_teams)
                ->with('type')
                ->with('team')
                ->get();
        }

        return view('livewire.course')
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
