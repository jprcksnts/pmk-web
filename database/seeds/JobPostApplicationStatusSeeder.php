<?php

use Illuminate\Database\Seeder;

class JobPostApplicationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('job_post_application_statuses')->insert([
            [
                'status' => 'Pending',
            ],
            [
                'status' => 'Under Review',
            ],
            [
                'status' => 'Sent Job Offer',
            ],
            [
                'status' => 'Hired',
            ],
            [
                'status' => 'Rejected',
            ],
            [
                'status' => 'Cancelled',
            ],
            [
                'status' => 'Retracted',
            ],
        ]);
    }
}
