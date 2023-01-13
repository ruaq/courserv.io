<?php

namespace App\Http\Livewire;

use App\Events\CertificateRequested;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CourseParticipant extends Component
{
    use AuthorizesRequests;

    public bool $can_update = false;

    public bool $can_view = false;

    public bool $showCertModal = false;

    public bool $showDownloadModal = false;

    public bool $showCancelModal = false;

    public string $course;

    public array $select;

    public Course $course_data;

    public $course_types;

    public Participant $participant;

    public Collection $participants;

    public $certTemplate;

    protected function rules(): array
    {
        return [
            //            'editing.name' => 'required',
            //            'editing.email' => 'required|email:rfc|unique:users,email,'.$this->editing->id,
            'participant.payed' => 'bool|nullable',
            'participant.participated' => 'bool|nullable',
        ];
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->select = [];
        $this->participant = $this->makeBlankParticipant();
        $this->certTemplate = false;
    }

    public function participate(Participant $participant)
    {
        $this->authorize('update', $participant);

        $this->participant = $participant;

        $this->participant->participated ? $this->participant->participated = 0 : $this->participant->participated = 1;

        $this->validate();
        $this->participant->save();
    }

    public function pay(Participant $participant)
    {
        $this->authorize('update', $participant);

        $this->participant = $participant;

        $this->participant->payed ? $this->participant->payed = 0 : $this->participant->payed = 1;

        $this->validate();
        $this->participant->save();
    }

    public function showCancelModal(Participant $participant)
    {
        $this->authorize('update', $participant);
        $this->participant = $participant;
        $this->showCancelModal = true;
    }

    public function cancel()
    {
        $this->authorize('update', $this->participant);

        $this->participant->participated = 0;
        $this->participant->cancelled = now();
        $this->participant->save();
        $this->participant = $this->makeBlankParticipant();

        $this->showCancelModal = false;
    }

    public function showDetails(Participant $participant)
    {
        $this->authorize('view', $participant);

        return $this->redirect(
            route(
                'participant.details',
                ['participant' => Hashids::encode($participant->id)]
            )
        );
    }

    public function getCert()
    {
        if ($this->select) { // get selected participants
            $participants = $this->select;
        } else { // or all, if nothing selected
            $participants = $this->participants->pluck('id')->toArray();
        }

        // If file is already exists, delete
        $file = 'certTmp/'.Hashids::encode(auth()->id()).'-'.$this->course.'.pdf';
        if (Storage::exists($file)) {
            Storage::delete($file);
        }

        event(
            new CertificateRequested(
                auth()->user(),
                Hashids::decode($this->course),
                $this->certTemplate,
                $participants
            )
        );

        $this->showCertModal = false;
        $this->showDownloadModal = true;
    }

    public function checkDownload()
    {
        $file = 'certTmp/'.Hashids::encode(auth()->id()).'-'.$this->course.'.pdf';
        if (Storage::exists($file)) {
            $this->showDownloadModal = false;

            return Storage::download($file, 'cert-'.$this->course.'.pdf', ['Content-Type: application/pdf']);
        }
    }

    public function render()
    {
        $this->participants = Participant::whereCourseId(Hashids::decode($this->course))->orderBy('company')->get();

        $this->course_data = Course::whereId(Hashids::decode($this->course))->first();

        $this->authorize('viewParticipants', $this->course_data);

        // get the available cert templates for the course type - deprecated
//        $this->course_types = CourseType::whereId($this->course_data->course_type_id)
//            ->with('certTemplates')
//            ->first();

//        dd($this->course_types->certTemplates);

        return view('livewire.course-participant', [
            'companies' => $this->participants->groupBy('company'),
        ])
            ->layout('layouts.app', [
                'metaTitle' => _i('participants'),
                'active' => 'participants',
                'breadcrumb_back' => [
                    'link' => route('course'),
                    'text' => _i('Courses'),
                ],
                'breadcrumbs' => [
                    [
                        'link' => route('course'),
                        'text' => _i('Courses'),
                    ],
                    [
                        'link' => route('course'),
                        'text' => $this->course_data->internal_number,
                    ],
                    [
                        'link' => route(
                            'participant.course',
                            [
                                'course' => Hashids::encode($this->course_data->id),
                            ]
                        ),
                        'text' => _i('participants'),
                    ],
                ],
            ]);
    }

    protected function makeBlankParticipant(): Participant
    {
        return new Participant();
    }
}
