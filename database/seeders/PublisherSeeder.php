<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishers = [
            [
                'name' => 'Prentice Hall',
                'slug' => 'prentice-hall',
                'email' => 'info@prenticehall.com',
                'phone' => '+1 (800) 922-0579',
                'address' => 'Upper Saddle River, New Jersey, United States',
            ],
            [
                'name' => 'O\'Reilly Media',
                'slug' => 'oreilly-media',
                'email' => 'orders@oreilly.com',
                'phone' => '+1 (707) 827-7000',
                'address' => '1005 Gravenstein Highway North, Sebastopol, CA 95472',
            ],
            [
                'name' => 'Addison-Wesley',
                'slug' => 'addison-wesley',
                'email' => 'contact@addison-wesley.com',
                'phone' => '+1 (617) 848-6000',
                'address' => 'Boston, Massachusetts, United States',
            ],
            [
                'name' => 'Penguin Books',
                'slug' => 'penguin-books',
                'email' => 'support@penguin.co.uk',
                'phone' => '+44 20 7840 8000',
                'address' => '80 Strand, London WC2R 0RL, United Kingdom',
            ],
        ];

        foreach ($publishers as $publisher) {
            Publisher::updateOrCreate(
                ['slug' => $publisher['slug']],
                array_merge($publisher, ['status' => 'active', 'created_by' => 1])
            );
        }
    }
}