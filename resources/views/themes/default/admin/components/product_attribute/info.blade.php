<?php
use App\Helper\LocaleHelper;
use App\Models\Constant\Gender;
use App\Models\Constant\YesNo;
use App\Models\Constant\ProductAttributeType;

?>
@extends('layout')

@section('theme_header')
@stop

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 w-full lg:py-16">
        <h2 class="mb-4 text-4xl font-bold text-gray-900 dark:text-white">{{ __(":action :name", ["action"=>$model->id ? __("Update"):__("Create"), "name"=>__("Product Attribute")]) }}</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="grid gap-4 sm:gap-6">
                <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("General") }}</h3>
                <div class="w-full">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                    <input type="text" name="name" required="true" value="{{ old("name", $model->name) }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                </div>
                <div class="w-full">
                    <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Attribute Code") }}</label>
                    <input type="text" name="code" required="true" value="{{ old("code", $model->code) }}" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Code") }}" required="true">
                </div>
                <div class="w-full">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Attribute Type") }}</label>
                    <select name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Please Select">
                        <option>{{ __("Please Select") }}</option>
                        @foreach(ProductAttributeType::getOptions() as $optionValue => $optionLabel)
                        <option value="{{ $optionValue }}" {{ $model->type == $optionValue ? "selected":"" }}>{{ $optionLabel }}</option>
                        @endforeach
                    </select>
                    <ul>

                        @foreach(ProductAttributeType::getOptions() as $optionValue => $optionLabel)
                        <li id="product-attribute-type-{{ $optionValue }}" class="product-attribute-type {{ $model->type == $optionValue ? "":"hidden" }}">
                        @if($optionValue != ProductAttributeType::TEXT)
                            <h3 class="flex my-6">
                                {{ $optionLabel }}
                                <a href="#" class="btn-add-option w-6 ml-3">{{ __("Add") }}</a>
                            </h3>
                            <div class="locale-options grid grid-cols-1 sm:grid-cols-{{ count($locale)+1 }}">
                                @foreach($locale as $code)
                                    <div>{{ __($code) }}</div>
                                @endforeach
                            </div>
                            <div class="options">
                            @if(is_array($model->locale) && $model->type == $optionValue)
                                @foreach($model->locale as $index => $_locale)
                                <x-product_attribute.localeOptions :data="$_locale" :locale="$locale" :index="$index" />
                                @endforeach
                            @endif
                            </div>
                        @endif
                        </li>
                        @endforeach
                    </ul>
                </div>



                @csrf
                @if($model->id)
                <input type="hidden" name="_method" value="PUT">
                @endif
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Save") }}
            </button>

            <a href="/product_attributes" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Back") }}
            </a>
        </form>
    </div>
  </section>

<div class="clone hidden">
    <x-product_attribute.localeOptions :data="[]" :locale="$locale" index="0" />
</div>


<script type="text/javascript">
$('[name="type"]').on("change", function(e){
    const selectedValue = $(this).val();
    $(".product-attribute-type").addClass("hidden");
    $("#product-attribute-type-"+selectedValue).removeClass("hidden");
});

$('.btn-delete-option').on("click", function(e){
    e.preventDefault();
    $(this).parent().parent().remove()
})

$('.btn-add-option').on("click", function(e){
    let $clone = $('.clone .locale-options').clone();
    $('.options', $(this).parent().parent()).append($clone);

    var locales = <?=json_encode($locale, JSON_UNESCAPED_UNICODE) ?>;
    for(var x in locales){
        var loop = true;
        var i = 0;
        do{
            var name = 'product_attribute['+locales[x]+']['+i+'][option][]';
            var className = "locale-"+locales[x]+"-option-"+i;
            var $option = $(`.${className}`);
            console.log(className, $option.length);
            loop = $option.length > 0;
            if(!loop){
                $('[type=text]',$clone).attr("name", name).addClass(className);
            }
            i++
        }while(loop);
    }

    $('.btn-delete-option',$clone).on("click", function(e){
        e.preventDefault();
        $(this).parent().parent().remove()
    });
});

$('.btn-add-suboptions').on("click", function(e){

    e.preventDefault();

    var $clone = $('.clone-suboption', $(this)).clone();

});


$('[name="type"]').trigger("change");

</script>
@stop
