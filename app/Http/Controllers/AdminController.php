<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\FaqTopic;
use App\Models\Faq;
use App\Models\CmsPage;
use Auth;
use DB;
use Hash;
use File;
use Mail;
use App\Notifications\addNewCustomer;
use App\Notifications\addNewRinkOperator;
use Str;
use App;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = new \stdClass();
        $count->customers = User::whereUserType('customer')->count(); 
        $count->rinkOperators = User::whereUserType('rink-operator')->count();
        return view('admin.dashboard',compact('count'));
    }

    public function profile(){
         return view('admin.settings.profile');
    }

    public function updateAdminProfile(Request $request){

        $formData = request()->except(['_token']);

        if ($request->hasFile('profile_pic')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('profile_pic');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['profile_pic'] = $file->store('profile_pics');
            }
        }
        
        $user = User::find(['id' => Auth::id()])->first();

        if ($user->update($formData)) {
            return back()->with('success','You have successfully updated the profile.!');

        } else {
            return back()->with('error','Sorry there is an error while updating your profile.!');

        }

    }

    public function changePassword(){
        return view('admin.settings.change-password');
    }

    public function  updateAdminPassword(Request $request)
    {
        $user = DB::table('users')
            ->select('*')
            ->where('id', Auth::guard('admin')->id())
            ->first();

        if (!Hash::check($request->oldpassword, $user->password)) {
            return back()->with('error', 'Sorry your current password does not match.!');
        }

        $this->validate($request, ['password' => 'required|confirmed|min:8']);

        if ($request->password == $request->password_confirmation) {
            if ($user) {
                $password_updated = DB::table('users')
                    ->where('id',  Auth::guard('admin')->id())
                    ->update(['password' => Hash::make($request->password)]);

                if ($password_updated) {
                    return back()->with(['success' => 'Password is changed successfully.!']);
                } else {
                    return back()->with(['error' => 'There is an error while changing the password please try again later.!']);
                }
            }
        } else {
            return back()->with('error', 'New password do not matched with confirm password.!');
        }
    }

    public function manageCustomers()
    {
        $result = User::whereUserType('customer')->get();
        return view('admin.customers.manage', compact('result'));
    }

    public function addCustomer()
    {
        return view('admin.customers.add');
    }

    public function saveCustomer(Request $request)
    {
        $formData = request()->except(['_token']);

        $password = str_random(10);

        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string'],

        ], [
            "first_name.required" => "Please enter :attribute",
            "last_name.required" => "Please enter :attribute",
            "email.required" => "Please enter :attribute",
            "address.required" => "Please enter :attribute",
        ]);

        $formData['password'] = Hash::make($password);
        $formData['user_type'] = 'customer';
        $formData['email_verified_at'] = date("Y-m-d");

        if ($request->hasFile('profile_pic')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('profile_pic');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['profile_pic'] = $file->store('profile_pics');
            }
        }

        $customer = User::create($formData);

        //Notify the customer for the registration
        $customer->notify(new addNewCustomer($customer, $password));

        if ($customer->save()) {
            return redirect('/admin/manage-customers')->with('success', 'Customer added successfully.');
        } else {
            return redirect('/admin/manage-customers')->with('error', 'Sorry there is an error while adding customer. please try again.');
        }
    }

    public function editCustomer($id)
    {
        $row = User::find($id);
        return view('admin.customers.edit', compact('row'));
    }

    public function updateCustomer($id, Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address' => ['required', 'string'],

        ], [
            "first_name.required" => "Please enter :attribute",
            "last_name.required" => "Please enter :attribute",
            "email.required" => "Please enter :attribute",
            "address.required" => "Please enter :attribute",
        ]);

        // save the row to the database
        $duplicateEntry = User::whereEmail($formData['email'])->first();

        if ($duplicateEntry == '' || ($duplicateEntry != '' && $duplicateEntry->id == $id)) {
            if ($request->hasFile('profile_pic')) {
                $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
                $file = $request->file('profile_pic');
                File::delete($formData['oldImageValue']);

                $extension = $file->getClientOriginalExtension();

                if (in_array($extension, $allowedfileExtension)) {

                    $formData['profile_pic'] = $file->store('profile_pics');
                }
            } else {
                $formData['profile_pic'] = $formData['oldImageValue'];
            }
            User::find($id)->update($formData);
        } else
            return redirect()->back()->with('error', 'Email already taken.');

        return redirect('/admin/manage-customers')->with('success', 'Customer updated successfully.');
    }

    public function deleteCustomer(Request $request)
    {
        $id = $request->input('id');

        if (User::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted customer']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting customer. Please try again later!']);
        }
    }

    public function manageRinkOperators()
    {
        $result = User::whereUserType('rink-operator')->get();
        return view('admin.rink-operators.manage', compact('result'));
    }

    public function addRinkOperator()
    {
        return view('admin.rink-operators.add');
    }

    public function saveRinkOperator(Request $request)
    {
        $formData = request()->except(['_token']);

        $password = str_random(10);

        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

        ], [
            "first_name.required" => "Please enter :attribute",
            "last_name.required" => "Please enter :attribute",
            "email.required" => "Please enter :attribute",
        ]);

        if ($request->hasFile('profile_pic')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('profile_pic');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['profile_pic'] = $file->store('profile_pics');
            }
        }

        $formData['password'] = Hash::make($password);
        $formData['user_type'] = 'rink-operator';
        $formData['email_verified_at'] = date("Y-m-d");

        $rinkOperator = User::create($formData);

        //Notify the rink-operator for the registration
        $rinkOperator->notify(new addNewRinkOperator($rinkOperator, $password));

        if ($rinkOperator->save()) {
            return redirect('/admin/manage-rink-operators')->with('success', 'Rink Operator added successfully.');
        } else {
            return redirect('/admin/manage-rink-operators')->with('error', 'Sorry there is an error while adding rink operator. please try again.');
        }
    }

    public function editRinkOperator($id)
    {
        $row = User::find($id);
        return view('admin.rink-operators.edit', compact('row'));
    }

    public function updateRinkOperator($id, Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],

        ], [
            "first_name.required" => "Please enter :attribute",
            "last_name.required" => "Please enter :attribute",
            "email.required" => "Please enter :attribute",
        ]);

        // save the row to the database
        $duplicateEntry = User::whereEmail($formData['email'])->first();

        if ($duplicateEntry == '' || ($duplicateEntry != '' && $duplicateEntry->id == $id)) {
            if ($request->hasFile('profile_pic')) {
                $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
                $file = $request->file('profile_pic');
                File::delete($formData['oldImageValue']);

                $extension = $file->getClientOriginalExtension();

                if (in_array($extension, $allowedfileExtension)) {

                    $formData['profile_pic'] = $file->store('profile_pics');
                }
            } else {
                $formData['profile_pic'] = $formData['oldImageValue'];
            }
            User::find($id)->update($formData);
        } else
            return redirect()->back()->with('error', 'Email already taken.');

        return redirect('/admin/manage-rink-operators')->with('success', 'Rink Operator updated successfully.');
    }

    public function deleteRinkOperator(Request $request)
    {
        $id = $request->input('id');

        if (User::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted rink operator']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting rink operator. Please try again later!']);
        }
    }

    public function manageBlogs()
    {
        $result = Blog::all();
        return view('admin.blogs.manage', compact('result'));
    }

    public function addBlog()
    {
        return view('admin.blogs.add');
    }

    public function saveBlog(Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ], [
            "title.required" => "Please enter :attribute",
            "description.required" => "Please enter :attribute",
        ]);

        if ($request->hasFile('image')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['image'] = $file->store('blog_images');
            }
        }

        $formData['slug'] = str_slug($formData['title']);

        $blog = Blog::create($formData);

        if ($blog->save()) {
            return redirect('/admin/manage-blogs')->with('success', 'Blog added successfully.');
        } else {
            return redirect('/admin/manage-blogs')->with('error', 'Sorry there is an error while adding blog. please try again.');
        }
    }

    public function editBlog($id)
    {
        $row = Blog::find($id);
        return view('admin.blogs.edit', compact('row'));
    }

    public function updateBlog($id, Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ], [
            "title.required" => "Please enter :attribute",
            "description.required" => "Please enter :attribute",
        ]);

        if ($request->hasFile('image')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['image'] = $file->store('blog_images');
            }
        }

        $formData['slug'] = str_slug($formData['title']);

        // save the row to the database
        $duplicateEntry = Blog::whereTitle($formData['title'])->first();

        if ($duplicateEntry == '' || ($duplicateEntry != '' && $duplicateEntry->id == $id)) {
            Blog::find($id)->update($formData);
        } else
            return redirect()->back()->with('error', 'Blog title already taken.');

        return redirect('/admin/manage-blogs')->with('success', 'Blog updated successfully.');
    }

    public function deleteBlog(Request $request)
    {
        $id = $request->input('id');

        if (Blog::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted blog']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting blog. Please try again later!']);
        }
    }

    public function activateDeactivateBlog(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
            
        if($status == 1)
            $msg = 'You have successfully activated the blog.';
        else
            $msg = 'You have successfully deactivated the blog.';

        if (Blog::find($id)->update(['status'=>$status])) {
            return response()->json(['status' => 'success', 'msg' => $msg]);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error while changing the status of blog. Please try again later!']);
        }
    }

    public function manageFaqTopics()
    {
        $result = FaqTopic::all();
        return view('admin.faq-topics.manage', compact('result'));
    }

    public function addFaqTopic()
    {
        return view('admin.faq-topics.add');
    }

    public function saveFaqTopic(Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'topic' => ['required', 'string'],
        ], [
            "topic.required" => "Please enter :attribute",
        ]);

        $duplicateEntry = FaqTopic::whereTopic($formData['topic'])->count();

        if ($duplicateEntry == 0) {
            $faq_topic = FaqTopic::create($formData);
            if ($faq_topic->save()) {
                return redirect('/admin/manage-faq-topics')->with('success', 'FAQ Topic added successfully.');
            } else {
                return redirect('/admin/manage-faq-topics')->with('error', 'Sorry there is an error while adding FAQ Topic please try again.');
            }
        } else {
            return redirect('/admin/manage-faq-topics')->with('success', 'Sorry this FAQ Topic already exist.');
        }
    }

    public function editFaqTopic($id)
    {
        $row = FaqTopic::find($id);
        return view('admin.faq-topics.edit', compact('row'));
    }

    public function updateFaqTopic($id, Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'topic' => ['required', 'string'],
        ], [
            "topic.required" => "Please enter :attribute",
        ]);

        $duplicateEntry = FaqTopic::whereTopic($formData['topic'])->count();

        if ($duplicateEntry == 0) {
            FaqTopic::find($id)->update($formData);
            return redirect('/admin/manage-faq-topics')->with('success', 'FAQ Topic updated successfully.');
        } else {
            return redirect('/admin/manage-faq-topics')->with('success', 'Sorry this FAQ Topic already exist.');
        }
        
    }

    public function deleteFaqTopic(Request $request)
    {
        $id = $request->input('id');

        if (FaqTopic::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted FAQ Topic']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting FAQ Topic. Please try again later!']);
        }
    }

    public function manageFaqs()
    {
        $result = Faq::with('topic')->get();
        return view('admin.faqs.manage', compact('result'));
    }

    public function addFaq()
    {
        $topics = FaqTopic::all();
        return view('admin.faqs.add',compact('topics'));
    }

    public function saveFaq(Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ], [
            "question.required" => "Please enter :attribute",
            "answer.required" => "Please enter :attribute",
        ]);

        $duplicateEntry = Faq::whereQuestion($formData['question'])->count();

        if ($duplicateEntry == 0) {
            $faq = Faq::create($formData);
            if ($faq->save()) {
                return redirect('/admin/manage-faqs')->with('success', 'FAQ added successfully.');
            } else {
                return redirect('/admin/manage-faqs')->with('error', 'Sorry there is an error while adding FAQ please try again.');
            }
        } else {
            return redirect('/admin/manage-faqs')->with('success', 'Sorry this FAQ already exist.');
        }
    }

    public function editFaq($id)
    {
        $topics = FaqTopic::all();
        $row = Faq::find($id);
        return view('admin.faqs.edit', compact('row','topics'));
    }

    public function updateFaq($id, Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ], [
            "question.required" => "Please enter :attribute",
            "answer.required" => "Please enter :attribute",
        ]);

        // save the row to the database
        Faq::find($id)->update($formData);

        return redirect('/admin/manage-faqs')->with('success', 'FAQ updated successfully.');
    }

    public function deleteFaq(Request $request)
    {
        $id = $request->input('id');

        if (Faq::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted FAQ']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting FAQ. Please try again later!']);
        }
    }

    public function activateDeactivateFaq(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
            
        if($status == 1)
            $msg = 'You have successfully activated the FAQ.';
        else
            $msg = 'You have successfully deactivated the FAQ.';

        if (Faq::find($id)->update(['status'=>$status])) {
            return response()->json(['status' => 'success', 'msg' => $msg]);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error while changing the status of FAQ. Please try again later!']);
        }
    }

    public function managePages()
    {
        $result = CmsPage::all();
        return view('admin.pages.manage', compact('result'));
    }

    public function addPage()
    {
        return view('admin.pages.add');
    }

    public function savePage(Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ], [
            "title.required" => "Please enter :attribute",
            "content.required" => "Please enter :attribute",
        ]);

        if ($request->hasFile('banner')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
            $file = $request->file('banner');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['banner'] = $file->store('page_banners');
            }
        }

        $formData['slug'] = str_slug($formData['title']);
        //$formData['position'] = implode(',', $formData['position']);

        $page = CmsPage::create($formData);

        if ($page->save()) {
            return redirect('/admin/manage-pages')->with('success', 'Page added successfully.');
        } else {
            return redirect('/admin/manage-pages')->with('error', 'Sorry there is an error while adding page. please try again.');
        }
    }

    public function editPage($id)
    {
        $row = CmsPage::find($id);
        return view('admin.pages.edit', compact('row'));
    }

    public function updatePage($id, Request $request)
    {
        $formData = request()->except(['_token']);

        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ], [
            "title.required" => "Please enter :attribute",
            "content.required" => "Please enter :attribute",
        ]);

        if ($request->hasFile('banner')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
            $file = $request->file('banner');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['banner'] = $file->store('page_banners');
            }
        }

        $formData['slug'] = str_slug($formData['title']);
        //$formData['position'] = implode(',', $formData['position']);

        // save the row to the database
        $duplicateEntry = CmsPage::whereTitle($formData['title'])->first();

        if ($duplicateEntry == '' || ($duplicateEntry != '' && $duplicateEntry->id == $id)) {
            CmsPage::find($id)->update($formData);
        } else
            return redirect()->back()->with('error', 'Page title already taken.');

        return redirect('/admin/manage-pages')->with('success', 'Page updated successfully.');
    }

    public function deletePage(Request $request)
    {
        $id = $request->input('id');

        if (CmsPage::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted page']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting page. Please try again later!']);
        }
    }

    public function activateDeactivatePage(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
            
        if($status == 1)
            $msg = 'You have successfully activated the page.';
        else
            $msg = 'You have successfully deactivated the page.';

        if (CmsPage::find($id)->update(['status'=>$status])) {
            return response()->json(['status' => 'success', 'msg' => $msg]);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error while changing the status of page. Please try again later!']);
        }
    }

    public function notifications()
    {
        DB::table('notifications')->where('read_at', NULL)->where('notifiable_id', Auth::id())->update(['read_at' => Date('Y-m-d H:i:s')]);

        $all_notifications = Auth::user()->notifications()->get();
        $notifications = [];
        foreach ($all_notifications as $notification) {
            $notifications[] = $notification;
        }

        return view('admin.settings.notifications', compact('notifications'));
    }

}