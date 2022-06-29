<?php

namespace App\Http\Livewire\SchoolAdmin;

use App\Models\SuperAdmin\School;
use Livewire\Component;

class SchoolDependentDropdown extends Component
{
    public $countries, $select, $cities, $branches, $value = "<button>no button</button>";

    public function mount()
    {
        $select = __('Admin/backend.select');
        $this->select = "<option value='' selected>$select</option>";
    }

    public function render()
    {
        $id = optional(auth()->user()->userSchool)->school_id;
        $schools = School::find($id);
        if($schools) {
            foreach ($schools->getCityCountryState()->getCountry() as $countries) {
                $this->countries .= "<option value=$schools->id>$countries</option>";
            }
            foreach ($schools->getCityCountryState()->getCity() as $cities) {
                $this->cities .= "<option value=$schools->id>$cities</option>";
            }

            foreach ($schools->getCityCountryState()->getBranch() as $branches) {
                $this->branches .= "<option value=$schools->id>$branches</option>";
            }
        }

        return view('livewire.school-admin.school-dependent-dropdown', compact('schools'));
    }
}