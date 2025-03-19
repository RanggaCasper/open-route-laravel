@props([  
    'name',   
    'label' => 'Label',   
    'options' => [],   
    'selected' => null,   
    'placeholder' => '-- Pilih Opsi --',   
    'class' => '',   
    'attr' => null,  
])  

<div class="form-group">  
    <label for="{{ $name }}">{{ $label }}</label>  
    <select   
        name="{{ $name }}"   
        id="{{ $name }}"   
        class="form-control {{ $class }}"   
        {{ $attr }}   
    >  
        <option value="" disabled selected>{{ $placeholder }}</option>  
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