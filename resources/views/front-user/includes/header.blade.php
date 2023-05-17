@include("front-user.includes.headerTop")

    <div id="app" >

        <header class="site-header rink-header">
            
            <div class="container">
                
                <div class="row">
                   
                    <div class="col-sm-4">
                        <a href="{{url('/')}}"><img src="{{ asset('/') }}/assets/front-end/images/logo-word.png" alt=""></a>
                    </div>
                    <div class="col-lg-4 col-md-5 stop-mn text-center">
                        <ul class="h-menu">
                            <li>
                                <a href="{{url('/')}}">HOME</a>
                                
                            </li>
                            @if(Auth::check())
                            @php 
                            $notificationCount = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->where('read_at', NULL)->count(); 
                            @endphp
                            <li>
                              <a href="{{url('notifications')}}" class="icon"><i class="far fa-bell"></i>
                                <span class="count">{{$notificationCount}}</span>
                              </a>
                            </li>
                            <li class="drop-state">
                                <!-- <a href="{{url('/')}}">HOME</a> -->
                                <div class="dropdown">
                                    <button type="button" class="user-btn dropdown-toggle" data-toggle="dropdown">
                                        @php 
                                        if(Auth::user()->profile_pic == '' || Auth::user()->profile_pic == null)
                                        $src = URL::asset('/')."/images/default-profile-pic.png";
                                        else
                                        $src = url('storage/app').'/'.Auth::user()->profile_pic;
                                        @endphp
                                      <div class="img-usr">
                                         <img src="{{$src}}" alt=""> 
                                      </div>
                                       {{Auth::user()->first_name}}
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="{{url('my-profile')}}">My Profile</a>
                                      <a class="dropdown-item" href="{{url('meetings')}}">Meetings</a>

                                      @if(Auth::user()->user_type=='customer')
                                      <a class="dropdown-item" href="{{url('my-booking-requests')}}">Booking Requests</a>
                                      @else
                                      <a class="dropdown-item" href="{{url('payment-setup')}}">Payment set up</a>
                                      <a class="dropdown-item" href="{{url('my-rinks')}}">My rinks</a>
                                      <a class="dropdown-item" href="{{url('booking-requests')}}">Booking requests</a>
                                      <a class="dropdown-item" href="{{url('my-rink-bookings')}}">My bookings</a>
                                      @endif
                                      <a class="dropdown-item" href="{{url('followed-rinks')}}">Followed Rinks</a>
                                      @if(Auth::user()->password!='')
                                      <a class="dropdown-item" href="{{url('change-password')}}" class="{{ Request::is('change-password') ? 'active' : '' }}">Change Password</a>
                                      @endif
                                      <a class="dropdown-item" href="{{url('logout')}}">Log Out</a>

                                    </div>
                                  </div>
                            </li>
                            @else
                            <li><a href="{{url('login')}}">LOG IN</a></li>
                            <li><a href="{{url('signup')}}">SIGN UP</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-sm-8 text-right stare-mn">
                        <div class="sidemenu-btn">
                             @if(Auth::check())
                             <ul class="h-menu">
                                <li class="logedin-icon"><a href="" class="icon"><i class="far fa-bell"></i></a></li>
                                <li class="logedin-icon"><a href="" class="icon"><i class="far fa-envelope"></i></a></li>
                             </ul>
                             @endif
                            <button class="openbtn" onclick="openNav()">☰</button>  
                            <div class="external-menuz">
                                <div id="mySidebar" class="sidebar">
                                     <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                                     <ul>
                                        <li><a href="{{url('/')}}">HOME</a></li>
                                        @if(Auth::check())
                                        <li class="drop-state">
                                            <!-- <a href="{{url('/')}}">HOME</a> -->
                                            <div class="dropdown">
                                                <button type="button" class="user-btn dropdown-toggle" data-toggle="dropdown">
                                                    @php 
                                                    if(Auth::user()->profile_pic == '' || Auth::user()->profile_pic == null)
                                                    $src = URL::asset('/')."/images/default-profile-pic.png";
                                                    else
                                                    $src = url('storage/app').'/'.Auth::user()->profile_pic;
                                                    @endphp
                                                  <div class="img-usr">
                                                     <img src="{{$src}}" alt=""> 
                                                  </div>
                                                   {{Auth::user()->first_name}}
                                                </button>
                                                <div class="dropdown-menu">
                                                  <a class="dropdown-item" href="{{url('my-profile')}}">My Profile</a>
                                                  @if(Auth::user()->user_type=='customer')
                                                  <a class="dropdown-item" href="{{url('my-bookings')}}">Bookings</a>
                                                  @else
                                                  <a class="dropdown-item" href="#">Payment set up</a>
                                                  <a class="dropdown-item" href="{{url('booking-agreement')}}">booking agreement</a>
                                                  <a class="dropdown-item" href="{{url('my-rinks')}}">My rinks</a>
                                                  <a class="dropdown-item" href="{{url('booking-requests')}}">Booking request</a>
                                                  <a class="dropdown-item" href="{{url('my-rink-bookings')}}">My bookings</a>
                                                  @endif
                                                  <a class="dropdown-item" href="{{url('followed-rinks')}}">Followed Rinks</a>
                                                  <a class="dropdown-item" href="{{url('change-password')}}" class="{{ Request::is('change-password') ? 'active' : '' }}">Change Password</a>

                                                  <a class="dropdown-item" href="{{url('logout')}}">Log Out</a>
                                                </div>
                                              </div>
                                        </li>
                                        <div class="clear"></div>
                                        <li class="logedin-add-rink"><a href="#" class="add-rink" data-toggle="modal" data-target="#add-rink">Add rink request</a></li>
                                        @else
                                        <li><a href="{{url('login')}}">LOG IN</a></li>
                                        <li><a href="{{url('signup')}}">SIGN UP</a></li>
                                        <li><a href="#" class="add-rink" data-toggle="modal" data-target="#add-rink">Add rink request</a></li>
                                        @endif
                                    </ul>
                                    <!-- <ul>
                                        <li><a href="{{url('/')}}">HOME</a></li>
                                        <li><a href="{{url('login')}}">LOG IN</a></li>
                                        <li><a href="{{url('signup')}}">SIGN UP</a></li>
                                        <li><a href="#" class="add-rink" data-toggle="modal" data-target="#add-rink">Add rink request</a></li>
                                    </ul> -->
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                

                
            </div>

            <!--modal-->

            <!--end-->

        </header>




        <script type="text/javascript">
            function openNav() {
              document.getElementById("mySidebar").style.width = "250px";
              document.getElementById("main").style.marginLeft = "250px";
            }

            function closeNav() {
              document.getElementById("mySidebar").style.width = "0";
              document.getElementById("main").style.marginLeft= "0";
            }

        </script>

    <script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>


    <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2oRAljHGZArBeQc5OXY0MI5BBoQproWY&amp;libraries=places"></script>


    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                // place variable will have all the information you are looking for.
                $("#latitude").val(place.geometry['location'].lat());
                $("#longitude").val(place.geometry['location'].lng());
                console.log(place.geometry['location'].lat());
                console.log(place.geometry['location'].lng());

                const geocoder = new google.maps.Geocoder;

            });
        }
    </script>

    <style type="text/css">
      .pac-container {
          z-index: 10000 !important;
      }
    </style>


    <div class="content-area">
