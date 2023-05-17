     
    </div>
    <footer class="site-footer">
        
        <section class="section-footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <ul class="f-menus">         
                            <li><a href="{{url('/')}}" class="{{ URL::to('/') == url()->current() ? 'active' : ' ' }}">Home</a></li>
                            <li><a href="{{url('login')}}" class="{{ URL::to('login') == url()->current() ? 'active' : ' ' }}">Log In</a></li>
                            <li><a href="{{url('signup')}}" class="{{ URL::to('signup') == url()->current() ? 'active' : ' ' }}">Sign Up</a></li>
                            <li><a href="{{url('contact')}}" class="{{ URL::to('contact') == url()->current() ? 'active' : ' ' }}">Contact</a></li>
                            <li><a href="{{url('faq')}}" class="{{ URL::to('faq') == url()->current() ? 'active' : ' ' }}">FAQs</a></li>
                            <li><a href="{{url('blog')}}" class="{{ URL::to('blog') == url()->current() ? 'active' : ' ' }}">Blog</a></li>
                            @php $pages = App\Models\CmsPage::whereStatus(1)->get(); @endphp
                            @foreach($pages as $page)
                            <li><a href="{{url('/').'/'.$page->slug}}" class="{{ URL::to($page->slug) == url()->current() ? 'active' : ' ' }}">{{$page->title}}</a></li>
                            @endforeach
                        </ul>
                        <p>© <a href="{{url('/')}}">{{env('APP_NAME')}}</a> {{date('Y')}}. Powered by <a href="#">Alkurn Technologies</a></p>
                    </div>
                </div>
            </div>
        </section>

    </footer>
@include("front-user.includes.footer-bottom")