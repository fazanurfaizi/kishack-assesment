<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = collect(['Create', 'Update', 'Show', 'Delete', 'List']);
        $resources = collect(['Users', 'Articles']);

        $resources->each(function($resource) use ($actions) {
            $actions->each(
                fn ($action) => Permission::create([
                    'name' => "$action $resource",
                    'slug' => Str::slug("$action $resource")
                ])
            );
        });
    }
}
