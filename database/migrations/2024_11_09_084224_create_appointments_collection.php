<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Client;

class CreateAppointmentsCollection extends Migration
{
    public function up()
    {
        $client = new Client(env('MONGODB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE', 'bullyproof'));

        try {
            $database->dropCollection('appointments');
        } catch (Exception $e) {
        }

        $database->createCollection('appointments', [
            'validator' => [
                '$jsonSchema' => [
                    'bsonType' => 'object',
                    'required' => [
                        'respondent_name',
                        'respondent_email',
                        'complainant_name',
                        'complainant_email',
                        'appointment_date',
                        'appointment_start_time',
                        'appointment_end_time',
                        'status',
                        'created_at',
                        'updated_at'
                    ],
                    'properties' => [
                        'respondent_name' => [
                            'bsonType' => 'string',
                            'description' => 'Name of the respondent - required'
                        ],
                        'respondent_email' => [
                            'bsonType' => 'string',
                            'pattern' => '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$',
                            'description' => 'Email of the respondent - required'
                        ],
                        'complainant_name' => [
                            'bsonType' => 'string',
                            'description' => 'Name of the complainant - required'
                        ],
                        'complainant_email' => [
                            'bsonType' => 'string',
                            'pattern' => '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$',
                            'description' => 'Email of the complainant - required'
                        ],
                        'appointment_date' => [
                            'bsonType' => 'date',
                            'description' => 'Date of the appointment - required'
                        ],
                        'appointment_start_time' => [
                            'bsonType' => 'string',
                            'pattern' => '^([1-9]|1[0-2]):[0-5][0-9]\s(AM|PM)$', 
                            'description' => 'Start time of the appointment - required in 12-hour format (e.g., 11:00 AM)'
                        ],
                        'appointment_end_time' => [
                            'bsonType' => 'string',
                            'pattern' => '^([1-9]|1[0-2]):[0-5][0-9]\s(AM|PM)$', 
                            'description' => 'End time of the appointment - required in 12-hour format (e.g., 02:30 PM)'
                        ],
                        'status' => [
                            'bsonType' => 'string',
                            'enum' => ['Waiting For Confirmation', 'Approved', 'Cancelled', 'Missed', 'Done'],
                            'description' => 'Status of the appointment'
                        ],
                        'created_at' => [
                            'bsonType' => 'date',
                            'description' => 'Timestamp of creation - required'
                        ],
                        'updated_at' => [
                            'bsonType' => 'date',
                            'description' => 'Timestamp of last update - required'
                        ]
                    ]
                ]
            ],
            'validationAction' => 'error'
        ]);

        $collection = $database->appointments;
        $collection->createIndex(['appointment_date' => 1]);
        $collection->createIndex(['appointment_start_time' => 1]);
        $collection->createIndex(['appointment_end_time' => 1]);
        $collection->createIndex(['respondent_email' => 1]);
        $collection->createIndex(['complainant_email' => 1]);
        $collection->createIndex(['status' => 1]);
    }

    public function down()
    {
        $client = new Client(env('MONGODB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE', 'bullyproof'));
        $database->dropCollection('appointments');
    }
}
