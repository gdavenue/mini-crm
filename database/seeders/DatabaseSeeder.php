<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manager']);

        $user = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('e9xfZ4X=5]Ep'),
        ]);
        $user->assignRole('admin');

        $customers = Customer::factory(10)->create();

        $customers->each(function ($customer) {
            Ticket::factory(rand(1, 3))->create([
                'customer_id' => $customer->id,
            ])->each(function (Ticket $ticket) {
                foreach (range(1, rand(1, 3)) as $i) {
                    $fileName = Str::random(8) . '.txt';
                    $content = fake()->paragraphs(rand(2, 5), true);

                    $tmpPath = storage_path("app/tmp/{$fileName}");
                    if (!is_dir(dirname($tmpPath))) {
                        mkdir(dirname($tmpPath), 0777, true);
                    }
                    file_put_contents($tmpPath, $content);

                    $ticket->addMedia($tmpPath)->usingFileName($fileName)->toMediaCollection('attachments');
                }
            });
        });
    }
}
