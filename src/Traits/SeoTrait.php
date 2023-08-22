<?php

namespace Artsites\NovaSeo\Traits;

trait SeoTrait
{

    public function seo(){
        return $this->morphOne(\App\Models\SEO::class, 'model');
    }

}
