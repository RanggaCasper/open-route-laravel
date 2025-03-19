@props([
    'type' => 'text',
    'label' => null,
    'id' => null,
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'class' => '',
    'attr' => '',
    'isRequired' => true
])

@if($label)
    <label class="form-label" @if($id) for="{{ $id }}" @endif>{{ $label }}</label>@if ($isRequired) <span class="text-danger">*</span> @endif
@endif

@if($type == 'password')
    <div class="mb-3 position-relative auth-pass-inputgroup">
        <input 
            type="password" 
            class="form-control pe-5 password-input @isset($class) {{ $class }} @endisset" 
            @isset($name) name="{{ $name }}" @endisset
            @isset($id) id="{{ $id }}" @endisset
            @isset($value) value="{{ $value }}" @endisset
            @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
            @isset($attr) {{ $attr }} @endisset
        >

        <button 
            class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon" 
            type="button" 
            id="{{ $id }}-addon"
        >
            <i class="align-middle ri-eye-fill"></i>
        </button>
    </div>
@else
    <input 
        type="{{ $type }}" 
        class="form-control {{ $class }}" 
        @if($name) name="{{ $name }}" @endif
        @if($id) id="{{ $id }}" @endif
        @if($value) value="{{ $value }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attr }}
    >
@endif