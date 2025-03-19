@extends('layouts.app')

@section('content')
<x-card title="Sortir Menu">
    <div class="list-group col nested-list nested-sortable" id="menu-list">  
        @foreach ($menus as $menu)  
            <div class="list-group-item nested-1" data-id="{{ $menu['id'] }}" id="menu-items"> 
                <div class="w-full d-flex align-items-center justify-content-between">
                    <span>
                        {{ $menu['name'] }}  
                    </span>
                    <button type="button" class="btn btn-primary btn-sm edit-item" data-id="{{ $menu['id'] }}" data-bs-toggle="modal" data-bs-target="#updateItem">Ubah Item</button>
                </div>
                <div class="list-group nested-list nested-sortable">  
                    @foreach ($menu['items'] as $item)  
                        <div class="list-group-item nested-2" data-id="{{ $item['id'] }}">  
                            <i class="{{ $item['icon'] }}"></i>  
                            {{ $item['name'] }}  
                        </div>  
                    @endforeach  
                </div>  
            </div>  
        @endforeach  
    </div>
</x-card>
<x-modal id="updateItem" centered="true" title="Update Item" size="lg" />  
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/sortablejs/Sortable.min.js') }}"></script>

<script>
    $(document).ready(function() {  
        var el = document.getElementById('menu-list');  
        var sortable = Sortable.create(el, {  
            group: "nested",  
            animation: 150,  
            onEnd: function (evt) {  
                var data = [];  
                $('#menu-list .nested-1').each(function(index) {  
                    var menuId = $(this).data('id');  
                    data.push({ id: menuId, position: index + 1 });  
                });  

                $.ajax({  
                    url: '{{ route('configurations.menuSortable.update', ['type' => 'group']) }}',  
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
                        Swal.fire({
                            html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                                    <div class="pt-2 mt-4 fs-15">
                                        <h4>Terjadi kesalahan!</h4>
                                        <p class="mx-4 mb-0 text-muted">${error.responseJSON.message}</p>
                                    </div>x
                                </div>
                            `,
                            showCancelButton: true,
                            showConfirmButton: false,
                            customClass: {
                                cancelButton: "btn btn-primary w-xs mb-1",
                            },
                            cancelButtonText: "Back",
                            buttonsStyling: false,
                            showCloseButton: true,
                        });
                    }  
                });  
            }  
        });  

        $('.edit-item').on('click', function() {
            var id = $(this).data('id');  
            console.log(id)

            $.ajax({
                url: '{{ route("configurations.menuSortable.getById", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                beforeSend: function () {
                    $('#updateItem .modal-body').html('<p class="text-muted">Sedang memuat data...</p>');
                },
                success: function(response) {
                    $('#updateItem .modal-body').html(response.data);
                },
                error: function (error) {
                    Swal.fire({
                        html: `
                            <div class="mt-3">
                                <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                                <div class="pt-2 mt-4 fs-15">
                                    <h4>Terjadi kesalahan!</h4>
                                    <p class="mx-4 mb-0 text-muted">${error.responseJSON.message}</p>
                                </div>x
                            </div>
                        `,
                        showCancelButton: true,
                        showConfirmButton: false,
                        customClass: {
                            cancelButton: "btn btn-primary w-xs mb-1",
                        },
                        cancelButtonText: "Back",
                        buttonsStyling: false,
                        showCloseButton: true,
                    });
                },
            });
        }); 
    });  
</script>
@endpush