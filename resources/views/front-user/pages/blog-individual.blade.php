@extends('front-user.layouts.master_user')


@section('content')
<section class="blog-individual">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
            <div class="separate-blog">
                <div class="blog-image">
                    <img src="{{url('storage/app').'/'.$blog->image}}" alt="">
                </div>
                <div class="blog-text blogBox">
                  <h1>{{$blog->title}}</h1>

                  <div class="blogBoxBottom">
                    <div class="blogby"><span><i class="far fa-user"></i></span>by {{$blog->author?$blog->author:'Admin'}}</div>
                    <div class="blogdate"><span><i class="far fa-calendar"></i></span>{{date('F d, Y',strtotime($blog->created_at))}}</div>
                    
                  </div>
                  {!! $blog->description !!}

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