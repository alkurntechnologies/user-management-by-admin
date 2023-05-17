@if(count($blogs) > 0)
@foreach($blogs as $blog)
<div class="blogBox">
  <div class="blogBoxImg">
    <img src="{{url('storage/app').'/'.$blog->image}}" alt="">
  </div>
  <div class="blogBoxContent">
    <div class="blogBoxText">
      <h3><a href="{{url('blog-detail').'/'.$blog->slug}}">{{$blog->title}}</a></h3>
      {!! $blog->content !!}
    </div>
    <div class="blogBoxBottom">
      <div class="blogby"><span><i class="far fa-user"></i></span>by {{$blog->author?$blog->author:'Admin'}}</div>
      <div class="blogdate"><span><i class="far fa-calendar"></i></span>{{date('F d, Y',strtotime($blog->created_at))}}</div>
      <div class="blogview"><a href="{{url('blog-detail').'/'.$blog->slug}}">Read More</a></div>
    </div>
  </div>
</div>
@endforeach
@else
<p class="no-blogs">No blogs found..</p>
@endif

<!-- <div class="custom-pagination">
  <ul class="pagination">
    <li><a href=""><i class="fas fa-chevron-left"></i></a></li>
    <li><a href="">1</a></li>
    <li><a href="">2</a></li>
    <li><a href="">3</a></li>
    <li><a href=""><i class="fas fa-chevron-right"></i></a></li>
  </ul>
</div> -->

@if ($blogs->hasPages())
<div class="custom-pagination">
    <ul class="pagination">
        {{-- First Page Link --}}
        @if($blogs->currentPage() > 1)
            <li class=""><a class="dir-page-link" href="{{ $blogs->url(1) }}">&lt;&lt;</a></li>
        @else
            <li class=" disabled "><a class="dir-page-link">&lt;&lt;</a></li>
        @endif
        {{-- Previous Page Link --}}
        @if ($blogs->onFirstPage())
            <li class=" disabled "><a class="dir-page-link">&lt;</a></li>
        @else
            <li class=""><a class="dir-page-link" href="{{ $blogs->previousPageUrl() }}" rel="prev"><</a></li>
        @endif
        
        @foreach(range(1, $blogs->lastPage()) as $i)
            @if($i >= $blogs->currentPage() - 1 && $i <= $blogs->currentPage() + 1 || (($blogs->onFirstPage() || !$blogs->hasMorePages()) && $i >= $blogs->currentPage() - 2 && $i <= $blogs->currentPage() + 2) )
                @if ($i == $blogs->currentPage())
                    <li class=" active "><a class="dir-page-link">{{ $i }}</a></li>
                @else
                    <li class=""><a class="dir-page-link" href="{{ $blogs->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        
        {{-- Next Page Link --}}
        @if ($blogs->hasMorePages())
            <li class=""><a class="dir-page-link" href="{{ $blogs->nextPageUrl() }}" rel="next">></a></li>
        @else
            <li class=" disabled "><a class="dir-page-link">&gt;</a></li>
        @endif
        {{-- Last Page Link --}}
        @if($blogs->currentPage() < $blogs->lastPage())
            <li class=""><a class="dir-page-link" href="{{ $blogs->url($blogs->lastPage()) }}">&gt;&gt;</a></li>
        @else
            <li class="  disabled "><a class="dir-page-link">&gt;&gt;</a></li>
        @endif
    </ul>
</div>

@endif


<script type="text/javascript">
    $('.dir-page-link').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $('#blog-ajax').html('Loading...'); 
        $("html,body").animate({scrollTop: $("body").offset().top}, "100");
        setTimeout(function(){ 
            $.ajax({
                url: url
            })
            .done(function(data) {
                //alert("Search Completed!");
                $("#blog-ajax").html(data);
            });
        }, 1000);
        
    });
</script>