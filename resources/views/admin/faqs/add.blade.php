@extends('admin.layouts.master_admin')

{{config('app.name')}} | Add Faq

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Faq</h1>
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
                            <label for="exampleInputEmail4">Topic <span class="text-danger">*</span></label>
                            <select name="topic_id" id="topic_id" class="form-control" required=""data-parsley-required-message="Please select topic.">
                                <option value="">Select</option>
                                @foreach($topics as $topic)
                                <option value="{{$topic->id}}" @if($topic->id==old('topic_id')) selected @endif>{{$topic->topic}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('topic_id'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('topic_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Question <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="question"
                                    id="question" placeholder="Enter question" required=""   data-parsley-required-message="Please enter question." value="{{old('question')}}">
                            @if ($errors->has('question'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('question') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group ns-des show-maze-icons">
                            <label for="exampleInputEmail4">Answer <span class="text-danger">*</span></label> 
                            <textarea name="answer" id="answer" placeholder="Enter answer" class="form-control" required="" data-parsley-required-message="Please enter answer." data-parsley-errors-container="#descriptionError">{{old('answer')}}</textarea>

                            <div id="descriptionError" class=""></div>
                                
                            @if ($errors->has('answer'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('answer') }}</strong>
                                </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail4">Status</label>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#answer').summernote({height: 300});
    });
</script>


@endsection
