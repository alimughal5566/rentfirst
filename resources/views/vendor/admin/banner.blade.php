@extends('admin::layouts.master')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
    <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
    <div class="row page-titles">
        <div class="col-md-6 col-12 align-self-center">
            <h3 class="mb-0">
                Home Banner
            </h3>
        </div>
        <div class="col-md-6 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
                <li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">Home Banner</li>
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

            <form method="post" action="{{url('bannerCreate')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->

                    <div class="card mb-0">
                        <div class="row">
                            <!-- used for heading, separators, etc -->
                            <div class="form-group col-md-12"
                            >
                                <h2 class="setting-group-name">Banner</h2>
                            </div>							<!-- used for heading, separators, etc -->
                            <div data-preview="#logo" data-aspectRatio="0" data-crop="" class="form-group col-md-6 image"

                            >
                                <div>
                                    <label>Banner Logo</label>
                                </div>
                                <!-- Wrap the image or canvas element with a block element (container) -->
                                <div class="row">
                                    <div class="col-sm-6" style="margin-bottom: 20px;">
{{--                                        <?php $banner=\App\Models\Banner::all()->first();--}}
{{--                                        ?>--}}
{{--                                        @if($banner)--}}

{{--                                            <img id="mainImage" src="{{asset('images/banner/'.$banner->logo)}}" >--}}
{{--                                        @endif--}}
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <label class="btn btn-primary btn-file">
                                        Choose file <input type="file" accept="image/*" id="imgInp" name="logo"  class="hide"
                                        >
                                        <input type="hidden" id="hiddenImage" name="logo">
                                    </label>
                                    <button class="btn btn-danger" id="remove" type="button"><i class="fa fa-trash"></i></button>
                                </div>


                            </div>
                            <div class="form-group col-md-12"
                            >
                                <p class="setting-group-breadcrumb">Admin panel &rarr; Home Banner</p>
                            </div>							<!-- used for heading, separators, etc -->

                            <div class="form-group col-md-12"
                            >
                                <h3>Banner Info</h3>
                            </div>							<!-- text input -->

                            <!-- used for heading, separators, etc -->
                            <div class="form-group col-md-12"
                            >
                                <div style="clear: both;"></div>
                            </div>


                        </div>

                    </div>



                </div>
                <div class="card-footer">
                    <div class="btn-group">

                        <button type="submit" class="btn btn-primary shadow">
                            <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span data-value="save_and_back">Save and back</span>
                        </button>
                        <div class="ml-2">
                            <a href="{{url('admin/dashboard')}}" class="btn btn-secondary shadow"><span class="fa fa-ban"></span> &nbsp;Cancel</a>
                        </div>
                    </div>
                </div>
            </form>

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
                jQuery(document).ready(function($) {
                    // Loop through all instances of the image field
                    $('.form-group.image').each(function(index){
                        // Find DOM elements under this form-group element
                        var $mainImage = $(this).find('#mainImage');
                        var $uploadImage = $(this).find("#uploadImage");
                        var $hiddenImage = $(this).find("#hiddenImage");
                        var $hiddenFilename = $(this).find("#hiddenFilename");
                        var $rotateLeft = $(this).find("#rotateLeft")
                        var $rotateRight = $(this).find("#rotateRight")
                        var $zoomIn = $(this).find("#zoomIn")
                        var $zoomOut = $(this).find("#zoomOut")
                        var $reset = $(this).find("#reset")
                        var $remove = $(this).find("#remove")
                        // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
                        var options = {
                            viewMode: 2,
                            checkOrientation: false,
                            autoCropArea: 1,
                            responsive: true,
                            preview : $(this).attr('data-preview'),
                            aspectRatio : $(this).attr('data-aspectRatio')
                        };
                        var crop = $(this).attr('data-crop');

                        // Hide 'Remove' button if there is no image saved
                        if (!$mainImage.attr('src')){
                            $remove.hide();
                        }
                        // Initialise hidden form input in case we submit with no change
                        $hiddenImage.val($mainImage.attr('src'));


                        // Only initialize cropper plugin if crop is set to true
                        if(crop){

                            $remove.click(function() {

                                $mainImage.cropper("destroy");
                                $mainImage.attr('src','');
                                $hiddenImage.val('');
                                if (filename == "true"){
                                    $hiddenFilename.val('removed');
                                }
                                $rotateLeft.hide();
                                $rotateRight.hide();
                                $zoomIn.hide();
                                $zoomOut.hide();
                                $reset.hide();
                                $remove.hide();

                            });
                        } else {

                            $(this).find("#remove").click(function() {
                                $mainImage.attr('src','');
                                $hiddenImage.val('');
                                $hiddenFilename.val('removed');
                                $remove.hide();


                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                jQuery.ajax({
                                    url: "{{ route('bannerDelete') }}",
                                    method: 'post',
                                    data: {
                                        id:'',
                                    },
                                    success: function(result){
                                        console.log(result);
                                    }});

                            });
                        }
                        //////////////////////////////////////////////////////

                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    $('#mainImage').attr('src', e.target.result);
                                    $remove.show();
                                }

                                reader.readAsDataURL(input.files[0]); // convert to base64 string
                            }
                        }

                        $("#imgInp").change(function () {
                            readURL(this);
                        });

                        //////////////////////////////////////////////////////

                    });
                });


            </script>

            <script>

            </script>


@endsection
