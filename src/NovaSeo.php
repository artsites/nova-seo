<?php

namespace ArtSites\NovaSeo;

use App\Models\SEO;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class NovaSeo extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'seo-field';

    public function __construct($name = 'SEO', $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->withMeta([
            'has_auto_title' => false,
            'auto_title' => false,
            'has_auto_description' => false,
            'auto_description' => false,
        ]);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute = 'seo')
    {
        $model::saved(function ($model) use ($request, $requestAttribute) {
            $model::withoutEvents(function() use($model, $request, $requestAttribute) {

                if (!$request->exists($requestAttribute) && !is_string($request[$requestAttribute])) return;
                $data = json_decode($request[$requestAttribute]);

                $title = $data?->title ?? '';
                $autoTitle = $data?->auto_title ?? false;
                $description = $data?->description ?? '';
                $autoDescription = $data?->auto_description ?? false;
                $link = isset($this->meta['route']) ? route($this->meta['route'], ['slug' => $model->slug]) : null;

                ////////////////////////////////////////////////////////
                if(!$link && ($this->meta['propertyRouteName'] ?? false)) {
                    $link = route(app()->getLocale().'.'.$model->status->key.'.'.$this->meta['propertyRouteName'], ['slug' => $model->slug]);
                }
                ////////////////////////////////////////////////////////

                $seo = SEO::query()
                    ->where('model_id', $model->id)
                    ->where('model_type', get_class($model))
                    ->first();

                if($seo){
                    $model->seo()->update(
                        [
                            'auto_title'            => $autoTitle,
                            'title'                 => $title,
                            'h1'                    => $seo->h1,
                            'link'                  => $link,
                            'auto_description'      => $autoDescription,
                            'description'           => $description,
                        ]
                    );
                } else {
                    $model->seo()->create(
                        [
                            'auto_title'            => $autoTitle,
                            'title'                 => $title,
                            'h1'                    => null,
                            'link'                  => $link,
                            'auto_description'      => $autoDescription,
                            'description'           => $description,
                        ]
                    );
                }
            });
        });
    }

    public function routeName($name): NovaSeo
    {
        return $this->withMeta(['route' => $name]);
    }

    public function routeByPropertyWithStatus($propertyRouteName): NovaSeo
    {
        return $this->withMeta(['propertyRouteName' => $propertyRouteName]);
    }

    public function autoTitle(bool $isAuto = true): NovaSeo
    {
        return $this->withMeta(['auto_title' => $isAuto, 'has_auto_title' => true]);
    }

    public function autoDescription(bool $isAuto = true): NovaSeo
    {
        return $this->withMeta(['auto_description' => $isAuto, 'has_auto_description' => true]);
    }
}
