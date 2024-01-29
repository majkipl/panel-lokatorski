<div class="row field {{ $classWrapper ?? '' }}">
    <div class="col-12">
        <label for="{{ $name }}">{{ ucfirst($label) }}:</label>
    </div>
    <div class="col-12 col-md-10 col-lg-8 col-xl-6">
        <select class="input select empty {{ $class ?? '' }}"
                name="{{ $name }}"
                id="{{ $name }}"
                aria-label="{{ $placeholder }}{{ $required ? '*' : '' }}"
            {{ $required ? 'required' : '' }}
        >
            <option class="selected" selected>{{ $placeholder }}</option>
            @foreach($items as $key => $item)
                @isset($item->id)
                    <option value="{{ $item->id }}" {{ old($name) == $item->id ? 'selected' : '' }}>
                        {{ $item->firstname }} {{ $item->lastname }}
                    </option>
                @else
                    <option value="{{ $item }}" {{ old($name) == $item ? 'selected' : '' }}>
                        {{ $item }}
                    </option>
                @endisset
            @endforeach
        </select>
    </div>
    <div class="col-12 d-flex">
        <span class="error-post">{{ $errors->first($name) }}</span>
    </div>
</div>
