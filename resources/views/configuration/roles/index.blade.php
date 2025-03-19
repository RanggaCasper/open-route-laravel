@extends('layouts.app')

@section('content')
<x-card title="Kelola Role">
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button>
    <table id="datatables" class="table align-middle nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</x-card>

<x-modal id="createModal" centered="true" title="Tambah Role" size="lg">  
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-input label="Nama" type="text" name="name" id="name_update" />
        </div>
        <div class="mb-3">
            <x-input label="Akses" type="text" name="guard_name" placeholder="web" id="guard_name_update" />
        </div>
        <div class="mb-3">
            <div class="table">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Menu</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_update">
                            @foreach ($permissions as $prefix => $actions)
                                <tr>
                                    <td>{{ ucfirst($prefix) }}</td>
                                    <td class="gap-3 d-flex">
                                        @foreach ($actions as $action)
                                            @if ($action['action'])
                                                <x-checkbox
                                                    id="{{ $prefix }}-{{ $action['action'] }}"
                                                    name="permission[]"
                                                    value="{{ $prefix }}-{{ $action['action'] }}"
                                                    label="{{ ucfirst($action['action']) }}"
                                                    attr="{{ $action['full_name'] }}"
                                                />
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update Role" size="lg" />  
@endsection


@push('scripts')
<script>
    $('#datatables').DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        ajax: '{{ route('configurations.roles.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'name', name: 'name' },
            { data: 'guard_name', name: 'guard_name' },
            { data: 'action', name: 'action' },
        ],
    });
</script>
<x-script.update-swal routeGet="configurations.roles.getById" routeUpdate="configurations.roles.update" hasLoading="true">
    $('#updateModal .modal-body').html(response.data);
</x-script.update-swal>
<x-script.delete-swal route="configurations.roles.destroy" />
@endpush