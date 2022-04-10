<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lesson;
use App\Category;
use App\Topic;
use App\Level;
use DB;

class LessonsController extends Controller
{
	public function lesson($id) {
		$lesson = DB::table('Lessons')
                ->where('id', '=', $id)
                ->first();
    	return view('/lesson/lesson', ['lesson' => $lesson]);
    }

    public function categories() {
    	$lessons = Lesson::all();
    	$categories = Category::all();
    	$topics = Topic::all();
    	$levels = Level::all();
    	return view('/lesson/list', ['lessons' => Lesson::where('visible', '=', 1)->orderBy('category_order')->get(), 'groups' => $categories, 'topics' => $topics, 'levels' => $levels, 'sort' => 'categories']);
    }
    public function topics() {
    	$lessons = Lesson::all();
    	$categories = Category::all();
    	$topics = Topic::all();
    	$levels = Level::all();
    	return view('/lesson/list', ['lessons' => Lesson::where('visible', '=', 1)->orderBy('topic_order')->get(), 'groups' => $topics, 'categories' => $categories, 'levels' => $levels, 'sort' => 'topics']);
    }
    public function levels() {
    	$lessons = Lesson::all();
    	$categories = Category::all();
    	$topics = Topic::all();
    	$levels = Level::all();
    	return view('/lesson/list', ['lessons' => Lesson::where('visible', '=', 1)->orderBy('level_order')->get(), 'categories' => $categories, 'topics' => $topics, 'groups' => $levels, 'sort' => 'levels']);
    }
}