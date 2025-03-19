<div class="list-group col nested-list nested-sortables" id="menu-list">  
    @foreach ($menus->items as $item)  
        <div class="list-group-item nested-3" data-id="{{ $item->id }}">  
            <i class="{{ $item->icon }}"></i>  
            {{ $item->name }}  
        </div>  
    @endforeach  
</div>  

<script>  
$(".nested-sortables").each(function() {  
    new Sortable(this, {  
        group: "nested",  
        animation: 150,  
        fallbackOnBody: true,  
        swapThreshold: 0.65,  
        onEnd: function (evt) {  
            var data = [];  
            $('#menu-list .nested-3').each(function(index) {  
                var itemId = $(this).data('id');  
                data.push({ id: itemId, position: index + 1 });  
            });  
            $.ajax({  
                url: '{{ route('configurations.menuSortable.update', ['type' => 'item']) }}',  
                method: 'POST',  
                data: {  
                    data: data,
                    _method: 'PUT',  
                    _token: '{{ csrf_token() }}'  
                },  
                success: function(response) {  
                    if (response.status) {  
                        toastr.success(response.message, 'Berhasil!');  
                    }
                },  
                error: function(xhr) {  
                    console.error('Error updating positions.', xhr);  
                }  
            });  
        }  
    });  
});
</script>