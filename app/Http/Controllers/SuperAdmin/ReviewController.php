<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

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
        $reviews = Review::with('user', 'course_applications.school')->get();

        return view('superadmin.review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('user_type', 'user')->get();
        return view('superadmin.review.add', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'review' => 'required',
            ]
        );
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
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
        $review->level_cleanliness = $request->level_cleanliness;
        $review->distance_accommodation_school = $request->distance_accommodation_school;
        $review->satisfied_accommodation = $request->satisfied_accommodation;
        $review->airport_transfer = $request->airport_transfer;
        $review->city_activities = $request->city_activities;
        $review->recommend_this_school = $request->recommend_this_school;
        $review->use_full_name = $request->use_full_name;
        $review->save();
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
        
        return view('superadmin.review.edit', compact('review'));
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
        $rules = [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules, [
            'title_ar.required' => __('SuperAdmin/backend.errors.blog_title_in_arabic'),
            'title_en.required' => __('SuperAdmin/backend.errors.blog_title_in_english'),
            'description_en.required' => __('SuperAdmin/backend.errors.description_en_required'),
            'description_ar.required' => __('SuperAdmin/backend.errors.description_ar_required'),
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
        $save = $validate->validated();

        $review->fill($save)->save();
        $saved = __('SuperAdmin/backend.data_saved_successfully');
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
        $deleted = __('SuperAdmin/backend.data_deleted_successfully');
        $delete->delete();
        return back()->with(['message' => $deleted]);
    }

    public function approve($id)
    {
        $review = Review::find($id);
        $review->approved = 1;
        $review->save();

        toastr()->success(__('SuperAdmin/backend.review_approved'));
        return back();
    }

    public function disapprove($id)
    {
        $review = Review::find($id);
        $review->approved = 0;
        $review->save();

        toastr()->success(__('SuperAdmin/backend.review_disapproved'));
        return back();
    }
}