<?php

namespace App\Http\Controllers\User\PersonalInfo;

use Auth;
use Image;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Models\User\UserPersonalInfo;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\User\UserBaseController;

class PersonalInfosController extends UserBaseController
{
    public function edit($user_id)
    {
        $user = $this->getUser($user_id);
        return view('user.personalInfo.edit')
        ->with('user', $user)
        ->with('personalInfo', $user->personalInfo);
    }

    public function update(Request $request, $user_id)
    {
        $this->validate($request,[
            'designation' => 'required|min:3|max:150',
            'mobile' => 'required|min:8|max:15',
            'gender' => 'required|numeric',
            'blood_group' => 'required|min:1',
            'joining_date' => 'required|date',
            'about' => 'max:500',
        ]);

        $input = $request->all();
        $input['designation'] = ucwords($request->designation);
        $input['about'] = ucfirst($request->about);

        $user = $this->getUser($user_id);
        if ($pInfo = $user->personalInfo) {
            $input['supervisor_id'] = Auth::user()->user_id;
            if ($pInfo->update($input)) {
                Session::flash('success','Pserosnal info update successfull');
            }
        }else{
            $input['user_id'] = $user->user_id;
            $input['supervisor_id'] = Auth::user()->user_id;
            if (UserPersonalInfo::create($input)) {
                Session::flash('success','Pserosnal info create successfull');
            }
        }

        return redirect()->route('profile.show',$user_id);
    }

    public function profilePic($user_id)
    {
        $user = $this->getUser($user_id);
        return view('user.personalInfo.profile_pic')
        ->with('user', $user)
        ->with('personalInfo', $user->personalInfo);
    }

    public function uploadProfilePic(Request $request, $user_id)
    {
        $this->validate($request,[
            'image' => 'required|image|mimes:jpg,jpeg,png:max:1000',
        ]);

        $input = $request->all();
        $user = $this->getUser($user_id);

        if ($image = $request->file('image')) {
            //......if user has personal info
            if ($pInfo = $user->personalInfo) {
                //.......if user has personal info image update it
                if ($user->personalInfo->image) {
                    //........resize image
                    $img = UserPersonalInfo::resizeImage($image);
                    //........saving to  disk
                    Storage::disk('profile')->put($pInfo->image, $img,'public');
                    Session::flash('success','Profile picture upload successfull');
                }else {
                    //......create new name
                    $new_name     = UserPersonalInfo::generateImageName($image);
                    $pInfo->image = $new_name;
                    $pInfo->supervisor_id = Auth::user()->user_id;
                    //........resize image
                    $img = UserPersonalInfo::resizeImage($image);
                    //........saving to disk
                    Storage::disk('profile')->put($new_name, $img,'public');

                    if ($pInfo->save()) {
                        Session::flash('success','Profile picture upload successfull');
                    }

                }
            }else{
                $pInfo = new UserPersonalInfo();
                $pInfo->user_id = $user->user_id;
                $pInfo->supervisor_id = Auth::user()->user_id;
                //......create new name
                $new_name     = UserPersonalInfo::generateImageName($image);
                $pInfo->image = $new_name;
                //........resize image
                $img = UserPersonalInfo::resizeImage($image);
                //........saving to disk
                Storage::disk('profile')->put($new_name, $img,'public');

                if ($pInfo->save()) {
                    Session::flash('success','Profile picture upload successfull');
                }
            }
        }


        return redirect()->route('profile.show',$user_id);
    }
}
