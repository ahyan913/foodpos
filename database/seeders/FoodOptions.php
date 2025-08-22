<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OptionGroup;
use App\Models\Constant\OptionType;
use App\Models\Constant\Status;
use App\Models\Option;
use App\Models\ProductOption;
use App\Models\ProductOptionGroups;

class FoodOptions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $optionGroup = new OptionGroup();
        $optionGroup->name = "套餐飲品";
        $optionGroup->locale = json_decode('{"en_US": {"name": "Combo Drinks"}, "zh_HK": {"name": "套餐飲品"}}', true);
        $optionGroup->limit = 1;
        $optionGroup->type = OptionType::PRODUCT;
        $optionGroup->status = Status::ACTIVE;
        $optionGroup->sort_order = 1;
        $optionGroup->save();

        $sortOrder = 1;
        for($i=4; $i<=11; $i++){

            $productOption = new ProductOption();
            $productOption->option_group_id = $optionGroup->id;
            $productOption->product_id = $i;
            $productOption->price = 0.00;
            $productOption->status = Status::ACTIVE;
            $productOption->sort_order = $sortOrder++;
            $productOption->save();
        }

        for($i=1; $i<=3; $i++){

            $productOption = new ProductOptionGroups();
            $productOption->product_id = $i;
            $productOption->option_group_id = $optionGroup->id;
            $productOption->sort_order = 4;
            $productOption->save();
        }

        $optionGroup = new OptionGroup();
        $optionGroup->name = "冰份量";
        $optionGroup->locale = json_decode('{"en_US": {"name": "Ice Portion"}, "zh_HK": {"name": "冰份量"}}', true);
        $optionGroup->limit = 1;
        $optionGroup->type = OptionType::NORMAL;
        $optionGroup->status = Status::ACTIVE;
        $optionGroup->sort_order = 1;
        $optionGroup->save();

        $locales = ['{"en_US": "no milk", "zh_HK": "走冰"}', '{"en_US": "less milk", "zh_HK": "正常"}', '{"en_US": "extra milk", "zh_HK": "多冰"}'];
        foreach($locales as $index => $locale){

            $option = new Option();
            $option->option_group_id = $optionGroup->id;
            $option->locale = json_decode($locale, true);
            $option->price = 0.00;
            $option->status = Status::ACTIVE;
            $option->sort_order = $index;
            $option->save();

        }

        foreach([5,7,9,11] as $i){

            $productOption = new ProductOptionGroups();
            $productOption->product_id = $i;
            $productOption->option_group_id = $optionGroup->id;
            $productOption->sort_order = 4;
            $productOption->save();
        }



        $optionGroup = new OptionGroup();
        $optionGroup->name = "牛奶份量";
        $optionGroup->locale = json_decode('{"en_US": {"name": "Milk Portion"}, "zh_HK": {"name": "牛奶份量"}}', true);
        $optionGroup->limit = 1;
        $optionGroup->type = OptionType::NORMAL;
        $optionGroup->status = Status::ACTIVE;
        $optionGroup->sort_order = 1;
        $optionGroup->save();

        $sortOrder = 1;

        $locales = ['{"en_US": "no milk", "zh_HK": "走奶"}', '{"en_US": "less milk", "zh_HK": "少奶"}', '{"en_US": "less milk", "zh_HK": "正常"}', '{"en_US": "extra milk", "zh_HK": "多奶"}'];
        foreach($locales as $index => $locale){

            $option = new Option();
            $option->option_group_id = $optionGroup->id;
            $option->locale = json_decode($locale, true);
            $option->price = 0.00;
            $option->status = Status::ACTIVE;
            $option->sort_order = $index;
            $option->save();

        }

        foreach([4,5,10,11] as $i){

            $productOption = new ProductOptionGroups();
            $productOption->product_id = $i;
            $productOption->option_group_id = $optionGroup->id;
            $productOption->sort_order = 4;
            $productOption->save();
        }

        $optionGroup = new OptionGroup;
        $optionGroup->name = "早餐A - 主餐";
        $optionGroup->locale = json_decode('{"en_US": {"name": "Main Dishes"}, "zh_HK": {"name": "主餐"}}', true);
        $optionGroup->limit = 2;
        $optionGroup->type = OptionType::NORMAL;
        $optionGroup->status = Status::ACTIVE;
        $optionGroup->sort_order = 1;
        $optionGroup->save();

        $locales = ['{"en_US":"Ham Pasta","zh_HK":"\u706b\u817f\u901a\u7c89"}', '{"en_US":"Rice Noodles with Pickled Vegetables and Shredded Pork","zh_HK":"\u96ea\u83dc\u8089\u7d72\u7c73\u7c89"}'];
        $sortOrder = 1;
        foreach($locales as $index => $locale){
            $optionValue = new Option;
            $optionValue->option_group_id = $optionGroup->id;
            $optionValue->price = 0.00;
            $optionValue->locale = json_decode($locale, true);
            $optionValue->status = Status::ACTIVE;
            $optionValue->sort_order = $index;
            $optionValue->save();
        }

        $optionGroup = new OptionGroup();
        $optionGroup->name = "套餐 - 包類";
        $optionGroup->locale = json_decode('{"en_US": {"name": "Bread"}, "zh_HK": {"name": "套餐 - 包類"}}', true);
        $optionGroup->limit = 1;
        $optionGroup->type = OptionType::NORMAL;
        $optionGroup->status = Status::ACTIVE;
        $optionGroup->sort_order = 1;
        $optionGroup->save();

        $locales = ['{"en_US":"Toast","zh_HK":"多士"}', '{"en_US":"Bread","zh_HK":"麵包"}'];
        $sortOrder = 1;
        foreach($locales as $index => $locale){
            $optionValue = new Option;
            $optionValue->option_group_id = $optionGroup->id;
            $optionValue->sort_order = $index;
            $optionValue->status = Status::ACTIVE;
            $optionValue->price = 0;
            $optionValue->locale = json_decode($locale, true);
            $optionValue->save();
        }

        for($i=1; $i<=3; $i++){
            $productOption = new ProductOptionGroups();
            $productOption->product_id = $i;
            $productOption->option_group_id = $optionGroup->id;
            $productOption->sort_order = 2;
            $productOption->save();
        }



        $optionGroup = new OptionGroup;
        $optionGroup->name = "套餐 - 選項";
        $optionGroup->limit = 2;
        $optionGroup->type = OptionType::NORMAL;
        $optionGroup->locale = json_decode('{"en_US": {"name": "Options"}, "zh_HK": {"name": "套餐 - 選項"}}', true);
        $optionGroup->status = Status::ACTIVE;
        $optionGroup->sort_order = 1;
        $optionGroup->save();

        $locales = ['{"en_US":"Sausage","zh_HK":"腸仔"}', '{"en_US":"Egg","zh_HK":"煎蛋"}', '{"en_US":"Baken","zh_HK":"煙肉"}', '{"en_US":"Ham","zh_HK":"火腿"}', '{"en_US":"Pork Chop","zh_HK":"豬排"}', '{"en_US":"Beef","zh_HK":"牛排"}', '{"en_US":"Chicken","zh_HK":"雞排"}', '{"en_US":"Fish Filet","zh_HK":"魚柳"}'];

        foreach($locales as $index => $locale){
            $optionValue = new Option;
            $optionValue->option_group_id = $optionGroup->id;
            $optionValue->sort_order = $index;
            $optionValue->price = mt_rand(0, 5);
            $optionValue->status = Status::ACTIVE;
            $optionValue->locale = json_decode($locale, true);
            $optionValue->save();

        }

        for($i=1; $i<=3; $i++){
            $productOption = new ProductOptionGroups();
            $productOption->product_id = $i;
            $productOption->option_group_id = $optionGroup->id;
            $productOption->sort_order = 3;
            $productOption->save();
        }

    }
}
