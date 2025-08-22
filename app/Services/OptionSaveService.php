<?php
namespace App\Services;

use App\Models\OptionGroup;
use Illuminate\Support\Facades\DB;
use App\Models\Constant\OptionType;
use App\Models\ProductOption;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Models\Constant\Status;

class OptionSaveService {

    protected $optionGroup;
    protected $options;
    protected $optionIds = array();
    protected $locale = array();

    protected $optionFees = [];
    protected $optionStatus = [];
    protected $optionLocales = [];
    protected $optionProductIds = [];

    public function __construct(OptionGroup $optionGroup = null)
    {
        $this->optionGroup = $optionGroup ?? new OptionGroup();
    }

    public function setByRequest(Request $request){

        $this->optionGroup->name = $request->input("name");
        $this->optionGroup->limit = $request->input("limit");
        $this->optionGroup->locale = $request->input("locale");
        $this->optionGroup->type = $request->input("type");
        $this->optionGroup->status = $request->input("status");

        if($this->optionGroup->type == OptionType::PRODUCT){
            $this->options = $request->input("product_options");
            $this->optionProductIds = isset($this->options['product_ids']) ? $this->options['product_ids'] : [];
        }else{
            $this->options = $request->input("options");
            $this->optionLocales = isset($this->options['locale']) ? $this->options['locale'] : [];
        }
        $this->optionIds = isset($this->options['ids']) ? $this->options['ids'] : [];
        $this->optionFees = isset($this->options['fees']) ? $this->options['fees'] : [];
        $this->optionStatus = isset($this->options['status']) ? $this->options['status'] : [];

        return $this;

    }

    protected function removeUncheckedOptions(){
        switch($this->optionGroup->type){
            case OptionType::NORMAL:
                ProductOption::where("option_group_id",$this->optionGroup->id)->delete();
                Option::whereNotIn("id", array_filter($this->optionIds))->where("option_group_id",$this->optionGroup->id)->delete();
                break;
            case OptionType::PRODUCT:
                Option::where("option_group_id",$this->optionGroup->id)->delete();
                ProductOption::whereNotIn("id", array_filter($this->optionIds))->where("option_group_id",$this->optionGroup->id)->delete();
                break;
        }
        return $this;
    }

    protected function updateOptions(){

        switch($this->optionGroup->type){
            case OptionType::NORMAL:
                $this->updateNormalOptions();
                break;
            case OptionType::PRODUCT:
                $this->updateProductOptions();
                break;
            default:
                throw new \Exception(__("Invalid Option type"));
                break;
        }
    }

    /**
     *
     *
     * @return void
     */
    public function save(){

        try{

            DB::beginTransaction();

            $this->optionGroup->save();
            $this
                ->removeUncheckedOptions()
                ->updateOptions();
            DB::commit();
            return true;
        }catch(\Throwable $t){
            DB::rollBack();
            throw $t;
        }
        return false;
    }

    private function updateNormalOptions(){

        $locale = [];

        foreach($this->optionLocales as $code => $options){
            foreach($options as $index => $label){
                $locale[$index][$code] = $label;
            }
        }

        foreach($this->optionIds as $index => $optionId){
            $model = new Option();
            if(isset($optionId) && is_numeric($optionId)){
                if($obj = Option::find($optionId)){
                    $model = $obj;
                }
            }

            $model->option_group_id = $this->optionGroup->id;
            $model->locale = isset($locale[$index]) ? $locale[$index] : null;
            $model->price = isset($this->optionFees[$index]) && is_numeric($this->optionFees[$index]) ? $this->optionFees[$index] : null;
            $model->status =  (isset($this->optionStatus[$index]) && is_numeric($this->optionStatus[$index])  && !is_null($this->optionStatus[$index])) ? $this->optionStatus[$index] : Status::INACTIVE;
            $model->sort_order = ($index+1);
            $model->save();
        }
    }

    private function updateProductOptions(){

        if($this->optionProductIds){
            foreach($this->optionIds as $index => $optionId){
                $model = new ProductOption();
                if(isset($optionId) && is_numeric($optionId)){
                    if($obj = ProductOption::find($optionId)){
                        $model = $obj;
                    }
                }
                $model->product_id = isset($this->optionProductIds[$index]) && is_numeric($this->optionProductIds[$index]) ? $this->optionProductIds[$index] : null;;
                $model->option_group_id = $this->optionGroup->id;
                $model->price = isset($this->optionFees[$index]) && is_numeric($this->optionFees[$index]) ? $this->optionFees[$index] : null;
                $model->status = (isset($this->optionStatus[$index]) && is_numeric($this->optionStatus[$index]) && !is_null($this->optionStatus[$index])) ? $this->optionStatus[$index] : Status::INACTIVE;
                $model->sort_order = ($index+1);
                $model->save();
            }
        }
    }




}
