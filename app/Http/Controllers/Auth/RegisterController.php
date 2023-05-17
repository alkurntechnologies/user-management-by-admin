<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Notifications\registration;
use App\Notifications\adminUserRegistration;
use Auth;
use Socialite;
use Storage;
use GuzzleHttp\Client;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function showSignupForm()
    {
      return view('auth.signup');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[
            'email.unique'=>'The email is already registered on this site.',
            'password.confirmed'=>'The proposed passwords do not match.'
        ]);
    }

    protected function register(Request $request)
    {
        $formData = request()->except(['_token']);

        // validate the user form data
        $validation = $this->validator($formData);

        // if validation fails
        if ($validation->fails()) {
            // redirect back to the form 
            return redirect()->back()->withErrors($validation)->withInput();
        }
        // if validation passes
        $password = $formData['password'];
        $formData['password'] = Hash::make($formData['password']);

        $formData['verify_token'] = str_random(30);

        // save the user to the database
        $user = User::create($formData);

        //Notify the user for the registration
        $user->notify(new registration($user));

        //Notify the admin for the registration
        $admin = User::whereUserType('admin')->first();
        $admin->notify(new adminUserRegistration ($user,$admin));

        // return a view 
        return redirect('/login')->with('success', 'Registration successful! Please check your email for verification.');
    }

     ### social login api
    public function redirectToProvider($provider)
    {
        Session::put('provider',$provider);
        if($provider=='facebook')
            return Socialite::driver($provider)->scopes(['email','public_profile','user_link','user_friends','pages_show_list','pages_read_engagement','user_posts'])->redirect();
        elseif($provider=='instagram')
            return Socialite::driver('facebook')->scopes(['pages_show_list','instagram_basic'])->redirect();
        else    
            return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider, Request $request)
    {
        if($request->error!='')
            return redirect('login');

        $userSocial = Socialite::driver($provider)->user();

        if($provider=='youtube')
        {
            $youtube_subscribers = file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$userSocial->id.'&key='.env('YOUTUBE_API_KEY'));
            $youtube_api_response = json_decode($youtube_subscribers, true );
            $userSocial->followers_count = intval($youtube_api_response['items'][0]['statistics']['subscriberCount']);

            $userSocial->profileUrl = "https://www.youtube.com/channel/".@$userSocial->id;
        }
        elseif(Session::get('provider')=='instagram')
        {
            $provider = 'instagram';
            $url = "https://graph.facebook.com/".@$userSocial->pages[0]['id']."?fields=instagram_business_account&access_token=".@$userSocial->token;
            $client = new Client();
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();
            $oAuth = json_decode($content);
            $insta_user_id = @$oAuth->instagram_business_account->id;

            if($insta_user_id=='')
            {
                Session::put('influencer_follower_error', 'Invalid page or instagram account selected'); 
                return "<script type='text/javascript'> self.close(); window.opener.refreshParentError();</script>";
            }
            $url = "https://graph.facebook.com/".$insta_user_id."?fields=id,name,username,profile_picture_url,followers_count&access_token=".@$userSocial->token;
            $client = new Client();
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();
            $oAuth = json_decode($content);

            //$userSocial = new \stdClass();
            $userSocial->name = @$oAuth->name;
            $userSocial->followers_count = @$oAuth->followers_count;
            $userSocial->profileUrl = "https://www.instagram.com/".@$oAuth->username;
            $userSocial->avatar_original = @$oAuth->profile_picture_url;
        }
        elseif($provider=='facebook')
        {
            $userSocial->name = @$userSocial->pages[0]['name'];
            $userSocial->profileUrl = @$userSocial->pages[0]['link'];
            $userSocial->avatar_original = 'https://graph.facebook.com/'.@$userSocial->pages[0]['id'].'/picture';
        }

        dd($userSocial);

        $accessToken = $userSocial->token;

        $fb_user_id = $userSocial->id;

        $url = 'https://graph.facebook.com/'.$fb_user_id.'/posts?fields=object_id,message,link,type,created_time,attachments&access_token='.$accessToken;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);

        echo "<pre>";
        print_r($data);
        echo "</pre>"; 
        exit;
        //return redirect('login')->with(['userSocial'=>$userSocial,'provider'=>$provider]);

        echo @$userSocial->pages[0]['name'];
        echo nl2br('<br>');
        echo @$userSocial->pages[0]['link'];
        echo nl2br('<br>');
        $name = @$userSocial->name!=''?@$userSocial->name:@$userSocial->nickname;
        echo "Name: ". $name;
        echo nl2br('<br>');
        $avatar = @$userSocial->avatar_original!=''?@$userSocial->avatar_original:@$userSocial->avatar;
        echo "Picture: ". $avatar;
        echo nl2br('<br>');
        // echo "Email: ". @$userSocial->email;
        // echo nl2br('<br>');
        echo "URL: ". @$userSocial->profileUrl;
        echo nl2br('<br>');
        echo "Followers: ". @$userSocial->followers_count;
        echo nl2br('<br>');

        if($provider=='youtube')
            echo "Youtube channel: https://www.youtube.com/channel/".@$userSocial->id;
        elseif($provider=='facebook')
        {
            echo "Facebook page(s):";
            echo nl2br('<br>');
            foreach (@$userSocial->pages as $page) {
                echo $page['link'];
                echo nl2br('<br>');
            }
        }

        exit;

        if(@$userSocial->email != null)
            $user = User::where('email', @$userSocial->email)->first();
        else
            $user = User::where('provider_id', @$userSocial->id)->first();

        if (!$user)
        {
            if($userSocial->avatar=='')
                $userSocial->avatar = @$userSocial->getAvatar();
            //create new user and login him
            $name = explode(' ', @$userSocial->name);
            $fileContents = file_get_contents($avatar);
            $filename = str_random(40);
            Storage::put('profile_pics/'.$filename.'.jpg', $fileContents);

            $user = User::updateOrCreate(['first_name'=>$name[0], 'last_name'=>$name[1], 'email'=>@$userSocial->email, 'email_verified_at'=>date('Y-m-d'), 'provider'=>$provider, 'provider_id'=>@$userSocial->id, 'user_type'=>'customer', 'profile_pic'=> 'profile_pics/'.$filename.'.jpg']);  

            //Notify the admin for the registration
            $admin = User::whereUserType('admin')->first();
            $admin->notify(new adminUserRegistration ($user,$admin));
                  
        }
        elseif($user->email_verified_at==null)
        {
            $user->update(['email_verified_at'=>date('Y-m-d')]);
        }
        Auth::login($user);
        return redirect('/');
    }

    public function verify_user($token)
    {
        $verifyUser = User::where('verify_token', $token)->first();
        if($verifyUser){
            $verifyUser->email_verified_at = Date('Y-m-d H:i:s');
            $verifyUser->save();

            Auth::login($verifyUser);
        }
        return redirect('/');
        
    }

    public function sendVerificationMail($email)
    {
        $email = base64_decode($email);

        $user = User::whereEmail($email)->first();
        $user->verify_token = str_random(30);
        $user->save();

        //Notify the user for the registration
        $user->notify(new registration($user));

        return redirect('/login')->with('success', 'Verification email resent. Please check your email.');
    }
}
