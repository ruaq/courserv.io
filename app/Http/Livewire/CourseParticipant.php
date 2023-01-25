<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Jobs\ConcatCerts;
use App\Jobs\DeleteCerts;
use App\Jobs\GenerateCertificate;
use App\Models\Course;
use App\Models\Participant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Bus\Batch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property mixed $participantsRows
 * @property mixed $courseDataRows
 * @property mixed $participantsRowsQuery
 */
class CourseParticipant extends Component
{
    use AuthorizesRequests;
    use WithCachedRows;
    use WithPerPagePagination;
    use WithSorting;

    public bool $creationFailed = false;

    public bool $creationFinished = false;

    public bool $showDownloadModal = false;

    public bool $showCertModal = false;

    public bool $showCreationFailedModal = false;

    public bool $showWaitModal = false;

    public bool $showCancelModal = false;

    public string $batchId;

    public int $actCert = 1;

    public int $totalCert;

    public bool $concat = false;

    public int $courseId;

    public string $course;

    public array $select;

    public Course $course_data;

    public Participant $participant;

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

    /**
     * @throws AuthorizationException
     */
    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->select = [];
        $this->participant = $this->makeBlankParticipant();
        $this->certTemplate = false;

        $this->courseId = Hashids::decode($this->course)[0];

        $this->course_data = $this->courseDataRows;

        $this->authorize('viewParticipants', $this->course_data);
    }

    public function getParticipantsRowsQueryProperty()
    {
        $query = Participant::query()
            ->where('course_id', $this->courseId)
            ->orderBy('company')
        ;

        return $this->applySorting($query);
    }

    public function getParticipantsRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->participantsRowsQuery);
        });
    }

    public function getCourseDataRowsProperty()
    {
        return $this->cache(function () {
            return Course::whereId(Hashids::decode($this->course))->first();
        });
    }

    /**
     * @throws AuthorizationException
     */
    public function participate(Participant $participant)
    {
        $this->authorize('update', $participant);

        $this->participant = $participant;

        $this->participant->participated ? $this->participant->participated = 0 : $this->participant->participated = 1;

        $this->validate();
        $this->participant->save();
    }

    /**
     * @throws AuthorizationException
     */
    public function pay(Participant $participant)
    {
        $this->authorize('update', $participant);

        $this->participant = $participant;

        $this->participant->payed ? $this->participant->payed = 0 : $this->participant->payed = 1;

        $this->validate();
        $this->participant->save();
    }

    public function showCertModal()
    {
        $this->useCachedRows();

        $this->showCertModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function showCancelModal(Participant $participant)
    {
        $this->authorize('update', $participant);
        $this->useCachedRows();
        $this->participant = $participant;
        $this->showCancelModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function cancel()
    {
        $this->authorize('update', $this->participant);

        $this->participant->participated = 0;
        $this->participant->cancelled = now();
        $this->participant->save();
        $this->participant = $this->makeBlankParticipant();

        $this->showCancelModal = false;
    }

    /**
     * @throws AuthorizationException
     */
    public function showDetails(Participant $participant)
    {
        $this->authorize('view', $participant);
        $this->useCachedRows();

        return $this->redirect(
            route(
                'participant.details',
                ['participant' => Hashids::encode($participant->id)]
            )
        );
    }

    /**
     * @throws Throwable
     */
    public function getCert()
    {
        $this->authorize('viewParticipants', $this->course_data);
        $this->useCachedRows();

        if ($this->select) { // get selected participants
            $participants = $this->select;
        } else { // or all, if nothing selected
            // skip pagination and use $this->participantsRowsQuery instead of $this->participantsRows
            $participants = $this->participantsRowsQuery->pluck('id')->toArray();
        }

        $this->creationFinished = false;
        $this->concat = false;
        $this->actCert = 1;
        $this->totalCert = count($participants);

        $jobs = [];

        // chain the certificates
        foreach ($participants as $p) {
            $jobs[] = [GenerateCertificate::class, [$p]];
        }

        // chain the job to concat them
        $jobs[] = [ConcatCerts::class, [$participants]];

        $jobBag = array_map(function ($item) {
            return new $item[0](...$item[1]);
        }, array_slice($jobs, 0));

        $batch = Bus::batch([
            $jobBag,
        ])->then(function (Batch $batch) { // success
            //cleanup after 3 hour
            DeleteCerts::dispatch($batch->id)
                ->delay(now()->addHours(3));
        })->catch(function (Batch $batch, Throwable $e) { // failed
            // cleanup directly
            DeleteCerts::dispatch($batch->id)
                ->delay(now()->addSeconds(30));
        })->dispatch();

        $this->batchId = $batch->id;

        $this->showCertModal = false;
        $this->showWaitModal = true;
    }

    public function getCreationBatchProperty(): ?Batch
    {
        $this->useCachedRows();

        if (! $this->batchId) {
            return null;
        }

        return Bus::findBatch($this->batchId);
    }

    public function updateCreationProgress()
    {
        $this->useCachedRows();

        if (isset($this->creationBatch)) { // prevent error if it’s a long run / many participants
            if ($this->creationBatch->pendingJobs > 1) {
                $this->actCert = $this->creationBatch->processedJobs() + 1;
                $this->totalCert = $this->creationBatch->totalJobs - 1;
            } elseif ($this->creationBatch->pendingJobs == 1) {
                $this->concat = true;
            }

            $this->creationFinished = $this->creationBatch->finished();
        }

        if (isset($this->creationBatch)) { // prevent error if it’s a long run / many participants
            $this->creationFinished = $this->creationBatch->finished();
            $this->creationFailed = $this->creationBatch->failedJobs;
        }

        if ($this->creationFinished) {
            if ($this->creationFailed >= 5) {
                $this->showWaitModal = false;
                $this->showCreationFailedModal = true;
            }
            $this->checkDownload();
        }
    }

    public function checkDownload()
    {
        $this->useCachedRows();

        $this->showWaitModal = false;

        $file = 'certTmp/' . $this->batchId . '.pdf';

        if (! Storage::exists($file)) {
            $this->creationFailed = true;

            return;
        }

        $this->showDownloadModal = true;
    }

    public function downloadFile(): StreamedResponse
    {
        $this->useCachedRows();

        $this->showDownloadModal = false;
        $file = 'certTmp/' . $this->batchId . '.pdf';

        return Storage::download($file, 'cert-' . $this->course . '.pdf', ['Content-Type: application/pdf']);
    }

    /**
     * @throws AuthorizationException
     */
    public function render()
    {
        // get the available cert templates for the course type - deprecated
//        $this->course_types = CourseType::whereId($this->course_data->course_type_id)
//            ->with('certTemplates')
//            ->first();

//        dd($this->course_types->certTemplates);

        return view('livewire.course-participant', [
            'companies' => $this->participantsRows->groupBy('company'),
            'paginate' => $this->participantsRows,
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
