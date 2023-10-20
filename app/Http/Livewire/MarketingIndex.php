<?php

namespace App\Http\Livewire;

use App\Models\Marketing;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;


class MarketingIndex extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $types;
    public $pagination = 10;
    protected $marketings;
    public $areas = [];
    public $creators = [];
    public $technicians = [];
    public $departments = [];
    public $tags = [];
    public $statuses = [];
    public $filter = [];

    public function mount(Request $request)
    {
        $this->filter =
            [
                'name' => '',
                'phone' => '',
                'start_created_at' => '',
                'end_created_at' => '',
                'creators' => [],
                'types' => $request->type ?? [],
            ];
        request()->query->remove('start_completed_at');
        request()->query->remove('end_completed_at');
        request()->query->remove('type');
    }

    public function getData()
    {
        $this->marketings = Marketing::query()
            ->filterWhenRequest($this->filter)
            ->with(['user'])
            ->latest('id');
    }

    // public function export()
    // {
    //     $this->getData();
    //     return Excel::download(new OrdersExport('pages.orders.excel', 'Orders', $this->orders->get()), 'Orders.xlsx');  //Excel
    // }

    public function updatedFilter()
    {
        $this->resetPage();
    }


    public function render()
    {
        $this->creators = User::whereHas('marketings')->get();
        $this->types = ['marketing', 'information', 'service_not_available'];

        $this->getData();
        $marketings = $this->marketings->paginate($this->pagination);
        return view('livewire.marketing-index', compact('marketings'));
    }





}
