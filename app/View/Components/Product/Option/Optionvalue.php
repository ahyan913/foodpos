<?php

namespace App\View\Components\Product\Option;

use Illuminate\View\Component;

class Optionvalue extends Component
{

    public $option;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($option = null)
    {
        //var_dump($option);
        $this->option = $option;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product.option.optionvalue');
    }
}
