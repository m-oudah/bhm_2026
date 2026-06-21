@extends('layouts.master_form')
@section('title', 'الحرف')
@section('content')

    <div class="app-content content ">
    <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Vertical Form</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-vertical" action="{{url('crafts')}}" method="post">
                                        @csrf
                                        @if (\Session::has('success'))
                                            <div class="alert alert-success">
                                                <ul>
                                                    <li>{!! \Session::get('success') !!}</li>
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">الفئة</label>
                                                    <select type="text" class="form-control" name="category_id">
                                                        @foreach($categories as $item)
                                                        <option value="{{$item->id}}">{{$item -> name}}</option>
                                                        @endforeach
</select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">الحرفة</label>
                                                    <input type="text" class="form-control" name="name">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">حفظ</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
    </div>
    <!-- END: Content-->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script>
        $('.menu-horizontal-wrapper').hide();
    </script>
@endcontent