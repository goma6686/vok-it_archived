<?php
//use App\Lesson;

//$lessons = new lesson();

$dir  = 'pamokos_zip/';
$path = 'pamokos_final/';
$pattern = '/[[0-9]+.[^.]+$/i';

$ignored = array('.', '..',);
$files = array();
$files = scandir($dir); //nuskenuoja pamokos_zip ir ju vardus sudeda i array
$format = array();

foreach ($files as $key => $file) {
	if (in_array($file, $ignored)) continue;
    $zip = new ZipArchive();

    if (($zip->open($dir.'/'.$file) === TRUE)){
    	$formatName = $zip->getNameIndex(0); //ideda formata
    	$zip->renameIndex(0, $file); //pervadina zipe esanti faila jo folderio vardu
    	$formatName = preg_replace($pattern, "", $formatName);
    	$formatName = substr($formatName, 0, -1);
    	$format[]= $formatName;
    }
    $fileName = pathinfo($file, PATHINFO_FILENAME); //isgauna pamoku vardus be zipo
    $folderPath = $path.$fileName;

    $zip->open($dir.'/'.$file, ZipArchive::CREATE); //atidaro zipuose esancius zipus, kuriuose h5p
    $zip->extractTo($path); //juos isekstraktina i final

    mkdir($folderPath);      //sukuria kiekvienai pamokai folderi, pamokos vardu
    chmod($folderPath, 0755);

    $zip->open($path.'/'.$file, ZipArchive::CREATE);
    $zip->extractTo($folderPath); //extractina pamokas i sukurtus folderius
    $zip->close();
    //$lessons->name = $fileName;
    //$lessons->format = $formatName;
    //$lessons->save();
    echo $fileName . ' && ' . $formatName . "</br>";
}

array_map('unlink', glob($path.'*.zip')); //istrina likusius zipus final folderyje
array_map('unlink', glob($dir.'*.zip')); //istrina likusius zipus zip folderyje
?>