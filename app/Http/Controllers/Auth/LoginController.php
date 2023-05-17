<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FollowRink;
use App\Models\WishlistRink;
use App\Models\Rink;
use Hash;
use Auth;
use Session;
use DB;
use App\Notifications\sendPasswordLink;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout','followRink','wishlistRink');
    }

    public function showLoginForm()
    {
      return view('auth.login');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:8'
      ]);

      if ($user = User::where('email', $request->email)->where('user_type', '!=', 'admin')->first()) 
      {
          if ($user->email_verified_at != null) 
          {
              if($user->password != '')
              {
                  $remember_me = $request->has('remember_me') ? true : false;
                  if (auth()->attempt(['email' => $request->email, 'password' => $request->password], $remember_me))
                  {
                      Auth::login($user);
                      if(Session::has('follow_rink_id'))
                      {
                         $request = new Request();
                         $request->rink_id = Session::get('follow_rink_id');
                         $request->status = 1;
                         Session::forget('follow_rink_id');
                         $this->followRink($request);
                      }
                      // if(Session::has('wishlist_rink_id'))
                      // {
                      //    $request = new Request();
                      //    $request->rink_id = Session::get('wishlist_rink_id');
                      //    $request->status = 1;
                      //    Session::forget('wishlist_rink_id');
                      //    $this->wishlistRink($request);
                      // }
                      if(Session::has('redirectURL'))
                      {
                          $redirect = Session::get('redirectURL');
                          Session::forget('redirectURL');
                      }
                      else
                          $redirect = "/";

                      return redirect($redirect);
                  }
                  else{
                    return back()->with('error','Invalid Login Attempt. If you’ve forgotten your password, please use the Forgot Password link.');
                  }
              }
              else
                {
                    return back()->with('error','This Email is registered with '.$user->provider.'. Please try login with that.');
                  }
          }
          else{
                $url = url('send-verification-mail/'.base64_encode($request->email));
                return back()->with('error','Your email is not verified. Please verify your email address and retry. <a href="'.$url.'">Click here</a> to resend the verification email. ');
          }
      }
      else
      {
        return redirect()->back()->with('error','Sorry, there is no record of an account associated with this email. Please retry.')->withInput($request->only('email', 'remember'));
      }
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function forgetPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
        if ($user = User::where('email', $request->email)->where('user_type','!=','admin')->first()) {
            $token = str_random(60);
            $password_reset_user = DB::table('password_resets')
                ->where('email', $request->email)
                ->first();
            if ($password_reset_user) {
                $token_saved = DB::table('password_resets')
                    ->where('email', $password_reset_user->email)
                    ->update([
                        'token' => $token]);
            } else {
                $token_saved = DB::table('password_resets')->insert(['email' => $request->email,
                    'token' => $token, 'created_at' => date('Y-m-d H:i:s')]);
            }
            if ($token_saved) {
                $user->notify(new sendPasswordLink($user,$token));
                return back()->with('success', 'Please check your email for password reset instructions.');
            } else {
                return back()->with('error', 'This email does not exist.');
            }
        } else {
            return back()->with('error', 'This email does not exist.');
        }
    }

    public function updateForgotPassword(Request $request)
    {

        $validation = $this->validate($request, ['password' => 'required|min:8|confirmed', 'password_confirmation' => 'required']);
        $email = DB::table('password_resets')
            ->select('email')
            ->where('token', $request->token)
            ->first();
        $user = DB::table('users')
            ->select('*')
            ->where('email', $email->email)
            ->first();
        if ($request->password == $request->password_confirmation) {
            if ($user) {
                $password_updated = DB::table('users')
                    ->where('email', $user->email)
                    ->update(['password' => Hash::make($request->password)]);

                if ($password_updated) {
                    return redirect('/login')->with(['success' => 'Password was changed successfully.']);
                } else {
                    return redirect('/login')->with(['error' => 'There is an error while changing the password please try again later.!']);
                }
            }
        } else {
            return back()->with('error', 'Password do not matched with confirm password');
        }
    }

    public function followRink(Request $request)
    {
        if(Auth::check())
        {
            $rink = Rink::find($request->rink_id);
            if($rink->operator_id == Auth::id())
              return back()->with('error','You can not follow your own rink.');

            if($request->status == 1)
              $msg = 'You have successfully followed the rink.';
            else
              $msg = 'You have successfully unfollowed the rink.';

            $alreadyFollowed = FollowRink::whereUserId(Auth::id())->whereRinkId($request->rink_id)->first();
            if($alreadyFollowed)
            {
                if($alreadyFollowed->status == 1 && $request->status == 1)
                    return back()->with('error','You have already followed this rink.');
                else
                    $alreadyFollowed->update(['status'=>$request->status]);
            }
            else
                FollowRink::create(['user_id'=>Auth::id(),'rink_id'=>$request->rink_id,'status'=>1]);

            return back()->with('success', $msg);
        }
        else
        {
            Session::put('follow_rink_id',$request->rink_id);
            return redirect('login')->with('error','Please login, if you want to be notified of new added slots.');
        }
    }

    public function wishlistRink(Request $request)
    {
        if(Auth::check())
        {
            if($request->status == 1)
              $msg = 'You have successfully wishlisted the rink.';
            else
              $msg = 'You have removed the rink from wishlist.';

            $alreadyWishlisted = WishlistRink::whereUserId(Auth::id())->whereRinkId($request->rink_id)->first();
            if($alreadyWishlisted)
            {
                if($alreadyWishlisted->status == 1 && $request->status == 1)
                    return back()->with('error','You have already wishlisted this rink.');
                else
                    $alreadyWishlisted->update(['status'=>$request->status]);
            }
            else
                WishlistRink::create(['user_id'=>Auth::id(),'rink_id'=>$request->rink_id,'status'=>1]);

            return back()->with('success', $msg);
        }
        else
        {
            Session::put('wishlist_rink_id',$request->rink_id);
            return redirect('login')->with('error','Please login, if you want to add the rink to wishlist.');
        }
    }
}
