<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class favoriteWallet extends Model
{
    //

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cointype', 'address','note'
    ];

    

    static function newWallet($name,$cointype,$address,$note){
        favoriteWallet::create(['name'=>$name,"cointype"=>$cointype,"address"=>$address,"note"=>$note]);
    }

    function delete(){
        $this->deleted_at = Carbon::now()->toDateString();
        $this->save();
    }

}
