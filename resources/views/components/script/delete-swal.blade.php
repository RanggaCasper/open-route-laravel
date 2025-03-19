@props([
    'title' => 'Apakah anda yakin?',
    'subtitle' => 'Anda tidak akan dapat mengembalikan data ini!',
    'titleSuccess' => 'Data berhasil dihapus!',
    'titleError' => 'Data gagal dihapus!',
    'route',
]);

@push('scripts')
<script>
    $("#datatables").on("click", ".delete-btn", function () {
        var id = $(this).data("id");

        Swal.fire({
            html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="pt-2 mx-5 mt-4 fs-15">
                        <h4>{{ $title }}</h4>
                        <p class="mx-4 mb-0 text-muted">{{ $subtitle }}</p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            customClass: {
                confirmButton: "btn btn-primary w-xs me-2 mb-1",
                cancelButton: "btn btn-danger w-xs mb-1",
            },
            confirmButtonText: "Ya, Hapus!",
            buttonsStyling: false,
            showCloseButton: true,
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: '{{ route("$route", ["id" => ":id"]) }}'.replace(":id", id),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE",
                    },
                    success: function (data) {
                        Swal.fire({
                            html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                    <div class="pt-2 mt-4 fs-15">
                                        <h4>{{ $titleSuccess }}</h4>
                                        <p class="mx-4 mb-0 text-muted">${data.message}</p>
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
                        $("#datatables").DataTable().ajax.reload();
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
            }
        });
    });
</script>
@endpush