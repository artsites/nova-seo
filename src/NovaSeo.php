<?php

namespace Artsites\NovaSeo;

use App\Models\SEO;
use Illuminate\Support\Facades\Route;
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
        $this->parameterName = 'slug';
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param string $requestAttribute
     * @param object $model
     * @param string $attribute
     * @return void
     * @throws \Exception
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute = 'seo')
    {
        $model::saved(function ($model) use ($request, $requestAttribute) {
            if (!$request->exists($requestAttribute) && !is_string($request[$requestAttribute])) return;
            $data = json_decode($request[$requestAttribute]);

            $title = $data?->title ?? '';
            $autoTitle = $data?->auto_title ?? false;
            $description = $data?->description ?? '';
            $autoDescription = $data?->auto_description ?? false;

            $link = null;
            if (isset($this->meta['route'])) {
                if (isset($this->meta['relation'])) {

                    /** fix for sale-sold without redirect */
                    $value = $model->{$this->meta['relation']}()->first()->key;
                    $value = $value === 'rent' ? 'rent' : 'sale';
                    /** fix for sale-sold without redirect */

                    $route_name = app()->getLocale() . '.' . $value . '.' . $this->meta['route'];

                    $this->defineRouteParameterName($route_name);

                    $link = route($route_name, [$this->parameterName => $model->slug]);
                } else {
                    $route_name = app()->getLocale() . '.' . $this->meta['route'];

                    $this->defineRouteParameterName($route_name);

                    $link = route($route_name, [$this->parameterName => $model->slug]);
                }
            }

            $seo = SEO::query()
                ->where('model_id', $model->id)
                ->where('model_type', get_class($model))
                ->first();

            SEO::withoutEvents(function () use ($seo, $model, $autoTitle, $title, $link, $autoDescription, $description) {
                if ($seo) {
                    $seo->fill([
                        'auto_title' => $autoTitle,
                        'title' => $title,
                        'link' => $link,
                        'auto_description' => $autoDescription,
                        'description' => $description,
                    ])->save();
                } else {
                    $model->seo()->create([
                        'locale' => app()->getLocale(),
                        'model_type' => get_class($model),
                        'model_id' => $model->id,
                        'auto_title' => $autoTitle,
                        'title' => $title,
                        'link' => $link,
                        'auto_description' => $autoDescription,
                        'description' => $description,
                    ]);
                }
            });

        });
    }

    public function routeName(string $name): NovaSeo
    {
        return $this->withMeta(['route' => $name]);
    }

    public function routeRelation(string $relation): NovaSeo
    {
        return $this->withMeta(['relation' => $relation]);
    }

    public function autoTitle(bool $isAuto = true): NovaSeo
    {
        return $this->withMeta(['auto_title' => $isAuto, 'has_auto_title' => true]);
    }

    public function autoDescription(bool $isAuto = true): NovaSeo
    {
        return $this->withMeta(['auto_description' => $isAuto, 'has_auto_description' => true]);
    }

    /**
     * @throws \Exception
     */
    private function defineRouteParameterName($routeName): void
    {
        $route = Route::getRoutes()->getByName($routeName);

        if ($route) {
            $parametersNames = $route->parameterNames();
            if(isset($parametersNames[0]) && !empty($parametersNames[0])) {
                $this->parameterName = $parametersNames[0];
            }else{
                throw new \Exception('Parameter name if the route: '.$routeName . " should not be empty, it should contain a slug");
            }
        }
    }
}
