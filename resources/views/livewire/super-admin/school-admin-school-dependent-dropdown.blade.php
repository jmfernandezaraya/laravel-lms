<div>
    <div class="form-group">
        <label for="exampleSelectGender">{{__('SuperAdmin/backend.select_school')}}</label>
        <select  wire:change="getcountries($event.target.value)" name="school_id" class="form-control">
            <option value="">{{__('SuperAdmin/backend.select_school')}}</option>
            @foreach ($schools as $schools)
                <option value="{{$schools->id}}">{{$schools->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="exampleSelectGender">{{__('SuperAdmin/backend.select_country')}}</label>
        <select multiple name="country" class="form-control">
            {!! $select !!}
            {!! $countries !!}
        </select>
    </div>
    <div class="form-group">
        <label for="exampleSelectGender">{{__('SuperAdmin/backend.select_city')}}</label>
        <select multiple name="city" class="form-control">
            {!! $select !!}
            {!! $cities !!}
        </select>
    </div>
    <div class="form-group">
        <label for="exampleSelectGender">{{__('SuperAdmin/backend.select_branch')}}</label>
        <select name="branch[]" multiple multiple class="form-control">
            {!! $select !!}
            {!! $branches !!}
        </select>
    </div>
</div>