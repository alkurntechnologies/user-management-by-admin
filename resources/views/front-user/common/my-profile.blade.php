@extends('front-user.layouts.master_user')

@section('content')
@php
$imgNotFound = URL::asset('/')."/assets/front-end/images/i-user.png";
@endphp
<style type="text/css">
  #map{ width:700px; height: 500px; }
</style>
<section class="blogListingSect contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-4 col-sm-12 side-profile">
        @include('front-user.includes.sidebar')
      </div><!-- blogListing -->
      <div class="col-lg-9 col-md-8 col-sm-12">
         <div class="operator-profile customer">
          <form method="post" data-parsley-validate enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="op-img">
                  <img src="{{url('storage/app').'/'.Auth::user()->profile_pic}}" alt="" id="img-preview" onerror="this.onerror=null;this.src='{{$imgNotFound}}'">
                  <input type="hidden" name="oldImageValue" value="{{url('storage/app').'/'.Auth::user()->profile_pic}}">
                  <input type="file" class="form-control inputfile" name="profile_pic" id="profile_pic"  data-parsley-required-message="Please upload profile pic." onchange="readURL(this);">
                  <label for="profile_pic" class="stay-update"><span><strong><i class="fas fa-camera"></i></strong></span></label> 
                 <!--  <img src="{{ asset('/') }}/assets/front-end/images/cust-img.png" alt="">
                  <span><i class="fas fa-camera"></i></span> -->
                </div>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-12">
                
                <div class="row">
                    @csrf
                  <div class="col-sm-6">
                    <label>First Name</label>
                    <input type="text" placeholder="Byron" name="first_name" required="" data-parsley-required-message="Please enter first name." value="{{Auth::user()->first_name}}">
                  </div>
                  <div class="col-sm-6">
                    <label>Last Name</label>
                    <input type="text" placeholder="Jacobs" name="last_name" required="" data-parsley-required-message="Please enter last name." value="{{Auth::user()->last_name}}">
                  </div>
                  <div class="col-sm-6">
                    <label>Email Id</label>
                    <input type="email" placeholder="byron.jacobs@example.com" name="email" readonly="" value="{{Auth::user()->email}}">
                  </div>
                  <div class="col-sm-6">
                    <label>Phone Number</label>
                    <input type="text" placeholder="(003)-923-2320" name="phone" required="" data-parsley-required-message="Please enter phone." data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" data-parsley-pattern-message="Please enter a valid phone number." data-parsley-maxlength="15" data-parsley-maxlength-message="Please enter a valid phone number." value="{{Auth::user()->phone}}">
                  </div>

                  <div class="col-sm-6 up-now">
                    <input type="submit" class="up-btn" value="update">
                  </div>
                
                </div>
                
              </div>

             </form>
            </div>
         </div>

         <!-- <div class="customer-map">
            <img src="{{ asset('/') }}/assets/front-end/images/map-cust.png" alt="">
         </div> -->
          
      </div><!-- blogSidebar -->
    </div>
  </div>
</section>

@endsection

@section('script_links')

@endsection

@section('script_codes')
            

<script>
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('profile_address');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            // place variable will have all the information you are looking for.
            $("#profile_latitude").val(place.geometry['location'].lat());
            $("#profile_longitude").val(place.geometry['location'].lng());
            console.log(place.geometry['location'].lat());
            console.log(place.geometry['location'].lng());

            const geocoder = new google.maps.Geocoder;
        });
    }
</script>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-preview')
                    .attr('src', e.target.result)
                    .width(141)
                    .height(141);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection