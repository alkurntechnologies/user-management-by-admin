@extends('admin.layouts.master_admin')

{{config('app.name')}} | Add Faq Topic

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Faq Topic</h1>
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
                            <label for="exampleInputEmail4">Topic </label>
                            <input type="text" class="form-control" name="topic"
                                    id="topic" placeholder="Enter topic" required="" data-parsley-required-message="Please enter topic." value="{{old('topic')}}">
                            @if ($errors->has('topic'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('topic') }}</strong>
                                </span>
                            @endif
                        </div>


                        <input type="submit" class="btn btn-info" value="Save">

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
