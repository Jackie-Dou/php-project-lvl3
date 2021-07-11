<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlCheck extends Model
{
    use HasFactory;

    public $fillable = ['url_id', 'created_at', 'updated_at', 'h1', 'keywords', 'description', 'status_code'];
}
