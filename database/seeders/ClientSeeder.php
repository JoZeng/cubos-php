<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        // Substitua pelo ID real de um usuário existente
        $userId = DB::table('users')->first()?->id;

        if (!$userId) {
            echo "Nenhum usuário encontrado. Crie um usuário antes de rodar o seeder.\n";
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            Client::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'cpf' => $faker->unique()->cpf(false),
                'phone' => $faker->phoneNumber,
                'address' => $faker->streetAddress,
                'complement' => $faker->secondaryAddress,
                'cep' => $faker->postcode,
                'neighborhood' => $faker->streetName,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'user_id' => $userId
            ]);
        }
    }
}
