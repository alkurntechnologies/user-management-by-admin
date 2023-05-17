@extends('front-user.layouts.master_user')

@section('content')

<section class="loginSection">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 logImg">
                <div class="logImgDiv">
                    <h3>Forgot Password</h3>
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
                        <span class="hedSmlTxt">Please enter registered email address to send reset password link.</span>
                        <br>
                        <div class="authForm">
                            <form method="post" data-parsley-validate>
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email address" name="email" required="" data-parsley-required-message="Please enter email." data-parsley-type-message="Please enter a valid email.">
                                </div>
                                <button type="submit" class="blueBtn smallBtn">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- loginSection -->


@endsection

@section('script_links')

@endsection

@section('script_codes')



@endsection
