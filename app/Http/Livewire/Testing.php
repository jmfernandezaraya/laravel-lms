<?php

namespace App\Http\Livewire;

use App\Models\SuperAdmin\Course;
use Livewire\Component;

class Testing extends Component
{
    public $contacts, $name, $phone, $contact_id;

    public $updateMode = false;

    public $inputs = [];

    public $i = 1;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $this->contacts = Course::all();

        return view('livewire.testing');
    }
}