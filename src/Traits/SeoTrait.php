<?php

namespace ArtSites\NovaSeo\Traits;

trait SeoTrait
{

    public function seo(){
        return $this->morphOne(\App\Models\Seo::class, 'model');
    }

}
