<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = Role::paginate(10);

        return view('pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::orderBy('id')->get()->groupBy('section_name_en');

        return view('pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required', 'unique:roles,name_ar'],
            'name_en' => ['required', 'unique:roles,name_en'],
            'permissions' => ['required'],
        ], [
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'name_ar.unique' => __('messages.name_used'),
            'name_en.unique' => __('messages.name_used'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ];

        $role = Role::create($data);
        $role->permissions()->sync($request->permissions);

        return redirect(route('roles.index'))->with('success', __('messages.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::orderBy('id')->get()->groupBy('section_name_en');
        // dd($permissions);
        return view('pages.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required'],
            'name_en' => ['required'],
            'permissions' => ['required'],
        ], [
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'name_ar.unique' => __('messages.name_used'),
            'name_en.unique' => __('messages.name_used'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ];

        $role->update($data);
        $role->permissions()->sync($request->permissions);

        return redirect(route('roles.index'))->with('success', __('messages.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
