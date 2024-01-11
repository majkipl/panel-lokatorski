<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * @param null $name
     * @param array $items
     * @param null $class
     * @param null $classWrapper
     * @param string $placeholder
     * @param string $label
     * @param bool $required
     */
    public function __construct(
        public $name = null,
        public $items = [],
        public $class = null,
        public $classWrapper = null,
        public $placeholder = '',
        public $label = '',
        public $required = false,
    )
    {
        $this->name = $name ?? 'form_select_' . Str::random(8);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.select');
    }
}
