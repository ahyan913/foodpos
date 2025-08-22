<?php

namespace App\View\Components\Form\Checkbox;

use Illuminate\View\Component;

class Showhide extends Component
{
    public $name;
    public $checked;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = "", $checked = 0)
    {
        $this->checked = $checked;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.checkbox.showhide');
    }
}
