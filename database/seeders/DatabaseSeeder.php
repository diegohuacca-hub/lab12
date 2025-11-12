<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Nota;
use App\Models\recordatorio;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user1 = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
        ]);

        $note1 = Nota::create([
            'user_id' => $user1->id,
            'titulo' => 'Meeting Notes',
            'contenido' => 'Prepare for project meeting.',
        ]);
        $note1->recordatorio()->create(['fecha_vencimiento' => now()->addDays(2)]);

        $note2 = Nota::create([
            'user_id' => $user1->id,
            'titulo' => 'Grocery List',
            'contenido' => 'Buy milk and eggs.',
        ]);
        $note2->recordatorio()->create(['fecha_vencimiento' => now()->addHours(5)]);

        $note3 = Nota::create([
            'user_id' => $user2->id,
            'titulo' => 'Study Plan',
            'contenido' => 'Review Laravel Eloquent.',
        ]);
        $note3->recordatorio()->create([
            'fecha_vencimiento' => now()->subDay(),
            'completado' => true,
        ]);
    }
}
