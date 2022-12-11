<?php

namespace App\Http\Livewire;

use App\Events\CourseCancelled;
use App\Events\CourseCreated;
use App\Events\CourseRegisterRequired;
use App\Events\QsehCourseUpdated;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Course as CourseModel;
use App\Models\CourseDay;
use App\Models\CourseType as CourseTypeModel;
use App\Models\Position;
use App\Models\Price as PriceModel;
use App\Models\Team as TeamModel;
use App\Models\TrainerDay;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property mixed $rows
 * @property mixed $rowsQuery
 * @property mixed $teamsRows
 * @property mixed $positionsRows
 */
class Course extends Component
{
    use WithPerPagePagination;
    use WithSorting;
    use WithCachedRows;
    use AuthorizesRequests;

    protected $queryString = ['sorts'];

    public array $bag = [];

    public array $courseTypeCategories;

    public array $start_options;

    public array $end_options;

    public bool $showEditModal = false;

    public bool $showCancelModal = false;

    public bool $registerCourse = false;

    public bool $courseRegistered = false;

    public bool $showRegisterCourse = false;

    public bool $showOnlyOwnCourses = false;

    public CourseModel $editing;

    public Collection $courseTypes;

    public Collection $prices;

    public string $date_range;

    public string $time_start;

    public string $time_end;

    public array $courseDays = [];

    public array $priceIds = [];

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
        'dateFormat' => 'd.m.Y H:i',
        'weekNumbers' => true,
        'enableTime' => true,
        'time_24hr' => true,
        'locale' => 'de',
    ];

    public array $search_options = [
        'dateFormat' => 'd.m.Y',
        'weekNumbers' => true,
        'enableTime' => false,
        'locale' => 'de',
    ];

    public array $day_options = [
        'dateFormat' => 'd.m.Y',
        'weekNumbers' => true,
        'enableTime' => false,
        'time_24hr' => true,
        'locale' => 'de',
    ];

    public array $time_options = [
        'enableTime' => true,
        'time_24hr' => true,
        'noCalendar' => true,
        'dateFormat' => 'H:i',
    ];

    public array $start_time_options;

    public array $end_time_options;

    public array $trainer;

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
            'editing.public_bookable' => 'sometimes',
            'date_range' => 'sometimes',
            'time_start' => 'sometimes',
            'time_end' => 'sometimes',
            'trainer' => 'sometimes',
        ];
    }

    public function setStartTimeOptions(array $start_time_options): void
    {
        $this->start_time_options = array_merge($this->start_time_options, $start_time_options);
    }

    public function setEndTimeOptions(array $end_time_options): void
    {
        $this->end_time_options = array_merge($this->end_time_options, $end_time_options);
    }

    private function setStartOptions(array $start_options): void
    {
        $this->start_options = array_merge($this->start_options, $start_options);
    }

    private function setEndOptions(array $end_options): void
    {
        $this->end_options = array_merge($this->end_options, $end_options);
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

    public function updatedDateRange()
    {
        $range = explode(' ', $this->date_range);

        $this->editing->start = Carbon::createFromFormat(
            'd.m.y H:i',
            $range[0] . ' ' . $this->time_start
        );
        $this->editing->end = Carbon::createFromFormat(
            'd.m.y H:i',
            $range[array_key_last($range)] . ' ' . $this->time_end
        );

        $this->checkCourseLength();
        $this->setDayOptions();
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function updatedEditingCourseTypeId()
    {
        unset($this->editing->type); // force reload to prevent cache (prevents a bug if the course is already saved)

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

    public function updated($field, $newValue)
    {
        $split = explode('.', $field);

        // We want the courseDays
        if ($split[0] === 'courseDays') {
            // changed date?
            if ($split[2] === 'date') {
                // if date is empty, before the start or after the end
                if (
                    $newValue == '' ||
                    Carbon::createFromFormat('d.m.Y', $newValue)->lt($this->editing->start) ||
                    Carbon::createFromFormat('d.m.Y', $newValue)->gt($this->editing->end)
                ) {
                    unset($this->courseDays[$split[1]]); // delete it....
                } else {
                    // update order value
                    $this->courseDays[$split[1]]['order'] = Carbon::createFromFormat(
                        'd.m.Y',
                        $newValue
                    )
                        ->format('Y/m/d');
                }
            }

            // start time of the first day
            if ($split[1] == 0 && $split[2] === 'startTime') {
                // prevent that's not before the start time
                $firstDay = Carbon::createFromFormat('d.m.Y H:i', $this->courseDays[0]['date'] . ' ' . $newValue);
                if ($firstDay->lt($this->editing->start)) {
                    $this->courseDays[0]['startTime'] = $this->editing->start->format('H:i');
                }
            }

            if ($split[2] === 'startTime') {
                // correct if the startTime is after or equal the endTime
                if (
                    Carbon::createFromFormat(
                        'H:i',
                        $this->courseDays[$split[1]]['startTime']
                    )
                    ->gte(Carbon::createFromFormat('H:i', $this->courseDays[$split[1]]['endTime']))
                ) {
                    $this->courseDays[$split[1]]['startTime'] = Carbon::createFromFormat(
                        'H:i',
                        $this->courseDays[$split[1]]['endTime']
                    )
                        ->subMinutes(45)->format('H:i');
                }
            }

            // end time of the last day
            if ($split[1] == array_key_last($this->courseDays) && $split[2] === 'endTime') {
                // prevent that's not after the end time
                $lastDay = Carbon::createFromFormat(
                    'd.m.Y H:i',
                    $this->courseDays[array_key_last($this->courseDays)]['date'] . ' ' . $newValue
                );
                if ($lastDay->gt($this->editing->end)) {
                    $this->courseDays[
                        array_key_last($this->courseDays)]['endTime'] = $this->editing->end->format('H:i');
                }
            }

            if ($split[2] === 'endTime') {
                // correct if the endTime is before or equal the startTime
                if (
                    Carbon::createFromFormat(
                        'H:i',
                        $this->courseDays[$split[1]]['endTime']
                    )
                    ->lte(Carbon::createFromFormat(
                        'H:i',
                        $this->courseDays[$split[1]]['startTime']
                    ))
                ) {
                    $this->courseDays[$split[1]]['endTime'] = Carbon::createFromFormat(
                        'H:i',
                        $this->courseDays[$split[1]]['startTime']
                    )
                        ->addMinutes(45)->format('H:i');
                }
            }

            // remove duplicate dates
            $tempArr = array_unique(array_column($this->courseDays, 'order'));
            $this->courseDays = array_intersect_key($this->courseDays, $tempArr);

            // sorts array by order
            $keys = array_column($this->courseDays, 'order');
            array_multisort($keys, SORT_ASC, $this->courseDays);

            // is there still a date on the first day?
            if (
                ! isset($this->courseDays[0])
                || $this->courseDays[0]['date'] != $this->editing->start->format('d.m.Y')
            ) {
                // no? so, create it again, at the start of our array...
                array_unshift($this->courseDays, [
                    'date' => $this->editing->start->format('d.m.Y'),
                    'startTime' => $this->editing->start->format('H:i'),
                    'endTime' => $this->editing->end->format('H:i'),
                    'order' => $this->editing->start->format('Y/m/d'),
                ]);
            }

            // is there still a date on the last day?
            if ($this->courseDays[array_key_last($this->courseDays)]['date'] != $this->editing->end->format('d.m.Y')) {
                // no? so, create it again...
                $this->courseDays[] = [
                    'date' => $this->editing->end->format('d.m.Y'),
                    'startTime' => $this->editing->start->format('H:i'),
                    'endTime' => $this->editing->end->format('H:i'),
                    'order' => $this->editing->end->format('Y/m/d'),
                ];
            }

            foreach ($this->courseDays as $index => $foo) {
                if (! isset($this->trainer[$index])) {
                    $this->trainer[$index] = [0];
                }
            }
        }
    }

    public function updatedEditingTeamId()
    {
        unset($this->editing->team); // force reload to prevent cache (prevents a bug if the course is already saved)

        // reset all trainer
        $this->trainer = [];
        $this->trainer['general'] = [0];

        foreach ($this->courseDays as $index => $foo) {
            if (! isset($this->trainer[$index])) {
                $this->trainer[$index] = [0];
            }
        }
    }

    public function updatedTrainer()
    {
        $this->bag = [];
        foreach ($this->trainer as $item => $value) {
            foreach ($value as $i => $v) {
                if (
                    // if trainer can choose or is selected later and not on the leading position
                    isset($v['trainer']) && $v['trainer'] == 'later' && $i !== 0
                    || isset($v['trainer']) && $v['trainer'] == 'choose' && $i !== 0
                ) {
                    $this->bag[$item][] = $v;
                    unset($value[$i]);
                }
            }

            // remove empty entry's
            $result = [];
            $filtered = array_filter($value, function ($el) {
                return ! empty($el['trainer']);
            });

            // remove duplicates
            foreach ($filtered as $a) {
                $result[$a['trainer']] ??= $a; // only store if first occurrence of trainer
            }
            $array = array_values($result); // re-index and print

            $this->trainer[$item] = $array;
        }

        // combine trainer and trainer bag - array_merge_recursive won't work
        foreach ($this->trainer as $value => $item) {
            if (isset($this->bag[$value])) {
                foreach ($this->bag[$value] as $v) {
                    $this->trainer[$value][] = $v;
                }
            }
        }

        // quick & dirty -> set course leader TODO change / find better way?
        $trainer = Position::whereLeading(1)->first();
        $this->trainer['general'][0]['position'] = $trainer->id;
    }

    public function addTrainer($x)
    {
        $this->trainer[$x][] = [];
    }

    public function updatedTimeStart()
    {
        if (isset($this->editing->start)) {
            $this->editing->start = Carbon::createFromFormat(
                'd.m.Y H:i',
                $this->editing->start->format('d.m.Y') . ' ' . $this->time_start
            );
            $this->setStartTimeOptions([
                'defaultHour' => $this->editing->start->format('H'),
                'defaultMinute' => $this->editing->start->format('i'),
            ]);
            $this->checkCourseLength();
        }
    }

    public function updatedTimeEnd()
    {
        if (isset($this->editing->end)) {
            $this->editing->end = Carbon::createFromFormat(
                'd.m.Y H:i',
                $this->editing->end->format('d.m.Y') . ' ' . $this->time_end
            );
            $this->setEndTimeOptions([
                'defaultHour' => $this->editing->end->format('H'),
                'defaultMinute' => $this->editing->end->format('i'),
            ]);
            $this->checkCourseLength();
        }
    }

    public function setDayOptions()
    {
        if (isset($this->editing->start)) {
            $this->day_options['minDate'] = $this->editing->start->format('d.m.Y');
        }

        if (isset($this->editing->end)) {
            $this->day_options['maxDate'] = $this->editing->end->format('d.m.Y');
        }
    }

    public function checkCourseLength()
    {
        if (! $this->editing->course_type_id) {
            $this->editing->course_type_id = CourseTypeModel::first()->id;
        }

        if ($this->editing->type->units_per_day) {
            $unit_length = (int)$this->editing->type->units_per_day * 45;
        } else {
            $unit_length = 9 * 45;
        }

        $breaks = $this->editing->type->breaks;
        $length = (int)$unit_length + (int)$breaks;

        // no end before start date, please
        if (
            isset($this->editing->start) && ! isset($this->editing->end)
            || $this->editing->end->subMinutes($length)->lt($this->editing->start)
        ) {
            $this->editing->end = $this->editing->start->addMinutes($length);
            $this->time_end = $this->editing->end->format('H:i');
            $this->setEndTimeOptions([
                'defaultHour' => $this->editing->end->format('H'),
                'defaultMinute' => $this->editing->end->format('i'),
            ]);
        }

        // longer then one day?
        if (isset($this->editing->start) && ! $this->editing->start->isSameDay($this->editing->end)) {
            // if only first & last day or less is set, set / update it
            if (count($this->courseDays) <= 2) {
                $this->courseDays[0]['date'] = $this->editing->start->format('d.m.Y');
                $this->courseDays[0]['startTime'] = $this->editing->start->format('H:i');
                $this->courseDays[0]['endTime'] = $this->editing->end->format('H:i');
                $this->courseDays[0]['order'] = $this->editing->start->format('Y/m/d');

                $this->courseDays[1]['date'] = $this->editing->end->format('d.m.Y');
                $this->courseDays[1]['startTime'] = $this->editing->start->format('H:i');
                $this->courseDays[1]['endTime'] = $this->editing->end->format('H:i');
                $this->courseDays[1]['order'] = $this->editing->end->format('Y/m/d');

                $this->trainer[0] = [];
                $this->trainer[1] = [];
            }
        } else {
            $this->courseDays = [];
        }
    }

    public function participant($course)
    {
        return $this->redirect(
            route(
                'participant.course',
                ['course' => Hashids::encode($course)]
            )
        );
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
        $this->showRegisterCourse = false;

        if ($this->editing->isNot($course)) {
            $this->editing = $course;

            $this->priceIds = [];
            foreach ($this->editing->prices()->pluck('id') as $price) {
                $this->priceIds[] = (string) $price;
            }

            $this->date_range = $this->editing->start
                    ->format('d.m.y') . ' ' . _i('to') . ' ' . $this->editing->end->format('d.m.y');

            $this->resetFlatpickr();
            $this->setDayOptions();
            $this->setStartOptions(['defaultDate' => [$this->editing->start, $this->editing->end]]);
            $this->time_start = $this->editing->start->format('H:i');
            $this->setStartTimeOptions([
                'defaultHour' => $this->editing->start->format('H'),
                'defaultMinute' => $this->editing->start->format('i'),
            ]);

            $this->time_end = $this->editing->end->format('H:i');
            $this->setEndTimeOptions([
                'defaultHour' => $this->editing->end->format('H'),
                'defaultMinute' => $this->editing->end->format('i'),
            ]);

            // if there are courseDays, bring them to the site.
            $this->courseDays = [];
            $this->trainer = [];
            $i = 0;

            foreach ($this->editing->days as $courseDay) {
                $this->courseDays[] = [
                    'date' => Carbon::createFromFormat('Y-m-d', $courseDay['date'])->format('d.m.Y'),
                    'startTime' => Carbon::createFromFormat('H:i:s', $courseDay['startPlan'])->format('H:i'),
                    'endTime' => Carbon::createFromFormat('H:i:s', $courseDay['endPlan'])->format('H:i'),
                    'order' => Carbon::createFromFormat('Y-m-d', $courseDay['date'])->format('Y/m/d'),
                ];

                // add the trainer
                $x = 0;
                foreach ($courseDay->trainer as $trainer) {
                    if ($trainer->user_id === null) {
                        $t_id = $trainer->option;
                    } else {
                        $t_id = $trainer->user_id;
                    }
                    $this->trainer[$i][$x]['trainer'] = $t_id;
                    $this->trainer[$i][$x]['position'] = $trainer->position;
                    $x++;
                }

                // or an empty array to prevent error
                if (! isset($this->trainer[$i])) {
                    $this->trainer[$i] = [];
                }
                $i++;
            }

            $trainer = $this->editing->trainer->where('course_day_id', null)->sortBy('order');

            $i = 0;
            foreach ($trainer as $t) {
                if ($t->user_id === null) {
                    $t_id = $t->option;
                } else {
                    $t_id = $t->user_id;
                }
                $this->trainer['general'][$i]['trainer'] = $t_id;
                $this->trainer['general'][$i]['position'] = $t->position;
                $i++;
            }

            if ($this->editing->bag) {
                $bag = unserialize($this->editing->bag);
                foreach ($this->trainer as $value => $item) {
                    if (isset($bag[$value]) && count($bag[$value])) {
                        foreach ($bag[$value] as $v) {
                            $this->trainer[$value][] = $v;
                        }
                    }
                }
            }

            if (! isset($this->trainer['general']) || ! count($this->trainer['general'])) {
                $this->trainer['general'][]['trainer'] = [];
            }
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

        if (config('qseh.codeNumber') && config('qseh.password')) {
            // it's a QSEH course and already registered
            if (
                $this->editing->registration_number
                && $this->editing->registration_number != 'queued'
                && $this->editing->registration_number != 'failed'
                && $this->editing->type->wsdl_id
            ) {
                event(new CourseCancelled($this->editing));
            }
        }

        $this->editing->cancelled = now();
        $this->editing->save();

        $this->showEditModal = false;
        $this->showCancelModal = false;
        $this->resetPage();
    }

    /**
     * @throws AuthorizationException
     */
    public function save()
    {
        $this->authorize('save', $this->editing);

        $this->validate();

        $this->editing->start = Carbon::parse($this->editing->start->format('Y-m-d H:i:s'));

        $this->editing->end = Carbon::parse($this->editing->end->format('Y-m-d H:i:s'));

        // check if there is a trainer bag and the course longer than 1 day
        if (count($this->bag) && $this->courseDays) {
            $this->editing->bag = serialize($this->bag);
        } else {
            $this->editing->bag = '';
        }

        $this->editing->save();

        $this->editing->prices()->sync($this->priceIds);

        // start to set the courseDays
        $courseDays = [];
        $date = [];

        if (! $this->courseDays) { // it's a one-day course
            $this->courseDays[] = [
                'date' => $this->editing->start->format('d.m.Y'),
                'startTime' => $this->editing->start->format('H:i'),
                'endTime' => $this->editing->end->format('H:i'),
            ];
        }

        foreach ($this->courseDays as $courseDay) {
            $courseDays[] = [
                'course_id' => $this->editing->id,
                'date' => Carbon::createFromFormat('d.m.Y', $courseDay['date']),
                'startPlan' => $courseDay['startTime'],
                'endPlan' => $courseDay['endTime'],
            ];
            $date[] = Carbon::createFromFormat('d.m.Y', $courseDay['date'])->format('Y-m-d');
        }

        // create / update the actual course days
        CourseDay::upsert(
            $courseDays,
            ['course_id', 'date'],
            ['startPlan', 'endPlan']
        );

        // and delete old course days
        CourseDay::where('course_id', $this->editing->id)
            ->whereNotIn('date', $date)
            ->delete();

        // update the course_days from the database to get actual ids
        $this->editing = $this->editing->fresh();

        $trainerDays = [];

        // save the trainer for the days TODO is this the best way?
        foreach ($this->trainer as $item => $value) {
            if ($item == 'general') { // for the complete course
                foreach ($value as $i => $v) {
                    if (
                        // it's a trainer / user_id
                        isset($v['trainer']) && is_numeric($v['trainer'])
                        || isset($v['trainer']) && $i === 0
                    ) {
                        $option = '';
                        if (! is_numeric($v['trainer'])) {
                            $option = $v['trainer'];
                            $v['trainer'] = null;
                        }

                        $trainerDays[] = [
                            'course_id' => $this->editing->id,
                            'user_id' => $v['trainer'],
                            'course_day_id' => null,
                            'position' => $v['position'],
                            'order' => $i,
                            'option' => $option,
                        ];
                    }
                }

                continue;
            }

            if (count($this->courseDays) > 1) { // more than one day
                // for a specific day
                foreach ($value as $i => $v) {
                    if (
                        // it's a trainer / user_id
                        isset($v['trainer'])
                            && is_numeric($v['trainer'])
                            && isset($this->editing->days[$item]->id)
                        || isset($v['trainer'])
                            && $i === 0
                            && isset($this->editing->days[$item]->id)
                    ) {
                        $option = '';
                        if (! is_numeric($v['trainer'])) {
                            $option = $v['trainer'];
                            $v['trainer'] = null;
                        }

                        $trainerDays[] = [
                            'course_id' => $this->editing->id,
                            'user_id' => $v['trainer'],
                            'course_day_id' => $this->editing->days[$item]->id,
                            'position' => $v['position'],
                            'order' => $i,
                            'option' => $option,
                        ];
                    }
                }
            }
        }

        // create / update the trainer
        TrainerDay::upsert(
            $trainerDays,
            ['course_id', 'user_id', 'course_day_id'],
            ['position', 'order', 'option']
        );

        // TODO better way to clean up?
        $actual_entries = TrainerDay::whereCourseId($this->editing->id)->orderByDesc('updated_at')->pluck('updated_at');

        // and delete old entries
        TrainerDay::where('course_id', $this->editing->id)
            ->whereNotIn('updated_at', [$actual_entries->first()])
            ->delete();

        $this->showEditModal = false;

        if (! $this->editing->internal_number) { // new course
            $this->editing->internal_number = 'queued';
            $this->editing->save();
            event(new CourseCreated($this->editing));
        }

        if (config('qseh.codeNumber') && config('qseh.password')) {
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
                event(new QsehCourseUpdated($this->editing));
            }
        }
    }

    /**
     * @return mixed
     */
    public function getRowsQueryProperty(): mixed
    {
        $team_ids = [];
        $courses = '';
        if (! Auth::user()->isAbleTo('user.*') && ! $this->showOnlyOwnCourses) { // can't see all courses
            $teams = Auth::user()->teams()->pluck('id');

            foreach ($teams as $team) {
                if (Auth::user()->isAbleTo('course.*', $team)) {
                    $team_ids[]['team_id'] = $team;
                }
            }
            $courses = CourseModel::whereIn('team_id', $team_ids)
                ->orWhereIn('id', Auth::user()->courses()->pluck('course_id'));
        }

        if ($this->showOnlyOwnCourses) {
            $courses = CourseModel::whereIn('id', Auth::user()->courses()->pluck('course_id'));
        }

        $query = CourseModel::query()
            ->when(
                is_object($courses), // can't see all courses
                fn ($query, $user_teams) => $query->whereIn('id', $courses->pluck('id'))
            )
            ->when(
                $this->filters['courseType'],
                fn ($query, $courseType) => $query->where('course_type_id', $courseType)
            )
            ->when(
                $this->filters['team'],
                fn ($query, $team) => $query->where('team_id', $team)
            )
            ->when(
                $this->filters['amount-min'],
                fn ($query, $amount) => $query->where('amount', '>=', $amount)
            )
            ->when(
                $this->filters['amount-max'],
                fn ($query, $amount) => $query->where('amount', '<=', $amount)
            )
            ->when(
                $this->filters['date-min'],
                fn ($query, $date) => $query->where('start', '>=', Carbon::parse($date))
            )
            ->when(
                $this->filters['date-max'],
                fn ($query, $date) => $query->where('start', '<=', Carbon::parse($date))
            )
            ->when(
                ! $this->filters['showCancelled'],
                fn ($query, $date) => $query->where('cancelled', '=', null)
            )
            ->when(
                $this->filters['showCancelled'],
                fn ($query, $date) => $query->where('cancelled', '<>', null)
            )
            ->when(
                $this->filters['search'],
                fn ($query, $search) => $query->whereLike(
                    ['seminar_location', 'street', 'location', 'internal_number', 'registration_number'],
                    $search
                )
            )
            ->with('type')
            ->with('team')
            ->with('days')
            ->with('trainer');

        return $this->applySorting($query);
    }

    public function getRowsProperty(): mixed
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getPositionsRowsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return Position::all()->sortBy('title');
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
        // if no date is manually set, set it to today
        if ($this->filters['date-min'] === null) {
            $this->filters['date-min'] = today()->format('d.m.Y');
        }

        return view('livewire.course', [
            'courses' => $this->rows,
            'teams' => $this->teamsRows,
            'positions' => $this->positionsRows,
        ])
            ->layout('layouts.app', [
                'metaTitle' => _i('Courses'),
                'active' => 'courses',
                'breadcrumb_back' => ['link' => route('course'), 'text' => _i('Courses')],
                'breadcrumbs' => [['link' => route('course'), 'text' => _i('Courses')]],
            ]);
    }

    /**
     * @return CourseModel
     */
    protected function makeBlankCourse(): CourseModel
    {
        $this->courseTypes = CourseTypeModel::all()->groupBy('category')->toBase();
        $this->prices = PriceModel::whereActive(1)->get();

        $this->resetFlatpickr();
        $this->registerCourse = false;
        $this->courseRegistered = false;
        $this->showRegisterCourse = false;

        $this->trainer = [];
        $this->trainer['general'][] = [];

        $this->courseDays = [];
        $this->date_range = '';
        $this->priceIds = [];

        return new CourseModel();
    }

    protected function resetFlatpickr(): void
    {
        $this->start_options = [
            'minDate' => 'today',
            'dateFormat' => 'd.m.y',
            'weekNumbers' => true,
            'locale' => app()->getLocale(),
            'mode' => 'range',
        ];

        $this->time_start = '9:00';
        $this->time_end = '16:30';

        $this->start_time_options = $this->time_options;
        $this->setStartTimeOptions([
            'defaultHour' => 9,
            'defaultMinute' => 0,
        ]);
        $this->end_time_options = $this->time_options;
        $this->setEndTimeOptions([
            'defaultHour' => 16,
            'defaultMinute' => 30,
        ]);

        $this->end_options = [
            'minDate' => 'today',
            'defaultHour' => 16,
            'defaultMinute' => 30,
            'dateFormat' => 'd.m.Y H:i',
            'weekNumbers' => true,
            'enableTime' => true,
            'time_24hr' => true,
            'locale' => app()->getLocale(),
        ];
    }
}
