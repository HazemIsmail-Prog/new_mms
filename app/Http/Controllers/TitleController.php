<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() :View
    {
        $titles = Title::paginate(100);
        return view('pages.titles.index',compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() :View
    {
        return view('pages.titles.create');
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
            'name_ar' => [
                'required',
                'unique:titles'
            ],
            'name_en' => [
                'required',
                'unique:titles'
            ]
        ],[
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'name_ar.unique' => __('messages.name_used'),
            'name_en.unique' => __('messages.name_used'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'active' => $request->active ? 1 : 0
        ];

        Title::create($data);
        return redirect(route('titles.index'))->with('success', __('messages.added_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Title $title
     * @return View
     */
    public function edit(Title $title) :View
    {
        return view('pages.titles.edit',compact('title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Title $title
     * @return RedirectResponse
     */
    public function update(Request $request, Title $title) :RedirectResponse
    {
        $request->validate([
            'name_ar' => [
                'required',
                Rule::unique('titles')->ignore($title),
            ],
            'name_en' => [
                'required',
                Rule::unique('titles')->ignore($title),
            ],
        ],[
            'name_ar.required' => __('messages.name_required'),
            'name_en.required' => __('messages.name_required'),
            'name_ar.unique' => __('messages.name_used'),
            'name_en.unique' => __('messages.name_used'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'active' => $request->active ? 1 : 0
        ];

        $title->update($data);
        return redirect(route('titles.index'))->with('success', __('messages.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Title $title
     * @return RedirectResponse
     */
    public function destroy(Title $title) :RedirectResponse
    {
       $title->delete();
       return redirect(route('titles.index'))->with('success', __('messages.deleted_successfully'));
    }
}
