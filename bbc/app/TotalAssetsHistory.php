<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalAssetsHistory extends Model
{
    protected $fillable = [
        'type', 'amount', 'previous_total_assets', 'new_total_assets', 'description', 'user_id'
    ];
}