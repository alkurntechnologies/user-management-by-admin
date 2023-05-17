<a href="#" class="dashMenu">Dashboard Menu</a>
<ul>
	<li><a href="{{url('my-profile')}}" class="{{ Request::is('my-profile') ? 'active' : '' }}">My Profile</a></li>
  <li><a href="{{url('change-password')}}" class="{{ Request::is('change-password') ? 'active' : '' }}">Change Password</a></li>
  <li><a href="{{url('logout')}}">Log Out</a></li>
</ul>

<script>
$(document).ready(function(){
  $(".dashMenu").click(function(){
    $(".side-profile").toggleClass("expand");
  });
});
</script>