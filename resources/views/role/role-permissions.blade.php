@extends('layouts.master')
@section('title', 'إنشاء رول جديد')
@section('stylesheet')
    <style>
        .link_btn {
            text-align: left;
        }

        .card.card-statistics {
            padding: 0;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="form-group box_permission col-md-3">
                                <ul class="nav my-2">
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input selectAll" data-id="{{ $permission->id }}"
                                                type="checkbox" id="{{ $permission->id }} "
                                                onchange="update('{{ $role->id }}', '{{ $permission->id }}')"
                                                @foreach ($role->permissions as $item)
                                                    @checked($role->id == $item->pivot->role_id && $permission->id == $item->pivot->permission_id) @endforeach>
                                            <label for="{{ $permission->id }}"
                                                class="custom-control-label fw-bolder">{{ $permission->name }} - {{ $permission->name_ar }}</label>
                                        </div>

                                        @foreach ($permission->childrens as $item)
                                            <ul class="nav ps-1">
                                                <li>
                                                    <input class="custom-control-input selectItems_{{ $permission->id }}"
                                                        type="checkbox" id="{{ $item->id }}"
                                                        onchange="update('{{ $role->id }}', '{{ $item->id }}')"
                                                        @foreach ($role->permissions as $item_2)
                                                            @checked($role->id == $item_2->pivot->role_id && $item->id == $item_2->pivot->permission_id) @endforeach>
                                                    <label for="{{ $permission->id }}"
                                                        class="custom-control-label">{{ $item->name }} - {{ $item->name_ar }}</label>
                                                </li>
                                            </ul>
                                        @endforeach

                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        $(".selectAll").click(function() {
            $('.selectItems_' + $(this).data('id')).prop("checked", $(this).prop("checked"));
        });

        function update(roleId, permissionId) {
            axios.put("{{ url('/') }}" + '/home/roles/' + roleId + '/permissions', {
                permission_id: permissionId,
            }).then(function(response) {
                //   console.log(response);
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
            }).catch(function(error) {
                // console.log(error);
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: error.response.data.message
                })
            })
        }
    </script>
@endpush
