<div class="row field {{ $classWrapper ?? '' }}">
    <div class="col-12 d-flex">
        <label for="{{ $name }}">{{ ucfirst($label) }}:</label>
    </div>
    <div class="col-12 d-flex">
        <div class="d-flex w-lg--auto position-relative d-inline-block">
            @isset($prefix)
                <span>{{ $prefix }}</span>
            @endisset
            <input type="password"
                   class="input {{ $class ?? '' }}"
                   name="{{ $name }}"
                   placeholder="{{ $placeholder ?? '' }}"
                   aria-label=""{{ $placeholder ?? '' }}"
            value="{{ old($name) }}"
            {{ $required ? 'required' : '' }}
            @isset($max)
                maxlength="{{ $max }}"
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
