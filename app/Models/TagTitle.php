<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagTitle extends Model
{
    use HasFactory;

    protected $table = 'tag_title';
    

    static function get($token)    
    {
        $title = TitleUser::
                     where( 'user_id', Auth::id())
                    ->where('token',  $token)
                    ->first();

        if($title != null){

            $title->status_pay = 1;
            $title->token      = '';
            $title->update();

        }
            /*if(count( $tag) > 0){
                $get_title = TitleUser::select('id')
                                ->where( 'token', $token)
                                ->where( 'user_id', Auth::id())->first();
                $get_title-> status_pay = 1;
                $get_title-> token      = '';
                $get_title->update();
            }*/
        return $title;
    }

    static function listTitleTag($search, $page=null , $user_id = null)
    {
        # lista de titulos con sus etiquetas   
        DB::enableQueryLog();
        $titles = TitleUser::
                    select( 'photo', 'title_user.id', 'photo', 'user_id', 'heart', 'title', 'title_user.id as title_id')
                    ->join('users', 'users.id', '=', 'title_user.user_id')
                    ->orderBy( 'title_user.heart', 'desc')
                    ->where( 'status_pay' , 1);
                    
        if ($search != 'all') {
            $titles->where('tag_title.name', 'like', "%$search%");
        }

        if($user_id != 'null'){
            $titles->where('user_id', $user_id);
        }

        if($page != null){
            $titles->offset( $page );
            $titles->limit(5);
        }
                    
        $titles = $titles->get();


        $title_tags = array();
        $tags_value = array();

        /*foreach ($titles as $title ) {
            $tags = TitleUser::
                    select( 'heart', 'photo', 'tag_title.name as tag')
                    ->join( 'tag_title' , 'tag_title.title_id' , '=' , 'title_user.id')
                    ->join( 'users' , 'users.id' , '=' , 'title_user.user_id')
                    ->where( 'title_id', $title->id);
            
            if ($search != 'all') {
                $titles->where('tag_title.name', 'like', "%$search%");
            }

            $tags = $tags->get();
            foreach ($tags as $tag) {
                
                $tags_value[] = array('name' => $tag->tag);
            }
            $title_tags[] = array( 'title_id' => $title-> title_id , 'title' => $title-> title , 'user_id'=> $title-> user_id , 'heart' => $title-> heart , 'photo' => $title->photo , 'tags' => $tags_value );
            $tags_value = [];
        }*/
        //$title_tags[] = array( 'title_id' => $titles-> title_id , 'title' => $titles-> title , 'user_id'=> $titles-> user_id , 'heart' => $titles-> heart , 'photo' => $titles->photo , 'tags' => $tags_value );
        return $titles;
       
    }

}
