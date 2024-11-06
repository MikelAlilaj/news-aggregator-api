<?php

namespace Database\Seeders;

use App\Models\DataSource;
use Illuminate\Database\Seeder;

class DataSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $timestamp = now();
        $sources = [
            [
                'name' => 'New York Times',
                'service_key' => 'new_york_times',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'NewsAPI',
                'service_key' => 'news_api',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'The Guardian',
                'service_key' => 'guardian',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ];

        DataSource::insert($sources);
    }
}
