<?php

namespace App\Http\Livewire\SuperAdmin;

use App\Models\SuperAdmin\School;
use Livewire\Component;

class SchoolAdminSchoolDependentDropdown extends Component
{
    public $countries, $select, $cities, $branches, $value = "<button>no button</button>";

    public function mount()
    {
        $select = __('Admin/backend.select');
        $this->select = "<option value='' selected>$select</option>";
    }

    public function render()
    {
        $schools = School::all()->unique('name')->values()->all();

        return view('livewire.super-admin.school-admin-school-dependent-dropdown', compact('schools'));
    }

    public function getcountries($selectOption)
    {
        $schools = School::find($selectOption);
        $this->countries = '';

        foreach ($schools->getCityCountryState()->getCountry() as $countries) {
            $this->countries .= "<option value=$schools->id>$countries</option>";
        }
        $this->cities = '';
        foreach ($schools->getCityCountryState()->getCity() as $cities) {
            $this->cities .= "<option value=$schools->id>$cities</option>";
        }
        $this->branches = '';

        if (is_array($schools->getCityCountryState()->getBranch()) && !empty($schools->getCityCountryState()->getBranch())) {
            foreach ($schools->getCityCountryState()->getBranch() as $branches) {
                $this->branches .= "<option value=$schools->id>$branches</option>";
            }
        }
    }
}