<?php

use App\Models\StaticPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(StaticPage::class, 3)->create();

        StaticPage::find(1)->update([
            'key' => 'terms_and_conditions'
        ]);
        StaticPage::find(2)->update([
            'key' => 'privacy_policy'
        ]);
        StaticPage::find(3)->update([
            'key' => 'about'
        ]);

        $static_page_translations_rows = [
            ['id' => 1, 'static_page_id' => 1, 'locale' => 'en', 'title' => 'Terms and conditions'],
            ['id' => 2, 'static_page_id' => 1, 'locale' => 'ar', 'title' => 'الشروط و الأحكام'],
            ['id' => 3, 'static_page_id' => 2, 'locale' => 'en', 'title' => 'Privacy Policy'],
            ['id' => 4, 'static_page_id' => 2, 'locale' => 'ar', 'title' => 'سياسة الخصوصيه'],
            ['id' => 5, 'static_page_id' => 3, 'locale' => 'en', 'title' => 'About'],
            ['id' => 6, 'static_page_id' => 3, 'locale' => 'ar', 'title' => 'من نحن'],
        ];

        DB::table('static_page_translations')->insert($static_page_translations_rows);

        DB::table('static_page_translations')->update([
            'content' => 'Put any text here',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
