@extends('front-user.layouts.master_user')

@section('content')
<section class="blogListingSect contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-7 col-sm-12 blogListing">
          <div class="contact-div">

            <h2>Contact us</h2>
            

            <form class="form-contact" method="post" data-parsley-validate>
              @csrf
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" placeholder="Name" class="form-control" name="name" required="" data-parsley-required-message="Please enter your name.">
              </div>
              <div class="form-group">
                <label for="name">Email id</label>
                <input type="email" placeholder="Email Id" class="form-control" name="email" required="" data-parsley-required-message="Please enter your email." data-parsley-type-message="Please enter a valid email.">
              </div>
              <div class="form-group">
                <label for="name">Subject</label>
                <input type="text" placeholder="Subject" class="form-control" name="subject" required="" data-parsley-required-message="Please enter subject.">
              </div>
              <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" placeholder="Message" class="form-control" required="" data-parsley-required-message="Please enter message."></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="Send" class="submit-contact form-control" name="">
              </div>

            </form>

          </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>

@endsection

@section('script_links')


@endsection

@section('script_codes')
@endsection