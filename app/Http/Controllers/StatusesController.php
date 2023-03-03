<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $statuses = Status::all();

        return view('pages.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status): View
    {
        return view('pages.statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status): RedirectResponse
    {
        $request->validate([
            'name_ar' => [
                'required',
                Rule::unique('statuses')->ignore($status),
            ],
            'name_en' => [
                'required',
                Rule::unique('statuses')->ignore($status),
            ],
        ], [
            'name_messages.required' => __('messages.name_ar_required'),
            'name_en.required' => __('messages.name_en_required'),
            'name_messages.unique' => __('messages.name_ar_used'),
            'name_en.unique' => __('messages.name_en_used'),
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'color' => $request->color,
        ];

        $status->update($data);

        return redirect(route('statuses.index'))->with('success', __('messages.updated_successfully'));
    }
}
