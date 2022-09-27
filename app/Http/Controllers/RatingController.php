<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Ghanem\Rating\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /*
    * @param Request $request
    *
    * @return success or fail message
    * */
    public function saveRating(Request $request)
    {
        $data['status'] = true;
        if (!auth()->check()) {
            $data['status'] = false;
            $message = __('Frontend.login_first');
            return response(['failed' => $message]);
        }
        $user = User::findOrFail(auth()->user()->id);
        $school = School::find($request->school_id)->first();
        if(!(Rating::where('ratingable_id', $school->id)->where('author_id', auth()->user()->id)->first()))
        {
            $rating = $school->rating([
                'rating' => $request->how_much
            ], $user);

            return \Session::put('rating_id', $rating->id);
        } else{
            return response(['failed' => __('Frontend.already_rated')]);
        }
    }

    /*
    * function for saving comments
    *
    * @param Request $request
    *
    * @return success message
    *
    * */
    public function saveComments(Request $request)
    {
        $rating = Rating::find(\Session::get('rating_id'));
        $rating->comments = $request->comments;
        $rating->save();

        toastr()->success(__('Frontend.rating_received'));
        return back();
    }

    /*
    * function for approve rating
    *
    * @param id
    *
    * @return success message
    *
    *
    * */
    public function approve($id)
    {
        (new Rating)->updateRating($id, ['approved' => '1']);

        toastr()->success(__('Admin/backend.rating_approved'));
        return back();
    }
}