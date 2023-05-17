@extends('front-user.layouts.master_user')
@section('title')
    {{config('app.name')}} | Notifications
@endsection

@section('content')
<section class="blogListingSect contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-4 col-sm-12 side-profile">
        <ul>
          @include('front-user.includes.sidebar')
        </ul>
      </div><!-- blogListing -->
      <div class="col-lg-8 col-md-8 col-sm-12">
         <div class="operator-profile pass-change notificationPage">
            <div class="row">
              <div class="col-sm-12">
                
                @if(count($notifications) > 0)
                <table class="table" id="example1">
                    <tbody>
                        @foreach($notifications as $i => $notification)
                        <tr>
                            <td class="text-nowrap align-top dateTime">{{Date('M d, Y', strtotime($notification->created_at))}}<br />{{Date('h:i A', strtotime($notification->created_at))}}</td>
                            <td>
                            @if(@$notification->data['url'] == "")
                                <a class="notification">{{$notification->data['message']}}</a>  
                            @else
                                <a class="notification">{{$notification->data['message']}}</a>
                                <a href="{{$notification->data['url']}}" class="float-right"><i class="fas fa-eye    "></i></a>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    
                    </tbody>
                </table>
                @else
                No notifications yet
                @endif
              </div>

             
            </div>
         </div>
          
      </div><!-- blogSidebar -->
    </div>
  </div>
</section>

@endsection

@section('script_links')
<script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>

@endsection

@section('script_codes')
@endsection