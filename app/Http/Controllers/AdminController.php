<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lesson;
use App\Topic;

class AdminController extends Controller
{
    public function index() {

    	$lessons = Lesson::all();
        $topics = Topic::all();

    	return view('admin.index', ['lessons' => $lessons, 'topics' => $topics]);
    }

    public function store() {

    	$lessons = new Lesson();

    	$lessons->name = request('p_name');
    	$lessons->description = request('p_description');
    	$lessons->category_id = request('p_category_id');
    	$lessons->topic_id = request('p_topic_id');
    	$lessons->level_id = request('p_level_id');
    	$lessons->format = request('p_format');
    	$lessons->picture = request('p_picture');
    	
    	$lessons->save();

    	return redirect() -> back();
    }

    public function update($id) {

        $lessons = Lesson::findOrFail($id);

        $lessons->name = request('u_name');
        $lessons->description = request('u_description');
        $lessons->category_id = request('u_category_id');
        $lessons->topic_id = request('u_topic_id');
        $lessons->level_id = request('u_level_id');
        $lessons->format = request('u_format');
        $lessons->picture = request('u_picture');

        $lessons->save();

        return redirect() -> back();
    }

    public function destroy($id) {

    	$lessons = Lesson::findOrFail($id);

    	$lessons->delete();

    	return redirect() -> back();
    }

    public function uploadFile(Request $request) {

        $file = $request->file('file');
        $file->move(public_path('pamokos_files'), $_FILES['file']['name']);




        return redirect() -> back();
    }
}