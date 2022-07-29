<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{
    protected $table = 'wp_term_taxonomy';

    public $timestamps = false;

    protected $fillable = [
        'term_taxonomy_id', 'term_id', 'taxonomy', 'description', 'parent', 'count'
    ];
}
