<?php

namespace App\View\Components\Drawer;

use Illuminate\View\Component;

class NavItem extends Component
{

    public $url;
    public $icon;
    public $label;
    public $submenu;
    public $key;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($key, $url, $icon, $label, $submenu = array()){
        $this->url = $url;
        $this->icon = $icon;
        $this->label = $label;
        $this->submenu = $submenu;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {



        return view('components.drawer.navitem');
    }
}
