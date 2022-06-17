@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.registration_form')}}
@endsection

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@section('breadcrumbs')
    <h1>{{__('Frontend.registration_form')}}</h1>
@endsection

@section('content')
    <div class="course-details border-bottom">
        <form id="course_form_register" enctype="multipart/form-data" action="{{route('frontend.course.register')}}" data-action="{{route('frontend.course.details.back')}}" method="POST">
            {{csrf_field()}}

            <input hidden id="get_country" value="{{ $course_country }}" />
            
            <input hidden name="min_age" value="{{ $min_age }}" />
            <input hidden name="max_age" value="{{ $max_age }}" />
            <input hidden name="accommodation_min_age" value="{{ $accommodation_min_age }}" />
            <input hidden name="accommodation_max_age" value="{{ $accommodation_max_age }}" />
            <input hidden name="custodian_min_age" value="{{ $custodian_min_age }}" />
            <input hidden name="custodian_max_age" value="{{ $custodian_max_age }}" />

            <h3>{{__('Frontend.personal_info')}}:</h3>
            <div class="study m-2">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fname" class="col-form-label">{{__('Frontend.first_name')}}*</label>
                            <input type="text" required class="form-control" id="fname" name="fname" placeholder="{{__('Frontend.first_name')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mname" class="col-form-label">{{__('Frontend.middle_name')}}</label>
                            <input type="mname" name="mname" class="form-control" id="mname" placeholder="{{__('Frontend.middle_name')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lname" class="col-form-label">{{__('Frontend.last_name')}}*</label>
                            <input type="text" required class="form-control" id="lname" name="lname" placeholder="{{__('Frontend.last_name')}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city" class="col-form-label">{{__('Frontend.place_of_birth')}}*</label>
                            <input type="text" required class="form-control" name="place_of_birth" id="place_of_birth" placeholder="{{__('Frontend.city_country')}}*">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="gender" class="col-form-label">{{__('Frontend.gender')}}*</label>
                            <select name="gender" class="form-control" required>
                                <option value="">{{__('Frontend.please_select')}}</option>
                                <option value="male">{{__('Frontend.male')}}</option>
                                <option value="female">{{__('Frontend.female')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dob" class="col-form-label">{{__('Frontend.date_of_birth')}}*</label>
                            <input class="form-control" required type="date" name="dob">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nat" class="col-form-label">{{__('Frontend.nationality')}}*</label>
                            <select required name="nationality" class="form-control" id="nat">
                                <option value="Saudi Arabian"> Saudi Arabian</option>
                                <option value="Emirati"> Emirati</option>
                                <option value="Bahraini"> Bahraini</option>
                                <option value="Kuwaiti"> Kuwaiti</option>
                                <option value="Omani"> Omani</option>
                                <option value="Qatari"> Qatari</option>
                                <option value="Afghan"> Afghan</option>
                                <option value="Albanian"> Albanian</option>
                                <option value="Algerian"> Algerian</option>
                                <option value="American"> American</option>
                                <option value="Andorran"> Andorran</option>
                                <option value="Angolan"> Angolan</option>
                                <option value="Anguillan"> Anguillan</option>
                                <option value="Argentine"> Argentine</option>
                                <option value="Armenian"> Armenian</option>
                                <option value="Australian"> Australian</option>
                                <option value="Austrian"> Austrian</option>
                                <option value="Azerbaijani"> Azerbaijani</option>
                                <option value="Bahamian"> Bahamian</option>
                                <option value="Bangladeshi"> Bangladeshi</option>
                                <option value="Barbadian"> Barbadian</option>
                                <option value="Belarusian"> Belarusian</option>
                                <option value="Belgian"> Belgian</option>
                                <option value="Belizean"> Belizean</option>
                                <option value="Beninese"> Beninese</option>
                                <option value="Bermudian"> Bermudian</option>
                                <option value="Bhutanese"> Bhutanese</option>
                                <option value="Bolivian"> Bolivian</option>
                                <option value="Botswanan"> Botswanan</option>
                                <option value="Brazilian"> Brazilian</option>
                                <option value="British"> British</option>
                                <option value="British Virgin Islander"> British Virgin Islander</option>
                                <option value="Bruneian"> Bruneian</option>
                                <option value="Bulgarian"> Bulgarian</option>
                                <option value="Burkinan"> Burkinan</option>
                                <option value="Burmese"> Burmese</option>
                                <option value="Burundian"> Burundian</option>
                                <option value="Cambodian"> Cambodian</option>
                                <option value="Cameroonian"> Cameroonian</option>
                                <option value="Canadian"> Canadian</option>
                                <option value="Cape Verdean"> Cape Verdean</option>
                                <option value="Cayman Islander"> Cayman Islander</option>
                                <option value="Central African"> Central African</option>
                                <option value="Chadian"> Chadian</option>
                                <option value="Chilean"> Chilean</option>
                                <option value="Chinese"> Chinese</option>
                                <option value="Citizen of Antigua and Barbuda"> Citizen of Antigua and Barbuda</option>
                                <option value="Citizen of Bosnia and Herzegovina"> Citizen of Bosnia and Herzegovina</option>
                                <option value="Citizen of Guinea-Bissau"> Citizen of Guinea-Bissau</option>
                                <option value="Citizen of Kiribati"> Citizen of Kiribati</option>
                                <option value="Citizen of Seychelles"> Citizen of Seychelles</option>
                                <option value="Citizen of the Dominican Republic"> Citizen of the Dominican Republic</option>
                                <option value="Citizen of Vanuatu"> Citizen of Vanuatu</option>
                                <option value="Colombian"> Colombian</option>
                                <option value="Comoran"> Comoran</option>
                                <option value="Congolese (Congo)"> Congolese (Congo)</option>
                                <option value="Congolese (DRC)"> Congolese (DRC)</option>
                                <option value="Cook Islander"> Cook Islander</option>
                                <option value="Costa Rica"> Costa Rican</option>
                                <option value="Croatian"> Croatian</option>
                                <option value="Cuban"> Cuban</option>
                                <option value="Cymraes"> Cymraes</option>
                                <option value="Cymro"> Cymro</option>
                                <option value="Cypriot"> Cypriot</option>
                                <option value="Czech"> Czech</option>
                                <option value="Danish"> Danish</option>
                                <option value="Djiboutian"> Djiboutian</option>
                                <option value="Dominican"> Dominican</option>
                                <option value="Dutch"> Dutch</option>
                                <option value="East Timorese"> East Timorese</option>
                                <option value="Ecuadorean"> Ecuadorean</option>
                                <option value="Egyptian"> Egyptian</option>
                                <option value="English"> English</option>
                                <option value="Equatorial Guinean"> Equatorial Guinean</option>
                                <option value="Eritrean"> Eritrean</option>
                                <option value="Estonian"> Estonian</option>
                                <option value="Ethiopian"> Ethiopian</option>
                                <option value="Faroese"> Faroese</option>
                                <option value="Fijian"> Fijian</option>
                                <option value="Filipino"> Filipino</option>
                                <option value="Finnish"> Finnish</option>
                                <option value="French"> French</option>
                                <option value="Gabonese"> Gabonese</option>
                                <option value="Gambian"> Gambian</option>
                                <option value="Georgian"> Georgian</option>
                                <option value="German"> German</option>
                                <option value="Ghanaian"> Ghanaian</option>
                                <option value="Gibraltarian"> Gibraltarian</option>
                                <option value="Greek"> Greek</option>
                                <option value="Greenlandic"> Greenlandic</option>
                                <option value="Grenadian"> Grenadian</option>
                                <option value="Guamanian"> Guamanian</option>
                                <option value="Guatemalan"> Guatemalan</option>
                                <option value="Guinean"> Guinean</option>
                                <option value="Guyanese"> Guyanese</option>
                                <option value="Haitian"> Haitian</option>
                                <option value="Honduran"> Honduran</option>
                                <option value="Hong Konger"> Hong Konger</option>
                                <option value="Hungarian"> Hungarian</option>
                                <option value="Icelandic"> Icelandic</option>
                                <option value="Indian"> Indian</option>
                                <option value="Indonesian"> Indonesian</option>
                                <option value="Iranian"> Iranian</option>
                                <option value="Iraqi"> Iraqi</option>
                                <option value="Irish"> Irish</option>
                                <option value="Italian"> Italian</option>
                                <option value="Ivorian"> Ivorian</option>
                                <option value="Jamaican"> Jamaican</option>
                                <option value="Japanese"> Japanese</option>
                                <option value="Jordanian"> Jordanian</option>
                                <option value="Kazakh"> Kazakh</option>
                                <option value="Kenyan"> Kenyan</option>
                                <option value="Kittitian"> Kittitian</option>
                                <option value="Kosovan"> Kosovan</option>
                                <option value="Kyrgyz"> Kyrgyz</option>
                                <option value="Lao"> Lao</option>
                                <option value="Latvian"> Latvian</option>
                                <option value="Lebanese"> Lebanese</option>
                                <option value="Liberian"> Liberian</option>
                                <option value="Libyan"> Libyan</option>
                                <option value="Liechtenstein citizen"> Liechtenstein citizen</option>
                                <option value="Lithuanian"> Lithuanian</option>
                                <option value="Luxembourger"> Luxembourger</option>
                                <option value="Macanese"> Macanese</option>
                                <option value="Macedonian"> Macedonian</option>
                                <option value="Malagasy"> Malagasy</option>
                                <option value="Malawian"> Malawian</option>
                                <option value="Malaysian"> Malaysian</option>
                                <option value="Maldivian"> Maldivian</option>
                                <option value="Malian"> Malian</option>
                                <option value="Maltese"> Maltese</option>
                                <option value="Marshallese"> Marshallese</option>
                                <option value="Martiniquais"> Martiniquais</option>
                                <option value="Mauritanian"> Mauritanian</option>
                                <option value="Mauritian"> Mauritian</option>
                                <option value="Mexican"> Mexican</option>
                                <option value="Micronesian"> Micronesian</option>
                                <option value="Moldovan"> Moldovan</option>
                                <option value="Monegasque"> Monegasque</option>
                                <option value="Mongolian"> Mongolian</option>
                                <option value="Montenegrin"> Montenegrin</option>
                                <option value="Montserratian"> Montserratian</option>
                                <option value="Moroccan"> Moroccan</option>
                                <option value="Mosotho"> Mosotho</option>
                                <option value="Mozambican"> Mozambican</option>
                                <option value="Namibian"> Namibian</option>
                                <option value="Nauruan"> Nauruan</option>
                                <option value="Nepalese"> Nepalese</option>
                                <option value="New Zealander"> New Zealander</option>
                                <option value="Nicaraguan"> Nicaraguan</option>
                                <option value="Nigerian"> Nigerian</option>
                                <option value="Niuean"> Niuean</option>
                                <option value="North Korean"> North Korean</option>
                                <option value="Northern Irish"> Northern Irish</option>
                                <option value="Norwegian"> Norwegian</option>
                                <option value="Pakistani"> Pakistani</option>
                                <option value="Palauan"> Palauan</option>
                                <option value="Palestinian"> Palestinian</option>
                                <option value="Panamanian"> Panamanian</option>
                                <option value="Papua New Guinean"> Papua New Guinean</option>
                                <option value="Paraguayan"> Paraguayan</option>
                                <option value="Peruvian"> Peruvian</option>
                                <option value="Pitcairn Islander"> Pitcairn Islander</option>
                                <option value="Polish"> Polish</option>
                                <option value="Portuguese"> Portuguese</option>
                                <option value="Prydeinig"> Prydeinig</option>
                                <option value="Puerto Rican"> Puerto Rican</option>
                                <option value="Romanian"> Romanian</option>
                                <option value="Russian"> Russian</option>
                                <option value="Rwandan"> Rwandan</option>
                                <option value="Salvadorean"> Salvadorean</option>
                                <option value="Sammarinese"> Sammarinese</option>
                                <option value="Samoan"> Samoan</option>
                                <option value="Sao Tomean"> Sao Tomean</option>
                                <option value="Scottish"> Scottish</option>
                                <option value="Senegalese"> Senegalese</option>
                                <option value="Serbian"> Serbian</option>
                                <option value="Sierra Leonean"> Sierra Leonean</option>
                                <option value="Singaporean"> Singaporean</option>
                                <option value="Slovak"> Slovak</option>
                                <option value="Slovenian"> Slovenian</option>
                                <option value="Solomon Islander"> Solomon Islander</option>
                                <option value="Somali"> Somali</option>
                                <option value="South African"> South African</option>
                                <option value="South Korean"> South Korean</option>
                                <option value="South Sudanese"> South Sudanese</option>
                                <option value="Spanish"> Spanish</option>
                                <option value="Sri Lankan"> Sri Lankan</option>
                                <option value="St Helenian"> St Helenian</option>
                                <option value="St Lucian"> St Lucian</option>
                                <option value="Stateless"> Stateless</option>
                                <option value="Sudanese"> Sudanese</option>
                                <option value="Surinamese"> Surinamese</option>
                                <option value="Swazi"> Swazi</option>
                                <option value="Swedish"> Swedish</option>
                                <option value="Swiss"> Swiss</option>
                                <option value="Syrian"> Syrian</option>
                                <option value="Taiwanese"> Taiwanese</option>
                                <option value="Tajik"> Tajik</option>
                                <option value="Tanzanian"> Tanzanian</option>
                                <option value="Thai"> Thai</option>
                                <option value="Togolese"> Togolese</option>
                                <option value="Tongan"> Tongan</option>
                                <option value="Trinidadian"> Trinidadian</option>
                                <option value="Tristanian"> Tristanian</option>
                                <option value="Tunisian"> Tunisian</option>
                                <option value="Turkish"> Turkish</option>
                                <option value="Turkmen"> Turkmen</option>
                                <option value="Turks and Caicos Islander"> Turks and Caicos Islander</option>
                                <option value="Tuvaluan"> Tuvaluan</option>
                                <option value="Ugandan"> Ugandan</option>
                                <option value="Ukrainian"> Ukrainian</option>
                                <option value="Uruguayan"> Uruguayan</option>
                                <option value="Uzbek"> Uzbek</option>
                                <option value="Vatican citizen"> Vatican citizen</option>
                                <option value="Venezuelan"> Venezuelan</option>
                                <option value="Vietnamese"> Vietnamese</option>
                                <option value="Vincentian"> Vincentian</option>
                                <option value="Wallisian"> Wallisian</option>
                                <option value="Welsh"> Welsh</option>
                                <option value="Yemeni"> Yemeni</option>
                                <option value="Zambian"> Zambian</option>
                                <option value="Zimbabwean"> Zimbabwean</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nat" class="col-form-label">{{__('Frontend.id_iqama_number')}}*</label>
                            <input type="text" name="id_number" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Passport" class="col-form-label">{{__('Frontend.passport_no')}}*</label>
                            <input required type="text" name="passport_number" class="form-control" placeholder="{{__('Frontend.passport_no')}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="portdate" class="col-form-label">{{__('Frontend.passport_date_of_issue')}}*</label>
                            <input required class="form-control" type="date" name="passport_date_of_issue">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="edate" class="col-form-label">{{__('Frontend.passport_date_of_expiry')}}*</label>
                            <input required class="form-control" type="date" name="passport_date_of_expiry">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fname" class="col-form-label">{{__('Frontend.upload_passport_copy')}}*</label>
                            <input required type="file" name="passport_copy" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nat" class="col-form-label">{{__('Frontend.your_level_of_language')}}</label>
                            <select name="level_of_language" class="form-control" id="nat">
                                <option value="">{{__('Frontend.please_select')}}</option>
                                <option value="beginner_a1">{{__('Frontend.beginner_a1')}}</option>
                                <option value="elementary_a2">{{__('Frontend.elementary_a2')}}</option>
                                <option value="intermediate_b1">{{__('Frontend.intermediate_b1')}}</option>
                                <option value="upper_intermediate_b2">{{__('Frontend.upper_intermediate_b2')}}</option>
                                <option value="advanced_c1">{{__('Frontend.advanced_c1')}}</option>
                                <option value="proficient_c2">{{__('Frontend.proficient_c2')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city" class="col-form-label">{{__('Frontend.study_finance')}}*</label>
                            <select name="study_finance" class="form-control" id="study_finance" onchange="checkFinancialGurantee()">
                                <option value="">{{__('Frontend.please_select')}}</option>
                                <option value="personal">{{__('Frontend.personal')}}</option>
                                <option value="scholarship">{{__('Frontend.scholarship')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" id="financial_guarantee">
                        <div class="form-group">
                            <label for="nat" class="col-form-label">{{__('Frontend.upload_financial_gurantee')}}</label>
                            <input type="file" name="financial_guarantee" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4" id="bank_statement">
                        <div class="form-group">
                            <label for="nat" class="col-form-label">{{__('Frontend.upload_bank_statement')}}</label>
                            <input type="file" name="bank_statement" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="best">{{__('Frontend.contact_details')}}:</h3>
            <div class="study m-2">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mobile" class="col-form-label">{{__('Frontend.mobile')}}*</label>
                            <input type="mobile" name="mobile" class="form-control" id="mobile" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Tel" class="col-form-label">{{__('Frontend.tel')}}</label>
                            <input type="tel" name="telephone" class="form-control" id="telephone" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Email" class="col-form-label">{{__('Frontend.email')}}*</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="Address" class="col-form-label">{{__('Frontend.address')}}*</label>
                            <input type="text" name="address" class="form-control" id="address" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Post" class="col-form-label">{{__('Frontend.post_code')}}*</label>
                            <input type="text" name="post_code" class="form-control" id="post_code" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city_contact" class="col-form-label">{{__('Frontend.city')}}*</label>
                            <input type="text" name="city_contact" class="form-control" id="city_contact" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="province_region" class="col-form-label">{{__('Frontend.province_region')}}</label>
                            <input type="text" name="province_region" class="form-control" id="province_region" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="country_contact" class="col-form-label">{{__('Frontend.country')}}*</label>
                            <input type="text" name="country_contact" class="form-control" id="country_contact" placeholder="">
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="best">{{__('Frontend.emergency_contact_details')}}:</h3>
            <div class="study m-2">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="full_name_emergency" class="col-form-label">{{__('Frontend.full_name')}}*</label>
                            <input type="text" name="full_name_emergency" class="form-control" id="full_name_emergency" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="relative_emergency" class="col-form-label">{{__('Frontend.relative')}}*</label>
                            <input type="text" name="relative_emergency" class="form-control" id="relative_emergency" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mobile_emergency" class="col-form-label">{{__('Frontend.mobile')}}*</label>
                            <input type="mobile" name="mobile_emergency" class="form-control" id="mobile_emergency" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="telephone_emergency" class="col-form-label">{{__('Frontend.tel')}}</label>
                            <input type="tel" name="telephone_emergency" class="form-control" id="telephone_emergency" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email_emergency" class="col-form-label">{{__('Frontend.email')}}*</label>
                            <input type="email" name="email_emergency" class="form-control" id="email_emergency" placeholder="">
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="best">{{__('Frontend.how_you_heard_about_link_for_study_abroad')}}</h3>
            <div class="study m-2">
                <div class="form-check form-check-inline">
                    <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_google" value="Google">
                    <label class="form-check-label" for="heard_where_google">{{__('Frontend.google')}}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_twitter" value="Twitter">
                    <label class="form-check-label" for="heard_where_twitter">{{__('Frontend.twitter')}}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_instagram" value="Instagram">
                    <label class="form-check-label" for="heard_where_instagram">{{__('Frontend.instagram')}}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_snapchat" value="Snapchat">
                    <label class="form-check-label" for="heard_where_snapchat">{{__('Frontend.snapchat')}}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_tiktok" value="Tiktok">
                    <label class="form-check-label" for="heard_where_tiktok">{{__('Frontend.tiktok')}}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_youtube" value="YouTube">
                    <label class="form-check-label" for="heard_where_youtube">{{__('Frontend.youtube')}}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_friend" value="Friend">
                    <label class="form-check-label" for="heard_where_friend">{{__('Frontend.friend')}}</label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="other">{{__('Frontend.other')}}</label>
                    <input name="other" type="text" class="form-control ml-3" id="other" placeholder="">
                </div>
            </div>

            <h3 class="best">{{__('Frontend.comment')}}</h3>
            <div class="study m-2">
                <textarea name="comments" class="form-control" id="comment" rows="3"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary px-5 py-3" onclick="backCourseDetail($(this))">{{__('Frontend.back')}}</button>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary px-5 py-3 pull-right" onclick="doRegister($(this))">{{__('Frontend.next')}}</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function checkFinancialGurantee() {
            var country_name = $("#get_country").val();
            var study_finance = $("#study_finance").val();

            if (study_finance == 'personal') {
                $("#financial_guarantee").hide();
                if ((country_name == 'USA' || country_name == 'usa' || country_name == 'united states of america')) {
                    $("#bank_statement").show();
                } else {
                    $("#bank_statement").hide();
                }
            } else {
                $("#financial_guarantee").show();
                $("#bank_statement").hide();
            }
        }

        function backCourseDetail(object) {
            var formdata = new FormData($(object).parents().find('#course_form_register')[0]);
            var urlname = ($(object).parents().find('#course_form_register').data('action'));
            $("#loader").show();
            console.log(formdata);

            $.ajax({
                type: 'POST',
                url: urlname,
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#loader").hide();
                    console.log(data);
                    if (data.success == true) {
                        $('.alert-success').show();
                        $('.alert-success p').html(data.data);
                        document.documentElement.scrollTop = 0;

                        window.location.href = data.url;
                    } else if(data.errors) {
                        $('.alert-danger').show();
                        $('.alert-danger ul').html('');
                        document.documentElement.scrollTop = 0;
                        for(var error in data.errors) {
                            $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                        }
                    }
                }
            });
        }

        function doRegister(object) {
            var formdata = new FormData($(object).parents().find('#course_form_register')[0]);
            var urlname = ($(object).parents().find('#course_form_register').attr('action'));
            $("#loader").show();
            console.log(formdata);

            $.ajax({
                type: 'POST',
                url: urlname,
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#loader").hide();
                    console.log(data);
                    if (data.success == true) {
                        window.location.href = data.url;
                    } else if (data.errors) {
                        var alert_messages = '';
                        if (typeof data.errors === 'object') {
                            for (const [error_key, error_value] of Object.entries(data.errors)) {
                                alert_messages += error_value + '\n';
                            }
                        } else if (typeof data.errors === 'array') {
                            for (let error_index = 0; error_index < data.errors.length; error_index++) {
                                alert_messages += data.errors[error_index] + '\n';
                            }
                        } else {
                            alert_messages += error + '\n';
                        }
                        alert(alert_messages);
                    }
                }
            });
        }
    </script>
@endsection