<?php
use App\Models\Constant\Gender;
use App\Models\Constant\YesNo;

$weekdays = array();
foreach(["monday","tuesday","wednesday","thursday","friday","saturday","sunday"] as $day){
    $weekdays[$day] = json_decode($model->$day);
}
extract($weekdays);

$model->exclude_dates = preg_replace('/\s+/', '', $model->exclude_dates);

?>
@extends('layout')

@section('theme_header')
<script src="//cdn.jsdelivr.net/gh/dubrox/Multiple-Dates-Picker-for-jQuery-UI@master/jquery-ui.multidatespicker.js"></script>
<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />
@stop

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto w-full lg:py-16">
        <h2 class="mb-4 text-4xl font-bold text-gray-900 dark:text-white">{{ __(":action :name", ["action"=>$model->id ? __("Update"):__("Create"), "name"=>__("Timeslot")]) }}</h2>
        <form action="{{ $action }}" method="POST">
            <div class="grid gap-4 sm:gap-6">
                <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("General") }}</h3>
                <div class="w-full">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                    <input type="text" name="name" required="true" value="{{ old("name", $model->name) }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Name") }}" required="true">
                </div>

                @foreach(["monday", "tuesday","wednesday","thursday","friday","saturday","sunday"] as $weekday)
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 py-6 border-b-1 border-gray-300">
                    <label >{{ __(ucwords($weekday))  }}</label>
                    <div class="grid col-span-2 sm:grid-cols-1 grid-cols-1 sm:grid-cols-2 gap-6  ">
                        <div class="grid grid-cols-2 gap-6">
                            <div >
                                <label for="{{ $weekday }}-start">{{ __("Start") }}:</label>
                                <select id="{{ $weekday }}-start" name="{{ $weekday }}[start_time]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @foreach(App\Helper\TimeHelper::getOptions() as $option)
                                <option value="{{ $option }}" {{ isset($$weekday->start_time) && $$weekday->start_time == $option ? "selected":"" }}>{{ $option }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="{{ $weekday }}-end">{{ __("End") }}:</label>
                                <select id="{{ $weekday }}-end" name="{{ $weekday }}[end_time]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @foreach(App\Helper\TimeHelper::getOptions() as $option)
                                <option value="{{ $option }}" {{ isset($$weekday->end_time) && $$weekday->end_time == $option ? "selected":"" }}>{{ $option }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="{{ $weekday }}-rest-start">{{ __("Rest Start") }}:</label>
                                <select id="{{ $weekday }}-rest-start" name="{{ $weekday }}[rest_start]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @foreach(App\Helper\TimeHelper::getOptions() as $option)
                                <option value="{{ $option }}" {{ isset($$weekday->rest_start) && $$weekday->rest_start == $option ? "selected":"" }}>{{ $option }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="{{ $weekday }}-rest-end">{{ __("Rest End") }}:</label>
                                <select id="{{ $weekday }}-rest-end" name="{{ $weekday }}[rest_end]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @foreach(App\Helper\TimeHelper::getOptions() as $option)
                                <option value="{{ $option }}" {{ isset($$weekday->rest_end) && $$weekday->rest_end == $option ? "selected":"" }}>{{ $option }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="w-full">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Specific non working date")  }}</label>
                    <div class="flex justify-center">
                        <div id="excluded_date_calendar"></div>
                    </div>
                    <input type="hidden" name="excluded_dates" value="abc" id="excluded_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Excluded Date") }}" required="true">
                </div>
                @csrf
                @if($model->id)
                <input type="hidden" name="_method" value="PUT">
                @endif
            </div>

            <div class="text-center">
                <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    {{ __("Save") }}
                </button>
                <a href="<?= admin_url("timeslots") ?>" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    {{ __("Back") }}
                </a>
            </div>
        </form>
    </div>
  </section>

  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
    }

    input {
      width: 300px;
      padding: 7px;
    }

    .ui-state-highlight {
      border: 0 !important;
    }

    .ui-state-highlight a {
      background: #363636 !important;
      color: #fff !important;
    }
  </style>
<script>
$(function(){
    window.mobileAndTabletCheck = function() {
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
    };

    var numOfCalendar =  mobileAndTabletCheck() ? 1:4;

    $("#excluded_date_calendar").multiDatesPicker({
        @if ($model->exclude_dates)
        addDates: <?= $model->exclude_dates ?>,
        @endif
        numberOfMonths: [1, numOfCalendar],
        altField: "#excluded_date",
        dateFormat: "yy-mm-dd"
    });
});
</script>

@stop
