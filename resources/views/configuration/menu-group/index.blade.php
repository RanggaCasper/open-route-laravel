@extends('layouts.app')

@section('content')
<x-card title="Kelola Menu">
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button>
    <table id="datatables" class="table align-middle nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Perizinan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</x-card>

<x-modal id="createModal" centered="true" title="Tambah Menu" size="lg">  
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-input label="Nama" type="text" name="name" id="name" />
        </div>
        <div class="mb-3">
            <x-select2
                name="permission"  
                label="Perizinan"  
                id="permission"
                :options="$permissions" 
            />  
        </div>
        <div class="mb-3">
            <x-checkbox id="statuses" name="status" value="1" label="Aktif" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update Menu" size="lg">  
    <form method="POST" id="form_update">
        @csrf
        @method('put')
        <div class="mb-3">
            <x-input label="Nama" type="text" name="name" id="name_update" />
        </div>
        <div class="mb-3">
            <x-select2
                name="permission"  
                label="Perizinan"  
                id="permission_update"
                :options="$permissions" 
            />  
        </div>
        <div class="mb-3">
            <x-checkbox id="statuses_update" name="status" value="1" label="Aktif" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>
@endsection

@push('scripts')
<script>
    $('#datatables').DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        ajax: '{{ route('configurations.menuGroups.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'name', name: 'name' },
            { data: 'permission_name', name: 'permission_name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
        ],
    });
</script>
<x-script.update-swal routeGet="configurations.menuGroups.getById" routeUpdate="configurations.menuGroups.update">
    $('#name_update').val(response.data.name);
    $('#statuses_update').prop('checked', !!response.data.status);
    $('#permission_update').val(null).trigger('change');

    if (response.data.permission_name) {
        $('#permission_update').val(response.data.permission_name).trigger('change');
    }
</x-script.update-swal>
<x-script.delete-swal route="configurations.menuGroups.destroy" />
@endpush