<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\Title;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::query()
        ->when(auth()->id() != 1 , function($q){
            $q->where('id','!=', 1);
        })
        ->with('departments','title','roles')
        ->paginate(1000);
        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $departments = Department::all();
        $roles = Role::all();
        $titles = Title::all();
        return view('pages.users.create', compact('departments','titles','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required'],
            'name_en' => ['required'],
            'username' => ['required', 'unique:users'],
            'email' => ['nullable', 'email'],
            'password' => ['required', 'min:5'],
            'title_id' => ['required'],
            'departments' => ['required'],
            'roles' => ['required'],
        ],[
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'username.required' => __('messages.username_required'),
            'username.unique' => __('messages.username_used'),
            'email.email' => __('messages.wrong_email'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min_5'),
            'title_id.required' => __('messages.title_required'),
            'departments.required' => __('messages.department_required'),
            'roles.required' => __('messages.roles_required'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'title_id' => $request->title_id,
            'active' => $request->active ? 1 : 0,
            'api_token' => bin2hex(openssl_random_pseudo_bytes(30)),
        ];

        $user = User::create($data);
        $user->departments()->sync($request->departments);
        $user->roles()->sync($request->roles);
        return redirect(route('users.index'))->with('success', __('messages.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user) :View
    {
        $departments = Department::all();
        $roles = Role::all();
        $titles = Title::all();
        return view('pages.users.edit', compact('user','titles','departments','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user) :RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required'],
            'name_en' => ['required'],
            'username' => ['required', 'unique:users,username,'.$user->id],
            'email' => ['nullable', 'email'],
            'password' => ['nullable', 'min:5'],
            'title_id' => ['required'],
            'departments' => ['required'],
            'roles' => ['required'],
        ],[
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'username.required' => __('messages.username_required'),
            'username.unique' => __('messages.username_used'),
            'email.email' => __('messages.wrong_email'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min_5'),
            'title_id.required' => __('messages.title_required'),
            'departments.required' => __('messages.department_required'),
            'roles.required' => __('messages.roles_required'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'username' => $request->username,
            'email' => $request->email,
            'title_id' => $request->title_id,
            'active' => $request->active ? 1 : 0
        ];

        $user->update($data);
        if ($request->password){
            $user->update(['password' => bcrypt($request->password),]);
        }

        $user->departments()->sync($request->departments);
        $user->roles()->sync($request->roles);
        return redirect(route('users.index'))->with('success', __('messages.updated_successfully'));    
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user) :RedirectResponse
    {
        $user->delete();
        return redirect(route('users.index'))->with('success', __('messages.deleted_successfully'));
    }

    public function replicateRecord(User $user)
    {
        $departments = Department::all();
        $roles = Role::all();
        $titles = Title::all();
        return view('pages.users.replicate', compact('user', 'titles', 'departments', 'roles'));
    }
}