@extends('frontend.layouts.app')

@section('css')
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    #sig-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 15px;
        cursor: crosshair;
    }
    
    #financial_guarantee {
        display: none;
    }
    
    #bank_statement {
        display: none;
    }
    
    .diff-tution {
        color: #b94443;
    }
    
    #signature {
        border: 2px solid black;
    }
    
    form > * {
        margin: 10px;
    }
    
    @media (max-width: 400px) {
        #sig-canvas {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="breadcrumbs" data-aos="fade-in">
    <div class="container">
        <h2>Reservation-detail</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- reservation -->
<div class="container">
    <div class="inter-full mt-3">
        <div class="course-details border-bottom">
            @include('schooladmin.include.alert')

            <h1>Registration Form</h1>
            <h3>Reservation Details:</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>School Name</td>
                        <td>{{$schools->name}} - {{is_array($schools->branch_name) ? $schools->branch_name[0] : $schools->branch_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>{{$schools->city}}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td id="get_country">{{$schools->country}}</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="best">Course Detail:</h6>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Programme Name</td>
                        <td>{{$course->program_name}}</td>
                    </tr>
                    <tr>
                        <td>Lessons / Hours P/W</td>
                        <td>{{$course->lessons_per_week}} Lessons/ {{$course->hours_per_week}} Hours</td>
                    </tr>
                    <tr>
                        <td>Duration</td>
                        <td>{{$request->program_duration}} Weeks</td>
                    </tr>
                    <tr>
                        <td>Start Date</td>
                        <td>{{$request->date_selected}}</td>
                    </tr>
                    <tr>
                        <td>End Date</td>
                        <td>{{$program_end_date}}</td>
                    </tr>
                    <tr>
                        <td>Age Range</td>
                        <td>{{$min_age}} - {{$max_age}} Years</td>
                    </tr>
                </tbody>
            </table>

            @if($accomodation)
                <h6 class="best">Accommodation Details:</h6>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Accommodation type</td>

                            <td>{{$accomodation->type}} - {{$accomodation->room_type}} - {{$accomodation->meal}}</td>
                        </tr>
                        <tr>
                            <td> Duration</td>
                            <td>{{$request->accommodation_duration}} Weeks</td>
                        </tr>
                        <tr>
                            <td>Start Date</td>
                            <td>{{$accommodation_start_date}}</td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td>{{$accommodation_end_date}}</td>
                        </tr>
                        <tr>
                            <td>Age Range</td>
                            <td>{{$accom_min_age}} - {{$accom_max_age}} Years</td>
                        </tr>
                    </tbody>
                </table>
            @endif
            
            @if(isset($airport->{'airport_name_' . get_language() }))
                <h6 class="best">Airport Transfer:</h6>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>{{isset($airport->{'airport_name_' . get_language() }) ? $airport->{'airport_name_' . get_language() } : '' }}</td>
                            <td>{{isset($airport->{'airport_service_name_' . get_language() }) ? $airport->{'airport_service_name_' . get_language() } : '' }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
            
            @if(isset($request->insurance_selected))
                <h6 class="best">Medical Insurance:</h6>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Start Date</td>
                            <td>{{\Carbon\Carbon::create($request->date_selected)->subDay()->format('d-m-Y') ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td>{{\Carbon\Carbon::create($request->date_selected)->subDay()->addWeeks($request->insurance_duration)->subDay()->format('d-m-Y') ?? ''}}</td>
                        </tr>
                    </tbody>
                </table>
            @endif

            <form id="course_form_paid" enctype="multipart/form-data" action="{{route('payment-gateway')}}" method="POST">
                <h6 class="best">Total Cost {{$request->total_fees}} {{$currency_name}} / {{$currency_price}} SAR</h6> {{--
                <h6 class="best">Total Cost SAR 10,000.00</h6>--}}
                <p>Please Note: Balance / final payment will be according to the exchange rate for the day of the payment
                </p>

                <?php
                    $array = (array)$request;
                    $array['total_fees'] = $request->total_fees . " " . $currency_name;
                    $array['other_currency'] = $currency_price . " " . "SAR";
                    $array['study_mode'] = $request->study_mode;
                    $array['age_selected'] = $request->age_selected;
                    $array['accommodation_end_date'] = $accommodation_start_date;
                    $array['accommodation_start_date'] = $accommodation_end_date;
                    unset($array['_token']);
                ?>
                {{csrf_field()}} @foreach($array as $key => $requests)

                <input hidden name="{{$key}}" value="{{$requests}}"> @endforeach

                <input hidden type="text" name="min_age" value="{{$min_age}}">
                <h1>Registration Form</h1>
                <h3>Personal Info:</h3>
                <div class="study row m-2">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="fname" class="col-sm-5 col-form-label"> First Name*</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="fname" required name="fname" placeholder="First Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="mname" class="col-sm-5 col-form-label">Middle Name</label>
                            <div class="col-text-7">
                                <input type="mname" name="mname" class="form-control" id="mname" placeholder="Middle Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="lname" class="col-sm-5 col-form-label"> Last Name*</label>
                            <div class="col-sm-7">
                                <input onchange="getName($('#fname').val(), $('#mname').val(), $(this).val())" type="text" required class="form-control" id="lname" name="lname" placeholder="Last Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="fname" class="col-sm-5 col-form-label"> Date Of Birth:</label>
                            <div class="col-sm-7">
                                <input class="form-control" required type="date" name="dob">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="city" class="col-sm-5 col-form-label">Place of Birth</label>
                            <div class="col-sm-7">
                                <input type="city" required class="form-control" name="place_of_birth" id="mname" placeholder="City">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-sm-7">
                                <input type="Country" required name="country" class="form-control" id="mname" placeholder="Country*">
                            </div>
                        </div>
                    </div>                        
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="city" class="col-sm-5 col-form-label">Gender</label>
                            <div class="col-sm-7">
                                <div class="form-check form-check-inline">
                                    <input required class="form-check-input" type="radio" name="gender" id="inlineCheckbox1" value="male">
                                    <label class="form-check-label" for="inlineCheckbox1">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="inlineCheckbox2" value="female">
                                    <label class="form-check-label" for="inlineCheckbox2">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nat" class="col-sm-5 col-form-label">Nationality</label>
                            <div class="col-sm-7">
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Passport" class="col-sm-5 col-form-label">Passport no.</label>
                            <div class="col-sm-7">
                                <input required type="text" name="passport_number" class="form-control" id="pport" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="portdate" class="col-sm-5 col-form-label"> Passport Date of Issue</label>
                            <div class="col-sm-7">
                                <input required class="form-control" type="date" name="passport_date_of_issue">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="edate" class="col-sm-5 col-form-label">Passport Date of Expiry</label>
                            <div class="col-sm-7">
                                <input required class="form-control" type="date" name="passport_date_of_expiry">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="fname" class="col-sm-5 col-form-label"> Upload Passport Copy Page of the details*
                            </label>
                            <div class="col-sm-7">
                                <input required type="file" name="passport_copy" class="form-control" id="fname" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="city" class="col-sm-5 col-form-label">Study Finance</label>
                            <div class="col-sm-7">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="study_finance" onclick="getBankStatement($(this).val()); displayFinancial($(this).val())" type="radio" id="inlineCheckbox1" value="personal">
                                    <label class="form-check-label" for="inlineCheckbox1">personal</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="study_finance" onclick="getBankStatement($(this).val()); displayFinancial($(this).val())" type="radio" id="inlineCheckbox2" value="scholarship">
                                    <label class="form-check-label" for="inlineCheckbox2">Scholarship</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="financial_guarantee">
                        <div class="form-group row">
                            <label for="nat" class="col-sm-5 col-form-label">Upload Financial Guarantee</label>
                            <div class="col-sm-7">
                                <input type="file" name="financial_guarantee" class="form-control" id="fname" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nat" class="col-sm-5 col-form-label">ID/ Lqama Number</label>
                            <div class="col-sm-7">
                                <input type="text" name="id_number" class="form-control" id="fname" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nat" class="col-sm-5 col-form-label">Your level of language?</label>
                            <div class="col-sm-7">
                                <select name="level_of_language" class="form-control" id="nat">
                                    <option value="">Please select</option>
                                    <option value="Beginner (A1)">Beginner (A1)</option>
                                    <option value="Elementary (A2)">Elementary (A2)</option>
                                    <option value="Intermediate (B1)">Intermediate (B1)</option>
                                    <option value="Upper Intermediate (B2)">Upper Intermediate (B2)</option>
                                    <option value="Advanced (C1)">Advanced (C1)</option>
                                    <option value="Proficient (C2)">Proficient (C2)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="best">Contact Details:</h6>
                <div class="study row m-2">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label">Mobile* </label>
                            <div class="col-sm-9">
                                <input type="mobile" name="mobile" class="form-control" id="mobile" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Tel" class="col-sm-3 col-form-label"> Tel</label>
                            <div class="col-sm-9">
                                <input type="number" name="telephone" class="form-control" id="Tel" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Email" class="col-sm-3 col-form-label">Email*</label>
                            <div class="col-sm-9">
                                <input type="text" name="email" class="form-control" id="Email" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Address" class="col-sm-3 col-form-label">Address*</label>
                            <div class="col-sm-9">
                                <input type="text" name="address" class="form-control" id="Address" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Post" class="col-sm-3 col-form-label">Post Code*</label>
                            <div class="col-sm-9">
                                <input type="text" name="post_code" class="form-control" id="Post" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="City1" class="col-sm-3 col-form-label">City*</label>
                            <div class="col-sm-9">
                                <input type="text" name="city_contact" class="form-control" id="City1" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="City1" class="col-sm-3 col-form-label">Country*</label>
                            <div class="col-sm-9">
                                <input type="text" name="country_contact" class="form-control" id="City1" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="best">Emergency Contact Details:</h6>
                <div class="study row m-2">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="fullname" class="col-sm-3 col-form-label">Full Name*</label>
                            <div class="col-sm-9">
                                <input type="text" name="full_name_emergency" class="form-control" id="fullname" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Relative" class="col-sm-3 col-form-label">Relative*</label>
                            <div class="col-sm-9">
                                <input type="text" name="relative_emergency" class="form-control" id="Relative" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Mobile" class="col-sm-3 col-form-label">Mobile*</label>
                            <div class="col-sm-9">
                                <input type="Mobile" name="mobile_emergency" class="form-control" id="Mobile" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Tel1" class="col-sm-3 col-form-label">Tel*</label>
                            <div class="col-sm-9">
                                <input type="Tel1" name="telephone_emergency" class="form-control" id="Tel1" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="Email1" class="col-sm-3 col-form-label">Email*</label>
                            <div class="col-sm-9">
                                <input type="Email1" name="email_emergency" class="form-control" id="Email1" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="best">How you heard about link for study abroad?</h6>
                <div class="study row m-2">
                    <div class="form-check form-check-inline">
                        <input name="heard_where[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Google">
                        <label class="form-check-label" for="inlineCheckbox1">Google</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="heard_where[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Twitter">
                        <label class="form-check-label" for="inlineCheckbox1">Twitter</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="heard_where[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Instagram">
                        <label class="form-check-label" for="inlineCheckbox1">Instagram</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="heard_where[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Snapchat">
                        <label class="form-check-label" for="inlineCheckbox1">Snapchat</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="heard_where[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Tiktok">
                        <label class="form-check-label" for="inlineCheckbox1">Tiktok</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="heard_where[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="YouTube">
                        <label class="form-check-label" for="inlineCheckbox1">YouTube</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="heard_where[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Friend">
                        <label class="form-check-label" for="inlineCheckbox1">Friend</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="inlineCheckbox1">Other</label>
                        <input name="other" type="text" class="form-control ml-3" id="Email1" placeholder="">
                    </div>
                </div>

                <div class="study row m-2">
                    <h6 class="best">{{__('Frontend.comment'}}:</h6>
                    <textarea name="comments" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>

                <div class="study m-2">
                    <img src="{{asset('public/frontend/assets/img/logo.png')}}" class="img-fluid" alt="" style="width: 100px;">
                    <h6 class="best text-center">Registration/Cancelation Conditions:</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                    <h6 class="best">Face to face Program:</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                    <h6 class="best">Online Program:</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                    <div class="col-md-12" id="bank_statement">
                        <div class="form-group row">
                            <label for="bank" class="col-sm-3 col-form-label">Upload Bank Certifecate/Statment
                            </label>
                            <div class="col-sm-9">
                                <input type="file" name="bank_statement" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>{{__('Frontend.online_program'}}:</h1>
                            <div>
                                <input class="form-control col-sm-3" name="name" readonly id="your_name" placeholder="Your name">
                            </div>
                            <p>{{__('Frontend.legal_guardian_signature'}}:</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="sig-canvas" width="300" height="100"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" id="sig-submitBtn">{{__('Frontend.submit_signature'}}</button>
                            <button type="button" class="btn btn-danger" id="sig-clearBtn">{{__('Frontend.clear_signature'}}</button>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="signature" hidden id="sig-dataUrl" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <img id="sig-image" src="" alt="Your signature will go here!" />
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="guardian" class="col-sm-6 col-form-label">{{__('Frontend.name_of_the_legal_guardian'}}:</label>
                                <div class="col-sm-6">
                                    <input type="guardian" name="legal_guardian_name" class="form-control" id="guardian" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="iqama" class="col-sm-5 col-form-label">{{__('Frontend.id_iqama_number'}}:</label>
                                <div class="col-sm-7">
                                    <input type="iqama" class="form-control" name="legal_id_number" id="iqama" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="date" class="col-sm-6 col-form-label">{{__('Frontend.date'}}:</label>
                                <div class="col-sm-6">
                                    <p>
                                        <input class="form-control" readonly value="{{\Carbon\Carbon::now()->format('d-M-Y')}}">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="fullname" class="col-sm-5 col-form-label">{{__('Frontend.mobile'}}:</label>
                                <div class="col-sm-7">
                                    <input type="mobile" class="form-control" name="legal_mobile" id="mobile" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-check">
                            <input name="terms_and_conditions" class="form-check-input" type="checkbox" value="terms_and_conditions" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                I Read and Agreed to the(<a href="{{$schools->website_link}}">Registration Conditions</a>, <a href="{{$schools->website_link}}">Terms and
                                        Conditions</a> & <a href="{{$schools->website_link}}">Private Policy</a>) of Link for Study Abroad
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="terms" type="checkbox" value="terms" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                I Read and Agree to the <a href="{{$schools->website_link}}">Terms and Conditions</a> of the school/institute.
                            </label>
                        </div>
                        <p class="pt-2 diff-tution mb-0">Please note: Tuition fees need to be paid in full if you will apply for the "Student Visa to the Ireland, Australia and New Zealand" to issue payment receipt from school as per the embassy requiremet.</p>
                        <p class="diff-tution pt-2">The Tuition Fees are Refundable in case of visa Rejection</p>

                        <div class="w-100">
                            @if($program->program_registration_fee != null)
                                <h6 class="best">{{__('Frontend.deposit_registraion_fee'}}: {{$deposit }} {{$currency_name}} / {{ $deposit_price }} SAR</h6>
                            @else
                                <h6 class="best">{{__('Frontend.deposit_registraion_fee'}}: {{ $deposit_price }} SAR</h6> @endif @if(isset($request->courier_fee))
                                <h6 class="best">{{__('Frontend.courier_fee'}}: {{readCalculationFromDB('courier_fee')}} {{$currency_name}} / {{$courier_price}} SAR </h6>
                                <input hidden value="{{$courier_price}}" name="courier_fee">
                            @endif

                            <h6 class="best">{{__('Frontend.total'}} {{$request->total_fees}} {{$currency_name}} / {{$currency_price}}SAR</h6>
                        </div>

                        <input hidden id="fees_to_be_paid" value="{{$deposit_price}}" name="paid_amount">
                        <button type="button" onclick="register_now($(this))" class="btn btn-primary mt-1 choose">{{__('Frontend.apply_now'}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="loader"></div>

<script>
    function register_now(object) {
        var formdata = new FormData($(object).parents().find('#course_form_paid')[0]);
        var urlname = ($(object).parents().find('#course_form_paid').attr('action'));
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
                if(data.success == true) {
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

    function displayFinancial(val) {
        if(val == 'scholarship') {
            $("#financial_guarantee").show();
        } else {
            $("#financial_guarantee").hide();
        }
    }

    function getBankStatement(value) {
        var country_name = $("#get_country").text();

        if((country_name == 'USA' || country_name == 'usa' || country_name == 'united states of america') && value != 'scholarship') {
            $("#bank_statement").show();
            $("#get_country").append("<input hidden name='country_get' value=1>");
        } else {
            $("#bank_statement").hide();
        }

        if(value != 'scholarship') {
            $("#fees_to_be_paid").val({
                {
                    $deposit_price
                }
            });
            var fees_to = $("#fees_to_be_paid").val();
        } else {
            $("#fees_to_be_paid").val({
                {
                    $courier_price
                }
            });
            var fees_to = $("#fees_to_be_paid").val();
        }
    }

    (function() {
        window.requestAnimFrame = (function(callback) {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimaitonFrame ||
                function(callback) {
                    window.setTimeout(callback, 1000 / 60);
                };
        })();

        var canvas = document.getElementById("sig-canvas");
        var ctx = canvas.getContext("2d");
        ctx.strokeStyle = "#222222";
        ctx.lineWidth = 4;

        var drawing = false;
        var mousePos = {
            x: 0,
            y: 0
        };
        var lastPos = mousePos;

        canvas.addEventListener("mousedown", function(e) {
            drawing = true;
            lastPos = getMousePos(canvas, e);
        }, false);

        canvas.addEventListener("mouseup", function(e) {
            drawing = false;
        }, false);

        canvas.addEventListener("mousemove", function(e) {
            mousePos = getMousePos(canvas, e);
        }, false);

        // Add touch event support for mobile
        canvas.addEventListener("touchstart", function(e) {

        }, false);

        canvas.addEventListener("touchmove", function(e) {
            var touch = e.touches[0];
            var me = new MouseEvent("mousemove", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(me);
        }, false);

        canvas.addEventListener("touchstart", function(e) {
            mousePos = getTouchPos(canvas, e);
            var touch = e.touches[0];
            var me = new MouseEvent("mousedown", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(me);
        }, false);

        canvas.addEventListener("touchend", function(e) {
            var me = new MouseEvent("mouseup", {});
            canvas.dispatchEvent(me);
        }, false);

        function getMousePos(canvasDom, mouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: mouseEvent.clientX - rect.left,
                y: mouseEvent.clientY - rect.top
            }
        }

        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            }
        }

        function renderCanvas() {
            if(drawing) {
                ctx.moveTo(lastPos.x, lastPos.y);
                ctx.lineTo(mousePos.x, mousePos.y);
                ctx.stroke();
                lastPos = mousePos;
            }
        }

        // Prevent scrolling when touching the canvas
        document.body.addEventListener("touchstart", function(e) {
            if(e.target == canvas) {
                e.preventDefault();
            }
        }, false);
        document.body.addEventListener("touchend", function(e) {
            if(e.target == canvas) {
                e.preventDefault();
            }
        }, false);
        document.body.addEventListener("touchmove", function(e) {
            if(e.target == canvas) {
                e.preventDefault();
            }
        }, false);

        (function drawLoop() {
            requestAnimFrame(drawLoop);
            renderCanvas();
        })();

        function clearCanvas() {
            canvas.width = canvas.width;
        }

        // Set up the UI
        var sigText = document.getElementById("sig-dataUrl");
        var sigImage = document.getElementById("sig-image");
        var clearBtn = document.getElementById("sig-clearBtn");
        var submitBtn = document.getElementById("sig-submitBtn");
        clearBtn.addEventListener("click", function(e) {
            clearCanvas();
            sigText.innerHTML = "Data URL for your signature will go here!";
            sigImage.setAttribute("src", "");
        }, false);
        submitBtn.addEventListener("click", function(e) {
            var dataUrl = canvas.toDataURL();
            sigText.innerHTML = dataUrl;
            sigImage.setAttribute("src", dataUrl);
        }, false);

    })();

    function getName(fname, mname, lname) {
        var full_name = fname + " " + mname + " " + lname;
        $("#your_name").val(full_name);
    }
</script>
<!-- reservation_end -->
@endsection