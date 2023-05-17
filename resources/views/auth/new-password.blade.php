@extends('front-user.layouts.master_user')

@section('content')

<div class="bgContainer resetPass">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="lodginLeft">
                                <div class="lgLogo">
                                    <a href="{{url('/')}}">
                                        HOME
                                    </a>
                                </div>
                                <div class="lgTxtBig">
                                Set New Password
                                </div>
                                <div class="lgTxtSmall">
                                
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 p-0">
                            <div class="loginRight">
                                <div class="lgTitle">Set New Password</div>
                                @if(Session::has('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        {{Session::get('success')}}
                                    </div>
                                @endif
                                @if(Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        {{Session::get('error')}}
                                    </div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                    </div>
                                @endif
                                <div class="authForm">
                                    <form method="post" data-parsley-validate style="padding-top: 171px;">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">New Password</label>
                                            <input type="password" class="password form-control" id="password" placeholder="Password" name="password" required data-parsley-required-message="Please enter password.">
                                            <button class="passView toggle-password"><i class="fas fa-eye"></i></button>
                                            <!-- <span class="passChk"><input type="checkbox" id="checkPass"><i class="far fa-eye-slash sd" style="display:none;"></i><i class="far fa-eye sd" ></i></span> -->
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Re Enter New Password</label>
                                            <input type="password" class="password form-control" id="exampleInputPassword1" placeholder="Re-enter password" name="password_confirmation" data-parsley-equalto="#password" data-parsley-equalto-message="Password and confirm password should be same." required data-parsley-required-message="Please re-enter password.">
                                            <button class="passView toggle-password"><i class="fas fa-eye"></i></button>
                                            <!-- <span class="passChk"><input type="checkbox" id="checkPass1"><i class="far fa-eye-slash sd1" style="display:none;"></i><i class="far fa-eye sd1"></i></span> -->
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">Reset</button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script_links')

@endsection

@section('script_codes')

@endsection
