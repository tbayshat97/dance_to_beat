<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get all data from menu.json file
        $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);
        $horizontalMenuJson = file_get_contents(base_path('resources/json/horizontalMenu.json'));
        $horizontalMenuData = json_decode($horizontalMenuJson);

        // get all artist data from menu.json file
        $verticalMenuJsonArtist = file_get_contents(base_path('resources/json/verticalMenu-artist.json'));
        $verticalMenuDataArtist = json_decode($verticalMenuJsonArtist);
        $horizontalMenuJsonArtist = file_get_contents(base_path('resources/json/horizontalMenu-artist.json'));
        $horizontalMenuDataArtist = json_decode($horizontalMenuJsonArtist);

        // share all menuData to all the views
        \View::share('menuData', [$verticalMenuData, $horizontalMenuData]);
        \View::share('menuDataArtist', [$verticalMenuDataArtist, $horizontalMenuDataArtist]);

    }
}
