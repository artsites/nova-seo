<?php

namespace App\Nova;

use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class SEO extends Resource
{
    public static string $model = \App\Models\SEO::class;

    public static $title = 'id';

    public static $search = [
        'id', 'title', 'link'
    ];

    public function fields(Request $request)
    {
        $link = $this->link ? "<a href='".$this->link."' target='_blank'>".$this->link."</a>" : '';

        return [
            Text::make('link')
                ->displayUsing(fn($link) => Str::limit($link, 110, '...'))
                ->onlyOnIndex(),
            Textarea::make('link')
                ->help($link ?? '')
                ->rules('required', 'url', 'unique:seo,link,{{resourceId}}', 'max:750')
                ->rows(2),

            Text::make('title')->rules('max:191')->hideFromIndex(),
            Text::make('h1')->rules('max:191')->hideFromIndex(),
            Textarea::make('description')->hideFromIndex(),

            Boolean::make('noindex', 'is_noindex')->default(0)->hideFromIndex(),
            Boolean::make('nofollow', 'is_nofollow')->default(0)->hideFromIndex(),

            NovaTinyMCE::make('text')->hideFromIndex(),
        ];
    }

    public static function label(): string
    {
        return 'SEO';
    }
}
