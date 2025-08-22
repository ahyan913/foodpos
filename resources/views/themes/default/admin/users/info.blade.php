<?php
use App\Models\Constant\Gender;
use App\Models\Constant\StaffStatus;
?>

@extends('layout')
@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:pb-32">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __(":action :name", ["action"=>$staff->id ? __("Update"):__("Create"), "name"=>__("Staff")]) }}</h2>
        <form action="{{ $action }}" method="POST">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="w-full">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("First Name") }}</label>
                    <input type="text" name="first_name" value="{{  old("first_name", $staff->first_name) }}" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("First Name") }}" required="true">
                </div>
                <div class="w-full">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Last Name") }}</label>
                    <input type="text" name="last_name" value="{{  old("last_name", $staff->last_name) }}" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __("Last Name") }}" required="true">
                </div>

                <div class="sm:col-span-2">
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Gender") }}</label>
                    <select name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <?php foreach(Gender::getOptions() as $value => $label): ?>
                    <option value="<?=$value ?>" {{ $value == old("gender", $staff->gender) ? "selected":"" }}><?=$label ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Status") }}</label>
                    <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <?php foreach(StaffStatus::getOptions() as $value => $label): ?>
                    <option value="<?=$value ?>" {{ $value == old("status", $staff->status) ? "selected":"" }}><?=$label ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Username") }}</label>
                    <input type="text" name="username" value="{{ old("username", $staff->username) }}" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Email Address") }}</label>
                    <input type="email" name="email" value="{{ old("email", $staff->email) }}" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                </div>
                <div class="sm:col-span-2">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Password") }}</label>
                    <input type="password" name="password" id="password" value="{{ old("password", "") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="">
                </div>
                <div>
                    <label for="roles" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Roles") }}</label>
                    <div class="group">
                    @foreach ($roles as $role)
                        <div class="flex gap-6 items-center"><input type="checkbox" name="role[]" value="{{ $role->id }}" {{ in_array($role->id, old("role",$selectedRoleIds)) ? "checked":"" }}>{{ $role->name }}</div>
                    @endforeach
                    </div>
                </div>
                @csrf

                @if($staff->id)
                    <input type="hidden" name="_method" value="PUT">
                @endif
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Save") }}
            </button>


            <a href="/users" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                {{ __("Back") }}
            </a>
        </form>
    </div>
  </section>
@stop
