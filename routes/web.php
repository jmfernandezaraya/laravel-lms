<?php

use App\Http\Controllers\Frontend\ApplyVisaController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CourseControllerFrontend;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\FrontendController;

use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\CourseDetailsController;
use App\Http\Controllers\SuperAdmin\CourseFormController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

///// Test Routes /////
Route::get('test_school', function() {
    $school =  \App\Models\SuperAdmin\School::find(21);
    return $school->getCityCountryStatewithCommas()->branch;
});
Route::get('tesetCourseSend', 'Frontend\FrontendController@testCourseNotification');
Route::view('superamin/test_livewire', 'superadmin.test');

///// Frontend Routes Start /////
Route::post('visa_submit', [ApplyVisaController::class, 'applyForVisaPost'])->name('frontend.visa_submit')->middleware('paymentauth:visa_form');
Route::post('getNumberofPeople','Frontend\ApplyVisaController@getNumberOfPeople')->name('frontend.get_number_of_people');

Route::get('/blogs', [BlogController::class, 'index'])->name('frontend.blog');
Route::get('/blog/search/{value}', [BlogController::class, 'search'])->name('frontend.blog.search');
Route::get('blogs/details/{id}', [BlogController::class, 'show'])->name('frontend.blog_detail');

Route::post('/enquiry/submit', [FrontendController::class, 'submitEnquiry'])->name('enquiry.submit');

Route::get('/handle-payment/success', [FrontendController::class, 'TelrResponse']);
Route::get('/handle-payment/cancel', [FrontendController::class, 'TelrResponseFailed']);
Route::get('/handle-payment/declined', [FrontendController::class, 'TelrResponseFailed']);
Route::view('about-us', 'frontend.about');
Route::view('apply', 'frontend.apply');
Route::view('how-to-apply', 'frontend.how-to-apply');
Route::get('apply-for-visa', [ApplyVisaController::class, 'applyForVisa'])->name('frontend.visa');
Route::post('get_visa_details', [ApplyVisaController::class, 'getVisaDetails'])->name('frontend.visa_details');
Route::get('getNationality/{id}', [ApplyVisaController::class, 'getNationality'])->name('frontend.getNationality');
Route::get('getTravel/{id}/{apply_id}', [ApplyVisaController::class, 'getTravel'])->name('frontend.getTravel');
Route::get('getApplicationCenter/{id}/{apply_id}', [ApplyVisaController::class, 'getApplicationCenter'])->name('frontend.getApplicationCenter');
Route::get('getTypeOfVisa/{id}/{apply_id}', [ApplyVisaController::class, 'getTypeOfVisa'])->name('frontend.getTypeOfVisa');

Route::group(['prefix' => '', 'as' => 'frontend.'], function () {
    Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
        Route::post('ages', [FrontendController::class, 'getAgeList'])->name('ages');
        Route::post('countries', [FrontendController::class, 'getCountryList'])->name('countries');
        Route::post('program_types', [FrontendController::class, 'getProgramTypeList'])->name('program_types');
        Route::post('study_modes', [FrontendController::class, 'getStudyModeList'])->name('study_modes');
        Route::post('cities', [FrontendController::class, 'getCityList'])->name('cities');
        Route::post('program_names', [FrontendController::class, 'getProgramNameList'])->name('program_names');
        Route::post('program_durations', [FrontendController::class, 'getProgramDurationList'])->name('program_durations');
    
        Route::post('course', [FrontendController::class, 'searchCourse'])->name('course');
    });
    
    Route::get('course', [FrontendController::class, 'viewCourse'])->name('course');
    
    Route::post('download', [FrontendController::class, 'downloadFile'])->name('download');
});

Route::group(['prefix' => 'school', 'as' => 'school.'], function () {
    Route::get('{id}', [FrontendController::class, 'schoolDetails'])->name('details');
    Route::post('programs', [FrontendController::class, 'getPrograms'])->name('programs');
});

Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
    Route::get('{program_id}/{school_id}', [CourseControllerFrontend::class, 'index'])->name('single');

    Route::post('rooms_meals', [CourseControllerFrontend::class, 'getRoomTypeAndMealType'])->name('rooms_meals');
    Route::post('meals', [CourseControllerFrontend::class, 'getMealType'])->name('meals');
    Route::post('accomm_durations', [CourseControllerFrontend::class, 'getAccommodationDuration'])->name('accomm_durations');    
    Route::post('calculate', [CourseControllerFrontend::class, 'calculate'])->name('calculate');
    Route::group(['prefix' => 'calculate', 'as' => 'calculate.'], function () {
        Route::post('accommodation', [CourseControllerFrontend::class, 'calculateAccommodation'])->name('accommodation');
        Route::post('discount', [CourseControllerFrontend::class, 'discountCalculate'])->name('discount');
        Route::group(['prefix' => 'reset', 'as' => 'reset.'], function () {
            Route::get('program', [CourseControllerFrontend::class, 'resetProgram'])->name('program');
            Route::get('accommodation', [CourseControllerFrontend::class, 'resetAccommodation'])->name('accommodation');
            Route::get('other_service', [CourseControllerFrontend::class, 'resetOtherService'])->name('other_service');
        });
    });

    Route::post('airport/names', [CourseControllerFrontend::class, 'getAirportNames'])->name('airport.names');
    Route::post('airport/services', [CourseControllerFrontend::class, 'getAirportServiceNames'])->name('airport.services');
    Route::post('airport/fee', [CourseControllerFrontend::class, 'setAirportPickupFee'])->name('airport.fee');

    Route::post('medical/deductibles', [CourseControllerFrontend::class, 'getMedicalDeductibles'])->name('medical.deductibles');
    Route::post('medical/durations', [CourseControllerFrontend::class, 'getMedicalDurations'])->name('medical.durations');
    Route::post('medical/fee', [CourseControllerFrontend::class, 'setMedicalInsuranceFee'])->name('medical.fee');
    
    Route::post('other_service/fee', [CourseControllerFrontend::class, 'setOtherServiceFee'])->name('other_service.fee');

    Route::post('details/back', [FrontendController::class, 'backDetails'])->name('details.back');
    Route::post('details', [FrontendController::class, 'viewRegister'])->name('details.save')->middleware('course.register');
});

///// Frontend Middleware Starts //////
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
        Route::post('details', [FrontendController::class, 'viewRegister'])->name('details.save');
        Route::get('register', [FrontendController::class, 'viewRegister'])->name('register.detail');
        Route::post('register', [FrontendController::class, 'register'])->name('register');
        Route::get('reservation', [FrontendController::class, 'viewReservation'])->name('reservation.detail');
        Route::post('reservation', [FrontendController::class, 'reservation'])->name('reservation');
        Route::get('reservation_confirm', [FrontendController::class, 'viewConfirmReservation'])->name('reservation_confirm.detail');
        Route::post('reservation_confirm', [FrontendController::class, 'confirmReservation'])->name('reservation_confirm');
        // Route::post('/telr-gateway', [FrontendController::class, 'paymentPost'])->name('payment-gateway');
    });

    Route::get('/like_school/{school_id}', [FrontendController::class, 'likeSchool'])->name('likeschool');
    Route::post('/school/rating_save', [\App\Http\Controllers\RatingController::class, 'saveComments'])->name('rateSaved');
    
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/login_password', [CustomerController::class, 'loginPassword'])->name('login_password');
        Route::post('/login_password', [CustomerController::class, 'updateLoginPassword'])->name('login_password.update');
        Route::post('/verify_email', [CustomerController::class, 'verifyEmail'])->name('verify_email');
        Route::post('/verify_phone', [CustomerController::class, 'verifyPhone'])->name('verify_phone');
        Route::get('/course_applications', [CustomerController::class, 'courseApplication'])->name('course_applications');
        Route::get('/course_application/{id}', [CustomerController::class, 'detailCourseApplication'])->name('course_application');
        Route::post('/course_application/print', [CustomerController::class, 'printCourseApplication'])->name('course_application.print');
        Route::get('/course_application/approve/{id}/{value}', [CustomerController::class, 'approveCourseApplication'])->name('course_application.approve');
        Route::post('/course_application/send_message', [CustomerController::class, 'sendCourseApplicationMessage'])->name('course_application.send_message');
        Route::get('/reviews', [CustomerController::class, 'reviews'])->name('reviews');
        Route::get('/review/{id}', [CustomerController::class, 'review'])->name('review');
        Route::post('/review/{id}', [CustomerController::class, 'reviewBooking'])->name('review.booking');
        Route::get('/payments', [CustomerController::class, 'payments'])->name('payments');
    });
});

Route::view('payment_terms', 'frontend.payment_page.payment-refund');

Route::get('db_migrate', function() { return Artisan::call('migrate'); });

Route::get('/verify_email/{id}', [\App\Http\Controllers\LoginController::class, 'verifyEmail'])->name('verify-email-user');
Route::get('/verify_email_again/{id}', [\App\Http\Controllers\LoginController::class, 'verifyEmailAgain'])->name('verify-email-user-again');

///// Contact URL /////
Route::view('/contact-us', 'frontend.contact')->name('contact-us-get');
Route::post('/contact-us/post', [ContactController::class, 'ContactUS'])->name('contact-us');
Route::get('/register', [\App\Http\Controllers\LoginController::class, 'register'])->name('register_user');
Route::post('/save_rating', [\App\Http\Controllers\RatingController::class, 'saveRating'])->name('save_rating');
Route::get('/forgot-password/{token}', function ($token) { return view('frontend.reset_password', ['token' => $token]); })->name('password.reset');
Route::post('/forgot-password', [\App\Http\Controllers\LoginController::class, 'forgotPassword'])->name('forgot-password-post');
Route::post('/reset-password', [\App\Http\Controllers\LoginController::class, 'resetPassword'])->name('reset-password-post');

Route::post('/register_post', [\App\Http\Controllers\LoginController::class, 'registerPost'])->name('user_register_post');
Route::group(['middleware' => ['emailverification']], function () {
    Route::get('/login', [\App\Http\Controllers\LoginController::class, 'show'])->name('login');
    Route::get('/login/superadmin', [\App\Http\Controllers\LoginController::class, 'showSuperAdminForm'])->name('superlogin');
    Route::get('/login/schooladmin', [\App\Http\Controllers\LoginController::class, 'showSchoolAdminForm'])->name('schoollogin');
    Route::get('/login/branchadmin', [\App\Http\Controllers\LoginController::class, 'showBranchAdminForm'])->name('branchlogin');
    Route::post('/login/branchadmin', [\App\Http\Controllers\LoginController::class, 'branchAdminauthenticate'])->name('branchlogin.submit');
    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('user_login_post');
    Route::post('/login/superadmin', [\App\Http\Controllers\LoginController::class, 'superAdminauthenticate'])->name('super_admin_login_post');
    Route::post('/login/schooladmin', [\App\Http\Controllers\LoginController::class, 'schoolAdminauthenticate'])->name('school_admin_login_post');
    Route::get('/', [FrontendController::class, 'index'])->name('land_page');
    Route::get('send_verification_email/{token}', [\App\Http\Controllers\LoginController::class, 'sendMailAgain'])->name('send_once_again_email_verification');
});

Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::post('schoolAdminlogout', [\App\Http\Controllers\LoginController::class, 'schoolAdminlogout'])->name('schooladmin.logout')->middleware('school_admin');
Route::post('branchAdminlogout', [\App\Http\Controllers\LoginController::class, 'branchAdminlogout'])->name('branchadmin.logout')->middleware('branch_admin');

Route::get('/set_language/{locale}', function ($lang) {
    Session::put('locale', $lang);
    return redirect()->back();
})->name('change_lang');

///// Super Admin Routes /////
Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.', 'middleware' => 'super_admin', 'namespace' => 'SuperAdmin'], function () {
    Route::get('/', function () {
        return redirect()->route('superadmin.dashboard');
    });

    Route::group(['prefix' => 'manage_application', 'as' => 'manage_application.'], function () {
        Route::get('customer/{customer_id}', 'CourseApplicationController@listForCustomer')->name('list.customer');
        Route::post('print', 'CourseApplicationController@print')->name('print');
        Route::get('course/{course_id}/{user_course_booked_id}/{school_id}', 'CourseApplicationController@editCourse')->name('course.edit');
    });
    Route::resource('manage_application', CourseApplicationController::class);

    Route::post('programagerangeupdate', 'CourseController@update')->name('course.programagerangeupdate');
    Route::get('update_airport_page', 'CourseController@viewAirportForUpdate')->name('update_airport_page');

    Route::get('course_program_under_age_give_access_to_school_admin/{id}', [CourseDetailsController::class, 'giveAccessToSchoolAdminCourseProgramUnderAge'])->name('course_program_under_age_give_access_to_school_admin');
    Route::get('course_give_access_to_school_admin/{id}', [CourseDetailsController::class, 'giveAccessToSchoolAdminCourse'])->name('course_give_access_to_school_admin');

    Route::post('airport_update', [CourseDetailsController::class, 'airportUpdate'])->name('airport_update');
    Route::post('medical_update', [CourseDetailsController::class, 'medicalUpdate'])->name('medical_update');

    Route::post('assign_course_permission', [CourseDetailsController::class, 'assignCoursePermission'])->name('assign_course_permission');

    Route::get('apply_visa', 'VisaFormController@index')->name('add_visa_form');

    Route::get('view_visa_forms', 'VisaFormController@show')->name('view_visa_forms');
    Route::get('view_visa_forms/{id}', 'VisaFormController@edit')->name('visa_form_edit');
    Route::post('view_visa_forms/{id}', 'VisaFormController@update')->name('visa_form_update');

    Route::delete('delete/{visaId}', 'VisaFormController@destroy')->name('delete_visa_forms');

    Route::post('visa_submit', 'VisaFormController@applyForVisa')->name('visa_submit');

    Route::post('delete_applying_from', 'AddVisaFieldsController@deleteApplyingFrom')->name('delete_applying_from');
    Route::post('add_applying_from', 'AddVisaFieldsController@addApplyingFrom')->name('add_applying_from');

    Route::post('delete_application_center', 'AddVisaFieldsController@deleteApplicationCenter')->name('delete_application_center');
    Route::post('add_application_center', 'AddVisaFieldsController@addApplicationCenter')->name('add_application_center');

    Route::post('delete_nationality', 'AddVisaFieldsController@deleteNationality')->name('delete_nationality');
    Route::post('add_nationality', 'AddVisaFieldsController@addNationality')->name('add_nationality');

    Route::post('delete_travel', 'AddVisaFieldsController@deleteTravel')->name('delete_travel');
    Route::post('add_travel', 'AddVisaFieldsController@addTravel')->name('add_travel');

    Route::post('delete_type_of_visa', 'AddVisaFieldsController@deleteTypeOfVisa')->name('delete_type_of_visa');
    Route::post('add_type_of_visa', 'AddVisaFieldsController@addTypeOfVisa')->name('add_type_of_visa');

    Route::post('/logout/superadmin', [\App\Http\Controllers\LoginController::class, 'superAdminlogout'])->name('superadmin-logout');

    Route::resource('/visa', 'FormbuildController');
    Route::resource('enquiry', 'EnquiryController');

    Route::view('rating', 'superadmin.rating.index')->name('rating.index');
    Route::get('rating/approve/{id}', [\App\Http\Controllers\RatingController::class, 'approve'])->name('rating.approve');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('review/approve/{id}', 'ReviewController@approve')->name('review.approve');
    Route::post('review/disapprove/{id}', 'ReviewController@disapprove')->name('review.disapprove');
    Route::resource('review', ReviewController::class);

    Route::post('blogs/update/{id}', 'BlogController@update')->name('blogs.update');
    Route::post('blogs/image_upload', 'BlogController@upload')->name('blogs.upload');
    Route::post('blogs/pause/{id}', 'BlogController@pause')->name('blogs.pause');
    Route::post('blogs/play/{id}', 'BlogController@play')->name('blogs.play');
    Route::resource('blogs', 'BlogController');

    Route::group(['prefix' => 'school', 'as' => 'school.'], function () {
        Route::post('image_upload', 'SchoolController@upload')->name('upload');
        Route::post('country', 'SchoolController@getCountryList')->name('country.list');
        Route::post('city_by_country', 'SchoolController@getCityByCountryList')->name('city_by_country.list');
        Route::post('city', 'SchoolController@getCityList')->name('city.list');
        Route::post('branch', 'SchoolController@getBranchList')->name('branch.list');
        Route::post('clone/{id}', 'SchoolController@clone')->name('clone');
        Route::post('pause/{id}', 'SchoolController@pause')->name('pause');
        Route::post('play/{id}', 'SchoolController@play')->name('play');
        Route::post('bulk', 'SchoolController@bulk')->name('bulk');
        Route::get('country_city', 'SchoolController@viewCountryCityList')->name('country_city');
        Route::post('country_city', 'SchoolController@updateCoutryCityList')->name('country_city.update');
        Route::get('name', 'SchoolController@viewNameList')->name('name');
        Route::post('name', 'SchoolController@updateNameList')->name('name.update');
        Route::post('nationality', 'SchoolController@addNationality')->name('nationality.add');
        Route::delete('nationality', 'SchoolController@deleteNationality')->name('nationality.delete');
    });
    Route::resource('school', 'SchoolController');

    Route::post('school/save/program/session', 'CourseController@programSessionSave')->name('course.session_store_for_program');

    Route::post('language', [CourseFormController::class, 'addLanguage'])->name('language.add');
    Route::delete('language', [CourseFormController::class, 'deleteLanguage'])->name('language.delete');
    Route::post('study_mode', [CourseFormController::class, 'addStudyMode'])->name('study_mode.add');
    Route::delete('study_mode', [CourseFormController::class, 'deleteStudyMode'])->name('study_mode.delete');
    Route::post('program_type', [CourseFormController::class, 'addProgramType'])->name('program_type.add');
    Route::delete('program_type', [CourseFormController::class, 'deleteProgramType'])->name('program_type.delete');
    Route::post('branch', [CourseFormController::class, 'addBranch'])->name('branch.add');
    Route::delete('branch', [CourseFormController::class, 'deleteBranch'])->name('branch.delete');
    Route::post('study_time', [CourseFormController::class, 'addStudyTime'])->name('study_time.add');
    Route::delete('study_time', [CourseFormController::class, 'deleteStudyTime'])->name('study_time.delete');
    Route::post('classes_day', [CourseFormController::class, 'addClassesDay'])->name('classes_day.add');
    Route::delete('classes_day', [CourseFormController::class, 'deleteClassesDay'])->name('classes_day.delete');
    Route::post('start_day', [CourseFormController::class, 'addStartDay'])->name('start_day.add');
    Route::delete('start_day', [CourseFormController::class, 'deleteStartDay'])->name('start_day.delete');
    Route::post('program_age_range', [CourseFormController::class, 'addProgramAgeRange'])->name('program_age_range.add');
    Route::delete('program_age_range', [CourseFormController::class, 'deleteProgramAgeRange'])->name('program_age_range.delete');
    Route::post('program_under_age_range', [CourseFormController::class, 'addProgramUnderAge'])->name('program_under_age_range.add');
    Route::delete('program_under_age_range', [CourseFormController::class, 'deleteProgramUnderAge'])->name('program_under_age_range.delete');
    Route::post('accomm_age_range', [CourseFormController::class, 'addAccommodationAgeRange'])->name('accomm_age_range.add');
    Route::delete('accomm_age_range', [CourseFormController::class, 'deleteAccommodationAgeRange'])->name('accomm_age_range.delete');
    Route::post('accomm_custodian_age', [CourseFormController::class, 'addCustodianAgeRange'])->name('accomm_custodian_age.add');
    Route::delete('accomm_custodian_age', [CourseFormController::class, 'deleteCustodianAgeRange'])->name('accomm_custodian_age.delete');
    Route::post('accomm_under_age', [CourseFormController::class, 'addAccommodationUnderAge'])->name('accomm_under_age.add');
    Route::delete('accomm_under_age', [CourseFormController::class, 'deleteAccommodationUnderAge'])->name('accomm_under_age.delete');

    // Course Routes
    Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
        Route::get('deleted', 'CourseController@deleted')->name('deleted');
        Route::delete('delete/{course_id}', 'CourseController@delete')->name('delete');
        Route::post('restore/{course_id}', 'CourseController@restore')->name('restore');
        Route::post('clone/{course_id}', 'CourseController@clone')->name('clone');
        Route::post('pause/{course_id}', 'CourseController@pause')->name('pause');
        Route::post('play/{course_id}', 'CourseController@play')->name('play');
        Route::post('bulk', 'CourseController@bulk')->name('bulk');
    
        Route::post('program_under_age/fetch', 'CourseController@fetchProgramUnderAgePage')->name('program_under_age.fetch');
        Route::get('program_under_age/edit', 'CourseController@editProgramUnderAge')->name('program_under_age.edit');
        Route::get('program_under_age', 'CourseController@viewProgramUnderAge')->name('program_under_age');
        
        Route::get('accommodation/edit', 'CourseController@editAccommodation')->name('accommodation.edit');
        Route::get('accommodation/{course_unique_id}', 'CourseController@detailsAccommodation')->name('accommodation.details');
        Route::get('accommodation', 'CourseController@viewAccommodation')->name('accommodation');
        Route::delete('accommodation/{id}', 'CourseDetailsController@deleteAccommodation')->name('accommodation.delete');
    
        Route::post('accomm_under_age/fetch', 'CourseController@fetchAccommodationUnderAgePage')->name('accomm_under_age.fetch');
        Route::get('accomm_under_age/edit', 'CourseController@editAccommodationUnderAge')->name('accomm_under_age.edit');
        Route::get('accomm_under_age/{course_unique_id}', 'CourseController@detailsAccommodationUnderAge')->name('accomm_under_age.details');
        Route::get('accomm_under_age', 'CourseController@viewAccommodationUnderAge')->name('accomm_under_age');
        Route::delete('accomm_under_age/{id}', 'CourseDetailsController@deleteAccommodationUnderAge')->name('accomm_under_age.delete');
    
        Route::get('other_service/edit', 'CourseController@editOtherService')->name('other_service.edit');
        Route::get('other_service/{course_unique_id}', 'CourseController@detailsOtherService')->name('other_service.details');
        Route::get('other_service', 'CourseController@viewOtherService')->name('other_service');
        Route::delete('other_service/{id}', 'CourseDetailsController@deleteOtherService')->name('other_service.delete');
        
        Route::get('program/{course_unique_id}', 'CourseDetailsController@detailsProgram')->name('program.details');
        Route::delete('program/{unique_id}', 'CourseDetailsController@deleteProgram')->name('program.delete');
    
        Route::post('update', 'CourseDetailsController@courseUpdate')->name('course_update');
    
        Route::post('image_upload', 'CourseController@upload')->name('upload');

        Route::get('customer/{customer_id}', 'CourseController@listForCustomer')->name('list.customer');
    });
    Route::resource('course', CourseController::class);
    
    Route::resource('manage_app', CourseApplicationController::class);
    Route::resource('payment_received', PaymentController::class);

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::resource('customer', 'CustomerController');
        Route::resource('school_admin', 'SchoolAdminController');
        Route::resource('super_admin', 'SuperAdminController');
    });

    Route::get('visa_application', 'VisaApplicationController@index');
    Route::get('visa_application/other_fields/{id}', 'VisaApplicationController@getOtherFields')->name('visa.otherfields');    

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::post('currency/set_default/{id}', 'CurrencyController@setDefault')->name('currency.set_default');
        Route::resource('currency', 'CurrencyController');

        Route::get('header_footer', 'SettingController@viewHeaderFooter')->name('header_footer');
        Route::post('header_footer', 'SettingController@updateHeaderFooter')->name('header_footer.update');

        Route::get('home_page', 'SettingController@viewHomePage')->name('home_page');
        Route::post('home_page', 'SettingController@updateHomePage')->name('home_page.update');

        Route::post('image_upload', 'SettingController@upload')->name('upload');
        
        Route::group(['prefix' => 'front_page', 'as' => 'front_page.'], function () {
            Route::post('image_upload', 'FrontPageController@upload')->name('upload');
            
            Route::post('clone/{id}', 'FrontPageController@clone')->name('clone');
            Route::post('pause/{id}', 'FrontPageController@pause')->name('pause');
            Route::post('play/{id}', 'FrontPageController@play')->name('play');
            Route::post('bulk', 'FrontPageController@bulk')->name('bulk');
        });
        Route::resource('front_page', FrontPageController::class);
    });
});

///// School Admin Routes /////
Route::group(['namespace' => 'SchoolAdmin', 'prefix' => 'schooladmin', 'middleware' => 'school_admin', 'as' => 'schooladmin.'], function () {
    Route::get('/', function () {
        return redirect()->route('schooladmin.dashboard');
    });

    Route::resource('branch_admin', 'BranchAdminController');

    Route::get('dashboard', [\App\Http\Controllers\SchoolAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('course_update', 'CourseControllerSchoolAdmin@courseUpdate')->name('course_update');
    Route::resource('course', 'CourseControllerSchoolAdmin');

    Route::get('course_program_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@courseProgramDetails')->name('course_program_details');
    Route::get('accomodation_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@accomodationDetails')->name('accomodation_details');

    Route::get('accomodation_underage_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@accomodationUderageDetails')->name('accomodation_underage_details');

    Route::get('airport_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@airportDetails')->name('airport_details');
    Route::get('medical_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@medicalDetails')->name('medical_details');
    Route::get('course_program_underage/{program_id}', 'CourseDetailsSchoolAdminController@courseProgramUnderAgeDetails')->name('course_program_underage_details');
    Route::post('course_program_edit', 'CourseDetailsSchoolAdminController@courseProgramEdit')->name('course_program_edit');
    Route::post('course_accommodation_underage_edit', 'CourseDetailsSchoolAdminController@courseAccommodationUnderAgeUpdate')->name('course_accommodation_underage_edit');

    Route::get('course_program_under_age_give_access_to_school_admin/{id}', 'CourseDetailsSchoolAdminController@giveAccessToSchoolAdminCourseProgramUnderAge')->name('course_program_under_age_give_access_to_school_admin');
    Route::get('course_give_access_to_school_admin/{id}', 'CourseDetailsSchoolAdminController@giveAccessToSchoolAdminCourse')->name('course_give_access_to_school_admin');

    Route::get('airport_delete/{id}', 'CourseDetailsSchoolAdminController@airportDelete')->name('airport_delete');
    Route::get('course_program_delete/{unique_id}', 'CourseDetailsSchoolAdminController@courseProgramDelete')->name('course_program_delete');

    Route::get('course_accommodation_under_age_delete/{id}', 'CourseDetailsSchoolAdminController@courseAccommodationUnderAgeDelete')->name('course_accommodation_under_age_delete');

    Route::post('airport_update', 'CourseDetailsSchoolAdminController@airportUpdate')->name('airport_update');
    Route::post('medical_update', 'CourseDetailsSchoolAdminController@medicalUpdate')->name('medical_update');

    Route::post('course_update', 'CourseDetailsSchoolAdminController@courseUpdate')->name('course_update');
    Route::post('accommodation_update', 'CourseDetailsSchoolAdminController@accomodationUpdate')->name('accommodation_update');
    Route::post('assign_course_permission', 'CourseDetailsSchoolAdminController@assignCoursePermission')->name('assign_course_permission');

    Route::post('course_program_update', 'CourseDetailsSchoolAdminController@courseProgramUpdate')->name('course_program_update');

    Route::get('send_message_to_student', [\App\Http\Controllers\SchoolAdmin\SendMessageToStudentController::class, 'index'])->name('send_message.index');
    Route::post('send_message_to_student/send_message', [\App\Http\Controllers\SchoolAdmin\SendMessageToStudentController::class, 'sendMessage'])->name('send_message.sendmessage');

    Route::resource('enquiry', 'EnquiryController');

    Route::view('rating', 'rating.index')->name('rating.index');
    Route::get('rating/approve/{id}', [\App\Http\Controllers\RatingController::class, 'approve'])->name('rating.approve');

    Route::post('school/update/{id}', 'SchoolController@update')->name('school.update');
    Route::resource('school', 'SchoolController');

    Route::post('school/save/program/session', 'CourseControllerSchoolAdmin@programSessionSave')->name('course.session_store_for_program');
    
    Route::get('manage_application/approve/{id}/{value}', 'CourseApplicationController@approve')->name('manage_application.approve');
    Route::get('manage_application', 'CourseApplicationController@index')->name('manage_application.index');
    Route::get('manage_application/view_message/{id}', 'CourseApplicationController@viewMessage')->name('manage_application.view_message');
    Route::post('manage_application/send_message_to_super_admin', 'CourseApplicationController@sendMessageToSuperAdmin')->name('manage_application.send_message_to_super_admin');

    Route::resource('payment_received', PaymentController::class);

    Route::post('add_program_under_age_range', [CourseFormController::class, 'addProgramUnderAge'])->name('add_program_under_age_range');
    Route::post('delete_program_under_age_range', [CourseFormController::class, 'deleteProgramUnderAge'])->name('delete_program_under_age_range');

    Route::post('addaccomagerange', [CourseFormController::class, 'addAccommodationAgeRange'])->name('addaccomagerange');
    Route::post('deleteaccomagerange', [CourseFormController::class, 'deleteAccommodationAgeRange'])->name('deleteaccomagerange');

    Route::post('accomcustodianage', [CourseFormController::class, 'addCustodianAgeRange'])->name('accomcustodianage');
    Route::post('deleteacomcustodianage', [CourseFormController::class, 'deleteCustodianAgeRange'])->name('deleteacomcustodianage');

    Route::post('addaccomunderagefee', [CourseFormController::class, 'addAccommodationUnderAge'])->name('addaccomunderagefee');
    Route::post('deleteaccomunderagefee', [CourseFormController::class, 'deleteAccommodationUnderAge'])->name('deleteaccomunderagefee');
});

///// Branch Admin Routes /////
Route::group(['namespace' => 'BranchAdmin', 'prefix' => 'branch_admin', 'middleware' => 'branch_admin', 'as' => 'branch_admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('branch_admin.dashboard');
    });

    Route::get('manage_application/approve/{id}/{value}', 'CourseApplicationController@approve')->name('manage_application.approve');

    Route::get('dashboard', [\App\Http\Controllers\BranchAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('course_update', 'CourseControllerSchoolAdmin@courseUpdate')->name('course_update');
    Route::resource('course', 'CourseControllerSchoolAdmin');

    Route::get('course_program_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@courseProgramDetails')->name('course_program_details');
    Route::get('accomodation_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@accomodationDetails')->name('accomodation_details');

    Route::get('accomodation_underage_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@accomodationUderageDetails')->name('accomodation_underage_details');

    Route::get('airport_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@airportDetails')->name('airport_details');
    Route::get('medical_details/{course_unique_id}', 'CourseDetailsSchoolAdminController@medicalDetails')->name('medical_details');
    Route::get('course_program_underage/{program_id}', 'CourseDetailsSchoolAdminController@courseProgramUnderAgeDetails')->name('course_program_underage_details');
    Route::post('course_program_edit', 'CourseDetailsSchoolAdminController@courseProgramEdit')->name('course_program_edit');
    Route::post('course_accommodation_underage_edit', 'CourseDetailsSchoolAdminController@courseAccommodationUnderAgeUpdate')->name('course_accommodation_underage_edit');

    Route::get('course_program_under_age_give_access_to_school_admin/{id}', 'CourseDetailsSchoolAdminController@giveAccessToSchoolAdminCourseProgramUnderAge')->name('course_program_under_age_give_access_to_school_admin');
    Route::get('course_give_access_to_school_admin/{id}', 'CourseDetailsSchoolAdminController@giveAccessToSchoolAdminCourse')->name('course_give_access_to_school_admin');

    Route::get('airport_delete/{id}', 'CourseDetailsSchoolAdminController@airportDelete')->name('airport_delete');
    Route::get('course_program_delete/{unique_id}', 'CourseDetailsSchoolAdminController@courseProgramDelete')->name('course_program_delete');

    Route::get('course_accommodation_under_age_delete/{id}', 'CourseDetailsSchoolAdminController@courseAccommodationUnderAgeDelete')->name('course_accommodation_under_age_delete');

    Route::post('airport_update', 'CourseDetailsSchoolAdminController@airportUpdate')->name('airport_update');
    Route::post('medical_update', 'CourseDetailsSchoolAdminController@medicalUpdate')->name('medical_update');

    Route::post('course_update', 'CourseDetailsSchoolAdminController@courseUpdate')->name('course_update');
    Route::post('accommodation_update', 'CourseDetailsSchoolAdminController@accomodationUpdate')->name('accommodation_update');
    Route::post('assign_course_permission', 'CourseDetailsSchoolAdminController@assignCoursePermission')->name('assign_course_permission');

    Route::post('course_program_update', 'CourseDetailsSchoolAdminController@courseProgramUpdate')->name('course_program_update');

    Route::get('send_message_to_student', [\App\Http\Controllers\BranchAdmin\SendMessageToStudentController::class, 'index'])->name('send_message.index');
    Route::post('send_message_to_student/send_message', [\App\Http\Controllers\BranchAdmin\SendMessageToStudentController::class, 'sendMessage'])->name('send_message.sendmessage');

    Route::resource('enquiry', 'EnquiryController');

    Route::view('rating', 'rating.index')->name('rating.index');
    Route::get('rating/approve/{id}', [\App\Http\Controllers\RatingController::class, 'approve'])->name('rating.approve');

    Route::post('school/update/{id}', 'SchoolController@update')->name('school.update');
    Route::resource('school', 'SchoolController');

    Route::post('school/save/program/session', 'CourseControllerSchoolAdmin@programSessionSave')->name('course.session_store_for_program');

    Route::get('manage_application', 'CourseApplicationController@index')->name('manage_application.index');
    Route::get('manage_application/view_message/{id}', 'CourseApplicationController@viewMessage')->name('manage_application.view_message');
    Route::resource('payment_received', PaymentController::class);
    Route::post('manage_application/send_message_to_super_admin', 'CourseApplicationController@sendMessageToSuperAdmin')->name('manage_application.send_message_to_super_admin');

    Route::post('add_program_under_age_range', [CourseFormController::class, 'addProgramUnderAge'])->name('add_program_under_age_range');
    Route::post('delete_program_under_age_range', [CourseFormController::class, 'deleteProgramUnderAge'])->name('delete_program_under_age_range');

    Route::post('addaccomagerange', [CourseFormController::class, 'addAccommodationAgeRange'])->name('addaccomagerange');
    Route::post('deleteaccomagerange', [CourseFormController::class, 'deleteAccommodationAgeRange'])->name('deleteaccomagerange');


    Route::post('accomcustodianage', [CourseFormController::class, 'addCustodianAgeRange'])->name('accomcustodianage');
    Route::post('deleteacomcustodianage', [CourseFormController::class, 'deleteCustodianAgeRange'])->name('deleteacomcustodianage');

    Route::post('addaccomunderagefee', [CourseFormController::class, 'addAccommodationUnderAge'])->name('addaccomunderagefee');
    Route::post('deleteaccomunderagefee', [CourseFormController::class, 'deleteAccommodationUnderAge'])->name('deleteaccomunderagefee');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth:superadmin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});