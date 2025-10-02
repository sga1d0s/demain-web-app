<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('work_orders')->insert([
            [
                'title' => 'Instalación de impresora',
                'description' => 'Instalar y configurar impresora en oficina 3',
                'assigned_to' => 1, // id de usuario técnico
                'status' => 'pendiente',
                'due_date' => now()->addDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Revisión servidor',
                'description' => 'Verificar logs y actualizar parches de seguridad',
                'assigned_to' => 2,
                'status' => 'en_progreso',
                'due_date' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cambio de switch de red',
                'description' => 'Sustituir switch defectuoso en planta 2',
                'assigned_to' => null, // todavía sin técnico
                'status' => 'pendiente',
                'due_date' => now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
