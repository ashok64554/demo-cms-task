<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appsetting extends Model
{
    protected $fillable = [
        'app_name', 'app_logo', 'email', 'address', 'app_key', 'mobilenum', 'seo_keyword', 'seo_description', 'google_analytics'
    ];
}
