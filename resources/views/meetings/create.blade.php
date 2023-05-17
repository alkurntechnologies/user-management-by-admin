@extends('front-user.layouts.master_user')


@section('content')
<section class="blog-individual">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
            <div class="separate-blog">
               
                <div class="blog-text blogBox">
                <form method="post" action="{{url('store-meeting')}}" data-parsley-validate>
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputtopic1">Topic <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="exampleInputtopic1" aria-describedby="emailHelp" placeholder="Enter topic" name="topic" required="" data-parsley-required-message="Please enter topic." data-parsley-type-message="Please enter a valid topic.">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Start time <span class="text-danger">*</span></label>
                                    <input type="time" class="password form-control" id="exampleInputPassword1" placeholder="Enter start_time" name="start_time" required="" data-parsley-required-message="Please enter start_time.">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Duration <span class="text-danger">*</span></label>
                                    <input type="text" class="password form-control" id="exampleInputPassword1" placeholder="Enter duration" name="duration" required="" data-parsley-required-message="Please enter duration.">
                                </div>
  
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Agenda <span class="text-danger">*</span></label>
                                    <input type="text" class="password form-control" id="exampleInputPassword1" placeholder="Enter agenda" name="agenda" required="" data-parsley-required-message="Please enter agenda.">
                                </div>

                                <div class="form-group form-check custom-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck" name="host_video" >

                                    <label for="exampleCheck">Host Video </label>
                                </div>

                                <div class="form-group form-check custom-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck2" name="participant_video" >

                                    <label for="exampleCheck2">Participant Video </label>
                                </div>
  
                                <button type="submit" class="blueBtn smallBtn">Save</button>
                            </form>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

@endsection

@section('script_links')


@endsection

@section('script_codes')
@endsection