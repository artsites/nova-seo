<?php

namespace ArtSites\NovaSeo\Models;

use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    protected $table = 'seo';

    protected $fillable = ['title', 'description', 'link', 'is_noindex'];
}
