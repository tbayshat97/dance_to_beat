<?php

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDirectories();

        if (App::environment() === 'production') {
            echo ("Production mode seeding \n");
            $this->call($this->getProductionModeSeeders());
        } else {
            echo ("Development mode seeding \n");

            $productionSeeders = $this->getProductionModeSeeders();
            $developmentSeeders = $this->getDevelopmentModeSeeders();

            $seeders = array_merge($productionSeeders, $developmentSeeders);

            $this->call($seeders);
        }
    }

    public function cleanDirectories()
    {
        echo ("Cleaning Directories\n");
        $file = new Filesystem;

        $file->cleanDirectory('storage/app/public/customer');
        $file->cleanDirectory('storage/app/public/mainSlider');
        $file->cleanDirectory('storage/app/public/walkthrough');
        $file->cleanDirectory('storage/app/public/dance');
        $file->cleanDirectory('storage/app/public/artist');
        $file->cleanDirectory('storage/app/public/course');
    }

    public function getProductionModeSeeders()
    {
        return [
            TruncateAllTables::class,
            PassportSeeder::class,
            RolesTableSeeder::class,
            UserSeeder::class,
            WalkthroughSeeder::class,
            StaticPageSeeder::class,
        ];
    }

    public function getDevelopmentModeSeeders()
    {
        return [
            CustomerSeeder::class,
            CustomerNotificationSeeder::class,
            MainSliderSeeder::class,
            DanceSeeder::class,
            CustomerInterestSeeder::class,
            SubscriptionSeeder::class,
            ArtistSeeder::class,
            CourseSeeder::class,
            FavoriteSeeder::class,
            CustomerSubscriptionSeeder::class,
            CouponSeeder::class,
            OrderSeeder::class,
            CustomerCourseSeeder::class,
            AppointmentSeeder::class,
            ReviewSeeder::class,
            CourseProgressSeeder::class,
            DialogSeeder::class,
            ArtistAvailableTimeSeeder::class
        ];
    }
}
