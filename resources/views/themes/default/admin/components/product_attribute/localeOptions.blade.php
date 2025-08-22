<div class="locale-options grid grid-cols-1 sm:grid-cols-{{ count($locale)+1 }} my-3">
    @foreach($locale as $code)
    <?php $value = isset($data[$code]) ? $data[$code] : null; ?>
    <x-product_attribute.option :value="$value" :code="$code" :index="$index" name="product_attribute[{{ $code }}][{{ $index }}][option][]" />
    @endforeach
    <div class="text-right">
        <a href="#" class="btn-delete-option">{{ __("Delete") }}</a>
    </div>
    <div class="sm:colspan-{{ count($locale)+2 }}">
        <a href="#" class="btn-add-suboptions">{{ __("Add :name", ["name"=>__("Sub Option")]) }}</a>
        <ul class="sub-options">

        </ul>
        <ul class="clone-suboption hidden" data-index="{{ $index }}">
            <li class="locale-suboptions grid grid-cols-1 sm:grid-cols-{{ count($locale)+1 }} my-3">
                @foreach($locale as $code)
                <x-product_attribute.option :code="$code" :index="$index" />
                @endforeach
                <div class="text-right">
                    <a href="#" class="btn-delete-suboption">{{ __("Delete") }}</a>
                </div>
            </li>
        </ul>
    </div>
</div>


