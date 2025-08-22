
<?php
$labelName = isset($name) ? $name:"";
$labelPrice = isset($price) ? $price: 0;
$checked = isset($checked) ? $checked: 0;
$showHideName = isset($inputStatus) ? $inputStatus:null;

?>
<span class="name">{{ $labelName }}</span>
<span class="fee">{{ $labelPrice }}</span>
{{-- <x-form.checkbox.showhide :checked="$checked" :name="$showHideName" /> --}}
