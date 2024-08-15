<?php

namespace Modules\Reminder\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Reminder\app\Models\Phone;
use Modules\Reminder\app\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $contact = Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'created_by'=>1,
        ]);

        $phones =['123456789033','12345678903','123456789022'];
        foreach($phones as $phone)
        {
            Phone::create([
                'phone'=>$phone,
                'contact_id'=>$contact->id,
                'created_by'=>1,
            ]);
        }

        $contact2 = Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'created_by'=>1,
        ]);

        $phones2 =['123456789032','123456789024'];
        foreach($phones2 as $phone2)
        {
            Phone::create([
                'phone'=>$phone2,
                'contact_id'=>$contact2->id,
                'created_by'=>1,
            ]);
        }
    }
}
