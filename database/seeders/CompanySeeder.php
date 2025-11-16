<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create directory for logos if not exists
        Storage::disk('public')->makeDirectory('logos');

        for ($i = 1; $i <= 20; $i++) {
            // Generate dummy logo file name
            $logoFile = 'logos/company_' . $i . '.png';

            // Create a placeholder logo file (optional)
            $placeholder = file_get_contents('https://placehold.co/150x150.png?text=Logo+' . $i);
            Storage::disk('public')->put($logoFile, $placeholder);

            Company::create([
                'name' => $faker->company,
                'email' => $faker->unique()->companyEmail,
                'phone_1' => $faker->phoneNumber,
                'phone_2' => $faker->phoneNumber,
                'logo' => 'storage/' . $logoFile,
                'fax' => $faker->phoneNumber,
                'website' => $faker->url,
                'owner' => $faker->name,
                'source' => $faker->randomElement(['Website', 'Referral', 'Social Media', 'Cold Call']),
                'industry' => $faker->randomElement(['IT', 'Manufacturing', 'Retail', 'Finance', 'Healthcare']),
                'tags' => implode(',', $faker->words(3)),
                'description' => $faker->paragraph,
                'address' => $faker->address,
                'country' => $faker->country,
                'state' => $faker->state,
                'city' => $faker->city,
                'zipcode' => $faker->postcode,
                'facebook_url' => 'https://facebook.com/' . $faker->userName,
                'linkedin_url' => 'https://linkedin.com/company/' . $faker->userName,
                'instagram_url' => 'https://instagram.com/' . $faker->userName,
                'whatsapp_url' => 'https://wa.me/' . $faker->numerify('91##########'),
                'created_by' => 1, // change as per your user ID
                'updated_by' => 1,
            ]);
        }
    }
}
