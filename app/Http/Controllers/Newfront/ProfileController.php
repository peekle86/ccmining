<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
//use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    //use MediaUploadingTrait;

    public function index()
    {
        $user = auth()->user();
        return view('newfront.profile', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        // if ($request->input('avatar', false)) {
        //     if (!$user->avatar || $request->input('avatar') !== $user->avatar->file_name) {
        //         if ($user->avatar) {
        //             $user->avatar->delete();
        //         }
        //         $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
        //     }
        // } elseif ($user->avatar) {
        //     $user->avatar->delete();
        // }

        return redirect()->route('newfront.profile')->with('message', __('global.update_profile_success'));
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }

    public function password(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect()->route('frontend.profile.index')->with('message', __('global.change_password_success'));
    }
}
