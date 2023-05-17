
<div  class="top-secret">
    <aside id="main-sidebar" class="main-sidebar sidebar-dark-primary elevation-4 sidebarSmal">
        <!-- Brand Logo -->
        <a href="{{url('/')}}" class="brand-link">
            <img src="{{asset('/assets/admin/img/AdminLTELogo.png')}}" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">{{config('app.name')}} | Admin</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">

                    <?php
                    if(Auth::check() && Auth::guard('admin')->check() && (Auth::User()->profile_pic == '' || Auth::User()->profile_pic == null))
                        $src = URL::asset('/')."/assets/admin/img/default-profile-pic.png";
                    else
                        $src = URL::to('storage/app')."/".Auth::User()->profile_pic;
                    ?>

                    <img src="<?php echo ($src); ?>" class="img-circle elevation-2" id="adminProfileImgSidebar">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ ucfirst(Auth::User()->first_name)}} {{ucfirst(Auth::User()->last_name)}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->

                    <li class="nav-item has-treeview">
                        <a href="{{URL::to('admin')}}" class="nav-link {{ (Request::segment(1) === 'admin' && Request::segment(2) === '' ) ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>

                            <p>
                                Manage Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-customers')}}" class="nav-link {{ URL::to('admin/manage-customers') == url()->current() || URL::to('admin/add-customer') == url()->current() || URL::to('admin/edit-customer').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}">
                                <i class="fas fa-user-alt"></i>

                                    <p>Manage Customers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-rink-operators')}}" class="nav-link {{ URL::to('admin/manage-rink-operators') == url()->current() || URL::to('admin/add-rink-operator') == url()->current() || URL::to('admin/edit-rink-operator').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}">
                                <i class="fas fa-user-tie"></i>

                                    <p>Manage Rink Operators</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>

                            <p>
                                Manage CMS
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            
                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-blogs')}}" class="nav-link {{ URL::to('admin/manage-blogs') == url()->current() || URL::to('admin/add-blog') == url()->current() || URL::to('admin/edit-blog').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}">
                                    <i class="fas fa-tasks"></i>

                                    <p>Manage Blogs</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-faq-topics')}}" class="nav-link {{ URL::to('admin/manage-faq-topics') == url()->current() || URL::to('admin/add-faq-topic') == url()->current() || URL::to('admin/edit-faq-topic').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}">
                                    <i class="fas fa-tasks"></i>

                                    <p>Manage FAQ Topics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-faqs')}}" class="nav-link {{ URL::to('admin/manage-faqs') == url()->current() || URL::to('admin/add-faq') == url()->current() || URL::to('admin/edit-faq').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}">
                                    <i class="fas fa-tasks"></i>

                                    <p>Manage FAQs</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-pages')}}" class="nav-link {{ URL::to('admin/manage-pages') == url()->current() || URL::to('admin/add-page') == url()->current() || URL::to('admin/edit-page').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}">
                                    <i class="fas fa-tasks"></i>

                                    <p>Manage Other Pages</p>
                                </a>
                            </li>
                            
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</div>


<script>
$(document).ready(function(){
    if ($('.nav-treeview li a.nav-link').hasClass('active')) {
        $('.nav-treeview li a.nav-link.active').parent().parent().parent().addClass('menu-open');
    }
});


</script>