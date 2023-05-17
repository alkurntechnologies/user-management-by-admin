<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\newContactEnquiry;
use App\Models\User;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\CmsPage;
use App\Models\Attendee;
use App\Models\ShortCourse;
use DB;
use Auth;
use App;
use PDF;


class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('front-user.pages.home');
    }

    public function contact(Request $request)
    {
        $admin = User::whereUserType('admin')->first();

        $details = request()->except(['_token']);

        $admin->notify(new newContactEnquiry($admin, $details));

        return redirect()->back()->with('success', 'Your enquiry is submitted successfully. Admin will get back to you soon.');
    }

    public function blog(Request $request)
    {
        $blogs = Blog::whereStatus(1)->orderBy('created_at','desc')->paginate(2);

        foreach ($blogs as $blog) {
            $blog->content = $this->html_cut($blog->description,300);
        }

        if ($request->ajax()) {
            return \Response::json(\View::make('front-user.pages.blog-ajax', compact('blogs'))->render());
        }

        $latestBlogs = $this->getLatestBlogs($request);

        return view('front-user.pages.blog',compact('blogs','latestBlogs'));
    }

    function html_cut($text, $max_length)
    {
        $tags   = array();
        $result = "";

        $is_open   = false;
        $grab_open = false;
        $is_close  = false;
        $in_double_quotes = false;
        $in_single_quotes = false;
        $tag = "";

        $i = 0;
        $stripped = 0;

        $stripped_text = strip_tags($text);

        while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
        {
            $symbol  = $text[$i];
            $result .= $symbol;

            switch ($symbol)
            {
               case '<':
                    $is_open   = true;
                    $grab_open = true;
                    break;

               case '"':
                   if ($in_double_quotes)
                       $in_double_quotes = false;
                   else
                       $in_double_quotes = true;

                break;

                case "'":
                  if ($in_single_quotes)
                      $in_single_quotes = false;
                  else
                      $in_single_quotes = true;

                break;

                case '/':
                    if ($is_open && !$in_double_quotes && !$in_single_quotes)
                    {
                        $is_close  = true;
                        $is_open   = false;
                        $grab_open = false;
                    }

                    break;

                case ' ':
                    if ($is_open)
                        $grab_open = false;
                    else
                        $stripped++;

                    break;

                case '>':
                    if ($is_open)
                    {
                        $is_open   = false;
                        $grab_open = false;
                        array_push($tags, $tag);
                        $tag = "";
                    }
                    else if ($is_close)
                    {
                        $is_close = false;
                        array_pop($tags);
                        $tag = "";
                    }

                    break;

                default:
                    if ($grab_open || $is_close)
                        $tag .= $symbol;

                    if (!$is_open && !$is_close)
                        $stripped++;
            }

            $i++;
        }
        $result .= '...';
        
        while ($tags)
            $result .= "</".array_pop($tags).">";

        return $result;
    }

    public function getLatestBlogs(Request $request)
    {
        $condition = " 1 = 1 ";
        if(isset($request->keyword) && $request->keyword != '')
            $condition .= " and (title like '%".$request->keyword."%' or description like '%".$request->keyword."%')";

        $latestBlogs = Blog::whereRaw($condition)->whereStatus(1)->orderBy('created_at','desc')->take(5)->get();

        foreach ($latestBlogs as $blog) {
            $blog->content = $this->html_cut($blog->description,100);
        }

        if ($request->ajax()) {
            return \Response::json(\View::make('front-user.pages.latest-blog-ajax', compact('latestBlogs'))->render());
        }

        return $latestBlogs;

    }

    public function blogDetail($slug='')
    {
        $blog = Blog::whereSlug($slug)->first();

        if(!$blog)
            App::abort('404');

        else
            return view('front-user.pages.blog-individual',compact('blog'));
    }

    public function faqs(Request $request)
    {
        $condition = " 1 = 1 ";
        if ($request->faqKeyword != '')
            $condition .= " and (topic like '%" . $request->faqKeyword . "%' || question like '%" . $request->faqKeyword . "%' || answer like '%" . $request->faqKeyword . "%') ";

        $faqs = Faq::with('topic')->whereStatus(1)->whereRaw($condition)->get();
        $faq_arr = [];
        foreach ($faqs as $faq) {
            $faq_arr[$faq->topic->topic][] = $faq;
        }
        if ($request->ajax()) {
            return \Response::json(\View::make('content-pages.faq-ajax', compact('faq_arr'))->render());
        }
        return view('front-user.pages.faq', compact('faq_arr'));
    }

    public function cms($slug)
    {
        
        $page = CmsPage::whereSlug($slug)->first();

        if(!$page)
            App::abort('404');

        else
            return view('front-user.pages.cms',compact('page'));
    
    }

    public function certificate()
    {
        $attendee = Attendee::wherePaymentStatus('Completed')
                        ->whereHas('course', function($q) {
                            $q->whereRaw("SUBSTRING_INDEX(due_date,',',-1) <= '".date('Y-m-d', strtotime(' -1 day'))."'");
                        })
                        ->where('attended',1)
                        ->first();

        $data['attendee'] = $attendee;
        $certificateTime = time();

        $path = public_path('storage/app/certificates');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $pdfName = 'certificate'.$certificateTime.'.pdf'; 
        $pdf = PDF::loadView('front-user.common.class-certificate', $data)->setPaper('a4', 'landscape');    
        $pdf->save(public_path('storage/app/certificates/'.$pdfName));

        $file_url = public_path('storage/app/certificates/'.$pdfName);
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
        readfile($file_url); 

        return view('front-user.pages.home');
    }

}
