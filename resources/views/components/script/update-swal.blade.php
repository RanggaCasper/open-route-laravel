@props([
    'routeGet',
    'routeUpdate',
    'titleError' => 'Data gagal diupdate!',
    'hasLoading' => false,
])

@push('scripts')
<script>
    $('#datatables').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route("$routeGet", ["id" => ":id"]) }}'.replace(':id', id),
            type: 'GET',
            @if ($hasLoading)
                beforeSend: function () {
                    $('#updateModal .modal-body').html('<p class="text-muted">Sedang memuat data...</p>');
                },
            @endif
            success: function(response) {
                $('#form_update').attr('action', '{{ route("$routeUpdate", ["id" => ":id"]) }}'.replace(':id', id));
                {{ $slot }}
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                let message; 
                
                if (response.errors) {
                    message = response.errors;
                } else {
                    message = response.message;
                }
                
                Swal.fire({
                    html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                            <div class="pt-2 mt-4 fs-15">
                                <h4>{{ $titleError }}</h4>
                                <p class="mx-4 mb-0 text-muted">${message}</p>
                            </div>
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
</script>
@endpush