<?php

use App\MoonShine\Resources\Seo\FaviconSettings\FaviconSettings;
use App\MoonShine\Resources\Seo\FaviconSettings\ScripBottomSettings;
use App\MoonShine\Resources\Seo\FaviconSettings\ScripTopSettings;

if (! function_exists('favicon_tags')) {
    function favicon_tags(): FaviconSettings
    {
        return app(FaviconSettings::class);
    }
}

if (! function_exists('script_top')) {
    function script_top(): ScripTopSettings
    {
        return app(ScripTopSettings::class);
    }
}
if (! function_exists('script_bottom')) {
    function script_bottom(): ScripBottomSettings
    {
        return app(ScripBottomSettings::class);
    }
}
