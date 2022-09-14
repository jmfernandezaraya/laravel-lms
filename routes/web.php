<?php

use App\Http\Controllers\Frontend\ApplyVisaController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CourseControllerFrontend;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\FrontendController;

use App\Http\Controllers\SuperAdmin\DashboardController;

use App\Http\Controllers\Admin\CourseApplicationController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseDetailsController;
use App\Http\Controllers\Admin\CourseFormController;
use App\Http\Controllers\Admin\SchoolController;

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
Route::post('/enquiry/submit', [FrontendController::class, 'submitEnquiry'])->name('enquiry.submit');

Route::get('/handle-payment/success', [FrontendController::class, 'TelrResponse']);
Route::get('/handle-payment/cancel', [FrontendController::class, 'TelrResponseFailed']);
Route::get('/handle-payment/declined', [FrontendController::class, 'TelrResponseFailed']);

Route::group(['prefix' => '', 'as' => 'frontend.'], function () {
    Route::view('about-us', 'about');
    Route::view('apply', 'apply');
    Route::view('how-to-apply', 'how-to-apply');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/search/{value}', [BlogController::class, 'search'])->name('blog.search');
    Route::get('blog/details/{id}', [BlogController::class, 'show'])->name('blog_detail');

    Route::get('apply-for-visa', [ApplyVisaController::class, 'applyForVisa'])->name('visa');
    Route::post('get_visa_details', [ApplyVisaController::class, 'getVisaDetails'])->name('visa_details');
    Route::get('getNationality/{id}', [ApplyVisaController::class, 'getNationality'])->name('getNationality');
    Route::get('getTravel/{id}/{apply_id}', [ApplyVisaController::class, 'getTravel'])->name('getTravel');
    Route::get('getApplicationCenter/{id}/{apply_id}', [ApplyVisaController::class, 'getApplicationCenter'])->name('getApplicationCenter');
    Route::get('getTypeOfVisa/{id}/{apply_id}', [ApplyVisaController::class, 'getTypeOfVisa'])->name('getTypeOfVisa');
    Route::post('getNumberofPeople','Frontend\ApplyVisaController@getNumberOfPeople')->name('get_number_of_people');
    Route::view('payment_terms', 'payment_page.payment-refund');
    
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

    Route::group(['prefix' => 'country', 'as' => 'country.'], function () {
        Route::post('ages', [FrontendController::class, 'getCountryAges'])->name('ages');
        Route::get('{id}', [FrontendController::class, 'viewCountryPage'])->name('page');
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
        
        Route::group(['middleware' => 'course.register'], function () {
            Route::get('details', [FrontendController::class, 'viewRegister'])->name('details.save');
            Route::post('details', [FrontendController::class, 'viewRegister'])->name('details.save');
        });

        Route::post('coupon/apply', [CourseControllerFrontend::class, 'applyCoupon'])->name('coupon.apply');
    });

    ///// Frontend Middleware Starts //////
    Route::group(['middleware' => ['auth', 'email.verification']], function () {
        Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
            Route::post('details/back', [FrontendController::class, 'backDetails'])->name('details.back');
            Route::get('register', [FrontendController::class, 'viewRegister'])->name('register.detail');
            Route::post('register', [FrontendController::class, 'register'])->name('register');
            Route::get('reservation', [FrontendController::class, 'viewReservation'])->name('reservation.detail');
            Route::post('reservation', [FrontendController::class, 'reservation'])->name('reservation');
            Route::get('reservation_confirm', [FrontendController::class, 'viewConfirmReservation'])->name('reservation_confirm.detail');
            Route::post('reservation_confirm', [FrontendController::class, 'confirmReservation'])->name('reservation_confirm');
            // Route::post('/telr-gateway', [FrontendController::class, 'paymentPost'])->name('payment-gateway');
        });
    
        Route::get('/like_school/{school_id}', [FrontendController::class, 'likeSchool'])->name('likeschool');
        Route::post('/school/rating', [\App\Http\Controllers\RatingController::class, 'saveComments'])->name('rate.save');
        
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
            Route::get('/affiliate', [CustomerController::class, 'affiliate'])->name('affiliate');
            Route::get('/coupons', [CustomerController::class, 'coupons'])->name('coupons');
            Route::get('/coupons/{id}', [CustomerController::class, 'couponUsage'])->name('coupon.usage');
            Route::get('/transactions', [CustomerController::class, 'transactions'])->name('transactions');
        });
    });
});

Route::get('db_migrate', function() { return Artisan::call('migrate'); });

Route::get('/verify_email/{token}', [\App\Http\Controllers\LoginController::class, 'verifyEmail'])->name('verify-email-user');
Route::get('/verify_email_again/{id}', [\App\Http\Controllers\LoginController::class, 'verifyEmailAgain'])->name('verify-email-user-again');

///// Contact URL /////
Route::view('/contact-us', 'frontend.contact')->name('contact-us-get');
Route::post('/contact-us/post', [ContactController::class, 'ContactUs'])->name('contact-us');
Route::get('/register', [\App\Http\Controllers\LoginController::class, 'register'])->name('register_user');
Route::post('/save_rating', [\App\Http\Controllers\RatingController::class, 'saveRating'])->name('save_rating');
Route::get('/forgot-password/{token}', function ($token) { return view('frontend.reset_password', ['token' => $token]); })->name('password.reset');
Route::post('/forgot-password', [\App\Http\Controllers\LoginController::class, 'forgotPassword'])->name('forgot-password-post');
Route::post('/reset-password', [\App\Http\Controllers\LoginController::class, 'resetPassword'])->name('reset-password-post');

Route::post('/register_post', [\App\Http\Controllers\LoginController::class, 'registerPost'])->name('user_register_post');
Route::group(['middleware' => ['email.verification']], function () {
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

Route::post('branchAdminlogout', [\App\Http\Controllers\LoginController::class, 'branchAdminlogout'])->name('branchadmin.logout')->middleware('branch_admin');

Route::get('/set_language/{locale}', function ($lang) {
    Session::put('locale', $lang);
    return redirect()->back();
})->name('change_lang');

///// Super Admin Routes /////
Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.', 'middleware' => ['super_admin', 'email.verification'], 'namespace' => 'SuperAdmin'], function () {
    Route::get('/', function () { return redirect()->route('superadmin.dashboard'); });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'superAdminlogout'])->name('logout');

    Route::resource('/visa', 'FormbuildController');
    Route::resource('enquiry', 'EnquiryController');

    Route::post('delete_applying_from', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteApplyingFrom')->name('delete_applying_from');
    Route::post('add_applying_from', '\App\Http\Controllers\Admin\AddVisaFieldsController@addApplyingFrom')->name('add_applying_from');
    Route::post('delete_application_center', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteApplicationCenter')->name('delete_application_center');
    Route::post('add_application_center', '\App\Http\Controllers\Admin\AddVisaFieldsController@addApplicationCenter')->name('add_application_center');
    Route::post('delete_nationality', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteNationality')->name('delete_nationality');
    Route::post('add_nationality', '\App\Http\Controllers\Admin\AddVisaFieldsController@addNationality')->name('add_nationality');
    Route::post('delete_travel', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteTravel')->name('delete_travel');
    Route::post('add_travel', '\App\Http\Controllers\Admin\AddVisaFieldsController@addTravel')->name('add_travel');
    Route::post('delete_type_of_visa', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteTypeOfVisa')->name('delete_type_of_visa');
    Route::post('add_type_of_visa', '\App\Http\Controllers\Admin\AddVisaFieldsController@addTypeOfVisa')->name('add_type_of_visa');

    Route::group(['prefix' => 'school', 'as' => 'school.'], function () {
        Route::post('image_upload', '\App\Http\Controllers\Admin\SchoolController@upload')->name('upload');
        Route::post('country', '\App\Http\Controllers\Admin\SchoolController@getCountryList')->name('country.list');
        Route::post('city_by_country', '\App\Http\Controllers\Admin\SchoolController@getCityByCountryList')->name('city_by_country.list');
        Route::post('city', '\App\Http\Controllers\Admin\SchoolController@getCityList')->name('city.list');
        Route::post('branch', '\App\Http\Controllers\Admin\SchoolController@getBranchList')->name('branch.list');
        Route::post('clone/{id}', '\App\Http\Controllers\Admin\SchoolController@clone')->name('clone');
        Route::post('pause/{id}', '\App\Http\Controllers\Admin\SchoolController@pause')->name('pause');
        Route::post('play/{id}', '\App\Http\Controllers\Admin\SchoolController@play')->name('play');
        Route::post('bulk', '\App\Http\Controllers\Admin\SchoolController@bulk')->name('bulk');
        Route::post('nationality', '\App\Http\Controllers\Admin\SchoolController@addNationality')->name('nationality.add');
        Route::delete('nationality', '\App\Http\Controllers\Admin\SchoolController@deleteNationality')->name('nationality.delete');
        Route::get('country_city', '\App\Http\Controllers\Admin\SchoolController@viewCountryCityList')->name('country_city');
        Route::post('country_city', '\App\Http\Controllers\Admin\SchoolController@updateCoutryCityList')->name('country_city.update');
        Route::get('name', '\App\Http\Controllers\Admin\SchoolController@viewNameList')->name('name');
        Route::post('name', '\App\Http\Controllers\Admin\SchoolController@updateNameList')->name('name.update');
        
        Route::post('save/program/session', '\App\Http\Controllers\Admin\CourseController@programSessionSave')->name('course.session_store_for_program');
    });
    Route::resource('school', '\App\Http\Controllers\Admin\SchoolController');

    Route::post('language', '\App\Http\Controllers\Admin\CourseFormController@addLanguage')->name('language.add');
    Route::delete('language', '\App\Http\Controllers\Admin\CourseFormController@deleteLanguage')->name('language.delete');
    Route::post('study_mode', '\App\Http\Controllers\Admin\CourseFormController@addStudyMode')->name('study_mode.add');
    Route::delete('study_mode', '\App\Http\Controllers\Admin\CourseFormController@deleteStudyMode')->name('study_mode.delete');
    Route::post('program_type', '\App\Http\Controllers\Admin\CourseFormController@addProgramType')->name('program_type.add');
    Route::delete('program_type', '\App\Http\Controllers\Admin\CourseFormController@deleteProgramType')->name('program_type.delete');
    Route::post('branch', '\App\Http\Controllers\Admin\CourseFormController@addBranch')->name('branch.add');
    Route::delete('branch', '\App\Http\Controllers\Admin\CourseFormController@deleteBranch')->name('branch.delete');
    Route::post('study_time', '\App\Http\Controllers\Admin\CourseFormController@addStudyTime')->name('study_time.add');
    Route::delete('study_time', '\App\Http\Controllers\Admin\CourseFormController@deleteStudyTime')->name('study_time.delete');
    Route::post('classes_day', '\App\Http\Controllers\Admin\CourseFormController@addClassesDay')->name('classes_day.add');
    Route::delete('classes_day', '\App\Http\Controllers\Admin\CourseFormController@deleteClassesDay')->name('classes_day.delete');
    Route::post('start_day', '\App\Http\Controllers\Admin\CourseFormController@addStartDay')->name('start_day.add');
    Route::delete('start_day', '\App\Http\Controllers\Admin\CourseFormController@deleteStartDay')->name('start_day.delete');
    Route::post('program_age_range', '\App\Http\Controllers\Admin\CourseFormController@addProgramAgeRange')->name('program_age_range.add');
    Route::delete('program_age_range', '\App\Http\Controllers\Admin\CourseFormController@deleteProgramAgeRange')->name('program_age_range.delete');
    Route::post('program_under_age_range', '\App\Http\Controllers\Admin\CourseFormController@addProgramUnderAge')->name('program_under_age_range.add');
    Route::delete('program_under_age_range', '\App\Http\Controllers\Admin\CourseFormController@deleteProgramUnderAge')->name('program_under_age_range.delete');
    Route::post('accomm_age_range', '\App\Http\Controllers\Admin\CourseFormController@addAccommodationAgeRange')->name('accomm_age_range.add');
    Route::delete('accomm_age_range', '\App\Http\Controllers\Admin\CourseFormController@deleteAccommodationAgeRange')->name('accomm_age_range.delete');
    Route::post('accomm_custodian_age', '\App\Http\Controllers\Admin\CourseFormController@addCustodianAgeRange')->name('accomm_custodian_age.add');
    Route::delete('accomm_custodian_age', '\App\Http\Controllers\Admin\CourseFormController@deleteCustodianAgeRange')->name('accomm_custodian_age.delete');
    Route::post('accomm_under_age', '\App\Http\Controllers\Admin\CourseFormController@addAccommodationUnderAge')->name('accomm_under_age.add');
    Route::delete('accomm_under_age', '\App\Http\Controllers\Admin\CourseFormController@deleteAccommodationUnderAge')->name('accomm_under_age.delete');

    Route::post('airport_update', '\App\Http\Controllers\Admin\CourseController@airportUpdate')->name('airport_update');
    Route::post('medical_update', '\App\Http\Controllers\Admin\CourseController@medicalUpdate')->name('medical_update');

    Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
        Route::delete('delete/{course_id}', '\App\Http\Controllers\Admin\CourseController@delete')->name('delete');
        Route::post('restore/{course_id}', '\App\Http\Controllers\Admin\CourseController@restore')->name('restore');
        Route::post('clone/{course_id}', '\App\Http\Controllers\Admin\CourseController@clone')->name('clone');
        Route::post('pause/{course_id}', '\App\Http\Controllers\Admin\CourseController@pause')->name('pause');
        Route::post('play/{course_id}', '\App\Http\Controllers\Admin\CourseController@play')->name('play');
        Route::post('promotion/{course_id}', '\App\Http\Controllers\Admin\CourseController@promotion')->name('promotion');
        Route::post('link_fee/{course_id}', '\App\Http\Controllers\Admin\CourseController@toggleLinkFee')->name('link_fee');
        Route::post('bulk', '\App\Http\Controllers\Admin\CourseController@bulk')->name('bulk');
    
        Route::post('program_under_age/fetch', '\App\Http\Controllers\Admin\CourseController@fetchProgramUnderAgePage')->name('program_under_age.fetch');
        Route::get('program_under_age/edit', '\App\Http\Controllers\Admin\CourseController@editProgramUnderAge')->name('program_under_age.edit');
        Route::get('program_under_age', '\App\Http\Controllers\Admin\CourseController@viewProgramUnderAge')->name('program_under_age');
        
        Route::get('accommodation/edit', '\App\Http\Controllers\Admin\CourseController@editAccommodation')->name('accommodation.edit');
        Route::get('accommodation/{course_unique_id}', '\App\Http\Controllers\Admin\CourseController@detailsAccommodation')->name('accommodation.details');
        Route::get('accommodation', '\App\Http\Controllers\Admin\CourseController@viewAccommodation')->name('accommodation');
        Route::delete('accommodation/{id}', '\App\Http\Controllers\Admin\CourseDetailsController@deleteAccommodation')->name('accommodation.delete');
    
        Route::post('accomm_under_age/fetch', '\App\Http\Controllers\Admin\CourseController@fetchAccommodationUnderAgePage')->name('accomm_under_age.fetch');
        Route::get('accomm_under_age/edit', '\App\Http\Controllers\Admin\CourseController@editAccommodationUnderAge')->name('accomm_under_age.edit');
        Route::get('accomm_under_age/{course_unique_id}', '\App\Http\Controllers\Admin\CourseController@detailsAccommodationUnderAge')->name('accomm_under_age.details');
        Route::get('accomm_under_age', '\App\Http\Controllers\Admin\CourseController@viewAccommodationUnderAge')->name('accomm_under_age');
        Route::delete('accomm_under_age/{id}', '\App\Http\Controllers\Admin\CourseDetailsController@deleteAccommodationUnderAge')->name('accomm_under_age.delete');
    
        Route::get('other_service/edit', '\App\Http\Controllers\Admin\CourseController@editOtherService')->name('other_service.edit');
        Route::get('other_service/{course_unique_id}', '\App\Http\Controllers\Admin\CourseController@detailsOtherService')->name('other_service.details');
        Route::get('other_service', '\App\Http\Controllers\Admin\CourseController@viewOtherService')->name('other_service');
        Route::delete('other_service/{id}', '\App\Http\Controllers\Admin\CourseDetailsController@deleteOtherService')->name('other_service.delete');
        
        Route::get('program/{course_unique_id}', '\App\Http\Controllers\Admin\CourseDetailsController@detailsProgram')->name('program.details');
        Route::delete('program/{unique_id}', '\App\Http\Controllers\Admin\CourseDetailsController@deleteProgram')->name('program.delete');
    
        Route::post('update', '\App\Http\Controllers\Admin\CourseDetailsController@courseUpdate')->name('course_update');    
        Route::post('image_upload', '\App\Http\Controllers\Admin\CourseController@upload')->name('upload');
        Route::get('deleted', '\App\Http\Controllers\Admin\CourseController@deleted')->name('deleted');
        
        Route::get('language', '\App\Http\Controllers\Admin\CourseController@viewLanguageList')->name('language');        
        Route::get('study_mode', '\App\Http\Controllers\Admin\CourseController@viewStudyModeList')->name('study_mode');        
        Route::get('program_type', '\App\Http\Controllers\Admin\CourseController@viewProgramTypeList')->name('program_type');        
        Route::get('branch', '\App\Http\Controllers\Admin\CourseController@viewBranchList')->name('branch');        
        Route::get('study_time', '\App\Http\Controllers\Admin\CourseController@viewStudyTimeList')->name('study_time');        
        Route::get('classes_day', '\App\Http\Controllers\Admin\CourseController@viewClassesDayList')->name('classes_day');        
        Route::get('start_date', '\App\Http\Controllers\Admin\CourseController@viewStartDateList')->name('start_date');        
        Route::get('age', '\App\Http\Controllers\Admin\CourseController@viewProgramAgeList')->name('age');        
        Route::get('under_age', '\App\Http\Controllers\Admin\CourseController@viewProgramUnderAgeList')->name('under_age');        
        Route::get('accommodation_age', '\App\Http\Controllers\Admin\CourseController@viewAccommodationAgeList')->name('accommodation_age');        
        Route::get('accommodation_under_age', '\App\Http\Controllers\Admin\CourseController@viewAccommodationUnderAgeList')->name('accommodation_under_age');
        Route::get('custodian_under_age', '\App\Http\Controllers\Admin\CourseController@viewCustodianUnderAgeList')->name('custodian_under_age');
        
        Route::post('choose', '\App\Http\Controllers\Admin\CourseController@updateChooseList')->name('choose.update');
        Route::post('choose_age', '\App\Http\Controllers\Admin\CourseController@updateChooseAgeList')->name('choose_age.update');
    });
    Route::resource('course', '\App\Http\Controllers\Admin\CourseController');

    // Course Application Routes
    Route::group(['prefix' => 'course_application', 'as' => 'course_application.'], function () {
        Route::get('course/{id}', '\App\Http\Controllers\Admin\CourseApplicationController@editCourse')->name('course.edit');
        Route::post('course', '\App\Http\Controllers\Admin\CourseApplicationController@updateCourse')->name('course.update');
        Route::get('register/{id}', '\App\Http\Controllers\Admin\CourseApplicationController@editRegister')->name('register.edit');
        Route::post('register', '\App\Http\Controllers\Admin\CourseApplicationController@updateRegister')->name('register.update');
        Route::post('print', '\App\Http\Controllers\Admin\CourseApplicationController@print')->name('print');
        Route::get('approve/{id}/{value}', '\App\Http\Controllers\Admin\CourseApplicationController@approveCourseApplication')->name('approve');
        Route::get('customer/{customer_id}', '\App\Http\Controllers\Admin\CourseApplicationController@listForCustomer')->name('list.customer');
    });
    Route::resource('course_application', '\App\Http\Controllers\Admin\CourseApplicationController');

    Route::get('apply_visa', 'VisaFormController@index')->name('add_visa_form');
    Route::get('view_visa_forms', 'VisaFormController@show')->name('view_visa_forms');
    Route::get('view_visa_forms/{id}', 'VisaFormController@edit')->name('visa_form_edit');
    Route::post('view_visa_forms/{id}', 'VisaFormController@update')->name('visa_form_update');
    Route::delete('delete/{visaId}', 'VisaFormController@destroy')->name('delete_visa_forms');
    Route::post('visa_submit', 'VisaFormController@applyForVisa')->name('visa_submit');

    Route::resource('/visa', 'FormbuildController');
    Route::resource('enquiry', 'EnquiryController');
    
    Route::post('review/approve/{id}', '\App\Http\Controllers\Admin\ReviewController@approve')->name('review.approve');
    Route::post('review/disapprove/{id}', '\App\Http\Controllers\Admin\ReviewController@disapprove')->name('review.disapprove');
    Route::resource('review', '\App\Http\Controllers\Admin\ReviewController');

    Route::post('blog/update/{id}', 'BlogController@update')->name('blog.update');
    Route::post('blog/image_upload', 'BlogController@upload')->name('blog.upload');
    Route::post('blog/pause/{id}', 'BlogController@pause')->name('blog.pause');
    Route::post('blog/play/{id}', 'BlogController@play')->name('blog.play');
    Route::resource('blog', 'BlogController');

    Route::post('school/save/program/session', 'CourseController@programSessionSave')->name('course.session_store_for_program');
    
    Route::resource('payment_received', PaymentController::class);

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::resource('customer', 'CustomerController');
        Route::post('affiliate/{id}/transaction', 'AffiliateController@transaction')->name('affiliate.transaction');
        Route::resource('affiliate', 'AffiliateController');
        Route::resource('school_admin', 'SchoolAdminController');
        Route::resource('super_admin', 'SuperAdminController');
    });

    Route::get('visa_application', 'VisaApplicationController@index');
    Route::get('visa_application/other_fields/{id}', 'VisaApplicationController@getOtherFields')->name('visa.otherfields');

    Route::post('currency/set_default/{id}', 'CurrencyController@setDefault')->name('currency.set_default');
    Route::resource('currency', 'CurrencyController');

    Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
        Route::post('pause/{id}', 'CouponController@pause')->name('pause');
        Route::post('play/{id}', 'CouponController@play')->name('play');
        Route::get('usage/{id}', 'CouponController@usage')->name('usage');
    });
    Route::resource('coupon', 'CouponController');

    Route::resource('email_template', 'EmailTemplateController');

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('header_footer', 'SettingController@viewHeaderFooter')->name('header_footer');
        Route::post('header_footer', 'SettingController@updateHeaderFooter')->name('header_footer.update');

        Route::get('home_page', 'SettingController@viewHomePage')->name('home_page');
        Route::post('home_page', 'SettingController@updateHomePage')->name('home_page.update');

        Route::get('site', 'SettingController@viewSite')->name('site');
        Route::post('site', 'SettingController@updateSite')->name('site.update');

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
Route::group(['prefix' => 'schooladmin', 'as' => 'schooladmin.', 'middleware' => ['school_admin', 'email.verification'], 'namespace' => 'SchoolAdmin'], function () {
    Route::get('/', function () { return redirect()->route('schooladmin.dashboard'); });
    Route::get('dashboard', [\App\Http\Controllers\SchoolAdmin\DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'schoolAdminlogout'])->name('logout');

    Route::resource('enquiry', 'EnquiryController');

    Route::post('delete_applying_from', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteApplyingFrom')->name('delete_applying_from');
    Route::post('add_applying_from', '\App\Http\Controllers\Admin\AddVisaFieldsController@addApplyingFrom')->name('add_applying_from');
    Route::post('delete_application_center', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteApplicationCenter')->name('delete_application_center');
    Route::post('add_application_center', '\App\Http\Controllers\Admin\AddVisaFieldsController@addApplicationCenter')->name('add_application_center');
    Route::post('delete_nationality', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteNationality')->name('delete_nationality');
    Route::post('add_nationality', '\App\Http\Controllers\Admin\AddVisaFieldsController@addNationality')->name('add_nationality');
    Route::post('delete_travel', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteTravel')->name('delete_travel');
    Route::post('add_travel', '\App\Http\Controllers\Admin\AddVisaFieldsController@addTravel')->name('add_travel');
    Route::post('delete_type_of_visa', '\App\Http\Controllers\Admin\AddVisaFieldsController@deleteTypeOfVisa')->name('delete_type_of_visa');
    Route::post('add_type_of_visa', '\App\Http\Controllers\Admin\AddVisaFieldsController@addTypeOfVisa')->name('add_type_of_visa');

    Route::resource('branch_admin', 'BranchAdminController');
    
    Route::group(['prefix' => 'school', 'as' => 'school.'], function () {
        Route::post('image_upload', '\App\Http\Controllers\Admin\SchoolController@upload')->name('upload');
        Route::post('country', '\App\Http\Controllers\Admin\SchoolController@getCountryList')->name('country.list');
        Route::post('city_by_country', '\App\Http\Controllers\Admin\SchoolController@getCityByCountryList')->name('city_by_country.list');
        Route::post('city', '\App\Http\Controllers\Admin\SchoolController@getCityList')->name('city.list');
        Route::post('branch', '\App\Http\Controllers\Admin\SchoolController@getBranchList')->name('branch.list');
        Route::post('clone/{id}', '\App\Http\Controllers\Admin\SchoolController@clone')->name('clone');
        Route::post('pause/{id}', '\App\Http\Controllers\Admin\SchoolController@pause')->name('pause');
        Route::post('play/{id}', '\App\Http\Controllers\Admin\SchoolController@play')->name('play');
        Route::post('bulk', '\App\Http\Controllers\Admin\SchoolController@bulk')->name('bulk');
        Route::post('nationality', '\App\Http\Controllers\Admin\SchoolController@addNationality')->name('nationality.add');
        Route::delete('nationality', '\App\Http\Controllers\Admin\SchoolController@deleteNationality')->name('nationality.delete');
        Route::get('country_city', '\App\Http\Controllers\Admin\SchoolController@viewCountryCityList')->name('country_city');
        Route::post('country_city', '\App\Http\Controllers\Admin\SchoolController@updateCoutryCityList')->name('country_city.update');
        Route::get('name', '\App\Http\Controllers\Admin\SchoolController@viewNameList')->name('name');
        Route::post('name', '\App\Http\Controllers\Admin\SchoolController@updateNameList')->name('name.update');
        
        Route::post('save/program/session', '\App\Http\Controllers\Admin\CourseController@programSessionSave')->name('course.session_store_for_program');
    });
    Route::resource('school', '\App\Http\Controllers\Admin\SchoolController');

    Route::post('language', '\App\Http\Controllers\Admin\CourseFormController@addLanguage')->name('language.add');
    Route::delete('language', '\App\Http\Controllers\Admin\CourseFormController@deleteLanguage')->name('language.delete');
    Route::post('study_mode', '\App\Http\Controllers\Admin\CourseFormController@addStudyMode')->name('study_mode.add');
    Route::delete('study_mode', '\App\Http\Controllers\Admin\CourseFormController@deleteStudyMode')->name('study_mode.delete');
    Route::post('program_type', '\App\Http\Controllers\Admin\CourseFormController@addProgramType')->name('program_type.add');
    Route::delete('program_type', '\App\Http\Controllers\Admin\CourseFormController@deleteProgramType')->name('program_type.delete');
    Route::post('branch', '\App\Http\Controllers\Admin\CourseFormController@addBranch')->name('branch.add');
    Route::delete('branch', '\App\Http\Controllers\Admin\CourseFormController@deleteBranch')->name('branch.delete');
    Route::post('study_time', '\App\Http\Controllers\Admin\CourseFormController@addStudyTime')->name('study_time.add');
    Route::delete('study_time', '\App\Http\Controllers\Admin\CourseFormController@deleteStudyTime')->name('study_time.delete');
    Route::post('classes_day', '\App\Http\Controllers\Admin\CourseFormController@addClassesDay')->name('classes_day.add');
    Route::delete('classes_day', '\App\Http\Controllers\Admin\CourseFormController@deleteClassesDay')->name('classes_day.delete');
    Route::post('start_day', '\App\Http\Controllers\Admin\CourseFormController@addStartDay')->name('start_day.add');
    Route::delete('start_day', '\App\Http\Controllers\Admin\CourseFormController@deleteStartDay')->name('start_day.delete');
    Route::post('program_age_range', '\App\Http\Controllers\Admin\CourseFormController@addProgramAgeRange')->name('program_age_range.add');
    Route::delete('program_age_range', '\App\Http\Controllers\Admin\CourseFormController@deleteProgramAgeRange')->name('program_age_range.delete');
    Route::post('program_under_age_range', '\App\Http\Controllers\Admin\CourseFormController@addProgramUnderAge')->name('program_under_age_range.add');
    Route::delete('program_under_age_range', '\App\Http\Controllers\Admin\CourseFormController@deleteProgramUnderAge')->name('program_under_age_range.delete');
    Route::post('accomm_age_range', '\App\Http\Controllers\Admin\CourseFormController@addAccommodationAgeRange')->name('accomm_age_range.add');
    Route::delete('accomm_age_range', '\App\Http\Controllers\Admin\CourseFormController@deleteAccommodationAgeRange')->name('accomm_age_range.delete');
    Route::post('accomm_custodian_age', '\App\Http\Controllers\Admin\CourseFormController@addCustodianAgeRange')->name('accomm_custodian_age.add');
    Route::delete('accomm_custodian_age', '\App\Http\Controllers\Admin\CourseFormController@deleteCustodianAgeRange')->name('accomm_custodian_age.delete');
    Route::post('accomm_under_age', '\App\Http\Controllers\Admin\CourseFormController@addAccommodationUnderAge')->name('accomm_under_age.add');
    Route::delete('accomm_under_age', '\App\Http\Controllers\Admin\CourseFormController@deleteAccommodationUnderAge')->name('accomm_under_age.delete');

    Route::post('airport_update', '\App\Http\Controllers\Admin\CourseController@airportUpdate')->name('airport_update');
    Route::post('medical_update', '\App\Http\Controllers\Admin\CourseController@medicalUpdate')->name('medical_update');

    Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
        Route::delete('delete/{course_id}', '\App\Http\Controllers\Admin\CourseController@delete')->name('delete');
        Route::post('restore/{course_id}', '\App\Http\Controllers\Admin\CourseController@restore')->name('restore');
        Route::post('clone/{course_id}', '\App\Http\Controllers\Admin\CourseController@clone')->name('clone');
        Route::post('pause/{course_id}', '\App\Http\Controllers\Admin\CourseController@pause')->name('pause');
        Route::post('play/{course_id}', '\App\Http\Controllers\Admin\CourseController@play')->name('play');
        Route::post('promotion/{course_id}', '\App\Http\Controllers\Admin\CourseController@promotion')->name('promotion');
        Route::post('link_fee/{course_id}', '\App\Http\Controllers\Admin\CourseController@linkFee')->name('link_fee');
        Route::post('bulk', '\App\Http\Controllers\Admin\CourseController@bulk')->name('bulk');
    
        Route::post('program_under_age/fetch', '\App\Http\Controllers\Admin\CourseController@fetchProgramUnderAgePage')->name('program_under_age.fetch');
        Route::get('program_under_age/edit', '\App\Http\Controllers\Admin\CourseController@editProgramUnderAge')->name('program_under_age.edit');
        Route::get('program_under_age', '\App\Http\Controllers\Admin\CourseController@viewProgramUnderAge')->name('program_under_age');
        
        Route::get('accommodation/edit', '\App\Http\Controllers\Admin\CourseController@editAccommodation')->name('accommodation.edit');
        Route::get('accommodation/{course_unique_id}', '\App\Http\Controllers\Admin\CourseController@detailsAccommodation')->name('accommodation.details');
        Route::get('accommodation', '\App\Http\Controllers\Admin\CourseController@viewAccommodation')->name('accommodation');
        Route::delete('accommodation/{id}', '\App\Http\Controllers\Admin\CourseDetailsController@deleteAccommodation')->name('accommodation.delete');
    
        Route::post('accomm_under_age/fetch', '\App\Http\Controllers\Admin\CourseController@fetchAccommodationUnderAgePage')->name('accomm_under_age.fetch');
        Route::get('accomm_under_age/edit', '\App\Http\Controllers\Admin\CourseController@editAccommodationUnderAge')->name('accomm_under_age.edit');
        Route::get('accomm_under_age/{course_unique_id}', '\App\Http\Controllers\Admin\CourseController@detailsAccommodationUnderAge')->name('accomm_under_age.details');
        Route::get('accomm_under_age', '\App\Http\Controllers\Admin\CourseController@viewAccommodationUnderAge')->name('accomm_under_age');
        Route::delete('accomm_under_age/{id}', '\App\Http\Controllers\Admin\CourseDetailsController@deleteAccommodationUnderAge')->name('accomm_under_age.delete');
    
        Route::get('other_service/edit', '\App\Http\Controllers\Admin\CourseController@editOtherService')->name('other_service.edit');
        Route::get('other_service/{course_unique_id}', '\App\Http\Controllers\Admin\CourseController@detailsOtherService')->name('other_service.details');
        Route::get('other_service', '\App\Http\Controllers\Admin\CourseController@viewOtherService')->name('other_service');
        Route::delete('other_service/{id}', '\App\Http\Controllers\Admin\CourseDetailsController@deleteOtherService')->name('other_service.delete');
        
        Route::get('program/{course_unique_id}', '\App\Http\Controllers\Admin\CourseDetailsController@detailsProgram')->name('program.details');
        Route::delete('program/{unique_id}', '\App\Http\Controllers\Admin\CourseDetailsController@deleteProgram')->name('program.delete');
    
        Route::post('update', '\App\Http\Controllers\Admin\CourseDetailsController@courseUpdate')->name('course_update');
    
        Route::post('image_upload', '\App\Http\Controllers\Admin\CourseController@upload')->name('upload');

        Route::get('deleted', '\App\Http\Controllers\Admin\CourseController@deleted')->name('deleted');
    });
    Route::resource('course', '\App\Http\Controllers\Admin\CourseController');

    // Course Application Routes
    Route::group(['prefix' => 'course_application', 'as' => 'course_application.'], function () {
        Route::get('course/{id}', '\App\Http\Controllers\Admin\CourseApplicationController@editCourse')->name('course.edit');
        Route::post('course', '\App\Http\Controllers\Admin\CourseApplicationController@updateCourse')->name('course.update');
        Route::get('register/{id}', '\App\Http\Controllers\Admin\CourseApplicationController@editRegister')->name('register.edit');
        Route::post('register', '\App\Http\Controllers\Admin\CourseApplicationController@updateRegister')->name('register.update');
        Route::post('print', '\App\Http\Controllers\Admin\CourseApplicationController@print')->name('print');
        Route::get('approve/{id}/{value}', '\App\Http\Controllers\Admin\CourseApplicationController@approveCourseApplication')->name('approve');
    });
    Route::resource('course_application', '\App\Http\Controllers\Admin\CourseApplicationController');    
    
    Route::post('review/approve/{id}', '\App\Http\Controllers\Admin\ReviewController@approve')->name('review.approve');
    Route::post('review/disapprove/{id}', '\App\Http\Controllers\Admin\ReviewController@disapprove')->name('review.disapprove');
    Route::resource('review', '\App\Http\Controllers\Admin\ReviewController');

    Route::post('school/save/program/session', 'CourseControllerSchoolAdmin@programSessionSave')->name('course.session_store_for_program');
});

///// Branch Admin Routes /////
Route::group(['namespace' => 'BranchAdmin', 'prefix' => 'branch_admin', 'middleware' => 'branch_admin', 'as' => 'branch_admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('branch_admin.dashboard');
    });

    Route::get('course_application/approve/{id}/{value}', 'CourseApplicationController@approve')->name('course_application.approve');

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

    Route::resource('enquiry', 'EnquiryController');

    Route::view('rating', 'rating.index')->name('rating.index');
    Route::get('rating/approve/{id}', [\App\Http\Controllers\RatingController::class, 'approve'])->name('rating.approve');

    Route::post('school/save/program/session', 'CourseControllerSchoolAdmin@programSessionSave')->name('course.session_store_for_program');

    Route::get('course_application', 'CourseApplicationController@index')->name('course_application.index');
    Route::get('course_application/view_message/{id}', 'CourseApplicationController@viewMessage')->name('course_application.view_message');
    Route::resource('payment_received', PaymentController::class);
    Route::post('course_application/send_message_to_super_admin', 'CourseApplicationController@sendMessageToSuperAdmin')->name('course_application.send_message_to_super_admin');

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