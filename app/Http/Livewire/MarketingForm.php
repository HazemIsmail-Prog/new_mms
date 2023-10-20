<?php

namespace App\Http\Livewire;

use App\Models\Marketing;
use Livewire\Component;

class MarketingForm extends Component
{
    public $marketing;

    public function rules()
    {
        return [
            'marketing.name' => ['required'],
            'marketing.phone' => ['required','min:8','max:8'],
            'marketing.type' => ['required'],
            'marketing.address' => ['nullable'],
            'marketing.notes' => ['nullable'],
        ];
    }

    public function mount(Marketing $marketing)
    {
        $this->marketing = $marketing;
    }

    public function save()
    {
        $validated = $this->validate();
        if ($this->marketing->id) {
            //edit
            $this->marketing->update($validated['marketing']);
            $this->reset();
        } else {
            //create
            $validated['marketing']['user_id'] = auth()->id();
            Marketing::create($validated['marketing']);
            $this->reset();
        }
        return redirect()->route('marketing.index');
    }

    public function render()
    {
        return view('livewire.marketing-form');
    }
}
