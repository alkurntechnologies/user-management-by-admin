@extends('front-user.layouts.master_user')

@section('content')
<section class="blogListingSect">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-7 col-sm-12 blogListing" id="blog-ajax">
        @include('front-user.pages.blog-ajax')
      </div><!-- blogListing -->
      <div class="col-lg-4 col-md-5 col-sm-12 blogSidebar">
        @if(count($latestBlogs) > 0)
        <div class="blogsearch">
          <form>
            <button><i class="fas fa-search"></i></button>
            <input type="text" name="keyword" placeholder="Search Blog" id="keyword">
          </form>
        </div>
        <div class="latestBlog" id="latest-blog-ajax">
          @include('front-user.pages.latest-blog-ajax')
        </div>
        @endif
      </div><!-- blogSidebar -->
    </div>
  </div>
</section>

@endsection

@section('script_links')


@endsection

@section('script_codes')
<script type="text/javascript">
    $(function(){
        $("#keyword").keydown(function(){
            var keyword = $(this).val(); 

            $.ajax({
                url: "{{url('latest-blogs')}}",
                data: { keyword: keyword }
            })
            .done(function(data) {
                //alert("Search Completed!");
                $("#latest-blog-ajax").html(data);
            });
        });
    });
</script>
@endsection