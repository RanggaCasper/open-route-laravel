@extends('layouts.app')

@section('content')
<x-card title="Kelola Perizinan">
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

<x-modal id="createModal" centered="true" title="Tambah Perizinan" size="lg">  
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-select2
                name="route"  
                label="Rute"  
                id="route"
                :options="$routes" 
            />  
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
            <x-checkbox id="statuses" name="status" value="1" label="Aktif" :isChecked="true" />
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
            <x-select2
                name="route"  
                label="Rute"  
                id="route_update"
                :options="$routes_update" 
            />  
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
            <x-checkbox id="statuses_update" name="status" value="1" label="Aktif" :isChecked="true" />
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
        ajax: '{{ route('configurations.routes.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'route', name: 'route' },
            { data: 'permission_name', name: 'permission_name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
        ],
    });
</script>
<x-script.update-swal routeGet="configurations.routes.getById" routeUpdate="configurations.routes.update">
    $('#statuses_update').prop('checked', !!response.data.status);
   
    if (response.data.permission_name) {
        $('#permission_update').val(null).trigger('change');
        $('#permission_update').val(response.data.permission_name).trigger('change');
    }
    
    if (response.data.route) {
        $('#route_update').val(null).trigger('change');
        $('#route_update').val(response.data.route).trigger('change');
    }
</x-script.update-swal>
<x-script.delete-swal route="configurations.routes.destroy" />
@endpush