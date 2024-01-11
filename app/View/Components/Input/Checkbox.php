<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Checkbox extends Component
{
    /**
     * @param null $name
     * @param null $class
     * @param null $classWrapper
     * @param bool $required
     * @param bool $checked
     */
    public function __construct(
        public $name = null,
        public $class = null,
        public $classWrapper = null,
        public $required = false,
        public $checked = false,
    )
    {
        $this->name = $name ?? 'form_input_' . Str::random(8);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input.checkbox');
    }
}
