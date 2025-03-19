@extends('layouts.app')

@section('content')
<x-card title="Kelola Menu">
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button>
    <table id="datatables" class="table align-middle nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Rute</th>
                <th>Ikon</th>
                <th>Pratinjau Ikon</th>
                <th>Perizinan</th>
                <th>Grup</th>
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
            <x-input label="Ikon" type="text" name="icon" placeholder="ri-dashboard-fill" id="icon" />
            <span class="text-muted small">Gunakan awalan "ri-", Contoh-contoh ikon dapat diakses melalui situs berikut <a href="https://remixicon.com/" target="_blank" >https://remixicon.com/</a></span>
        </div>
        <div class="mb-3">
            <label>Pratinjau Ikon</label>
            <p>
                <i id="icon_preview" style="font-size: 32px;"></i>
            </p>
        </div>
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
            <x-select2
                name="menu_group_id"  
                label="Grup"  
                id="group"
                :options="$groups" 
            />  
        </div>
        <div class="mb-3">
            <x-checkbox id="statuses" name="status" value="1" label="Aktif" :isChecked="true" />
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
            <x-input label="Ikon" type="text" name="icon" placeholder="ri-dashboard-fill" id="icon_update" />
            <span class="text-muted small">Gunakan awalan "ri-", Contoh-contoh ikon dapat diakses melalui situs berikut <a href="https://remixicon.com/" target="_blank" >https://remixicon.com/</a></span>
        </div>
        <div class="mb-3">
            <label>Pratinjau Ikon</label>
            <p>
                <i id="icon_preview_update" style="font-size: 32px;"></i>
            </p>
        </div>
        <div class="mb-3">
            <x-select2
                name="route"  
                label="Rute"  
                id="route_update"
                :options="$routes" 
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
            <x-select2
                name="menu_group_id"  
                label="Grup"  
                id="group_update"
                :options="$groups" 
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
    $('#icon,#icon_update').on('keyup', function() {  
        var className = this.value;
        if (className) {  
            $('#icon_preview,#icon_preview_update').attr('class', className);
        }
    });
    
    $('#datatables').DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        ajax: '{{ route('configurations.menuItems.get') }}',
        columns: [
            { data: 'no', name: 'no' },
            { data: 'name', name: 'name' },
            { data: 'route', name: 'route' },
            { data: 'icon', name: 'icon' },
            { data: 'icon_preview', name: 'icon_preview' },
            { data: 'permission_name', name: 'permission_name' },
            { data: 'group.name', name: 'group.name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
        ],
    });
</script>
<x-script.update-swal routeGet="configurations.menuItems.getById" routeUpdate="configurations.menuItems.update">
    $('#name_update').val(response.data.name);
    $('#icon_update').val(response.data.icon);
    $('#icon_preview_update').attr('class', response.data.icon);
    $('#statuses_update').prop('checked', !!response.data.status);
    
    if (response.data.permission_name) {
        $('#permission_update').val(null).trigger('change');
        $('#permission_update').val(response.data.permission_name).trigger('change');
    }
    
    if (response.data.route) {
        $('#route_update').val(null).trigger('change');
        $('#route_update').val(response.data.route).trigger('change');
    }
    
    if (response.data.group) {
        $('#group_update').val(null).trigger('change');
        $('#group_update').val(response.data.group.id).trigger('change');
    }
</x-script.update-swal>
<x-script.delete-swal route="configurations.menuItems.destroy" />
@endpush