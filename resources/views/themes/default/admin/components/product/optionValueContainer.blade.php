<?php
use App\Models\Product;
use App\Models\Constant\OptionType;
$id = isset($optionGroup->id) ? $optionGroup->id:null;
$header = isset($optionGroup->name) ? $optionGroup->name:null;
?>
<h3 class="accordion-header" <?=  isset($id) ? 'id="accordion-header-'.$id.'"':null ?>>
    <span class="option-header">{{ isset($header) ? $header:null }}</span>
    {{-- <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-1" aria-expanded="true" aria-controls="accordion-flush-body-1">
        <span class="option-header">What is Flowbite?</span>
        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
        </svg>
    </button> --}}
    <a class="btn-remove-option w-6 h-6 inline-block absolute top-[-15px] left-[-15px]" <?=  isset($id) ? 'data-id="'.$id.'"':null ?> >
        <svg data-name="Layer 2" fill="currentColor" class="dark:text-slate-500 text-black" id="f2c063d8-1259-4c6c-9d6c-794b09db3fa6" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg"><path d="M19,.56A18.44,18.44,0,1,0,37.44,19,18.461,18.461,0,0,0,19,.56Z"/><rect fill="#fff" height="2.5" rx="1.25" transform="translate(19 45.87) rotate(-135)" width="15.435" x="11.282" y="17.75"/><rect fill="#fff" height="2.5" rx="1.25" transform="translate(-7.87 19) rotate(-45)" width="15.435" x="11.282" y="17.75"/></svg>
    </a>
</h3>
<div <?=  isset($id) ? 'id="accordion-body-'.$id.'"':null ?> class="accordion-body hidden" aria-labelledby="accordion-flush-heading-1">
    <input type="hidden" name="option_group_ids[]" data-hidden-field="option-group-id" value="" />
    <div class="font-bold grid grid-cols-2 items-center mb-3 gap-3">
        <span>{{ __("Name") }}</span>
        <span>{{ __("Fee") }}</span>
        {{-- <span>{{ __("Show") }}</span> --}}
    </div>
    <div class="grid grid-cols-2 items-center gap-3" data-field="options">
        @if (isset($optionGroup))
            <?php $options = $optionGroup->type == OptionType::NORMAL ? $optionGroup->options: $optionGroup->productOptions; ?>
            @foreach($options as $option)
            <?php
                $name = $optionGroup->type == OptionType::NORMAL ? $option->locale["en_US"]: $option->product->name;
                $price = number_format($option->price, 2);
            ?>
            <x-product.optionValueRow :name="$name" :price="$price" />
            @endforeach
        @endif
    </div>
</div>

