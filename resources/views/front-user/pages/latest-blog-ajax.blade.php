<h4>Latest Blog</h4>
@if(count($latestBlogs) > 0)
@foreach($latestBlogs as $latest)
<div class="LatestBox">
    <div class="LatestBoxImg">
      <a href="{{url('blog-detail').'/'.$latest->slug}}">
          <img src="{{url('storage/app').'/'.$latest->image}}" alt="">
      </a>
    </div>
    <div class="LatestBoxContent">
      <h4><a href="{{url('blog-detail').'/'.$latest->slug}}">{{$latest->title}}</a></h4>
      <p>
        <!-- <div class="text-e ellipsis">
          <span class="text-concat"> -->
            {!! $latest->content !!}
          <!-- </span>
        </div> -->
      </p>

      <div class="blogBoxBottom">
        <div class="blogby"><span><i class="far fa-user"></i></span>by {{$latest->author?$latest->author:'Admin'}}</div>
        <div class="blogdate"><span><i class="far fa-calendar"></i></span>{{date('F d, Y',strtotime($latest->created_at))}}</div>
      </div>
    </div>
    <div class="clear"></div>
</div>
@endforeach
@else
No blogs found..
@endif