<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $departments = Department::paginate(10);

        return view('pages.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required'],
            'name_en' => ['required'],
        ], [
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'name.unique' => __('messages.name_used'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'active' => $request->active ? 1 : 0,
            'is_service' => $request->is_service ? 1 : 0,
        ];

        Department::create($data);

        return redirect(route('departments.index'))->with('success', __('messages.added_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): View
    {
        return view('pages.departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department): RedirectResponse
    {
        $request->validate([
            'name_ar' => [
                'required',
                Rule::unique('departments')->ignore($department),
            ],
            'name_en' => [
                'required',
                Rule::unique('departments')->ignore($department),
            ],
        ], [
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'name.unique' => __('messages.name_used'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'active' => $request->active ? 1 : 0,
            'is_service' => $request->is_service ? 1 : 0,
        ];

        $department->update($data);

        return redirect(route('departments.index'))->with('success', __('messages.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect(route('departments.index'))->with('success', __('messages.deleted_successfully'));
    }
}
