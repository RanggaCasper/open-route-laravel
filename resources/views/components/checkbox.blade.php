@props([
    'id',
    'name',
    'label',
    'value' => null,
    'attr' => null,
    'isChecked' => false
])

<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" name="{{ $name }}" value="{{ $value }}" role="switch" id="{{ $id }}" {{ $attr }} @if ($isChecked) checked @endif>
    <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
</div>