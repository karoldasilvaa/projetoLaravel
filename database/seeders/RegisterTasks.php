<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Task;

class RegisterTasks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create ([
            'title' => 'Ir no mercado',
            'description' => 'Fazer compras pro natal',
            'image' => 'tarefa.png',
            'date' => '2024-12-23',
            'user_id' => 1,
            'status_id' => 1,
        ]);

        Task::create ([
            'title' => 'Comprar Livro',
            'description' => 'Lançamento em janeiro',
            'image' => 'tarefa.png',
            'date' => '2024-01-05',
            'user_id' => 1,
            'status_id' => 2,
        ]);

        Task::create ([
            'title' => 'Estudar para a prova',
            'description' => 'Prova de C#',
            'image' => 'tarefa.png',
            'date' => '2024-11-30',
            'user_id' => 1,
            'status_id' => 3,
        ]);

        Task::create ([
            'title' => 'Organizar Finanças Pessoais',
            'description' => 'Organizar as contas',
            'image' => 'tarefa.png',
            'date' => '2024-11-28',
            'user_id' => 1,
            'status_id' => 1,
        ]);
        
        Task::create ([
            'title' => 'Fazer Manutenção no Carro',
            'description' => 'Agendar manutenção preventiva',
            'image' => 'tarefa.png',
            'date' => '2024-12-15',
            'user_id' => 1,
            'status_id' => 2,
        ]);
    }
}
