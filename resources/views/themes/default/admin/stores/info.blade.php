<?php
use App\Models\Constant\Gender;
use App\Models\Constant\YesNo;
use App\Helper\LocaleHelper;
$storeLocale = old("locale", $store->locale ?? []);

$markerData = array(
    ["position"=>["lat"=>$store->latitude , "lng"=>$store->longitude ], "title"=>$store->name]
);


$tables = $store->tables->toArray();
?>
@extends('layout')

@section('content')
{{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> --}}

<section class="bg-white dark:bg-gray-900 <?= $store->image ? "bg-[url('".$store->getImageUrl()."')] bg-no-repeat bg-cover":"" ?>">
    <div class="py-8 px-4 lg:py-16 bg-white bg-opacity-75  dark:bg-gray-900 dark:bg-opacity-75">

        <form method="POST" enctype="multipart/form-data" >

            <div class="sticky top-[60px] z-10 flex flex-cols items-center mb-4 justify-between rounded p-4 bg-white dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75">

                <h2 class="text-4xl font-bold text-gray-900 dark:text-white">{{ __(":action :name", ["action"=>$store->id ? __("Update"):__("Create"), "name"=>__("Store")]) }}</h2>

                <div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5  text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        {{ __("Save") }}
                    </button>
                    <a href="../stores" class="inline-flex items-center px-5 py-2.5  text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        {{ __("Back") }}
                    </a>
                </div>

            </div>

            <div class="grid xl:grid-cols-2 gap-6">
                <div class="grid gap-4 sm:gap-6">
                    <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("General") }}</h3>
                    <div class="w-full">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Status") }}</label>
                        <select name="status" required="true" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                        @foreach(YesNo::getOptions() as $value => $label)
                            <option value="{{ $value }}" {{ $value == old("status", $store->status) ? "selected":"" }}>{{ $label }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                        <input type="text" name="name" required="true" value="{{ old("name", $store->name) }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                    </div>
                    <div class="w-full">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Code") }}</label>
                        <input type="text" name="code" required="true" value="{{ old("code", $store->code) }}" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Code") }}" required="true">
                    </div>
                    <div class="w-full">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Phone") }}</label>
                        <input type="text" name="phone" required="true" value="{{ old("phone", $store->phone) }}" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Code") }}" required="true">
                    </div>

                    <div class="w-full">
                        <label for="opening_hours" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Opening Hours") }}</label>
                        <div class="flex gap-3 items-center">
                            <select name="opening_hours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach($timeslots as $timeslot)
                                <option value="{{ $timeslot->id }}" {{ $timeslot->id == $store->open ? "selected":"" }}>{{ $timeslot->name }}</option>
                            @endforeach
                            </select>

                            @can("create", \App\Models\Timeslot::class)
                            <a href="/timeslot" class="w-6" target="_blank" title="{{ __(":action :name",["action"=>__("Create"), "name"=>__("Timeslot")]) }}">
                                <svg fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h48v48h-48z" fill="none"/><path d="M24 4c-11.05 0-20 8.95-20 20s8.95 20 20 20 20-8.95 20-20-8.95-20-20-20zm10 22h-8v8h-4v-8h-8v-4h8v-8h4v8h8v4z"/></svg>
                            </a>
                            @endcan

                            <a href="#" class="hints w-6" title="{{ __("View Detail") }}">
                            <svg fill="currentColor" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512"  xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M480,253C478.3,129.3,376.7,30.4,253,32S30.4,135.3,32,259c1.7,123.7,103.3,222.6,227,221C382.7,478.3,481.7,376.7,480,253   z M256,111.9c17.7,0,32,14.3,32,32s-14.3,32-32,32c-17.7,0-32-14.3-32-32S238.3,111.9,256,111.9z M300,395h-88v-11h22V224h-22v-12   h66v172h22V395z"/></g></svg>
                            </a>
                        </div>
                        <div class="opening_hours_detail">
                            @foreach($timeslots as $timeslot)
                            <div id="timeslot-{{ $timeslot->id }}-tooltip" class="grid grid-cols-3 gap-3 text-xs tooltips">
                                <table class="w-full">
                                    <thead>
                                        <th></th>
                                        <th class="text-left">{{ __("Opening Hours") }}</th>
                                        <th class="text-left">{{ __("Rest Hours") }}</th>
                                    </thead>
                                    <tbody>
                                    @foreach(["monday", "tuesday", "wednesday","thursday","friday","saturday","sunday"] as $weekday)
                                    <tr class="">
                                        <?php $setting = json_decode($timeslot->$weekday); ?>
                                        <td class="text-xs">{{ __(ucwords($weekday)) }} </td>
                                        <td>{{ $setting->start_time }} - {{ $setting->end_time }}</td>
                                        <td class="text-xs">{{ $setting->rest_start }} - {{ $setting->rest_end }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                <div class="mt-6 border-t-2 pt-6">
                                    <h2 >{{ __("Rest Days") }}</h2>
                                    <?php $excludedDates = json_decode($timeslot->exclude_dates) ?? [] ?>
                                    @foreach ($excludedDates as $date)
                                    <div class="my-2">{{ $date }}</div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label for="capacity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Capacity") }}</label>
                        <div class="flex gap-3 items-center">
                            <input type="text" name="capacity" required="true" value="{{ old("capacity", $store->capacity) }}" id="capacity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Capacity") }}" required="true">
                        </div>
                    </div>
                    <div>
                        <label for="place" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Search Place") }}</label>
                        <div class="flex gap-3 items-center">
                            <input type="text" id="place" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Place") }}">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="">
                            <label for="latitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Latitude") }}</label>
                            <input type="text" name="latitude" required="true" value="{{ old("latitude", $store->latitude) }}" id="latitude" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Latitude") }}" required="true">
                        </div>
                        <div class="w-full">
                            <label for="longitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Longitude") }}</label>
                            <input type="text" name="longitude" required="true" value="{{ old("longitude", $store->longitude) }}" id="longitude" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Longitude") }}" required="true">
                        </div>

                        <div id="map" class="col-span-2"></div>
                    </div>
                    <div >
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Image") }}</label>
                        @if($thumbnail = $store->getThumbnail())
                        <img src="{{ url('/api/images/thumbnails/store/'.$store->image) }}" />
                        @endif
                        <div class="flex gap-3 items-center">
                            <input name="image" type="file" value="1" class="bg-gray-50 border border-gray-300 text-gray-900 w-full" />
                        </div>
                    </div>

                    <hr />

                    <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("Locale Content") }}</h3>
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            @foreach($locale as $index => $code)
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="store-{{ $code }}-tab" data-tabs-target="#store-{{ $code }}" type="button" role="tab" aria-controls="{{ $code }}" aria-selected="false">{{ __($code) }}{{ $index == 0 ? __("(Default)"):"" }}</button>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div id="myTabContent">
                        @foreach($locale as $code)
                        <div class="hidden p-4 rounded-lg flex-col flex gap-6 bg-gray-50 dark:bg-gray-800" id="store-{{ $code }}" role="tabpanel" aria-labelledby="store-{{ $code }}-tab">
                            <div >
                                <label for="{{ $code }}-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                                <div class="flex gap-3 items-center">
                                    <input type="text" name="locale[{{ $code }}][name]" required="true" value="{{ LocaleHelper::getValue($storeLocale, $code, 'name') }}" id="{{ $code }}-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                                </div>
                            </div>
                            <div >
                                <label for="{{ $code }}-address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Address") }}</label>
                                <div class="flex gap-3 items-center">
                                    <input type="text" name="locale[{{ $code }}][address]" required="true" value="{{ LocaleHelper::getValue($storeLocale, $code, 'address') }}" id="{{ $code }}-address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Address") }}" required="true">
                                </div>
                            </div>
                            <div >
                                <label for="{{ $code }}-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Description") }}</label>
                                <div class="flex gap-3 items-center">
                                    <textarea name="locale[{{ $code }}][description]" required="true" id="{{ $code }}-description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Description") }}" required="true">{{ LocaleHelper::getValue($storeLocale, $code, 'description') }}</textarea>
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="relative">
                    <div class="sticky top-[150px] grid gap-6">
                        <div id="menu-panel">
                            <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("Food Menu") }}</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3">
                                @foreach($menus as $menu)
                                    <div>
                                        <input type="checkbox" name="menu_id[]" value="{{ $menu->id }}" id="menu-{{ $menu->id }}" {{ in_array($menu->id, $storeMenuIds) ? "checked":"" }} /><label for="menu-{{ $menu->id }}" class="ml-3">{{ $menu->name }}</label><br />
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <x-store.tables :tables="$tables" />
                    </div>
                </div>
            </div>
        </div>
        @csrf
        @if($store->id)
        <input type="hidden" name="_method" value="PUT">
        @endif
        </form>
    </div>
  </section>

<style type="text/css">
.opening_hours_detail .tooltips{
    display: none;
}

</style>

<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);e.set("language","zh-TW");a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
    ({key: "{{ env("GOOGLE_MAP_KEY") }}", v: "weekly"});



    var markerData = <?= json_encode($markerData) ?>;

    var setMarker = async function(map, markerData, bounds, AdvancedMarkerElement){

        for(var i in markerData){
            let {url, position, title} = markerData[i];
            const marker = new AdvancedMarkerElement({
                map:        map,
                position:   position,
                title:      title
            });
            if(url){
                marker.addListener("click", ()=>{
                    window.location=url;
                });
            }
            bounds.extend(position);
        }
    }

    async function initMap(){
        const {Map} = await google.maps.importLibrary("maps");
        const {AdvancedMarkerElement} = await google.maps.importLibrary("marker");
        const { Autocomplete } = await google.maps.importLibrary("places");
        const input = document.getElementById("place");
        const options = {
            fields: ["formatted_address", "geometry", "name"],
            componentRestrictions: { country: "hk" },
            strictBounds: false,
            types: ["establishment"]
        };

        const autocomplete = new Autocomplete(input, options);

        const position = {lat: 22.2875211, lng: 114.1922384};
        var bounds = new google.maps.LatLngBounds();
        map = new Map(document.getElementById("map"), {
            mapId: "DEMO_MAP_ID"
        });
        await setMarker(map, markerData, bounds, AdvancedMarkerElement);

        map.fitBounds(bounds);
        autocomplete.addListener("place_changed", ()=>{
            const { geometry } = autocomplete.getPlace();
            if(geometry){
                map.setCenter(geometry.location);
                document.getElementById("latitude").value = geometry.location.lat();
                document.getElementById("longitude").value = geometry.location.lng();
            }
        });

    }
    initMap();
</script>
<style type="text/css" rel="stylesheet">
#map{
    width: 100%;
    height: 500px;
}
</style>
<script type="text/javascript">
$(function(){
    $('.hints').on("click", function(e){
        e.preventDefault();
        var id = $('[name=opening_hours]').val();
        $('#timeslot-'+id+'-tooltip').dialog({
            modal: true,
            title: "{{ __("Opening Hours") }}"
        });

    });

});
</script>
@stop
