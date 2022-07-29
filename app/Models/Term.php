<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'wp_terms';

    public $timestamps = false;

    protected $fillable = [
        'term_id', 'name', 'slug', 'term_group',
    ];
}
