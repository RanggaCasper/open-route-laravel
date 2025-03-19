@props([  
    'id',  
    'title',  
    'centered' => false,  
    'size' => null,
    'slot' => ''
])  

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $centered ? 'modal-dialog-centered' : '' }} {{ $size ? 'modal-' . $size : '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="{{ $id }}Body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>