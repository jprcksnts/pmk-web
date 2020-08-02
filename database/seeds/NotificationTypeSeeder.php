<?php

use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('notification_types')->insert([
            [
                'type' => 'New Job Applicant',
                // Receiver is employer (new job applicant)
            ],
            [
                'type' => 'Job Application Update',
                // Receiver is employee (placed under review)
            ],
            [
                'type' => 'Job Offer Received',
                // Receiver is employee (job offer received)
            ],
            [
                'type' => 'Job Offer Accepted',
                // Receiver is employer (job offer is accepted)
            ],
            [
                'type' => 'Job Offer Declined',
                // Receiver is employer (job offer is declined)
            ]
        ]);
    }
}
