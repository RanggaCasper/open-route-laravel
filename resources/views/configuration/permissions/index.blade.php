@extends('layouts.app')

@section('content')
<x-card title="Kelola Perizinan">
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

<x-modal id="createModal" centered="true" title="Tambah Perizinan" size="lg">  
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-input label="Nama" type="text" name="name" id="name" />
            <span class="text-muted small">Format: gunakan "-" sebagai pemisah. Contoh: transaksi-create (transaksi adalah nama, create adalah aksi).</span>
        </div>
        <div class="mb-3">
            <x-input label="Akses" type="text" name="guard_name" placeholder="web" id="guard_name" />
        </div>
        <div class="mb-3">
            <x-select2
                name="roles[]"  
                label="Role"  
                id="roles"
                :options="$roles" 
                attr="multiple"
                :isRequired="false"
            />  
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</x-modal>

<x-modal id="updateModal" centered="true" title="Update Perizinan" size="lg">  
    <form method="POST" id="form_update">
        @csrf
        @method('put')
        <div class="mb-3">
            <x-input label="Nama" type="text" name="name" id="name_update" />
            <span class="text-muted small">Format: gunakan "-" sebagai pemisah. Contoh: transaksi-create (transaksi adalah nama, create adalah aksi).</span>
        </div>
        <div class="mb-3">
            <x-input label="Akses" type="text" name="guard_name" placeholder="web" id="guard_name_update" />
        </div>
        <div class="mb-3">
            <x-select2
                name="roles[]"  
                label="Role"  
                :options="$roles" 
                id="roles_update"
                attr="multiple"
                :isRequired="false"
            />  
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
        ajax: '{{ route('configurations.permissions.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'name', name: 'name' },
            { data: 'guard_name', name: 'guard_name' },
            { data: 'action', name: 'action' },
        ],
    });
</script>
<x-script.update-swal routeGet="configurations.permissions.getById" routeUpdate="configurations.permissions.update">
    $('#name_update').val(response.data.name);
    $('#guard_name_update').val(response.data.guard_name);
    $('#roles_update').val(null).trigger('change');

    if (response.data.roles && response.data.roles.length > 0) {
        var roleIds = response.data.roles.map(function(role) {
            return role.name;
        });
        $('#roles_update').val(roleIds).trigger('change');
    }
</x-script.update-swal>
<x-script.delete-swal route="configurations.permissions.destroy" />
@endpush