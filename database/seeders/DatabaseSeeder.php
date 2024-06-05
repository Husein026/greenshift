<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Instructors;
use App\Models\Login;
use App\Models\Package;
use App\Models\User;
use Database\Factories\LoginFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Manager;
use Illuminate\Tests\Integration\Queue\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Package::factory(10)->create();
        // Roles hardcoded
        $roles = [
            ['roleName' => 'Instructor'],
            ['roleName' => 'Student'],
            ['roleName' => 'Manager'],
        ];
        // Insert roles into the roles table
        DB::table('roles')->insert($roles);

        //TEST DATA
        $team = ['instructor', 'student', 'manager'];
        $x = 0;
        foreach($team as $user){
            $x++;
            $login = login::create([
                    'id' => $x,
                    'email' => str_replace(" ", "", $user) . '@localhost',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
                    'FKRoleId' => $x,
                ]);

            if ($user == 'instructor') {
                $instructor = Instructors::create([
                    'FKLoginId' => 1,
                    'firstname' => $user,
                    'insertion' => null,
                    'lastname' => 'Test',
                    'IsActive' => 1
                ]);
                for($y = 0; $y < 2; $y++) {

                    $firstname = fake()->firstName();
                    $lastname = fake()->lastName();
                    $email =  substr($firstname, 0, 1) . '.' . $lastname;

                    $login = login::create([
                        'id' => 14 + $y,
                        'email' => $email . '@localhost',
                        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
                        'FKRoleId' => $x,
                    ]);
                    $instructor = Instructors::create([
                        'FKLoginId' => 14 + $y,
                        'firstname' => $firstname,
                        'insertion' => null,
                        'lastname' => $lastname,
                        'IsActive' => 1
                    ]);
                }


            }
            if ($user == 'student') {
                $student = User::create([
                    'FKLoginId' => 2,
                    'firstname' => $user,
                    'insertion' => null,
                    'lastname' => 'Test',
                    'phone' => fake()->phoneNumber(),
                    'bankaccountnumber' => fake()->iban(),
                    'instructor_id' => 1,
                    'city' => 'Amsterdam',
                    'address' => 'straat',
                    'huisnumber' => '1',
                    'postcode' => '1234AB',
                    'dateOfBirth' => fake()->date(),
                ]);
            for ($y = 0; $y < 10; $y++) {



                $firstname = fake()->firstName();
                $lastname = fake()->lastName();
                $email =  substr($firstname, 0, 1) . '.' . $lastname;

                $login = login::create([
                    'id' => 4 + $y,
                    'email' => $email . '@localhost',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
                    'FKRoleId' => $x,
                ]);
                $student = User::create([
                    'FKLoginId' => 4 + $y,
                    'firstname' => $firstname,
                    'insertion' => null,
                    'lastname' => $lastname,
                    'phone' => fake()->phoneNumber(),
                    'bankaccountnumber' => fake()->iban(),
                    'instructor_id' => 1,
                    'city' => fake()->city(),
                    'address' => fake()->streetName(),
                    'huisnumber' => fake()->numberBetween(1, 256),
                    'postcode' => fake()->numberBetween(1234, 9999) . fake()->randomLetter() . fake()->randomLetter() ,
                    'dateOfBirth' => fake()->date(),
                ]);

            }


            }
            if ($user == 'manager') {
                $manager = \App\Models\Manager::create([
                    'FKLoginId' => 3,
                ]);

            }


        }


    }
}
