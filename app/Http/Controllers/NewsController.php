<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\News;
use File;
use App\NewsCategories;

class NewsController extends Controller
{
    public function news(){
        $news_categories = NewsCategories::all();
        $news = DB::table('news')->paginate(8);
        return view('administrator.news', ['news_categories' => $news_categories, 'news' => $news]);
    }

    function show(){
        //$data = News::all();
        $news_categories = NewsCategories::all();
        $data = DB::table('news')
            ->where('lang', '=', strtoupper(app()->getLocale()))
            ->orderBy('id', 'desc')
            ->get();
        return view('index', ['news'=>$data, 'news_categories' => $news_categories]);
    }

    public function postNews(Request $request){
        $this->validate($request, [
            'news_title' => 'required',
            'news_body' => 'required',
            'news_categoryId' => 'required',
        ]);

        $news = new News();
        $news -> news_title = $request->input('news_title');

        if($request->file('title_image')) {
         $file = $request->file('title_image');
         $filename = time().'_'.$file->getClientOriginalName();
         $news -> title_image = $filename;

         // File upload location
         $location = public_path('/news_images/title_images/');

         // Upload file
         $file->move($location,$filename);
      }

        $news -> description = $request->input('description');
        $news -> news_body = $request->input('news_body');
        $news -> news_categoryId = $request->input('news_categoryId');
        $news -> lang  = $request->input('lang');
        $news -> save();
        return redirect() -> back();
    }

    public function edit($id){
        $news_categories = NewsCategories::all();
        $news = News::find($id);
        return view('administrator.edit-news', ['news_categories' => $news_categories, 'news' => $news]);
     }

    public function expand($id){
        $news_categories = NewsCategories::all();
        $news = News::find($id);
        return view('expand', ['news' => $news]);
     }

    public function delete($id){

        $news = News::findOrFail($id);
        if ($news -> title_image != null){
			unlink('news_images/title_images/'.$news -> title_image);
        }
        $news->delete();
        return redirect('administrator/news#edit');
     }

    public function update($id){
        $news = News::findOrFail($id);

        $news->news_title = request('news_title');
        $news->description = request('description');
        $news->news_body = request('news_body');
        $news->news_categoryId = request('news_categoryId');
        $news->lang = request('lang');
        $news->save();

        return redirect('administrator/news#edit');
    }

	public function uploadImage($id){
		if($_FILES['titleImageUpload']['size'] > 0) {
	        $news = News::findOrFail($id);
	        $file = $_FILES['titleImageUpload']['name'];
	        $fileName = time().'_'.$file;

	        // File upload location
	        $location = public_path('/news_images/title_images/');

	        // Upload file
	        move_uploaded_file($_FILES['titleImageUpload']['tmp_name'], $location.$fileName);
	        $news -> title_image = $fileName;
	        $news -> save();
	    }
	        return redirect() -> back();
	}

    public function changeImage($id) {

        if($_FILES['imageChange']['size'] > 0) {
            $news = News::findOrFail($id);
            unlink('news_images/title_images/'.$news -> title_image);
            $news -> title_image = null;
            $fileName = time().'_'.$name;
            $extension = substr($_FILES['imageChange']['name'], strripos($_FILES['imageChange']['name'], '.'));
            move_uploaded_file($_FILES['imageChange']['tmp_name'], public_path($path.$fileName.$extension));
            $news -> title_image = $fileName.$extension;
            $news -> save();
        }
        return redirect() -> back();
    }

    public function removeImage($id) {

        $news = News::findOrFail($id);
        unlink('news_images/title_images/'.$news -> title_image);
        $news -> title_image = null;
        $news -> save();
        return redirect() -> back();
    }

}
