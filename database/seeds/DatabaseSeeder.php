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
        // $this->call(UserSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(EducationLevelSeeder::class);
        $this->call(JobPostStatusSeeder::class);
        $this->call(JobPostApplicationStatusSeeder::class);
        $this->call(JobOfferStatusSeeder::class);
        $this->call(EmployeeReviewTypeSeeder::class);
        $this->call(NotificationTypeSeeder::class);
    }
}
