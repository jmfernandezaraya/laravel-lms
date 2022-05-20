<?php

namespace App\Models;

use App\Models\Review;

use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\UserCourseBookedDetailsApproved;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

use TelrGateway\Transaction;

/**
 * Class UserCourseBookedDetails
 * @package App\Models
 */
class UserCourseBookedDetails extends Model
{
    use HasFactory;    
    use Notifiable;

    /**
     * @var string[]
     */
    protected $casts = ['heard_where' => 'array', 'start_date' => 'date'];
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return array
     */
    public function getAttributesName()
    {
        $attribute = $this->getAttributes();

        unset($attribute['id']);
        unset($attribute['user_id']);
        unset($attribute['created_at']);
        unset($attribute['updated_at']);

        return $attribute;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userBookDetailsApproveds()
    {
        return $this->hasMany(UserCourseBookedDetailsApproved::class, 'user_course_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userBookDetailsApproved()
    {
        return $this->hasOne(UserCourseBookedDetailsApproved::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'unique_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function airport()
    {
        return $this->belongsTo(CourseAirport::class, 'airport_id', 'unique_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accomodation()
    {
        return $this->belongsTo(CourseAccommodation::class, 'accommodation_id', 'unique_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review()
    {
        return $this->belongsTo(Review::class, 'id', 'user_course_booked_details_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCourseBookedStatusus()
    {
        return $this->hasMany(UserCourseBookedStatus::class, 'user_course_booked_detail_id');
    }

    /**
     * @param $status
     * @return string
     */
    public function getUserCourseBookedStatus($status)
    {
        $created_at = '-';
        $coursebookedstatus = $this->userCourseBookedStatusus()->where('status', $status)->first();
        if ($coursebookedstatus) {
            $created_at = $coursebookedstatus->created_at->format('d M Y');
        }

        return $created_at;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'order_id', 'cart_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCourseProgram()
    {
        return $this->belongsTo(CourseProgram::class, 'course_program_id', 'unique_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userCourseFee()
    {
        return $this->hasOne(UserCourseBookedFee::class);
    }
}