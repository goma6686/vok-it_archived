<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Feedback;


class FeedbackController extends Controller
{
    public function listFeedback(){
        //return view('administrator.feedback', ['results' => Feedback::all()]);
        //return View::make('administrator.feedback')->with('', $posts);
        //$results = Feedback::all();
        //$data = 'peen';
        //$feedbacks = DB::table('Feedback')->get();
        //return view('administrator.feedback')->with($results);
        //$data = 'this is a test';
        return view('administrator.feedback', ['feedbacks' => DB::table('Feedback')->orderBy('id', 'desc')->paginate(5)]);
        //return view('administrator.feedback', ['feedbacks' => Feedback::orderBy('id')->get()]);
    }

    function postFeedback(){
        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
        $message = @trim(stripslashes($_POST['message'])); 
        $page = $_POST['page']; 
        //echo $message;
        $feedback = new Feedback();
        $feedback -> text = $message;
        $feedback -> page = $page;
        $feedback -> created_at = $current_date_time;
        $feedback -> save();

    }
}
