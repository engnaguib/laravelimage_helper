<?php

/**
 * Created by PhpStorm.
 * User: Naguib
 * Date: 1/30/2017
 * Time: 1:54 PM
 */
namespace App\Support;

use  Illuminate\Support\Facades\Request;
use Intervention\Image\ImageManagerStatic as Image;
class Helper
{

    public static function upload_image($file_name, $path)
    {
        $File_obj = Request::file($file_name);
        $file_name = time() . '.' . $File_obj->getClientOriginalName();
        $file_name = str_replace(' ','',$file_name);
        if ($File_obj->move($path, $file_name)) {
            return $file_name;
        } else {
            return null;
        }
    }

    public static function resize_image($path,$new_path)
    {
        $image_resize_org = Image::make($path);
        $image_resize_org->save($new_path.$image_resize_org->basename);
        $image_resize= Image::make($new_path.$image_resize_org->basename);
        $width=$image_resize->width();
        $hight=$image_resize->height();
        $newHeight=0;
        $newwidth=0;
        $imgRation=$width/$hight;
        if($imgRation >= 1){
            $newHeight = 500 / $imgRation;
            $image_resize->resize(500, $newHeight);

        }elsE{
            $newwidth= 500 * $imgRation;
            $image_resize->resize($newwidth, 500);
        }

        if($image_resize->save()){
            return true;
        }elsE{
            return false;
        }
    }

}