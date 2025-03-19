@props([  
    'name',  
    'id',
    'label' => 'Label',  
    'options' => [],  
    'selected' => null,  
    'placeholder' => '-- Pilih Opsi --',  
    'class' => '',  
    'attr' => null,  
    'isRequired' => true,
])  

<div class="form-group">  
    <label for="{{ $name }}">{{ $label }}</label>@if($isRequired) <span class="text-danger">*</span>@endif
    <select  
        name="{{ $name }}"  
        id="{{ $id }}"  
        class="form-control select2 {{ $class }}"
        {{ $attr }}  
    >  
        <option></option>
        @foreach ($options as $value => $label)  
            <option  
                value="{{ $value }}"  
                {{ $selected == $value ? 'selected' : '' }}  
            >  
                {{ $label }}  
            </option>  
        @endforeach  
    </select>  
</div>  

@once
    @push('scripts')
        <script>  
            $('.select2').each(function () {
                var $p = $(this).parent();
                $(this).select2({
                    placeholder: $(this).data('placeholder') || '-- Pilih Opsi --',
                    allowClear: true,
                    dropdownParent: $p,
                });
            });
        </script> 
    @endpush
@endonce