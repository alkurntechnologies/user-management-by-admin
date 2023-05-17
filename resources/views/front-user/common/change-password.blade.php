@extends('front-user.layouts.master_user')

@section('content')
<section class="blogListingSect contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-4 col-sm-12 side-profile">
        <ul>
          @include('front-user.includes.sidebar')
        </ul>
      </div><!-- blogListing -->
      <div class="col-lg-8 col-md-8 col-sm-12">
         <div class="operator-profile pass-change">
            <div class="row">
              <div class="col-sm-12">
                <form method="post" data-parsley-validate>
                  @csrf
                <div class="row">
                  <div class="col-sm-6">
                    <label>Current Password</label>
                    <input type="password" placeholder="Current Password" name="current_password" required="" data-parsley-required-message="Please enter current password">
                  </div>
                  <div class="col-sm-6">
                    <label>New Password</label>
                    <input type="password" placeholder="New Password" name="password" id="password" required="" data-parsley-required-message="Please enter new password">
                  </div>
                  <div class="col-sm-6">
                    <label>Re-Enter New Password</label>
                    <input type="password" placeholder="Re-Enter New Password" name="password_confirmation" required="" data-parsley-required-message="Please enter current password" data-parsley-equalto="#password" data-parsley-equalto-message="New password and confirm password must be equal" >
                  </div>
                  <div class="col-sm-6 up-now">
                    <input type="submit" class="up-btn" value="update">
                  </div>
                </div>
                </form>

              </div>

             
            </div>
         </div>
          
      </div><!-- blogSidebar -->
    </div>
  </div>
</section>

@endsection

@section('script_links')
<script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>

@endsection

@section('script_codes')
@endsection