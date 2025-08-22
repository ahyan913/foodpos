<?php
use App\Helper\LocaleHelper;
use App\Models\Constant\Gender;
use App\Models\Constant\YesNo;
use App\Models\Constant\ProductOptionType;
use App\Models\Constant\OptionType;

$modelLocale = old("locale", $model->locale ?? [])  ;
?>
@extends('layout')

@section('theme_header')
@stop

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 w-full lg:py-16">
        <h2 class="mb-4 text-4xl font-bold text-gray-900 dark:text-white">{{ __(":action :name", ["action"=>$model->id ? __("Update"):__("Create"), "name"=>__("Product Option")]) }}</h2>
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
                    <label for="option_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Option Type") }}</label>
                    <select id="option_type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Please Select">
                        <option value="">{{ __("Please Select") }}</option>
                        @foreach(OptionType::getOptions() as $value => $label )
                        <option value="<?= $value ?>" <?= $value == $model->type ? "selected":"" ?>>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="limit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Label") }}</label>
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            @foreach($locale as $index => $code)
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="model-{{ $code }}-tab" data-tabs-target="#model-{{ $code }}" type="button" role="tab" aria-controls="{{ $code }}" aria-selected="false">{{ __($code) }}{{ $index == 0 ? __("(Default)"):"" }}</button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="myTabContent" className="">
                        @foreach($locale as $code)
                        <div class="hidden p-4 rounded-lg flex-col flex gap-6 bg-gray-50 dark:bg-gray-800" id="model-{{ $code }}" role="tabpanel" aria-labelledby="model-{{ $code }}-tab">
                            <div >
                                <label for="{{ $code }}-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                                <div class="flex gap-3 items-center">
                                    <input type="text" name="locale[{{ $code }}][name]" required="true" value="{{ LocaleHelper::getValue($modelLocale, $code, 'name') }}" id="{{ $code }}-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full">
                    <label for="limit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Maximum selection") }}</label>
                    <input type="text" name="limit" value="{{ old("limit", $model->limit) }}" id="limit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Limit") }}" required="true" />



                    <div id="product-option" class="option-type-2 option-type hidden">
                        <h3 class="my-6">
                            <a href="#" class="btn-add-product-option w-6 ml-3">{{ __("Add :name", ["name"=>__("Product Option")]) }}</a>
                        </h3>
                        <div class="options">
                            @if(isset($model->type) && $model->type == OptionType::PRODUCT)
                                @if($options = $model->productOptions()->orderBy("sort_order")->get())
                                    @foreach($options as $option)
                                    <x-product.option.productoptionvalue :products="$products" :option="$option" />
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>

                    <div id="normal-option" class="option-type-1 option-type hidden">
                        <h3 class="my-6">
                            <a href="#" class="btn-add-option w-6 ml-3">{{ __("Add :name", ["name"=>__("Option")]) }}</a>
                        </h3>
                        <div class="locale-options grid grid-cols-1 sm:grid-cols-{{ count($locale)+3 }}">
                            @foreach($locale as $code)
                                <div>{{ __($code) }}</div>
                            @endforeach
                            <div>{{ __("Fee") }}</div>
                            <div>{{ __("Action") }}</div>
                        </div>
                        <div class="options">
                            @if(isset($model->type) && $model->type == OptionType::NORMAL)
                                @if($options = $model->options()->orderBy("sort_order")->get())
                                    @foreach($options as $option)
                                    <x-product.option.optionvalue :option="$option" />
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @csrf

                @if($model->id)
                <input type="hidden" name="_method" value="PUT">
                @endif
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Save") }}
            </button>

            <a href="<?= admin_url("options") ?>" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Back") }}
            </a>
        </form>
    </div>
  </section>

<div class="clone hidden">
    <x-product.option.optionvalue />
    <x-product.option.productoptionvalue :products="$products" />
</div>

<script type="text/javascript">

$('.btn-remove-option').on("click", function(e){
    e.preventDefault();
    $(this).parent().parent().remove()
})

$('.btn-add-option').on("click", function(e){
    e.preventDefault();
    let $clone = $('.clone .option').clone(true);
    $('.options', $(this).parent().parent()).append($clone);


    $('.btn-delete-option',$clone).on("click", function(e){
         e.preventDefault();
         $(this).parent().parent().remove()
    });
});

$('.btn-add-product-option').on("click", function(e){
    e.preventDefault();
    let $clone = $('.clone .product-option').clone(true);
    $('.options', $(this).parent().parent()).append($clone);
    $('.btn-delete-option',$clone).on("click", function(e){
         e.preventDefault();
         $(this).parent().parent().remove()
    });
});

$('[name="type"]').trigger("change");

$('.options').sortable();

var updateOptionType = function(){
    const optionType = $("#option_type").val().length ? $("#option_type").val() : 1;
    console.log(optionType);
    $('.option-type').hide();
    $('.option-type-'+optionType).show();
    //$('.option-type .options').html("");
}

$("#option_type").on("change", function(e){
    updateOptionType();
});

updateOptionType();

</script>
@stop
