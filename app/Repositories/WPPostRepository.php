<?php

namespace App\Repositories;

use App\Models\WPPost;

class WPPostRepository extends BaseRepository
{
    public function getModel(): string
    {
        return WPPost::class;
    }
}
