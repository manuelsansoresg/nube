<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TitleUser extends Model
{
    use HasFactory;

    protected $table = 'title_user';
    protected $fillable = [
        'user_id', 'descripcion', 'palabras_clave', 'title', 'heart', 'status_pay', 'token', 'imagen'
    ];

    static function create($request)
    {
        /*$tags           = $request->tags;*/
        $title_user     = $request->title;
        $token          = $request->_token;

        $title          = new TitleUser();
        $title->user_id = Auth::id();
        $title->token   = $token;
        $title->title   = $title_user;

        $title->save();

        /*foreach ($tags as $tag ) {

            $tag_title           = new TagTitle();
            $tag_title->title_id = $title->id;
            $tag_title-> name    = $tag;
            $tag_title->save();
        }*/

        return $title;
        
    }

    public static function saveTitle($request)
    {
        $title = new TitleUser($request->all());
        $title->save();
        if($request->hasFile('imagen') != false){
            $image = $request->file('imagen');
            $fullName =$image->getClientOriginalName();
            $fullNameImage = 'title-'.time().'.'.$fullName;

            $image->move('img/title', $fullNameImage);

            TitleUser::find($title->id)->update(['imagen' => $fullNameImage]);
            
        }
        return $title;
    }

    static function addHeart($title_id, $hearts)
    {
        
        $get_my_hearts    = ProfileUser::select('heart')->where( 'user_id', Auth::id())->first();
        $get_title_hearts = TitleUser::select('heart', 'id')->where( 'id', $title_id)->first();
        $status           = 500;
        $my_heart         = $get_my_hearts->heart;
        $title_id         = null;
        $heart_title      = null;
        
        if ( $get_my_hearts->heart >= $hearts) {
            $my_heart    = $get_my_hearts->heart - $hearts;
            $title_id    = $get_title_hearts->id;
            $heart_title = $get_title_hearts->heart + $hearts;

            ProfileUser::select('heart')->where('user_id', Auth::id())->update([ 'heart' => $my_heart]);
            TitleUser::select('heart')->where('id', $title_id)->update(['heart' => $heart_title]);

            $status = 200;

        }

        $data = array('title_id' => $title_id , 'status' => $status, 'my_heart' => $my_heart , 'heart_title' => $heart_title);
        return $data;
    }

    public static function keywords($title_id)
    {
        if ($title_id != ''){
            $titles = TagTitle::select('name')
                        ->join('title_user', 'tag_title.title_id' , '=' , 'title_user.id')
                        ->where('title_id', $title_id)
                        ->get();
            $tags = '';
            foreach ($titles as $title) {
                $tags.= $title->name.',';
            }
            return trim($tags, ',');
        }
    }

    public static function list($user_id)
    {
        return TitleUser::where('user_id', $user_id)->where('status_pay', 1)->get();
    }
    
}
