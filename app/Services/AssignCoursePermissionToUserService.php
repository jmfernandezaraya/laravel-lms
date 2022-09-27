<?php

namespace App\Services;

use App\Models\SchoolAdminCourseEditPermissions;

use Illuminate\Http\Request;

class AssignCoursePermissionToUserService
{
    public function AsssignCoursePermissionToUser(Request $request)
    {
        if (empty($request->users)) {
            $getusers = SchoolAdminCourseEditPermissions::where('course_id', $request->id)->count();

            if ($getusers > 0) {
                $getusers = SchoolAdminCourseEditPermissions::where('course_id', $request->id)->get();
                foreach ($getusers as $getuser) {
                    $getuser->is_true = 0;
                    $getuser->save();
                }
            }

            return back();
        }

        for ($i = 0; $i < count($request->users); $i++) {
            $permission_count = SchoolAdminCourseEditPermissions::where('user_id', $request->users[$i])->where('course_id', $request->id)->count();
            if ($permission_count > 0) {
                if ($i == 0) {
                    $set_first_permission = SchoolAdminCourseEditPermissions::where('course_id', $request->id)->get();

                    foreach ($set_first_permission as $set) {
                        $set->is_true = false;
                        $set->save();
                    }
                }
                $permissions = SchoolAdminCourseEditPermissions::where('user_id', $request->users[$i])->where('course_id', $request->id)->first();

                if ($permissions->user_id == $request->users[$i]) {
                    $permissions->is_true = true;
                }

                $permissions->save();
            } else {
                SchoolAdminCourseEditPermissions::updateOrCreate(['course_id' => $request->id, 'user_id' => $request->users[$i]], [
                    'course_id' => $request->id,
                    'user_id' => $request->users[$i],
                    'is_true' => 1
                ]);
            }
        }

        toastr()->success(__('Admin/backend.data_saved_successfully'));

        return back();
    }
}