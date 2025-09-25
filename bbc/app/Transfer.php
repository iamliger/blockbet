<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasColumnComments;

class Transfer extends Model
{
    use HasColumnComments;

    protected $fillable = [
        'fromName', 'fromAddress','toName','toAddress','amount','ip','operator'
    ];
}