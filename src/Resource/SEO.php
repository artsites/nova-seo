<?php

namespace App\Nova;

use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Resource;

class SEO extends Resource
{
    public static string $model = \App\Models\SEO::class;

    public static $title = 'id';

    public static $search = [
        'id', 'title', 'url'
    ];

    public function fields(Request $request)
    {
        return [
            Text::make('link')
                ->displayUsing(fn($link) => Str::limit($link, 110, '...'))
                ->onlyOnIndex(),
            Textarea::make('link')
                ->rows(2),

            Text::make('title')->hideFromIndex(),
            Text::make('h1')->hideFromIndex(),
            Boolean::make('noindex, nofollow', 'is_noindex')->hideFromIndex(),
            Textarea::make('description')->hideFromIndex(),
            NovaTinyMCE::make('text')->hideFromIndex(),
        ];
    }

    public static function label(): string
    {
        return 'SEO';
    }
}
