@extends('front-user.layouts.master_user')

@section('content')
<section class="loginSection">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 logImg">
                <div class="logImgDiv">
                    <h3>Register</h3>
                    <div class="logImgBox">
                        <img src="{{ asset('/') }}/assets/front-end/images/log-lady.png" alt="">
                    </div>
                    <div class="lbBtmTxt">Already have an account with us, <a href="{{url('login')}}">Login</a></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 logForm">
                <div class="loginBox">
                <a href="{{url('/')}}" class="wow fadeInRight login-logo"><img src="{{ asset('/') }}/assets/front-end/images/blue-logo.png" alt=""></a>
                <div class="loginRight">
                    
                    <div class="authForm">
                        <form method="post" data-parsley-validate>
                            @csrf
                            <input type="hidden" name="user_type" value="trucker">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="firstName">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstName" aria-describedby="emailHelp" placeholder="Enter first name" name="first_name" required="" data-parsley-required-message="Please enter first name." value="{{old('first_name')}}">
                                        <strong>First Name</strong>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="lastName">&nbsp;</label>
                                        <input type="text" class="form-control" id="lastName" aria-describedby="emailHelp" placeholder="Enter last name" name="last_name" required="" data-parsley-required-message="Please enter last name." value="{{old('last_name')}}">
                                        <strong>Last Name</strong>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="enail">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" required=""  data-parsley-required-message="Please enter email."data-parsley-type-message="Please enter a valid email." value="@if (!$errors->has('email')){{old('email')}}@endif" >
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="phoneNumber">Phone Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="phoneNumber" aria-describedby="emailHelp" placeholder="Enter phone number" name="phone" required="" data-parsley-required-message="Please enter phone number" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" data-parsley-pattern-message="Please enter a valid phone number." data-parsley-maxlength="15" data-parsley-maxlength-message="Please enter a valid phone number." value="{{old('phone')}}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="drivinglicense">Driving License </label>
                                        <input type="tel" class="form-control" id="drivinglicense" aria-describedby="emailHelp" placeholder="Enter driving license" name="driving_license" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$"  data-parsley-maxlength="16" data-parsley-required-message="Please enter driving license" data-parsley-maxlength-message="Please enter a valid driving license.">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="enail">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="dob" aria-describedby="emailHelp" placeholder="Select date of birth" name="dob" required=""  data-parsley-required-message="Please enter date of birth."data-parsley-type-message="Please enter date of birth." value="{{old('dob')!=''?date('d-m-Y',strtotime(old('dob'))):''}}" >
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="zipcode">Zip Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="zipcode" aria-describedby="emailHelp" placeholder="Enter zip code" required="" name="zipcode"  data-parsley-required-message="Please enter zip code" data-parsley-type-message="Please enter a valid postcode" data-parsley-length="[5,8]" data-parsley-length-message="Please enter a valid postcode">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="password form-control" id="password" placeholder="Password" name="password" required data-parsley-required-message="Please enter password." value="@if (!$errors->has('password')){{old('password')}}@endif">
                                        <button class="passView toggle-password"><i class="fas fa-eye"></i></button>
                                        <strong>Password</strong>
                                        <!-- <span class="passChk"><input type="checkbox" id="checkPass"><label for="checkPass"></label></span> -->
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="reEnterPassword">&nbsp;</label>
                                        <input type="password" class="password form-control" id="reEnterPassword" name="password_confirmation" data-parsley-equalto="#password" data-parsley-equalto-message="Password and confirm password should be same." required data-parsley-required-message="Please re-enter password." placeholder="Re-enter password" value="@if (!$errors->has('password_confirmation')){{old('password_confirmation')}}@endif">
                                        <button class="passView toggle-password"><i class="fas fa-eye"></i></button>
                                        <strong>Confirm Password</strong>
                                        <!-- <span class="passChk"><input type="checkbox" id="checkPass1"><label for="checkPass1"></label></span> -->
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="{{config('settings.env.NOCAPTCHA_SITEKEY')}}" data-callback="checkCaptcha"></div>

                                        <input type="text" id="captch_name" data-parsley-required data-parsley-required-message="Please confirm you are human..!!" value="" style="display:none">
                                        @if ($errors->has('g-recaptcha-response'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group form-check custom-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1"required="" data-parsley-required-message="Please accept all terms and policy." checked="checked">
                                        <label class="form-check-label" for="exampleCheck1">Accept all <a href="terms-and-conditions/" target="_blank">terms & conditions</a> and <a href="privacy-policy/" target="_blank">privacy policy</a>.</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="blueBtn smallBtn">Register</button>
                                    </div>
                                </div>
                            </div>
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
<script src="https://www.google.com/recaptcha/api.js"></script>

@endsection

@section('script_codes')

<script>
    function checkCaptcha()
    {
         $("#captch_name").val("test");
    }
</script>

@endsection