<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use File;
use DB;
use App\Notifications\PasswordChanged;
use Str;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(request $request)
    {
        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Sorry your current password does not match.!');
        }

        $this->validate($request, ['password' => 'required|confirmed|min:8']);

        if ($request->password == $request->password_confirmation) {
            if ($user) {
                $password_updated = $user->update(['password' => Hash::make($request->password)]);

                if ($password_updated) {
                    $user->notify(new PasswordChanged($user));
                    return back()->with(['success' => 'Password is changed successfully.!']);
                } else {
                    return back()->with(['error' => 'There is an error while changing the password please try again later.!']);
                }
            }
        } else {
            return back()->with('error', 'New password do not matched with confirm password.!');
        }
    }

    public function updateProfile(Request $request)
    {
        $formData = request()->except(['_token']);

        if ($request->hasFile('profile_pic')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('profile_pic');
            File::delete($formData['oldImageValue']);

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['profile_pic'] = $file->store('profile_pics');
            }
        }

        User::find(Auth::id())->update($formData);

        return back()->with('success', 'Profile updated successfully.');

    }

    public function notifications($value='')
    {
        DB::table('notifications')->where('read_at', NULL)->where('notifiable_id', Auth::id())->update(['read_at' => Date('Y-m-d H:i:s')]);

        $all_notifications = Auth::user()->notifications()->get();
        $notifications = [];
        foreach ($all_notifications as $notification) {
            $notifications[] = $notification;
        }

        return view('front-user.common.notifications', compact('notifications', $notifications));
    }

}
