<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // 以下を追記
        $this->call(ArticlesTableSeeder::class);
        $this->call(SalesTableSeeder::class);
    }
}
