<?php

namespace Database\Seeders;

use App\Models\CustomerFeedback;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'pryvstfpedrera@gmail.com'],
            [
                'name' => 'Praisty Resort Administrator',
                'date_of_birth' => '2000-05-30',
                'staff_identifier' => 'pryvstfpedrera@gmail.com',
                'is_admin' => true,
                'two_factor_code' => Hash::make('053008'),
                'password' => Hash::make('Kruzo0530'),
            ],
        );

        $guest = User::updateOrCreate(
            ['email' => 'guest@praisty.test'],
            [
                'name' => 'Sample Praisty Guest',
                'date_of_birth' => '1999-01-15',
                'is_admin' => false,
                'password' => Hash::make('password123'),
            ],
        );

        $reservation = Reservation::updateOrCreate(
            ['reference' => 'PR-2026-10001'],
            [
                'user_id' => $guest->id,
                'guest_name' => $guest->name,
                'guest_email' => $guest->email,
                'phone' => '+63 995 527 1898',
                'country' => 'Philippines',
                'room_slug' => 'royal-overwater-bungalow',
                'room_name' => 'Royal Overwater Bungalow',
                'check_in' => now()->addDays(7)->toDateString(),
                'check_out' => now()->addDays(10)->toDateString(),
                'guests' => 2,
                'nights' => 3,
                'stay_total' => 285000,
                'resort_fee' => 14250,
                'taxes' => 25650,
                'grand_total' => 324900,
                'payment_method' => 'card',
                'status' => 'processing',
            ],
        );

        CustomerFeedback::updateOrCreate(
            ['reference' => $reservation->reference, 'email' => $guest->email],
            [
                'user_id' => $guest->id,
                'reservation_id' => $reservation->id,
                'name' => $guest->name,
                'rating' => 5,
                'message' => 'The sample local database is working. This feedback appears in the admin feedback page.',
            ],
        );

        unset($admin);
    }
}
