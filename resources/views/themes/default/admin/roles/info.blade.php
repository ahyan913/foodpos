<?php
use App\Models\Constant\Gender;
use App\Models\Constant\YesNo;



?>

@extends('layout')
@section('content')

<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-4xl font-bold text-gray-900 dark:text-white">{{ __(":action :name", ["action"=>$role->id ? __("Update"):__("Create"), "name"=>__("Role")]) }}</h2>
        <form method="POST">
            <div class="grid gap-4 sm:gap-6">
                <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("General") }}</h3>
                <div class="w-full">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
                    <input type="text" name="name" required="true" value="{{ old("name", $role->name) }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("First Name") }}" required="true">
                </div>
                <div >
                    <label for="is_super" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Administrator?") }}</label>
                    <div class="flex gap-3 items-center">
                        <input name="is_super" type="checkbox" value="1" {{ old("is_super",$role->is_super) === YesNo::YES ? "checked":"" }}  /><span>{{ __("Yes") }}</span>
                    </div>
                </div>

                <div id="permissions" class="w-full {{ $role->is_super ? "hidden":"" }}">
                    <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("Permission") }}</h3>

                    <div  class="grid grid-cols-4">
                    @foreach ($permissions as $groupName => $groups)
                        <div class="role-{{ $groupName }}">
                            <h4 class="mb-3">
                                <strong>{{ __($groupName) }}</strong>
                                <input type="checkbox" class="check-all" />
                            </h4>
                            <ul>
                            @foreach ( $groups as $permission)
                                <li class="flex gap-6 items-center">
                                    <input type="checkbox" {{ in_array($permission->id, old("permissions",$checked)) ? "checked":"" }}  name="permissions[]" value="{{ $permission->id }}">{{ __("Allow :action", ["action"=>__($permission->action)]) }}
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    @endforeach
                    </div>
                </div>
                @csrf

                @if($role->id)
                <input type="hidden" name="_method" value="PUT">
                @endif
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Save") }}
            </button>


            <a href="/roles" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Back") }}
            </a>
        </form>
    </div>
  </section>

<script>
$(()=>{
    $("[name=is_super]").on("change", function(){
        if($(this).is(":checked")){

            $('#permissions').addClass("hidden");
            $('#permissions [type=checkbox]').prop("checked", false).attr("checked", false);


        }else{
            $('#permissions').removeClass("hidden");
        }
    });

    $(".check-all").on("change", function(){
        console.log($("ul li [type=checkbox]",$(this).parent().parent()));
        let checked = $(this).is(":checked");
        $("ul li [type=checkbox]",$(this).parent().parent()).each(function(){
            $(this).prop("checked", checked).attr("checked", checked);
        })
    });

    $("ul li [type=checkbox]").on("change",function(){

        var $checkAll = $('h4 [type=checkbox]', $(this).parent().parent().parent());
        if(!$(this).is(":checked")){
            $checkAll.prop("checked", false).attr("checked", false);
        }else{
            var allChecked = true;
            $('[type=checkbox]', $(this).parent().parent()).each(function(){
                if(!$(this).is(":checked")){
                    allChecked = false;
                    return;
                }
            });

            if(allChecked){
               $checkAll.prop("checked", true).attr("checked", true);
            }

        }
    });
});
</script>


@stop
