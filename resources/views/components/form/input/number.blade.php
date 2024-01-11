<div class="row field {{ $classWrapper ?? '' }}">
    <div class="col-12 d-flex">
        <label for="{{ $name }}">{{ ucfirst($label) }}:</label>
    </div>
    <div class="col-12 d-flex">
        <div class="d-flex w-lg--auto position-relative d-inline-block">
            @isset($prefix)
                <span>{{ $prefix }}</span>
            @endisset
            <input type="number"
                   class="input {{ $class ?? '' }}"
                   name="{{ $name }}"
                   placeholder="{{ $placeholder ?? '' }}"
                   aria-label=""{{ $placeholder ?? ''}}"
            value="{{ old($name) }}"
            {{ $required ? 'required' : '' }}
            @isset($max)
                max="{{ $max }}"
            @endisset
            @isset($step)
                step="{{ $step }}"
            @else
                step="any"
            @endisset
            />
            @isset($suffix)
                <span>{{ $suffix }}</span>
            @endisset
        </div>
    </div>
    <div class="col-12 d-flex">
        <span class="error-post">{{ $errors->first($name) }}</span>
    </div>
</div>
