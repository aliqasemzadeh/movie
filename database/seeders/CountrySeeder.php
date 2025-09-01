<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\VideoSystem\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            'Iran',
            'Turky',
            'India',
            'United States',
            'Brazil',
            'Portugal',
            'France',
            'Germany',
            'United Kingdom',
            'Ireland',
            'Spain',
            'South Korea',
            'Canada',
            'Estonia',
            'Iceland',
            'Sweden',
            'Panama',
            'Romania',
        ];

        foreach ($countries as $name) {
            Country::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
