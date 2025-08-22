<?php
use App\Helper\LocaleHelper;
use App\Models\Constant\Gender;
use App\Models\Constant\YesNo;
use App\Models\Constant\OptionType;

$optionsMap = [];
$productOptionProducts = [];

foreach($optionGroups as $optionGroup){
    if($optionGroup->type == OptionType::PRODUCT){
        foreach($optionGroup->productOptions as $pOption){
            if(!isset($productOptionProducts[$pOption->id])){
                $productOptionProducts[$pOption->id] = array();
            }
            $productOptionProducts[$pOption->id][] = $pOption->product->toArray();
        }
    }
}

$optionHeader = "";

$modelLocale = old("locale", $model->locale ?? [])  ;
?>
@extends('layout')

@section('content')
<section class="bg-white dark:bg-gray-900">

    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-4xl font-bold text-gray-900 dark:text-white">{{ __(":action :name", ["action"=>$model->id ? __("Update"):__("Create"), "name"=>__("Food")]) }}</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="grid gap-4 sm:gap-6">
                <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("General") }}</h3>
                <div class="w-full">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Status") }}</label>
                    <select name="status" required="true" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                    @foreach(YesNo::getOptions() as $value => $label)
                        <option value="{{ $value }}" {{ $value == old("status", $model->status) ? "selected":"" }}>{{ $label }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                    <input type="text" name="name" required="true" value="{{ old("name", $model->name) }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                </div>
                <div class="w-full">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Unit Price") }}</label>
                    <input type="text" name="price" required="true" value="{{ old("price", $model->price) }}" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Price") }}" required="true">
                </div>

                <div class="w-full">
                    <h3 class="text-2xl mb-3">{{ __("Food Type") }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3">
                    @foreach($productTypes as $productType)
                    <div>
                        <input type="checkbox" name="type_id[]" id="product-type-{{ $productType->id }}" {{ in_array($productType->id, $model->getProductTypeIds()) ? "checked":"" }} value="{{ $productType->id }}" />
                        <label for="product-type-{{ $productType->id }}" class="ml-3">{{ $productType->name }}</label>
                    </div>
                    @endforeach
                    </div>
                </div>
                <div class="w-full">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Image") }}</label>
                    @if($thumbnail = $model->getThumbnailPath())
                    <img src="{{ product_url($model->image, "thumbnails") }}" />
                    @endif
                    <div class="flex gap-3 items-center">
                        <input name="image" id="image" type="file" value="1" class="bg-gray-50 border border-gray-300 text-gray-900 w-full" />
                    </div>
                </div>

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        @foreach($locale as $index => $code)
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="model-{{ $code }}-tab" data-tabs-target="#model-{{ $code }}" type="button" role="tab" aria-controls="{{ $code }}" aria-selected="false">{{ __($code) }}{{ $index == 0 ? __("(Default)"):"" }}</button>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div id="myTabContent">
                    @foreach($locale as $code)
                    <div class="hidden p-4 rounded-lg flex-col flex gap-6 bg-gray-50 dark:bg-gray-800" id="model-{{ $code }}" role="tabpanel" aria-labelledby="model-{{ $code }}-tab">
                        <div >
                            <label for="{{ $code }}-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                            <div class="flex gap-3 items-center">
                                <input type="text" name="locale[{{ $code }}][name]" required="true" value="{{ LocaleHelper::getValue($modelLocale, $code, 'name') }}" id="{{ $code }}-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                            </div>
                        </div>
                        <div >
                            <label for="{{ $code }}-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Description") }}</label>
                            <div class="flex gap-3 items-center">
                                <textarea name="locale[{{ $code }}][description]" required="true" id="{{ $code }}-description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Description") }}" required="true">{{ LocaleHelper::getValue($modelLocale, $code, 'description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


                <h3 class="mb-3 text-2xl">{{ __("Product Option") }}</h3>
                <div class="flex gap-6 items-center">
                    <select id="product-option-dropdown" class="basis-2/3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @foreach($optionGroups as $optionGroup)
                            <option value="{{ $optionGroup->id }}" data-type={{ $optionGroup->type }} data-values="{{  $optionGroup->type == OptionType::NORMAL ? $optionGroup->options : $optionGroup->productOptions }}" >{{ $optionGroup->name }}</option>
                        @endforeach
                    </select>
                    <a href="#" class="basis-1/3" id="btn-add-product-option">
                        <span>{{ __("Add :name", ["name"=>__("Option")]) }}</span>
                    </a>
                </div>

                <div id="product-options-accordion-collapse" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">

                @if($model->optionGroups)

                    @foreach($model->optionGroups as $optionGroup)
                    <x-product.optionValueContainer :optionGroup="$optionGroup" />
                    @endforeach

                @endif
                </div>
                @csrf
                @if($model->id)
                <input type="hidden" name="_method" value="PUT">
                @endif
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Save") }}
            </button>

            <a href="<?= admin_url("products") ?>" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Back") }}
            </a>
        </form>
    </div>
  </section>

<div class="clone hidden">
    <div id="accordion-flush" class="accordion" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
        <x-product.optionValueContainer />
    </div>
</div>


<script type="text/javascript">
const $collapse = $('#product-options-accordion-collapse');
const productOptionProducts = <?= json_encode($productOptionProducts) ?>;

var loopEffect = function($obj){
    $obj.effect("highlight").delay(1000).effect("highlight").delay(1000).effect("highlight");
}

const existingHandling = function(headerId, bodyId){
    toastr.error("{{ __("It is already existed") }}");
    $("html, body").animate({
        scrollTop: $("#"+headerId).position().top+"px"
    },function(){
        loopEffect($("#"+headerId));
        loopEffect($("#"+bodyId));
    });
}

$('#btn-add-product-option').on("click", function(e){
    e.preventDefault();

    var $clone = $('.clone > .accordion').clone();
    var $dropdown = $("#product-option-dropdown");
    var $option = $('option:selected', $dropdown);

    var id = $option.val();
    var headerId = "accordion-header-"+id;
    var bodyId = "accordion-body-"+id;

    if($("#"+headerId).length > 0){
        existingHandling(headerId, bodyId);
    }else{
        var values = $option.data("values");
        var type = $option.data("type");
        $(".option-header",$clone).html($option.html())
        $('.accordion-header',$clone).attr({ id: headerId }).addClass('option-value-'+id);
        $('.accordion-body',$clone).attr({ "aria-labelledby": headerId, id: bodyId }).addClass('option-value-'+id);
        $('.accordion-header button',$clone).attr({'data-accordion-target':"#"+bodyId, "aria-controls":bodyId});
        $('[data-hidden-field=option-group-id]',$clone).val(id);

        $('.accordion-header .btn-remove-option', $clone)
            .data('value', id)
            .on("click", function(e){
                e.preventDefault();
                var optionValueId = $(this).data('id');
                $('.option-value-'+id).remove();
            });

        var html = "";

        if(values.length > 0){
            for(var x in values){
                var option = values[x];
                console.log(option);
                if(type == 1){
                    html+="<span class='my-3'>"+option.locale.{{ $defaultLocale }}+"</span>";
                }else{
                    html+="<span class='my-3'>"+option.product.locale.{{ $defaultLocale }}.name+"</span>";
                }
                //html+="<input type='text' name='optionValue["+option.id+"][price]' placeholder='"+option.price+"' class='my-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500'  />";
                html+=`<span>${option.price.toFixed(2)}</span>`

                //             html+=`<label class="relative inline-flex items-center cursor-pointer gap-3">
    //             <input type="checkbox" checked name="optionValue[${option.id}][status]" value="1" class="sr-only peer">
    //     <svg class="w-6 dark:text-white peer-checked:block hidden" fill="currentColor" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"/></svg>
    //     <svg class="w-6 dark:text-white peer-checked:hidden block" fill="currentColor" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><path d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"/></svg>
    // </label>`;

            }
        }

        $('.accordion-body > [data-field=options]',$clone).html(html);

        $collapse
            .append($(".accordion-header",$clone))
            .append($(".accordion-body",$clone))
            .accordion('refresh');
    }

});

$collapse.accordion({
    collapsible: true,
    classes:{
        "ui-accordion-header": "justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 bg-white dark:bg-gray-900 text-gray-900 dark:text-white",
        "ui-accordion-content": "bg-transparent border-gray-200 dark:border-gray-700 dark:text-white"
    }
});

$('.btn-remove-option').on("click", function(e){
    e.preventDefault();
    var optionId = $(this).data('id');
    $('#accordion-header-'+optionId).remove();
    $('#accordion-body-'+optionId).remove();
});

$('#thumbnails').on("change", function(e){

    var $preview = $("#thumbnail-preview");
    $preview.html("");
    var load = async function(file){
        var reader = new FileReader();
        reader.onload = ()=>{
            var img = new Image();
            $(img).attr({
                src: reader.result,

            })
            $preview.append($(img));
        };
        await reader.readAsDataURL(file);
    }
    for(var x in e.target.files){
        var file =  e.target.files[x]
        if( file instanceof File){
            load(file);
        }
    }
});

</script>
@stop
