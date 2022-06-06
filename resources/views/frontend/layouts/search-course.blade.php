<form id="search-course-form" action="{{route('frontend.search.course')}}" method="POST">
    {{csrf_field()}}

    <div class="inner-form search-form">
        <div class="input-field">
            <div class="form-group">
                <label for="choose-language">{{ __('Frontend.choose_lang') }}</label>
                <select name="language" onchange="changeSearchLanguage()" class="form-control" id="choose-language">
                    <option value="">{{ __('Frontend.please_choose') }}</option>
                    @foreach ($languages as $language)
                        <option value="{{ $language->unique_id }}">{{ $language->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="input-field">
            <div class="form-group">
                <label for="choose-age">{{__('Frontend.your_age')}}</label>
                <select name="age" onchange="changeSearchAge()" class="form-control" id="choose-age">
                    <option value="">{{ __('Frontend.please_choose') }}</option>
                </select>
            </div>
        </div>

        <div class="input-field">
            <div class="form-group">
                <label for="choose-country">{{__('Frontend.country')}}</label>
                <select name="country" onchange="changeSearchCountry()" class="form-control" id="choose-country">
                    <option value="">{{ __('Frontend.please_choose') }}</option>
                </select>
            </div>
        </div>

        <div class="input-field">
            <div class="form-group">
                <label for="choose-program-type">{{__('Frontend.program_type')}}</label>
                <select name="program_type" onchange="changeSearchProgramType()" class="form-control" id="choose-program-type">
                    <option value="">{{ __('Frontend.please_choose') }}</option>
                </select>
            </div>
        </div>

        <div class="input-field">
            <div class="form-group">
                <label for="choose-study-mode">{{__('Frontend.study_mode')}}</label>
                <select name="study_mode" onchange="changeSearchStudyMode()" class="form-control" id="choose-study-mode">
                    <option value="">{{ __('Frontend.please_choose') }}</option>
                </select>
            </div>
        </div>

        <div class="input-field">
            <div class="form-group">
                <label for="choose-start-date">{{__('Frontend.start_date')}}</label>
                <div class="input-icon-wrap">
                    <input class="datepicker" id="start_date" name="start_date" type="date" placeholder="<?php echo date("d M Y")?>" />
                </div>
            </div>
        </div>

        <div class="input-field">
            <a href="javascript:void(0);">
                <button class="btn-search" type="button" onclick="searchCourse()">{{ __('Frontend.search') }}</button>
            </a>
            <a href="javascript:void(0);">
                <input type="hidden" value="collapsed" name="advanced" />
                <button class="btn-advanced-search" type="button" onclick="toggleAdvancedSearch()">{{ __('Frontend.advanced_search') }}</button>
            </a>
        </div>
    </div>

    <div class="inner-form advance-search-form" style="display: none;">
        <div class="input-field">
            <div class="form-group">
                <label for="choose-city">{{ __('Frontend.city') }}</label>
                <select name="city" onchange="changeSearchCity()" class="form-control" id="choose-city">
                    <option value="">{{ __('Frontend.please_choose') }}</option>
                </select>
            </div>
        </div>
        <div class="input-field">
            <div class="form-group">
                <label for="choose-program-name">{{ __('Frontend.program_name') }}</label>
                <select name="program_name" onchange="changeSearchProgramName()" class="form-control" id="choose-program-name">
                    <option value="">{{ __('Frontend.please_choose') }}</option>
                </select>
            </div>
        </div>
        <div class="input-field">
            <div class="form-group">
                <label for="choose-program-duration">{{ __('Frontend.program_duration') }}</label>
                <select name="program_duration" class="form-control" id="choose-program-duration">
                    <option value="">{{ __('Frontend.please_choose') }}</option>
                </select>
            </div>
        </div>
    </div>
</form>