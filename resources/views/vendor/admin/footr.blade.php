@extends('admin::layouts.master')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
    <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
    <div class="row page-titles">
        <div class="col-md-6 col-12 align-self-center">
            <h3 class="mb-0">
                Footer Banner
            </h3>
        </div>
        <div class="col-md-6 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
                <li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">Footer Banner</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

    <div class="flex-row d-flex justify-content-center">


        <div class="col-sm-12 col-md-9">
            <!-- Default box -->
            <a href="http://127.0.0.1:8000/admin/dashboard" class="btn btn-primary shadow">
                <i class="fa fa-angle-double-left"></i> Back to all
                <span class="text-lowercase"></span>
            </a>
            <br><br>


                <div class="card-body">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->

                    <div class="card mb-0">
                        <div class="row m-2" >
                            <table class="table table-fluid">
                                <thead>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($data->value as $image)
                                    <tr>
                                        <td>{{$image['text']}}</td>
                                        <td> <img width="250px" src="{{asset('images/'.$image['image'])}}" alt=""></td>
                                        <td>{{($image['status']=='on')?'Active':'Not active'}}</td>
                                        <td><span class="fa fa-edit " style="cursor: pointer" data-toggle="modal" data-target="#myModal" onclick="detail({{json_encode($image)}})"></span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>



                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div>
                                            <form method="post" action="{{route('footr-update')}}" enctype="multipart/form-data">
                                                @csrf
                                            <div class="form-group">
                                                <label >Title</label>
                                                <input type="text" class="form-control" required name="title" id="title">
                                                <input type="hidden"  name="id" id="data-id">
                                            </div>
                                            <div class="form-group">
                                                <label >Image</label><br>
                                                <label class="btn btn-primary btn-file">
                                                    Choose file <input type="file" accept="image/*"  name="image" class="form-control" >
                                                    <input type="hidden" id="hiddenImage" name="logo">
                                                </label>
                                                <img class="img-fluid pt-1" id="img" alt="">
                                            </div>

                                            <div class="form-group">
                                                <label>Status</label>
                                                <input type="checkbox" class=" text-left form-control " style="cursor: pointer;" name="status" id="status" >
                                            </div>
                                            <div class="form-group pb-2 pt-2">
                                                <input type="submit" class="btn text-center w-100 float-right btn-primary" required name="sbt"><br>
                                            </div>
                                        </form>
                                        </div>
                                    <!-- Modal footer -->
{{--                                    <div class="modal-footer">--}}
{{--                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>--}}
{{--                                    </div>--}}

                                </div>
                            </div>
                        </div>

                    </div>



                </div>
                <div class="card-footer">
{{--                    <div class="btn-group">--}}

{{--                        <button type="submit" class="btn btn-primary shadow">--}}
{{--                            <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;--}}
{{--                            <span data-value="save_and_back">Save and back</span>--}}
{{--                        </button>--}}
{{--                        <div class="ml-2">--}}
{{--                            <a href="{{url('admin/dashboard')}}" class="btn btn-secondary shadow"><span class="fa fa-ban"></span> &nbsp;Cancel</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                </div>
        </div>
        </div>


        @endsection

        @section('after_scripts')

            {{--    css--}}
            <link href="{{ asset('vendor/admin/cropper/dist/cropper.min.css') }}" rel="stylesheet" type="text/css" />
            <style>
                .hide {
                    display: none;
                }
                .btn-group {
                    margin-top: 10px;
                }
                img {
                    max-width: 100%; /* This rule is very important, please do not ignore this! */
                }
                .img-container, .img-preview {
                    width: 100%;
                    text-align: center;
                }
                .img-preview {
                    float: left;
                    margin-right: 10px;
                    margin-bottom: 10px;
                    overflow: hidden;
                }
                .preview-lg {
                    width: 263px;
                    height: 148px;
                }

                .btn-file {
                    position: relative;
                    overflow: hidden;
                }
                .btn-file input[type=file] {
                    position: absolute;
                    top: 0;
                    right: 0;
                    min-width: 100%;
                    min-height: 100%;
                    font-size: 100px;
                    text-align: right;
                    filter: alpha(opacity=0);
                    opacity: 0;
                    outline: none;
                    background: white;
                    cursor: inherit;
                    display: block;
                }
            </style>
        {{--css end--}}
        <!-- Ladda Buttons (loading buttons) -->
            <script src="{{ asset('vendor/admin/ladda/spin.js') }}"></script>
            <script src="{{ asset('vendor/admin/ladda/ladda.js') }}"></script>


            <script src="{{ asset('vendor/admin/cropper/dist/cropper.min.js') }}"></script>
            <script>
                function detail(det){
                    $('#data-id').val(det.key)
                    $('#title').val(det.text)
                    if(det.status=='on'){
                        $('#status').attr('checked','true');
                    }else{
                        $('#status').removeAttr('checked');
                    }

                    let globalPublicPath = '<?php  asset('images/') ?>';
                    $('#img').attr('src',globalPublicPath+'images/'+det.image)
                }



            </script>

            <script>

            </script>


@endsection
