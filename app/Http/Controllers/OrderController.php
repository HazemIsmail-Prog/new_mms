<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Area;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use App\Models\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $areas       = Area::all();
        // $areas       = Area::whereHas('orders')->get();
        $creators    = User::whereHas('orders_creator')->get();
        $technicians = User::whereHas('orders_technician')->get();
        $departments = Department::whereHas('orders')->get();
        $statuses    = Status::all();
        $orders      = Order::query()
                                    ->filterWhenRequest($request)
                                    ->with(['address', 'department', 'technician', 'creator','status', 'customer', 'phone'])
                                    ->latest('created_at');

        if ($request->action == 'excel') {
            return Excel::download(new OrdersExport('pages.orders.excel', 'Orders', $orders->get()), 'Orders.xlsx');  //Excel
        }

        $orders = $orders->paginate(10);
        return view('pages.orders.index', compact('orders', 'areas', 'creators', 'statuses', 'technicians', 'departments'));
    }
}
