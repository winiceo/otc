<?php



use Illuminate\Database\Seeder;

class PackagesSeeder extends Seeder
{
    /**
     * Run the seeder in packages.
     *
     * @return void
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function run()
    {
        $this->call(\Genv\PlusCheckIn\Seeds\DatabaseSeeder::class);
        $this->call(\Genv\Plus\Packages\News\Seeds\DatabaseSeeder::class);
        $this->call(\Genv\Plus\Packages\Feed\Seeds\DatabaseSeeder::class);
        $this->call(\Genv\Otc\Packages\Music\Seeds\DatabaseSeeder::class);
    }
}
