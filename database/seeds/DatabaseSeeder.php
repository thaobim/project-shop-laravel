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
        //cần viết theo thứ tự bảng chính trc bảng phụ sau
        $this->call(Users::class);
        $this->call(Category::class);
        $this->call(Order::class);
        $this->call(Product::class);
        $this->call(ProductOrder::class);
        $this->call(info::class);
    }
}
