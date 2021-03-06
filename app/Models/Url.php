<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 */
class Url extends Model
{
    use HasFactory;

    public $fillable = ['name', 'created_at', 'updated_at'];
}
