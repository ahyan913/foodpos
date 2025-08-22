<?php
$name = isset($name) ? $name:"";
$numOfCustomer = isset($numOfCustomer) ? $numOfCustomer: "";
?>
<div class="grid my-3 table-row grid-cols-3 gap-6">
    <div>
        <label>{{ __("Name") }}</label>
        <input class="pbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 name" name="tables[name][]" value="<?=$name ?>" />
    </div>
    <div>
        <label>{{ __("Number of customer") }}</label>
        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 num-of-customer" name="tables[num_of_customer][]" value="<?= $numOfCustomer ?>"  />
    </div>
    <div >
        <div>&nbsp;</div>
        <div class="w-6 grid items-center">
            <input type="hidden" name="tables[id][]" class="table-id" />
            <x-form.button.icondelete url="#" class="btn-delete-table" />
        </div>
    </div>
</div>
