@extends('admin.layouts.master_admin')

{{config('app.name')}} | Add Page

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Add Page</h1>
                </div>

                
            </div>
        </div><!-- /.container-fluid -->
    </section>

 
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post"
                        id="add_business_form" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="exampleInputEmail4">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title"
                                    id="title" placeholder="Enter title" required=""  data-parsley-required-message="Please enter title." >
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group ns-des show-maze-icons">
                            <label for="exampleInputEmail4">Content <span class="text-danger">*</span></label> 
                            <textarea name="content" id="content" placeholder="Enter content" class="form-control" required="" data-parsley-required-message="Please enter content." data-parsley-errors-container="#contentError"></textarea>

                            <div id="contentError" class=""></div>
                                
                            @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('content') }}</strong>
                                </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Banner <span class="text-danger">*</span></label>
                            <input type="file" class="form-control img-upload-tag" name="banner" id="banner" data-parsley-required-message="Please upload banner">
                            @if ($errors->has('banner'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('banner') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- <div class="form-group">
                            <label for="exampleInputEmail4">Position <span class="text-danger">*</span></label>
                            <select multiple="" name="position[]" id="position" class="form-control" required=""  data-parsley-required-message="Please select position."  data-parsley-errors-container="#statusError">
                                <option value="header">Header</option>
                                <option value="footer">Footer</option>
                            </select>

                            @if ($errors->has('position'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('position') }}</strong>
                                </span>
                            @endif
                        </div> -->

                        <div class="form-group">
                            <label for="exampleInputEmail4">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required=""  data-parsley-required-message="Please select status."  data-parsley-errors-container="#statusError">
                                <option value="1">Active</option>
                                <option value="0">De-Active</option>
                            </select>

                            <div id="statusError" class="mt-2"></div>

                            @if ($errors->has('status'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>

                        <input type="submit" class="btn-info btn" value="Save">

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
<script type="text/javascript">
    $(document).ready(function() {
        $('#content').summernote({height: 300});
    });
</script>


@endsection
