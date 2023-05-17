@extends('admin.layouts.master_admin')

@section('page_last_name')
{{config('app.name')}} | Edit Rink Operator
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Rink Operator</h1>
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
                            
                <form action="" method="post"
                        id="add_business_term_form" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="exampleInputEmail4">First Name</label>
                            <input type="text" class="form-control" name="first_name"
                                    id="first_name" placeholder="Enter first name"  required=""data-parsley-required-message="Please enter first name." value="{{@$row->first_name}}">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail4">Last Name</label>
                            <input type="text" class="form-control" name="last_name"
                                    id="last_name" placeholder="Enter last name"  required=""data-parsley-required-message="Please enter last name." value="{{@$row->last_name}}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Email</label>
                            <input type="email" class="form-control" name="email"
                                    id="email" placeholder="Enter email" required="" data-parsley-required-message="Please enter email." data-parsley-type-message="Please enter a valid email." value="{{@$row->email}}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                    id="phone" placeholder="Enter phone" required="" data-parsley-required-message="Please enter phone." data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" data-parsley-pattern-message="Please enter a valid phone number." data-parsley-maxlength="15" data-parsley-maxlength-message="Please enter a valid phone number." value="{{@$row->phone}}">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Profile Pic</label>
                            <br />
                            @if(@$row->profile_pic!='')<img src="{{url('storage/app').'/'.@$row->profile_pic}}" height="100" width="100">@endif
                            <input type="hidden" name="oldImageValue" value="{{'storage/app/'.@$row->profile_pic}}">
                            <br />
                            <label for="exampleInputEmail4">Update Profile Pic</label>
                            <input type="file" class="form-control img-upload-tag" name="profile_pic"
                                    id="profile_pic" data-parsley-required-message="Please upload main photo.">
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


@endsection
    
