<?php
namespace App\Services;
use App\Models\Type;
use App\Helper\ImageHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TypeSaveService
{
    protected Type $type;
    protected $uploadedImage;

    public function __construct(Type $type = null)
    {
        $this->type = is_null($type) ? new Type() : $type;
    }

    public function initByRequest(Request $request, ){
        $this->type->name = $request->input("name");
        $this->type->status = $request->input("status");
        $this->type->locale = $request->input("locale");
        $this->uploadedImage = $request->file("image");
        return $this;
    }

    public function uploadImage(){
        if($this->uploadedImage){
            $filename = time().".".$this->uploadedImage->extension();
            $srcPath = public_path("images/product_type/")."/".$filename;
            ImageHelper::upload($this->uploadedImage, $srcPath);
            $this->type->image = $filename;
        }
        return $this;
    }

    public function save(){
        try{
            DB::beginTransaction();
            $this->type->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
