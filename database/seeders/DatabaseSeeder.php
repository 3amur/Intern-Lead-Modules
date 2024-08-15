<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nwidart\Modules\Facades\Module;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);

        foreach (Module::allEnabled() as $module) {
            //            Artisan::call("module:seed ".$module->getName());
            $moduleName = $module->getName();
            if (file_exists(base_path("Modules/$moduleName/database/seeders/{$moduleName}DatabaseSeeder.php"))) {
                $this->call("\\Modules\\$moduleName\\database\\seeders\\{$moduleName}DatabaseSeeder");
            }
        }
    }
}
