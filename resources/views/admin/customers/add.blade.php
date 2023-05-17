@extends('admin.layouts.master_admin')

@section('page_last_name')
{{config('app.name')}} | Add Customer
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Customer</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    
    <!--Begin Content-->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button> -->
                </div>
            </div>
            <div class="card-body">
            
                <form action="" method="post" id="add_business_term_form" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="exampleInputEmail4">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name"
                                    id="first_name" placeholder="Enter first name" required=""  data-parsley-required-message="Please enter first name." value="{{old('first_name')}}">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail4">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name"
                                    id="last_name" placeholder="Enter last name"  required="" data-parsley-required-message="Please enter last name." value="{{old('last_name')}}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email"
                                    id="email" placeholder="Enter email" required=""  data-parsley-required-message="Please enter email."data-parsley-type-message="Please enter a valid email." value="{{old('email')}}"> 
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone"
                                    id="phone" placeholder="Enter phone" required="" data-parsley-required-message="Please enter phone." data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" data-parsley-pattern-message="Please enter a valid phone number." data-parsley-maxlength="15" data-parsley-maxlength-message="Please enter a valid phone number." value="{{old('phone')}}">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address"
                                    id="address" placeholder="Enter address"  required="" data-parsley-required-message="Please enter address." value="{{old('address')}}">
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Profile Pic</label>
                            <input type="file" class="form-control img-upload-tag" name="profile_pic"
                                    id="profile_pic"  data-parsley-required-message="Please upload profile pic.">
                            @if ($errors->has('profile_pic'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('profile_pic') }}</strong>
                                </span>
                            @endif
                        </div>

                        <input type="submit" class="btn btn-danger" value="Save">

                    </fieldset>
                </form>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{--Footer--}}
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
@section('admin_script_codes')

<script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2oRAljHGZArBeQc5OXY0MI5BBoQproWY&amp;libraries=places"></script>


<script>
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            // place variable will have all the information you are looking for.
            $("#latitude").val(place.geometry['location'].lat());
            $("#longitude").val(place.geometry['location'].lng());
            console.log(place.geometry['location'].lat());
            console.log(place.geometry['location'].lng());

            const geocoder = new google.maps.Geocoder;

            // geocoder.geocode({'placeId': place.place_id}, function (results, status) {
            //     if (status === google.maps.GeocoderStatus.OK) {
            //       console.log(results[0])
            //         const lat = results[0].geometry.location.lat();
            //         const lng = results[0].geometry.location.lng();

            //         var zipcode = results[0].address_components[results[0].address_components.length - 1].long_name;
            //         var country = results[0].address_components[results[0].address_components.length - 2].long_name;
            //         var state = results[0].address_components[results[0].address_components.length - 3].long_name;
            //         var city = results[0].address_components[results[0].address_components.length - 4].long_name;
            //         $('#country').val(country);
            //         $('#state').val(state);
            //         $('#city').val(city);
            //         $('#zipcode').val(zipcode);
            //     }
            // });
        });
    }
</script>
@endsection
    
