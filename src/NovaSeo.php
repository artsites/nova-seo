<?php

namespace ArtSites\NovaSeo;

use ArtSites\Models\SEO;
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


    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|callable|null  $attribute
     * @param  callable|null  $resolveCallback
     * @return void
     */
    public function __construct($name = "SEO", $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
    }

    /**
     * Resolve the field's value.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        // dd($resource->seo);
        parent::resolve($resource, $attribute);

        if (!$this->value) {
            $this->value = (object) [
                'title' => '',
                'description' => '',
                'keywords' => '',
            ];
        }
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
        $relationship = $model->{$attribute};

        $defaultValue = isset($this->meta['defaultValue']) ? $this->meta['defaultValue'] : null;

        $model::saved(function ($model) use ($request, $requestAttribute, $relationship, $defaultValue) {
            if ($request->exists($requestAttribute) && is_string($request[$requestAttribute])) {
                $value = json_decode($request[$requestAttribute]);

                $title = $value->title != '' ? $value->title :  $model->$defaultValue;

                $link = isset($this->meta['route']) ? route($this->meta['route'], ['slug' => $model->slug]) : null;

                $model->seo()->updateOrCreate(
                    ['link' => $link],
                    [
                        'title'        => $title,
                        'link'          => $link,
                        'description'   => $value->description ?? null,
                        'keywords'      => $value->keywords ?? null
                    ]
                );
            }
        });
    }

    public function routeName($name)
    {
        return $this->withMeta(['route' => $name]);
    }

    public function defaultValue($value)
    {
        return $this->withMeta(['defaultValue' => $value]);
    }
}
