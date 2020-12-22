<?php

use App\Contact;
use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::truncate();
        for($i = 1; $i<=20; $i++){
            Contact::create([
                'name' => "Pepe $i",
                'surname' => "Pons $i",
                'message' => "Laravel includes a simple method of seeding your database with test data using seed classes. ",
                'email' => 'pepe@mitziweb.com'
            ]);
        }
    }
}
