<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Menu;
// use App\Models\MenuToType;

class Store extends Model
{
    use HasFactory;
    public $table = "store";
    public $fillable = ["status","latitude", "longitude", "capacity", "opening_hours","weekdays", "exclude_dates", "locale"];
    protected $localeData = array();
    protected $casts = ["locale"=>"array"];
    protected $appends = ['image_url'];

    public function getImagePath($fileName = ""){
        return public_path("images/store/$fileName");
    }

    public function getImageUrlAttribute(){

        return url("/images/store/".$this->image);

    }

    public function getLocaleValue($locale, $key){

        return isset($this->localeData[$locale][$key]) ? $this->localeData[$locale][$key]: "";
    }

    public function tables(){
        return $this->hasMany(Table::class, "store_id", "id");
    }

    // public function menus(){
    //     return $this->belongsToMany(Menu::class, StoreToMenu::TABLE, "store_id", "menu_id");
    // }

    // public function getMenuIds(){
    //     return $this->menus->pluck("id")->toArray();
    // }

    public function removeImages(){
        foreach([$this->image, $this->getThumbnail()] as $img){
            if($img && $this->getImagePath($img))
                @unlink($this->getImagePath($img));
        }
    }

    public function getEditUrl(){
        $uri = env("ADMIN_URI", "administrator");
        return url("$uri/store/".$this->id);
    }

    public function getImageUrl(){
        return url("images/store/".$this->image);
    }

    public function getThumbnail(){

        if($this->image){
            try{
                list($name, $extension) = explode(".", $this->image);
                return "$name@2x.$extension";
            }catch(\Throwable $t){}
        }
        return null;

    }
}
