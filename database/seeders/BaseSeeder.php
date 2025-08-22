<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuration;

class BaseSeeder extends Seeder
{

    protected $localeFakers = [];
    protected $localeCodes = [];

    public function __construct()
    {

        $this->localeCodes =  Configuration::findByKey("locale_supported") ?? [];

        foreach($this->localeCodes as $localeCode){
            $this->localeFakers[$localeCode] = \Faker\Factory::create($localeCode);
        }

    }

}
