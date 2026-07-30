<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['code' => 'jawa',        'name' => 'Bahasa Jawa',        'style_file' => 'jawa.txt'],
            ['code' => 'sunda',       'name' => 'Bahasa Sunda',       'style_file' => 'sunda.txt'],
            ['code' => 'minangkabau', 'name' => 'Bahasa Minangkabau', 'style_file' => 'minangkabau.txt'],
            ['code' => 'bali',        'name' => 'Bahasa Bali',        'style_file' => 'bali.txt'],
            ['code' => 'bugis',       'name' => 'Bahasa Bugis',       'style_file' => 'bugis.txt'],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(['code' => $lang['code']], $lang);
        }
    }
}