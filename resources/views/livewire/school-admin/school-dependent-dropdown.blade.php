<div>
    <div class="form-group">
        <label for="exampleSelectGender">{{__('Admin/backend.select_school')}}</label>
        <select wire:change="getcountries($event.target.value)" name="school_id" class="form-control">
            <option value="{{optional($schools)->id}}">{{optional($schools)->name}}</option>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleSelectGender">{{__('Admin/backend.select_country')}}</label>
        <select multiple name="country" class="form-control">
            {!! $select !!}
            {!! $countries !!}
        </select>
    </div>
    <div class="form-group">
        <label for="exampleSelectGender">{{__('Admin/backend.select_city')}}</label>
        <select multiple name="city" class="form-control">
            {!! $select !!}
            {!! $cities !!}
        </select>
    </div>
    <div class="form-group">
        <label for="exampleSelectGender">{{__('Admin/backend.select_branch')}}</label>
        <select name="branch[]" multiple multiple class="form-control">
            {!! $select !!}
            {!! $branches !!}
        </select>
    </div>
</div>
