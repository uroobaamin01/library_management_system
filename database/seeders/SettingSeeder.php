<?php

namespace Database\Seeders;

use App\Models\DashboardStatistic;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Central Academic Library Management System', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_email', 'value' => 'admin@library.com', 'group' => 'general', 'type' => 'email'],
            ['key' => 'site_phone', 'value' => '+1 (800) 555-0199', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_address', 'value' => '742 Evergreen Terrace, University Campus, Building B', 'group' => 'general', 'type' => 'textarea'],
            ['key' => 'timezone', 'value' => 'UTC', 'group' => 'general', 'type' => 'text'],
            ['key' => 'theme_mode', 'value' => 'light', 'group' => 'appearance', 'type' => 'text'],
            ['key' => 'currency_symbol', 'value' => '$', 'group' => 'financial', 'type' => 'text'],
            ['key' => 'default_max_issue_limit', 'value' => '5', 'group' => 'rules', 'type' => 'number'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Initialize dynamic dashboard statistic entries
        $metrics = [
            'total_books',
            'available_copies',
            'issued_books',
            'lost_books',
            'total_authors',
            'total_categories',
            'total_publishers',
            'total_languages',
            'total_shelves',
            'total_racks',
            'registered_students',
            'active_librarians',
            'overdue_books',
            'returned_today',
            'pending_requests',
        ];

        foreach ($metrics as $metric) {
            DashboardStatistic::updateOrCreate(
                ['metric_key' => $metric],
                ['metric_value' => 0, 'last_calculated_at' => now()]
            );
        }
    }
}