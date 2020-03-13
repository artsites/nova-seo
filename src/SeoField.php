<?php

namespace Arthedain\SeoField;

use App\Models\SEO;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class SeoField extends Field
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
            $this->value = (object)[
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
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $relationship = $model->{$attribute};

        $model::saved(function($model) use($request, $requestAttribute, $relationship){
            if ($request->exists($requestAttribute) && is_string($request[$requestAttribute])) {
                $value = json_decode($request[$requestAttribute]);
                if($model->seo){
                    $relationship->fill([
                        'title'       => $value->title ?? null,
                        'description' => $value->description ?? null,
                        'keywords'    => $value->keywords ?? null,
                    ]);
                    $relationship->save();
                }
                else{
                    $model->seo()->create([
                        'title'       => $value->title ?? null,
                        'description' => $value->description ?? null,
                        'keywords'    => $value->keywords ?? null,
                    ]);
                }
            }
        });        
        
    }

}
