<?php

namespace App\Nova;

use ArtSites\NovaSeo\Rules\SeoLinkRule;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class SEO extends Resource
{
    use TabsOnEdit;

    public static string $model = \App\Models\SEO::class;

    public static $title = 'id';

    public static $search = [
        'id', 'title', 'link'
    ];

    public function fields(Request $request)
    {
        $link = $this->link ? "<a href='" . $this->link . "' target='_blank'>" . $this->link . "</a>" : '';

        return [
            Tabs::make('SEO', [
                'Главное' => [
                    Text::make('Link', 'link')
                        ->displayUsing(fn($link) => Str::limit($link, 110, '...'))
                        ->sortable()
                        ->onlyOnIndex(),
                    Textarea::make('Link', 'link')
                        ->help($link ?? '')
                        ->rules('required', 'url', 'unique:seo,link,{{resourceId}}', 'max:750', new SeoLinkRule())
                        ->rows(2),

                    Text::make('Title', 'title')->rules('max:191')->hideFromIndex(),
                    Text::make('h1', 'h1')->rules('max:191')->hideFromIndex(),
                    Textarea::make('Description', 'description')->hideFromIndex(),

                    Boolean::make('noindex', 'is_noindex')->default(0)->hideFromIndex(),
                    Boolean::make('nofollow', 'is_nofollow')->default(0)->hideFromIndex(),
                ],
                'Контент' => [
                    NovaTinyMCE::make('Content', 'content')->hideFromIndex()
                ]
            ])->withToolbar()
        ];
    }

    public static function label(): string
    {
        return 'SEO';
    }
}
