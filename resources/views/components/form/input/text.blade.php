<div class="row field {{ $classWrapper ?? '' }}">
    <div class="col-12">
        <label for="{{ $name }}">{{ ucfirst($label) }}:</label>
    </div>
    <div class="col-12 col-md-10 col-lg-8 col-xl-6">
        <div class="d-flex w-100 position-relative">
            @isset($prefix)
                <span>{{ $prefix }}</span>
            @endisset
            <input type="text"
                   class="input {{ $class ?? '' }}"
                   name="{{ $name }}"
                   placeholder="{{ $placeholder ?? '' }}"
                   aria-label=""{{ $placeholder ?? ''}}"
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
