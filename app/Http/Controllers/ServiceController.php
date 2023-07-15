<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $departments = Department::where('is_service', 1)->get();

        return view('pages.services.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required'],
            'name_en' => ['required'],
            'min_price' => ['required', 'numeric', 'min:0'],
            'max_price' => ['required', 'numeric', 'min:0'],
            'department_id' => ['required'],
            'type' => ['required'],
        ], [
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'name.unique' => __('messages.name_used'),
            'min_price.required' => __('messages.min_price_required'),
            'max_price.required' => __('messages.max_price_required'),
            'department_id.required' => __('messages.department_required'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            'department_id' => $request->department_id,
            'type' => $request->type,
            'active' => $request->active ? 1 : 0,
        ];

        Service::create($data);

        return redirect(route('services.index'))->with('success', __('messages.added_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        $departments = Department::where('is_service', 1)->get();

        return view('pages.services.edit', compact('service', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required'],
            'name_en' => ['required'],
            'min_price' => ['required', 'numeric', 'min:0'],
            'max_price' => ['required', 'numeric', 'min:0'],
            'department_id' => ['required'],
            'type' => ['required'],
        ], [
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'name.unique' => __('messages.name_used'),
            'min_price.required' => __('messages.min_price_required'),
            'max_price.required' => __('messages.max_price_required'),
            'department_id.required' => __('messages.department_required'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            'department_id' => $request->department_id,
            'type' => $request->type,
            'active' => $request->active ? 1 : 0,
        ];

        $service->update($data);

        return redirect(route('services.index'))->with('success', __('messages.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return redirect(route('services.index'))->with('success', __('messages.deleted_successfully'));
    }
}
