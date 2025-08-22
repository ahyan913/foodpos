<?php
use App\Helper\LocaleHelper;
use App\Models\Constant\Gender;
use App\Models\Constant\YesNo;
use App\Models\Constant\ProductAttributeType;

$selectedProductAttributeIds = old("product_attribute_ids", $model->getAttributeIds());

?>
@extends('layout')

@section('theme_header')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Type") }}</label>
                    <select multiple name="product_attribute_ids[]" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Please Select">
                        @foreach($productAttributes as $productAttribute)
                        <option value="{{ $productAttribute->id }}" {{  in_array($productAttribute->id, $selectedProductAttributeIds) ? "selected":"" }}>{{ $productAttribute->name }}</option>
                        @endforeach
                    </select>
                </div>
                @csrf
                @if($model->id)
                <input type="hidden" name="_method" value="PUT">
                @endif
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Save") }}
            </button>

            <a href="/product_attribute_sets" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Back") }}
            </a>
        </form>
    </div>
  </section>

<div class="clone hidden">
    <div class="locale-options grid grid-cols-1 sm:grid-cols-{{ count($locale)+1 }} my-3">
        @foreach($locale as $code)
        {{ $value = $value ?? "" }}
            <x-product_attribute.option :value="$value" :code="$code" />
        @endforeach
        <div class="text-right">
            <a href="#" class="btn-delete-option">{{ __("Delete") }}</a>
        </div>
    </div>
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
    $('.btn-delete-option',$clone).on("click", function(e){
        e.preventDefault();
        $(this).parent().parent().remove()
    });
});

//$('[name="product_attribute_ids"]').trigger("change");
$(".select2").select2({
    placeholder: "{{ __("Please Select") }}",
    dropdownCssClass:"dark:bg-gray-700 dark:border-gray-600",
    selectCssClass:"dark:bg-gray-700 dark:border-gray-600"
}).on("select2:select", function(e){
    $(".select2-selection__rendered").sortable();
});
$(".select2-selection__rendered").sortable({
    containerment: 'parent'
});
</script>
@stop
