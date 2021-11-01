<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dataweb;
use App\Models\Stopword;
use App\Models\Taghtml;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create()

        User::create([
            'username' => 'rangga',
            'password' => bcrypt('password'),
        ]);

        Dataweb::create([
            'nama' => 'Klikkalteng',
            'url' => 'https',
            'url_img' => 'http',
        ]);

        //Seeder Data Dari Csv Untuk Stopword

        Stopword::truncate();
  
        $csvFileStopword = fopen(base_path("database/data/Stopword.csv"), "r");
  
        $firstlineStopword = true;
        while (($data = fgetcsv($csvFileStopword, 2000, ",")) !== FALSE) {
            if (!$firstlineStopword) {
                Stopword::create([
                    "stopword"      => $data['0'],
                    "id"        => $data['1'],
                    "created_at"    => $data['2'],
                    "updated_at"    => $data['3']
                ]);    
            }
            $firstlineStopword = false;
        }
   
        fclose($csvFileStopword);
        
        // 

        Taghtml::truncate();
  
        $csvFileTaghtml = fopen(base_path("database/data/Taghtml.csv"), "r");
  
        $firstlineTaghtml = true;
        while (($data = fgetcsv($csvFileTaghtml, 2000, ",")) !== FALSE) {
            if (!$firstlineTaghtml) {
                Taghtml::create([
                    "id"      => $data['0'],
                    "taghtml"        => $data['1'],
                    "created_at"    => $data['2'],
                    "updated_at"    => $data['3']
                ]);    
            }
            $firstlineTaghtml = false;
        }
   
        fclose($csvFileTaghtml);
    
    }
}
