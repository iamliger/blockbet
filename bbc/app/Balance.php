<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    //
    protected $fillable = [
        'name', 'amount','type','ip','address','iban','swift','account','mobile','balance_type'
    ];
}
