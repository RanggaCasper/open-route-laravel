<div class="card">
    @isset($title)
        <div class="card-header">
            <h4 class="mb-0 card-title">{{ $title }}</h4>
        </div>
    @endisset
    
    @isset($img)
        <img class="card-img-top img-fluid" src="{{ Storage::url($img) }}" alt="Image">
    @endisset

    <div class="card-body">
        {{ $slot }}
    </div>
</div>
