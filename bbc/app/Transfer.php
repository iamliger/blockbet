<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    //
    protected $fillable = [
        'fromName', 'fromAddress','toName','toAddress','amount','ip','operator'
    ];
}
