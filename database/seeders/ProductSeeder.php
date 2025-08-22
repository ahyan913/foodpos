<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;

class ProductSeeder extends BaseSeeder
{

    const SIZE = 30;

    public $image = [
        "breakfast-a.jpeg",
        "breakfast-b.jpg",
        "breakfast-c.jpeg",
        "hot-coffee.png",
        "cold-coffee.jpeg",
        "hot-lemon-tea.jpeg",
        "cold-lemon-tea.jpeg",
        "hot-horlicks.jpeg",
        "ice-horlick.jpeg",
        "hot-milk-tea.jpeg",
        "cold-milk-tea.jpeg"
    ];

    public $locale = [
        "en_US"=>[
            "Breakfast A",
            "Breakfast B",
            "Breakfast C",
            "Hot Coffee",
            "Cold Coffee",
            "Hot Lemon Tea",
            "Cold Lemon Tea",
            "Hot Horlick",
            "Cold Horlick",
            "Hot Milk Tea",
            "Cold Milk Tea"
        ],
        "zh_HK"=>[
            "早餐A",
            "早餐B",
            "早餐C",
            "熱咖啡",
            "凍咖啡",
            "熱檸茶",
            "凍檸茶",
            "熱好立克",
            "凍好立克",
            "熱奶茶",
            "凍奶茶",
        ]
    ];



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = $this->localeFakers["zh_HK"];

        $size = self::SIZE;
        $size = count($this->image);

        for($i=0; $i < $size; $i++){
            $locale = [];
            foreach($this->localeCodes as $localeCode){
                $locale[$localeCode] = [
                    "name"=>$this->locale[$localeCode][$i],
                    "description"=>$this->localeFakers[$localeCode]->paragraph()
                ];
            }

            Product::create([
                "name"=>$this->locale["zh_HK"][$i],
                //"sku"=>$faker->regexify('[A-Z0-9]{6}'),
                "price"=>number_format(mt_rand(12, 80), 2),
                //"image"=>basename($faker->image(public_path("images/product"), 360, 360, "animals")),
                "image"=>$this->image[$i],
                "status"=>1,
                "locale"=>$locale,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s"),
            ]);
        }

    }


}
