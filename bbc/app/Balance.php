<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasColumnComments;

class Balance extends Model
{
    use HasColumnComments;

    protected $fillable = [
        'name', 'amount','type','ip','address','iban','swift','account','mobile','balance_type'
    ];
}