<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatCard extends Component
{
    public $title;
    public $value;
    public $subtitle;
    public $color;
    public $icon;

    public function __construct(
    $title = null,
    $value = null,
    $subtitle = null,
    $color = 'emerald',
    $icon = 'document'
) {
    $this->title = $title;
    $this->value = $value;
    $this->subtitle = $subtitle;
    $this->color = $color;
    $this->icon = $icon;
}


    public function render()
    {
        return view('components.stat-card');
    }
}
