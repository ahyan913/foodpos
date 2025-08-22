<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends BaseSeeder
{
    public $image = [
        "store1.jpeg",
        "store2.jpeg"
    ];

    public $stores = [
        "en_US"=>[
            "Hong Kong Store",
            "Kowloon Store"
        ],
        "zh_HK"=>[
            "香港店",
            "九龍店"
        ]
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = $this->localeFakers["zh_HK"];

        for($i=0; $i < count($this->stores); $i++){
            $locale = [];
            foreach($this->localeCodes as $localeCode){
                $locale[$localeCode] = [
                    "name"          =>          $this->stores[$localeCode][$i],
                    "address"       =>          $this->localeFakers[$localeCode]->address(),
                    "description"   =>          $this->localeFakers[$localeCode]->paragraphs()
                ];
            }

            Store::create([
                "name"=>$this->stores["zh_HK"][$i],
                "code"=>$faker->regexify('[A-Z]{2}[0-9]{2}'),
                "phone"=>$faker->regexify('2[0-9]{7}'),
                "image"=>$this->image[$i],
                "status"=>1,
                "locale"=>$locale,
                'latitude'=>mt_rand(2200000, 2250000) / 10000,
                'longitude'=>mt_rand(11400000, 11450000) / 10000,
                "opening_hours"=>1,
                "capacity"=>mt_rand(10, 100),
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"),
            ]);
        }
    }
}
