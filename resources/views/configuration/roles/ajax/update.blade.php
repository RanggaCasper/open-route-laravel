<form action="{{ route('configurations.roles.update', $data->id) }}" method="POST" id="form_update">
    @csrf
    @method('put')
    <div class="mb-3">
        <x-input label="Nama" type="text" name="name" value="{{ $data->name }}" id="name_update" />
    </div>
    <div class="mb-3">
        <x-input label="Akses" type="text" name="guard_name" value="{{ $data->guard_name }}" placeholder="web" id="guard_name_update" />
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
                        @php
                            $existingPermissions = [];
                            if (isset($data->permissions)) {
                                $existingPermissions = $data->permissions->pluck('name')->toArray();
                            }
                        @endphp
                        
                        @foreach ($permissions as $prefix => $actions)
                            <tr>
                                <td>{{ ucwords($prefix) }}</td>
                                <td class="gap-3 d-flex">
                                    @foreach ($actions as $action)
                                        @if ($action['action'])
                                            <x-checkbox
                                                id="{{ $prefix }}-{{ $action['action'] }}-{{ $loop->iteration }}"
                                                name="permission[]"
                                                value="{{ $prefix }}-{{ $action['action'] }}"
                                                label="{{ ucwords($action['action']) }}"
                                                attr="{{ in_array($action['full_name'], $existingPermissions) ? 'checked' : '' }}"
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