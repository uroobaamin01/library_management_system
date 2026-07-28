<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['name' => 'English', 'code' => 'en', 'status' => 'active'],
            ['name' => 'Spanish', 'code' => 'es', 'status' => 'active'],
            ['name' => 'French', 'code' => 'fr', 'status' => 'active'],
            ['name' => 'German', 'code' => 'de', 'status' => 'active'],
            ['name' => 'Mandarin Chinese', 'code' => 'zh', 'status' => 'active'],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']],
                $language
            );
        }
    }
}