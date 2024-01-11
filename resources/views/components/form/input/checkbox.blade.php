<div class="row field {{ $classWrapper ?? '' }}">
    <div class="col-12 d-flex">
        <label class="label {{ $class ?? '' }}">
            <input type="checkbox"
                   class="col-auto checkbox"
                   name="{{ $name }}"
                   id="{{ $name }}"
                   @isset($required) required @endisset
                   @isset($checked) checked @endisset
            />
            <span class="col-auto checkbox-text align-self-center">{{ isset($required) ? '*' : '' }}{{ $slot }}</span>
        </label>
        <div class="error-post">{{ $errors->first($name) }}</div>
    </div>
</div>
