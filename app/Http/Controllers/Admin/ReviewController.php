<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CourseApplication;
use App\Models\Review;
use App\Models\User;

use Ghanem\Rating\Models\Rating;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth('superadmin')->check()) {
            $reviews = Review::with('user', 'course_applications.school')->get();
        } else if (auth('schooladmin')->check()) {
            $school_ids = auth('schooladmin')->user()->school;
            $reviews = Review::with('user', 'course_applications.school')
                ->whereHas('course_applications.school', function ($query) use ($school_ids)
                    { $query->whereIn('id', $school_ids); }
                )->get();
        }

        return view('admin.review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('user_type', 'user')->get();
        return view('admin.review.add', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'review' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $review = new Review;
        $review->author_id = $request->user_id;
        $review->course_application_id = $id;
        $review->review = $request->review;
        $review->quality_teaching = $request->quality_teaching;
        $review->school_facilities = $request->school_facilities;
        $review->social_activities = $request->social_activities;
        $review->school_location = $request->school_location;
        $review->satisfied_teaching = $request->satisfied_teaching;
        $review->level_cleanliness = isset($request->level_cleanliness) ? $request->level_cleanliness : 0;
        $review->distance_accommodation_school = isset($request->distance_accommodation_school) ? $request->distance_accommodation_school : 0;
        $review->satisfied_accommodation = isset($request->satisfied_accommodation) ? $request->satisfied_accommodation : 0;
        $review->airport_transfer = isset($request->airport_transfer) ? $request->airport_transfer : 0;
        $review->city_activities = $request->city_activities;
        $review->recommend_this_school = $request->recommend_this_school;
        $review->use_full_name = $request->use_full_name;

        $course_application = CourseApplication::find($review->course_application_id);
        $review_point_count = 6;
        if ($course_application && $course_application->accommodation_id) {
            $review_point_count = $review_point_count + 3;
        }
        if ($course_application && $course_application->airport_id) {
            $review_point_count = $review_point_count + 1;
        }
        $review->average_point = ($review->quality_teaching + $review->school_facilities + $review->social_activities
            + $review->school_location + $review->satisfied_teaching + $review->level_cleanliness
            + $review->distance_accommodation_school + $review->satisfied_accommodation + $review->airport_transfer
            + $review->city_activities) / $review_point_count;
        $review->save();

        $saved = __('Admin/backend.data_saved_successfully');
        return response()->json(['data' => $saved, 'success' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::find($id);
        $course_application = CourseApplication::find($review ? $review->course_application_id : '');
        
        return view('admin.review.edit', compact('review', 'course_application'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        $validator = \Validator::make(
            $request->all(),
            [
                'review' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $save = $validator->validated();

        $review->review = $request->review;
        $review->quality_teaching = $request->quality_teaching;
        $review->school_facilities = $request->school_facilities;
        $review->social_activities = $request->social_activities;
        $review->school_location = $request->school_location;
        $review->satisfied_teaching = $request->satisfied_teaching;
        $review->level_cleanliness = isset($request->level_cleanliness) ? $request->level_cleanliness : 0;
        $review->distance_accommodation_school = isset($request->distance_accommodation_school) ? $request->distance_accommodation_school : 0;
        $review->satisfied_accommodation = isset($request->satisfied_accommodation) ? $request->satisfied_accommodation : 0;
        $review->airport_transfer = isset($request->airport_transfer) ? $request->airport_transfer : 0;
        $review->city_activities = $request->city_activities;
        $review->recommend_this_school = $request->recommend_this_school;
        $review->use_full_name = $request->use_full_name;

        $course_application = CourseApplication::find($review->course_application_id);
        $review_point_count = 6;
        if ($course_application && $course_application->accommodation_id) {
            $review_point_count = $review_point_count + 3;
        }
        if ($course_application && $course_application->airport_id) {
            $review_point_count = $review_point_count + 1;
        }
        $review->average_point = ($review->quality_teaching + $review->school_facilities + $review->social_activities
            + $review->school_location + $review->satisfied_teaching + $review->level_cleanliness
            + $review->distance_accommodation_school + $review->satisfied_accommodation + $review->airport_transfer
            + $review->city_activities) / $review_point_count;

        $review->save();

        $saved = __('Admin/backend.data_saved_successfully');
        return response()->json(['data' => $saved, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Review::findorFail($id);
        $deleted = __('Admin/backend.data_deleted_successfully');
        $delete->delete();
        return back()->with(['message' => $deleted]);
    }

    public function approve($id)
    {
        $review = Review::find($id);
        $review->approved = 1;
        $review->save();

        toastr()->success(__('Admin/backend.review_approved'));
        return back();
    }

    public function disapprove($id)
    {
        $review = Review::find($id);
        $review->approved = 0;
        $review->save();

        toastr()->success(__('Admin/backend.review_disapproved'));
        return back();
    }
}