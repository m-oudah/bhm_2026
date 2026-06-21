@extends('layouts.master')
@section('title', 'الملف الشخصي')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <h5 class="card-header">الملف الشخصي</h5>
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    @if (Auth::user()->photo)
                        <img src="{{Auth::user()->photo}}" class="d-block w-px-100 h-px-100 rounded">
                    @else
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar">
                    @endif
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <form id="formAccountSettings" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="mb-3 col-md-6 fv-plugins-icon-container">
                            <label for="firstName" class="form-label">الاسم كامل</label>
                            <input class="form-control" type="text" name="name" value="{{ Auth::user()->name }}">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">البريد الالكتروني</label>
                            <input class="form-control" type="text" name="email" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="username" class="form-label">اليوزرنيم</label>
                            <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="password">كلمة المرور</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="username" class="form-label">تحديث الصورة الشخصية</label>
                            <input type="file" class="form-control" name="user_Photo">
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">تحديث
                                البيانات</button>
                        </div>
                    </div>
                    <!-- /Account -->
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            $("#formAccountSettings").on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData($('#formAccountSettings')[0]);
                axios({
                        method: 'post',
                        url: "{{ route('users.updateProfile') }}",
                        data: formData
                    })
                    .then(function(response) {
                        $('#DataTables_Table_0').DataTable().ajax.reload();
                        toastr.success(response.data.message, "{{ __('Saved') }}")
                    })
                    .catch(function(error) {
                        // console.log(error);
                        if (error.response.status == 422) {
                            var object = error.response.data.errors;
                            for (const key in object) {
                                var message = object[key][0]
                                break;
                            }
                            toastr.error(message);
                        } else {
                            toastr.error(error.response.data.message);
                        }
                    });
            });
        </script>
    @endpush
