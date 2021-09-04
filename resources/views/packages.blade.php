@extends('admin::layouts.master')



<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .switch input:checked + .slider {
        background-color: #398bf7;
    }

    .switch input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    .switch input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
        line-height: auto;
        width: auto;
        height: auto;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

@section('header')
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="mb-0">
                Packages
            </h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
                <li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item active">Packages</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card mb-0 rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1">
                            <h3 class="card-title">List</h3>
                        </div>
                        <div class="col-md-10"></div>
                        <div class="col-md-1"><button class="btn btn-primary" onclick="add_package()"><i class="fas fa-plus"></i></button></div>
                    </div>
                    <br>
                    <table class="table" id="package_table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Limit</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $package)
                                <tr id="{{$package->id}}">
                                    <td>{{$package->name}}</td>
                                    <td>{{$package->category->name}}</td>
                                    <td>{{$package->post_limit}}</td>
                                    <td>{{$package->price}}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="text-warning" id="type_status{{$package->id}}" {{ $package->status == 1 ? 'checked' : '' }} onchange="update_status({{$package->id}})">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td><span onclick="edit_package({{$package}})" style="color: blue;"><i class="far fa-edit"></i></span>
                                        <span onclick="delete_package({{$package->id}})" onclick="return confirm('Are you sure you want to delete this item?');" style="color: red; margin-left: 20px;"><i class="far fa-trash-alt"></i></span></td>
                                </tr>
                            @empty
                                <tr><td>Nothing Found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="package" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="package_title">Add Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="package_form">
                        @csrf
                        <div class="form-group">
                            <label>Name: </label>
                            <input class="form-control" name="name" id="name" placeholder="Enter Name" required>
                            <input class="form-control" type="hidden" name="id" id="id">
                        </div>
                        <div class="form-group">
                            <label>Choose Category: </label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option selected disabled value="">Nothing Selected </option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"> {{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Enter Price</label>
                            <input value="number" name="price" id="price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Limit: </label>
                            <input type="number" class="form-control" name="post_limit" id="post_limit" placeholder="Enter Limit" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="save">Save</button>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Define blade stacks so css and js can be pushed from the fields to these sections. --}}
@section('after_styles')

@endsection

@section('after_scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>


    <script>
    $("#package_form").on("submit",function (e, xhr, s)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var url = '{{url('admin/create-package')}}';
        var id = $('#id').val();
        if(id){
            url = '{{url('admin/update-package')}}';
        }
        var formData = $(this).serialize();
        console.log(formData)
        $.ajax(
            {
                type:'post',
                url: url,
                data:formData,
                success:function(result)
                {
                    if(result.update){
                        $('#package').modal('hide')
                        toastr.success('Package has been updated')
                        setTimeout(function(){}, 3000);
                        window.location.replace('{{url('admin/limit-package')}}')
                    }else{
                        $('#package').modal('hide')
                        toastr.success('Package has been created')
                        setTimeout(function(){}, 3000);
                        window.location.replace('{{url('admin/limit-package')}}')

                    }
                    console.log(result)
                }
            });
    });
    function edit_package (package) {
        $('#package_title').text('Edit Package');
        $('#package').modal('show');
        $('#name').val(package.name);
        $('#category_id').val(package.category_id);
        $('#post_limit').val(package.post_limit);
        $('#price').val(package.price);
        $('#id').val(package.id);
        $('#save').text('Update');
    }
    function add_package () {
        $('#package').modal('show')
        $('#package_title').text('Add Package');
        $('#package_form')[0].reset();
        $('#save').text('Save');
    }
    function delete_package(id) {
        var txt;
        if (confirm("Do you want to delete!")) {
            var url = '{{url('admin/delete-package')}}'
            $.ajax({
                type: "get",
                url: url,
                data: {id:id},
                success: function( msg ) {
                    toastr.success('Package has been deleted');
                }
            });
        } else {
            return;
        }
    }
    function update_status(id) {
        var url = '{{url('admin/update-status')}}'
        var status = 0;
        if($('#type_status'+id).is(':checked')){
            status = 1;
        }
        $.ajax({
            type: "get",
            url: url,
            data: {id:id, status: status},
            success: function( msg ) {
                toastr.success('Status has been updated');
            }
        });
    }

</script>
@endsection
