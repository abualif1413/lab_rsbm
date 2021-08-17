<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SideBarItem extends Component
{
    public $caption;
    public $faIcon;
    public $url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($caption, $url, $faIcon)
    {
        //
        $this->caption = $caption;
        $this->faIcon = $faIcon;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.side-bar-item');
    }
}
