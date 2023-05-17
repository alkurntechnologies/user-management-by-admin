<?php
namespace App\Http\Controllers;

use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;
use Illuminate\Http\Request;
use App\Models\Meeting;
use Auth;

class ZoomController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function index()
    {
        $meetings =  Meeting::whereUserId(Auth::id())->get();

        return view('meetings.index', compact('meetings'));
    }

    public function show($meeting_id)
    {
        try{
            $meeting = $this->get($meeting_id);
        }catch(Exception $e){
            dd($e);
        }

        return view('meetings.show', compact('meeting'));
    }

    public function createMeeting()
    {
        return view('meetings.create');
    }

    public function store(Request $request)
    {
       $response = $this->create($request->all());

       if($response['success'] == true){
            Meeting::create([
                'user_id' => Auth::id(),
                'meeting_id' => $response['data']['id'],
                'topic' => $request->topic
            ]);
       }else{
            return redirect()->back()->with('error', 'something went wrong');
       }

        return redirect('meetings');
    }

    public function update($meeting, Request $request)
    {
        $this->update($meeting->zoom_meeting_id, $request->all());

        return redirect()->route('meetings.index');
    }

    public function destroy(ZoomMeeting $meeting)
    {
        $this->delete($meeting->id);

        return $this->sendSuccess('Meeting deleted successfully.');
    }
}