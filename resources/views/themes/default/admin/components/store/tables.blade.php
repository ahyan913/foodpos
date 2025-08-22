<?php
$tables = isset($tables) && is_array($tables) ? $tables : [];
?>
<div id="table-panel">
    <h3 class="block mb-2 text-2xl border-b-2 pb-3 border-gray-100 font-medium text-gray-900 dark:text-white">{{ __("Tables") }}</h3>
    <x-form.button.iconadd class="btn-add-table w-6 block"  />
    <div id="tables" class="grid grid-cols-1 sm:grid-cols-3">

    </div>
</div>

<script type="text/javascript">
var tables = <?= json_encode($tables) ?>;
const addTable = function(data){
    const { name, num_of_customers, id } = data;
    // const name = data.name ?? "";
    // const numOfCustomer = data.numOfCustomer ?? "";
    const $template = $(` <x-store.table />`);

    if(name){
        $(".name", $template).val(name);
    }

    if(num_of_customers){
        $(".num-of-customer",$template).val(num_of_customers);
    }

    if(id){
        $(".table-id",$template).val(id);
    }

    $(".btn-delete-table",$template).on("click", function(e){
        e.preventDefault();
        $(this).parent().parent().parent().remove();
    });

    $('#tables').append($template);

}

$(function(){

    const $tables = $("#tables");

    if(tables.length > 0){
        for(var x in tables){
            addTable(tables[x]);
        }
    }

    $(".btn-add-table").on("click", function(e){
        e.preventDefault();
        addTable({});
    });
});
</script>
