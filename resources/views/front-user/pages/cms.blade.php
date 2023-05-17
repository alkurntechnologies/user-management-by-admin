@extends('front-user.layouts.master_user')


@section('content')
<section class="blog-individual">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
            <div class="separate-blog">
                @if($page->banner!='')
                <div class="blog-image">
                    <img src="{{url('storage/app').'/'.$page->banner}}" alt="">
                </div>
                @endif
                <div class="blog-text blogBox">
                  <h1>{{$page->title}}</h1>

                  
                  {!! $page->content !!}

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