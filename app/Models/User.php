<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable {

    use Notifiable;

    protected $casts = array(
        'id' => 'integer',
        'mobile' => 'integer',
    );
    public static $sizes = array(
        's' => array('width' => 150, 'height' => 150)
    );

    public function bus() {
        return $this->hasOne(PilgrimsBus::class, 'user_id', 'id');
    }
    public static function transform($item)
    {
        $transformer = new \stdClass();
        $transformer->id = $item->id;
        $transformer->username = $item->username;
        if($item->type==2){
       
             $transformer->image = url('public/uploads/supervisors').'/'.$item->bus->supervisor->supervisor_image; 
        }else{
           $transformer->image = url('public/uploads/users').'/'.$item->image; 
        }
        if($item->bus){
            $transformer->busSupervisorId = $item->bus->supervisor->id;
        }
        
        return $transformer;
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($user) {
            
        });
    }

}
