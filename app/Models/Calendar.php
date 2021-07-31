<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Verot\Upload\Upload;
use Illuminate\Support\Facades\File;

class Calendar extends Model
{
    use HasFactory;

    static function create($request, $path)
    {
        $upload_photo = self::uploadPhoto($_FILES['photo'], $request, $path); //metodo para adjuntar imagen en perfil
        $status = 500;
        if(is_array($upload_photo)){
            $calendar = new Calendar();
            $calendar->user_id = Auth::id();
            $calendar->photo = $upload_photo['fullNameImage'];
            $calendar->fpublicacion = $request->date;
            $calendar->save();
            $status = 200;
        }
        return array('status' => $status);
    }

    static function uploadPhoto($photo , $request, $path){

        if($request->hasFile('photo') != false){
            $data = array();
            $image = $request->file('photo');

            $fullName =$image->getClientOriginalName();
            $extension =$image->getClientOriginalExtension();
            $onlyName = explode('.'.$extension,$fullName)[0];

            $name_image = 'calendar-'.time().'.'.$onlyName;
            $fullNameImage = 'calendar-'.time().'.'.$fullName;

            /*$image->move($path, $name_image);*/
            @File::makeDirectory('./'.$path);
            /* crear el thumb */
            $thumb = new Upload($_FILES['photo']);
            if ($thumb->uploaded) {
                $thumb->file_new_name_body   = $name_image;
                $thumb->image_resize         = true;
                $thumb->image_ratio_crop     = true;
                $thumb->image_x              = 500;
                $thumb->image_y              = 500;
                $thumb->process('./'.$path.'/');
            }

            $thumb = new Upload($photo);
            if ($thumb->uploaded) {
                $thumb->file_new_name_body   = $name_image;
                $thumb->file_name_body_pre   = 'thumb-';
                $thumb->image_resize         = true;
                $thumb->image_ratio_crop     = true;
                $thumb->image_x              = 140;
                $thumb->image_y              = 140;
                $thumb->process('./'.$path.'/');
            }


            $data['fullNameImage'] = $fullNameImage;
            $data['fullNameThumb'] = 'thumb_'.$fullNameImage;

            $data['image_thumb'] = $path.'/'.'thumb_'.$fullNameImage;
            $data['image'] = $path.'/'.$fullNameImage;
            return $data;
        }
    }

    static function getReward($date)
    {
        if (date("m", strtotime($date)) == date('m')){
            $heart = ProfileUser::find(Auth::id());

            $user = ProfileUser::find(Auth::id());
            $user->heart =  $heart->heart + 1000;
            $user->update();

            $heart = ProfileUser::find(Auth::id());
            return  number_format_short($heart->heart);
        }
    }

    static function removeReward($date)
    {
        if (date("m", strtotime($date)) == date('m')){
            $heart = ProfileUser::find(Auth::id());

            $user = ProfileUser::find(Auth::id());
            $user->heart = $heart->heart - 1000  ;
            $user->update();

            $heart = ProfileUser::find(Auth::id());
            return  number_format_short($heart->heart);
        }
    }

    static function getPhoto($date)
    {
        return Calendar::where('user_id', Auth::id())->where('fpublicacion', $date)->first();
    }

    static function drop($date, $path)
    {
        $get_calendar = Calendar::where('user_id', Auth::id())->where('fpublicacion', $date)->first();
        @unlink($path.'/'.$get_calendar->photo);
        @unlink($path.'/thumb-'.$get_calendar->photo);
        $calendar = Calendar::where('user_id', Auth::id())->where('fpublicacion', $date);
        $calendar->delete();
    }

}
