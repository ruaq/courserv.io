<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Price as PriceModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * @property mixed $rows
 * @property mixed $rowsQuery
 * @property mixed $teamsRows
 */
class Price extends Component
{
    use WithPerPagePagination;
    use WithSorting;
    use WithCachedRows;
    use AuthorizesRequests;

    protected $queryString = ['sorts'];

    public bool $showEditModal = false;
    public string $sign = '€';
    public array $payment = [];

    public PriceModel $editing;

    protected function rules(): array
    {
        return [
            'editing.title' => 'required',
            'editing.description' => 'sometimes',
            'editing.tax_rate' => 'nullable',
            'editing.amount_net' => 'required',
            'editing.amount_gross' => 'required',
            'editing.currency' => 'required',
            'payment' => 'required',
        ];
    }

    public function mount()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->editing = $this->makeBlankModel();
    }

    public function updatedEditingCurrency()
    {
        $this->sign = PriceModel::SIGN[$this->editing->currency];
    }

    public function updatedEditingTaxRate()
    {
        if ($this->editing->amount_net) {
            $this->editing->amount_gross = $this->calcGross($this->editing->amount_net, $this->editing->tax_rate);
        }
    }

    public function updatedEditingAmountNet()
    {
        if ($this->editing->amount_net) {
            $this->editing->amount_net = $this->formatAmount($this->editing->amount_net);
            $this->editing->amount_gross = $this->calcGross($this->editing->amount_net, $this->editing->tax_rate);
        }

        if (! $this->editing->amount_net || $this->editing->amount_net < 0) {
            $this->editing->amount_net = '0.00';
            $this->editing->amount_gross = '0.00';
        }
    }

    public function updatedEditingAmountGross()
    {
        if ($this->editing->amount_gross) {
            $this->editing->amount_gross = $this->formatAmount($this->editing->amount_gross);
            $this->editing->amount_net = $this->calcNet($this->editing->amount_gross, $this->editing->tax_rate);
        }

        if (! $this->editing->amount_gross || $this->editing->amount_gross < 0) {
            $this->editing->amount_net = '0.00';
            $this->editing->amount_gross = '0.00';
        }
    }

    public function create()
    {
        $this->authorize('create', PriceModel::class);

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankModel();
            //           $this->permIds = [];
        }
        $this->showEditModal = true;
    }

    public function getRowsQueryProperty(): mixed
    {
        $query = PriceModel::query()
            ->when(
                ! Auth::user()->isAbleTo('team.*'), // can't see all teams
                fn ($query, $user_teams) => $query
                    ->whereIn('team_id', Auth::user()->teams()->pluck('id'))
            );

        return $this->applySorting($query);
    }

    public function getRowsProperty(): mixed
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function edit(PriceModel $price)
    {
        $this->authorize('update', $price);

        if ($this->editing->isNot($price)) {
            $this->editing = $price;
            $this->payment = unserialize($this->editing->payment);
        }
        $this->showEditModal = true;
    }

    /**
     * @throws AuthorizationException
     */
    public function save()
    {
        $this->editing->payment = serialize(array_filter($this->payment));

        if (! $this->editing->currency) { // no currency selected
            $this->editing->currency = 'EUR'; // set default
        }

        if (! $this->editing->tax_rate) { // no tax rate selected
            $this->editing->tax_rate = 0; // set default
        }

        if (! $this->editing->amount_net) { // no amount set
            $this->editing->amount_net = '0.00';
            $this->editing->amount_gross = '0.00';
        }

        $this->authorize('save', $this->editing);

        $this->validate();

        $this->editing->save();
        $this->showEditModal = false;
    }

    /**
     * @throws AuthorizationException
     */
    public function render()
    {
        $this->authorize('viewAny', PriceModel::class);

        return view('livewire.price', [
            'prices' => $this->rows,
        ])
            ->layout('layouts.app', [
                'metaTitle' => _i('Prices'),
                'active' => 'prices',
            ]);
    }

    protected function makeBlankModel(): PriceModel
    {
        $this->sign = '€'; // reset sign
        $this->payment = [];

        return new PriceModel();
    }

    protected function formatAmount($amount): string
    {
        /** @var float $amount */
        $amount = str_replace(',', '.', $amount); // make it a float

        return number_format($amount, 2, '.', ''); // format it nice / compatible
    }

    protected function calcGross($net, $taxRate): string
    {
        $tax = $net * $taxRate / 100;

        return number_format($net + $tax, 2, '.', '');
    }

    protected function calcNet($gross, $taxRate): string
    {
        $tax = $taxRate / 100 + 1;

        return number_format($gross / $tax, 2, '.', '');
    }
}
