<?php
use App\Models\Constant\Locale;
extract($configs);
?>
@extends('layout')
@section('content')
<form method="POST">
    <div class="text-right">
        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            {{ __("Save") }}
        </button>
    </div>
    <div class="bg-white dark:bg-gray-900 flex">
        <div id="configuration-menu" class="col-span-3 transition-all duration-500 w-full basis-1/4 sm:order-2">
            <nav class="max-h-[32rem] overflow-y-auto sm:mt-6 bg-gray-100 sticky">
                <ul class="p-6">
                    @for($i=0; $i<200; $i++)
                    <li class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                        <a href="#locale">{{ __("Locale") }}</a>
                    </li>
                    @endfor
                </ul>
            </nav>

        </div>
        <div id="configuration-container" class="px-4 col-span-7 max-h-screen overflow-y-auto p-6 transition-all duration-500 w-full sm:order-1 basis-3/4">
            <div class="w-full flex gap-6 flex-col">
                <div id="accordion-open" data-accordion="open" class="flex flex-col">
                    <h2 id="accordion-open-heading-1">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl  dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-1" aria-expanded="true" aria-controls="accordion-open-body-1">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>{{ __("Locale") }}</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    </h2>
                    <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1">
                        <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 flex gap-6 flex-col">
                            <div class="grid sm:grid-cols-10">
                                <label for="name" class="col-span-2 p-3  block mb-2 text-sm font-medium text-gray-900 dark:text-white justify-end">{{ __("Supported") }}</label>
                                <select name="locale_supported[]" multiple class="col-span-8 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    @foreach(Locale::getOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ in_array($value, $locale_supported) ? "selected":"" }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid sm:grid-cols-10">
                                <label for="locale" class="col-span-2 p-3 block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Code") }}</label>
                                <select name="locale_default" multiple class="col-span-8 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    @foreach(Locale::getOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ $value == $locale_default ? "selected":"" }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h2 id="debug-heading" class="mt-6">
                        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl  dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#debug-body" aria-expanded="true" aria-controls="debug-body">
                            <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>{{ __("Debug") }}</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        </h2>
                        <div id="debug-body" class="hidden" aria-labelledby="debug-heading">
                            <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 flex gap-6 flex-col">
                                <div class="grid sm:grid-cols-10">
                                    <label for="name" class="col-span-2 p-3  block mb-2 text-sm font-medium text-gray-900 dark:text-white justify-end">{{ __("Log") }}</label>
                                    <div class="col-span-8 p-2.5">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="1" name="debug_log" class="sr-only peer" {{ isset($debug_log) && $debug_log == 1 ? "checked":"" }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __("Enabled") }}</span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>


    @csrf
    @method("PUT")
</form>

@stop

@section("footer")

@stop




