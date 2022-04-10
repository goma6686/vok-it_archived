<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use ZipArchive;
use File;

use App\Lesson;
use App\Category;
use App\Topic;
use App\Level;


class DashboardController extends Controller
{
    public function index(){        

        return view('administrator.dashboard', ['lessonsSortedByCategory' => Lesson::orderBy('category_order')->get(), 'lessonsSortedByTopic' => Lesson::orderBy('topic_order')->get(), 'lessonsSortedByLevel' => Lesson::orderBy('level_order')->get(), 'categories' => Category::all(), 'topics' => Topic::all(), 'levels' => Level::all()]);
    }

    public function uploadFile(Request $request) {

        // Variables + ZipArchive instatiation
    
        $file = $request->file('file');
        $fileName = $_FILES["file"]["name"];
        $fileBasename = substr($fileName, 0, strripos($fileName, '.'));
        $fileExtension = substr($fileName, strripos($fileName, '.'));

        $zip = new ZipArchive();
        $filesDirectory = 'pamokos_files/'.$fileBasename;

        // Check if folder with the same name already exists, if not, make directory for Lesson

        if(!is_dir($filesDirectory)) {

            mkdir($filesDirectory);
            chmod($filesDirectory, 0755);
        }

        // If file .zip -> get content and rename to current file + it's extension

        $h5pContentName = null;
        if(in_array($fileExtension, array('.zip'))) {

            $zip -> open($file, ZipArchive::CREATE);
            $zip -> extractTo($filesDirectory);
            $h5pContentName = $zip->getNameIndex(0);
        } else {

            $file -> move(public_path($filesDirectory), $fileName);
            $h5pContentName = $fileName;
        }

        // Extract .h5p to correct to the directory that was created for the file

        $zip -> open($filesDirectory.'/'.$h5pContentName, ZipArchive::CREATE);
        $zip -> extractTo($filesDirectory);
        $zip -> close();
        unlink($filesDirectory.'/'.$h5pContentName);

        // Find the cover image if the lesson has one

        $coverImage = null;
        $pathToImages = $filesDirectory."/content/images";
        if(is_dir($pathToImages)) {
            $imagesDirectoryContents = scandir($pathToImages);
            foreach($imagesDirectoryContents as $images) {
                if(substr($images, 0, 11) == "coverImage-") { // Checks each entry in imagesDirectoryContents and checks if it starts with "coverImage-" (offset 0 check 11 characters)
                    $coverImage = $images;
                    break;
                }
            }
        }

        // Make an entry in DB

        $lessons = new Lesson();
        $lessons -> name = $fileBasename;
        $lessons -> category_id = null;
        $lessons -> category_order = null;
        $lessons -> topic_id = null;
        $lessons -> topic_order = null;
        $lessons -> level_id = null;
        $lessons -> level_order = null;
        $lessons -> picture = $coverImage;
        $lessons -> visible = false;
        $lessons -> save();

        // Done

        return redirect() -> back();
    }

    public function update($id) {

        $lessons = Lesson::findOrFail($id);

        // Update directory name
        rename('pamokos_files/'.$lessons->name, 'pamokos_files/'.request('u_name'));

        // Update in Database
        $lessons -> name = request('u_name');
        $lessons -> description = request('u_description');
        $lessons -> category_id = request('u_category_id');
        $lessons -> category_order = request('u_category_order');
        $lessons -> topic_id = request('u_topic_id');
        $lessons -> topic_order = request('u_topic_order');
        $lessons -> level_id = request('u_level_id');
        $lessons -> level_order = request('u_level_order');
        $lessons -> format = request('u_format');
        $lessons -> picture = request('u_picture');
        $lessons -> save();
        return redirect() -> back();
    }

    public function delete($id) {
        $lesson = Lesson::findOrFail($id);
        $dirPath = 'pamokos_files/'.$lesson->name;

        // Delete local directory and all of its contents
        if (File::exists($dirPath)) {
            File::deleteDirectory($dirPath);
        }

        // Delete in DB
        $lesson -> delete();

        // Refresh page
        return redirect() -> back();
    }

    public function updatePos() {

        $jsonArray = json_decode($_POST['update']);
        
        foreach ($jsonArray as $jsonObj) {

            $lesson = Lesson::findOrFail($jsonObj -> id);

            $sort_id = $jsonObj -> parentId;
            $sort_pos = $jsonObj -> newPos;
            if($sort_id == "noId") {
                $sort_id = null;
                $sort_pos = null;
            }
            
            switch ($jsonObj -> sortingBy) {

                case 'category':
                    $lesson -> category_id = $sort_id;
                    $lesson -> category_order = $sort_pos;
                    break;
                case 'topic':
                    $lesson -> topic_id = $sort_id;
                    $lesson -> topic_order = $sort_pos;
                    break;
                case 'level':
                    $lesson -> level_id = $sort_id;
                    $lesson -> level_order = $sort_pos;
                    break;
            }
            $lesson -> save();
        }
    }

    public function updateVisibility($id) {

        $lesson = Lesson::findOrFail($id);
        if($lesson -> visible == true) {
            $lesson -> visible = false;
        } else {
            $lesson -> visible = true;
        }
        $lesson -> save();
    }

    public function uploadImage($id) {

        $lesson = Lesson::findOrFail($id);
        
        $path = 'pamokos_files/'.$lesson -> name.'/content/images/';
        if(!is_dir($path)) {
            mkdir($path);
            chmod($path, 0755);
        }

        $coverImage = null;
        $imagesDirectoryContents = scandir($path);
        foreach($imagesDirectoryContents as $images) {
            if (substr($images, 0, 11) == "coverImage-") { // Checks each entry in imagesDirectoryContents and checks if it starts with "coverImage-" (offset 0 check 11 characters)
                $coverImage = $images;
                break;
            }
        }

        $fileName = 'coverImage-';
        if($coverImage != null) {
            $fileName = substr($coverImage, 0, strripos($coverImage, '.'));
            unlink($path.$coverImage);
        }

        $extension = substr($_FILES['imageUpload']['name'], strripos($_FILES['imageUpload']['name'], '.'));
        move_uploaded_file($_FILES['imageUpload']['tmp_name'], public_path($path.$fileName.$extension));
        $lesson -> picture = $fileName.$extension;
        $lesson -> save();

        return redirect() -> back();
    }

    public function changeImage($id) {

        if ($_FILES['imageChange']['size'] > 0) {

            $lesson = Lesson::findOrFail($id);

            $path = 'pamokos_files/'.$lesson -> name.'/content/images/';
            unlink($path.$lesson -> picture);

            $fileName = substr($lesson -> picture, 0, strripos($lesson -> picture, '.'));
            $extension = substr($_FILES['imageChange']['name'], strripos($_FILES['imageChange']['name'], '.'));
            move_uploaded_file($_FILES['imageChange']['tmp_name'], public_path($path.$fileName.$extension));
            $lesson -> picture = $fileName.$extension;
            $lesson -> save();
        }
        return redirect() -> back();
    }

    public function removeImage($id) {

        $lesson = Lesson::findOrFail($id);
        $lesson -> picture = null;
        $lesson -> save();

        return redirect() -> back();
    }
}