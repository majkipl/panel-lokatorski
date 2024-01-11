<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Text extends Component
{
    /**
     * @param null $name
     * @param null $class
     * @param null $classWrapper
     * @param null $max
     * @param string $placeholder
     * @param string $label
     * @param bool $required
     * @param null $prefix
     * @param null $suffix
     */
    public function __construct(
        public $name = null,
        public $class = null,
        public $classWrapper = null,
        public $max = null,
        public $placeholder = '',
        public $label = '',
        public $required = false,
        public $prefix = null,
        public $suffix = null
    )
    {
        $this->name = $name ?? 'form_input_' . Str::random(8);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input.text');
    }
}
