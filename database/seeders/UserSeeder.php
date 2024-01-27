<?php

namespace Database\Seeders;

use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'firstname' => 'Jan',
                'lastname' => 'Kowalski',
                'email' => 'jk@example.com',
                'password' => Hash::make('asd123'),
                'role' => UserRole::ADMIN->value,
                'status' => UserStatus::ACTIVE->value,
                'created_at' => '2020-01-01 12:09:14',
                'updated_at' => '2020-01-01 14:06:12',
                'last_login_at' => '2024-04-25 22:38:38'
            ],
            [
                'firstname' => 'Olga',
                'lastname' => 'Tokarczuk',
                'email' => 'ot@example.com',
                'password' => Hash::make('536012413'),
                'role' => UserRole::USER->value,
                'status' => UserStatus::INACTIVE->value,
                'created_at' => '2020-01-19 22:49',
                'updated_at' => '2021-06-07 14:03:00',
                'last_login_at' => '2021-04-29 14:18:16'
            ],
            [
                'firstname' => 'Eliza',
                'lastname' => 'Orzeszkowa',
                'email' => 'ez@example.com',
                'password' => Hash::make('502540569'),
                'role' => UserRole::USER->value,
                'status' => UserStatus::INACTIVE->value,
                'created_at' => '2020-02-06 21:28:00',
                'updated_at' => '2021-07-01 17:33:21',
                'last_login_at' => '2021-03-01 14:25:00'
            ],
            [
                'firstname' => 'Maria',
                'lastname' => 'Konopnicka',
                'email' => 'mk@example.com',
                'password' => Hash::make('536961969'),
                'role' => UserRole::USER->value,
                'status' => UserStatus::INACTIVE->value,
                'created_at' => '2020-02-23 10:04:35',
                'updated_at' => '2020-09-02 11:12:26',
                'last_login_at' => '2020-09-07 15:01:41'
            ],
            [
                'firstname' => 'Henryk',
                'lastname' => 'Sienkiewicz',
                'email' => 'hs@example.com',
                'password' => Hash::make('692959475'),
                'role' => UserRole::USER->value,
                'status' => UserStatus::ACTIVE,
                'created_at' => '2021-07-01 21:05:08',
                'updated_at' => '2021-10-01 16:26:51',
                'last_login_at' => '2024-03-02 18:42:24'
            ],
            [
                'firstname' => 'Adam',
                'lastname' => 'Mickiewicz',
                'email' => 'am@example.com',
                'password' => Hash::make('518378896'),
                'role' => UserRole::USER->value,
                'status' => UserStatus::ACTIVE,
                'created_at' => '2021-07-01 21:06:55',
                'updated_at' => '2021-07-01 21:07:06',
                'last_login_at' => '2024-03-28 15:56:48'
            ],
            [
                'firstname' => 'User',
                'lastname' => 'Example',
                'email' => 'ue@example.com',
                'password' => Hash::make('987654321'),
                'role' => UserRole::USER->value,
                'status' => UserStatus::INACTIVE->value,
            ],
            [
                'firstname' => 'Guest',
                'lastname' => 'Example',
                'email' => 'ge@example.com',
                'password' => Hash::make('987654321'),
                'role' => UserRole::GUEST,
                'status' => UserStatus::INACTIVE->value,
            ]
        ]);
    }
}
