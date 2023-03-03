<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(): View
    {
        $areas = Area::orderBy('name_' . app()->getLocale())->paginate(10);
        return view('pages.areas.index', compact('areas'));
    }

    public function create(): View
    {
        return view('pages.areas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required', 'unique:areas,name_ar'],
            'name_en' => ['required', 'unique:areas,name_en'],
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

        $area = Area::create($data);
        return redirect(route('areas.index'))->with('success', __('messages.added_successfully'));
    }

    public function edit(Area $area): View
    {
        return view('pages.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $request->validate([
            'name_ar' => ['required'],
            'name_en' => ['required'],
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

        $area->update($data);
        return redirect(route('areas.index'))->with('success', __('messages.updated_successfully'));
    }

    public function destroy($id)
    {
        //
    }
}
