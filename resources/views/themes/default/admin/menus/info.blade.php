<?php
use App\Helper\LocaleHelper;
use App\Models\Constant\Gender;
use App\Models\Constant\YesNo;
$modelLocale = old("locale", $model->locale ?? [])  ;
?>
@extends('layout')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-4xl font-bold text-gray-900 dark:text-white">{{ __(":action :name", ["action"=>$model->id ? __("Update"):__("Create"), "name"=>__("Food Menu")]) }}</h2>
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
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Image") }}</label>
                    @if($thumbnail = $model->getThumbnail())
                    <img src="{{ menu_url('src/menu/'.$thumbnail) }}" />
                    @endif
                    <div class="flex gap-3 items-center">
                        <input name="image" id="image" type="file" value="1" class="bg-gray-50 border border-gray-300 text-gray-900 w-full" />
                    </div>
                </div>

                <hr />
                <h3 class="text-2xl flex justify-between items-center">
                    <span>{{  __("Stores") }}</span>
                    <x-store.addstorebutton />
                </h3>
                <hr />
                <div class="grid grid-cols-1 sm:grid-cols-3">
                @foreach($stores as $store)
                    <div>
                        <input type="checkbox" id="store-{{ $store->id }}" name="store_id[]" value="{{ $store->id }}" {{ in_array($store->id, $model->getStoreIds()) ? "checked":"" }}/> <label for="store-{{ $store->id }}">{{ $store->name }}</label>
                    </div>
                @endforeach
                </div>
                <hr />

                <hr />
                <h3 class="text-2xl">{{  __("Product Type") }}</h3>
                <hr />
                <div class="grid grid-cols-1 sm:grid-cols-3">
                @foreach($productTypes as $productType)
                    <div>
                        <input type="checkbox" id="store-{{ $productType->id }}" name="type_id[]" value="{{ $productType->id }}" {{ in_array($productType->id, $model->getTypeIds()) ? "checked":"" }}/> <label for="store-{{ $productType->id }}">{{ $productType->name }}</label>
                    </div>
                @endforeach
                </div>
                <hr />

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

                @csrf
                @if($model->id)
                <input type="hidden" name="_method" value="PUT">
                @endif
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Save") }}
            </button>

            <a href="<?= admin_url("menus") ?>" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Back") }}
            </a>
        </form>
    </div>
  </section>
@stop
