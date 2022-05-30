<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserVerificationController extends Controller
{
    public function approve($token)
    {
        $user = User::where('verification_token', $token)->first();
        abort_if(!$user, 404);

        $route = 'login';

        $user->verified           = 1;
        $user->verified_at        = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        $user->verification_token = null;
        $user->save();

        if( Auth::check() ) {
            $route = 'newfront.profile';
        }

        return redirect()->route($route)->with('message', trans('global.emailVerificationSuccess'));
    }
}
