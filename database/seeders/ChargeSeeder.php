<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Charge;
use App\Models\Client;
use Faker\Factory as Faker;

class ChargeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        $clients = Client::all();

        foreach ($clients as $client) {
            // Cada cliente recebe entre 2 e 5 cobranças
            $numCharges = rand(2, 5);

            for ($i = 0; $i < $numCharges; $i++) {
                Charge::create([
                    'client_id' => $client->id,
                    'description' => $faker->sentence(3),
                    'expiration' => $faker->dateTimeBetween('-2 months', '+2 months')->format('Y-m-d'),
                    'value' => $faker->randomFloat(2, 50, 500),
                    'status' => $faker->randomElement(['pendente', 'paga'])
                ]);
            }
        }
    }
}
