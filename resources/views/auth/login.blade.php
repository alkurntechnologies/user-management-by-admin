@extends('front-user.layouts.master_user')

@section('content')

<section class="loginSection">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 logImg">
                <div class="logImgDiv">
                    <h3>Login</h3>
                    <div class="logImgBox">
                        <img src="{{ asset('/') }}/assets/front-end/images/log-lady.png" alt="">
                    </div>
                    <div class="lbBtmTxt">Don't have an account with us, <a href="{{url('signup')}}">Create one</a></div>
                </div>
            </div> 
            <div class="col-lg-6 col-md-6 col-sm-12 logForm">
                <div class="loginBox">
                    <a href="{{url('/')}}" class="wow fadeInRight login-logo"><img src="{{ asset('/') }}/assets/front-end/images/blue-logo.png" alt=""></a>
                    <div class="loginRight">
                        
                        <div class="authForm">
                            <form method="post" data-parsley-validate>
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email address" name="email" required="" data-parsley-required-message="Please enter email." data-parsley-type-message="Please enter a valid email.">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="password form-control" id="exampleInputPassword1" placeholder="Enter password" name="password" required="" data-parsley-required-message="Please enter password.">
                                    <button class="passView toggle-password"><i class="fas fa-eye"></i></button>
                                    <!-- <span class="passChk">
                                        <input type="checkbox" id="checkPass"><label for="checkPass"></label>
                                    </span> -->
                                </div>
                                <div class="form-group form-check custom-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember_me" checked="checked">
                                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                    <div class="forGotLink">
                                        <a href="{{url('forgot-password')}}">Forgot Password?</a>
                                    </div>
                                </div>
                                <button type="submit" class="blueBtn smallBtn">Login</button>
                            </form>
                        </div>
                        <p>OR</p>
                        <a href="{{url('login/youtube')}}">Connect with Youtube</a><br/>
                        <a href="{{url('login/facebook')}}">Connect with Facebook</a><br/>
                        <a href="{{url('login/twitter')}}">Connect with Twitter</a><br/>
                        <a href="{{url('login/instagram')}}">Connect with Instagram</a><br/>
                        <a href="{{url('login/twitchtv')}}">Connect with TwitchTV</a><br/>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- loginSection -->



@php 
if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],'password/reset')===false)
    Session::put('redirectURL',$_SERVER['HTTP_REFERER']);
@endphp

@endsection

@section('script_links')

@endsection

@section('script_codes')


@endsection