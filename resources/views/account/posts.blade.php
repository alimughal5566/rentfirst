{{--
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

@section('content')
    @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
    <div class="main-container">
        <div class="container">
            <div class="row">

                @if (Session::has('flash_notification'))
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12">
                                @include('flash::message')
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-3 page-sidebar">
                    @includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
                </div>
                <!--/.page-sidebar-->

                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        @if ($pagePath=='my-posts')
                            <h2 class="title-2"><i class="icon-docs"></i> {{ t('my_ads') }} </h2>
                        @elseif ($pagePath=='archived')
                            <h2 class="title-2"><i class="icon-folder-close"></i> {{ t('archived_ads') }} </h2>
                        @elseif ($pagePath=='favourite')
                            <h2 class="title-2"><i class="icon-heart-1"></i> {{ t('favourite_ads') }} </h2>
                        @elseif ($pagePath=='pending-approval')
                            <h2 class="title-2"><i class="icon-hourglass"></i> {{ t('pending_approval') }} </h2>
                        @else
                            <h2 class="title-2"><i class="icon-docs"></i> {{ t('posts') }} </h2>
                        @endif

                        <div class="table-responsive">
                            <form name="listForm" method="POST" action="{{ url('account/' . $pagePath . '/delete') }}">
                                {!! csrf_field() !!}
                                <div class="table-action">
                                    <label for="checkAll">
                                        <input type="checkbox" id="checkAll">
                                        {{ t('Select') }}: {{ t('All') }} |
                                        <button type="submit" class="btn btn-sm btn-default delete-action">
                                            <i class="fa fa-trash"></i> {{ t('Delete') }}
                                        </button>
                                    </label>
                                    <div class="table-search pull-right col-sm-7">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-5 control-label text-right">{{ t('search') }} <br>
                                                    <a title="clear filter" class="clear-filter"
                                                       href="#clear">[{{ t('clear') }}]</a>
                                                </label>
                                                <div class="col-sm-7 searchpan">
                                                    <input type="text" class="form-control" id="filter">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table id="addManageTable"
                                       class="table table-striped table-bordered add-manage-table table demo"
                                       data-filter="#filter" data-filter-text-only="true">
                                    <thead>
                                    <tr>
                                        <th data-type="numeric" data-sort-initial="true"></th>
                                        <th>{{ t('Photo') }}</th>
                                        <th data-sort-ignore="true">{{ t('Ads Details') }}</th>
                                        <th data-type="numeric">--</th>
                                        <th>{{ t('Option') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    use App\Models\Rent;if (isset($posts) && $posts->count() > 0):
                                    foreach($posts as $key => $post):
                                    // Fixed 1
                                    if ($pagePath == 'favourite') {
                                        if (isset($post->post)) {
                                            if (!empty($post->post)) {
                                                $post = $post->post;
                                            } else {
                                                continue;
                                            }
                                        } else {
                                            continue;
                                        }
                                    }

                                    // Fixed 2
                                    if (!$countries->has($post->country_code)) continue;

                                    // Get Post's URL
                                    $postUrl = \App\Helpers\UrlGen::post($post);

                                    // Get Post's Pictures
                                    if ($post->pictures->count() > 0) {
                                        $postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
                                    } else {
                                        $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
                                    }

                                    // Get country flag
                                    $countryFlagPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';
                                    ?>
                                    <tr>
                                        <td style="width:2%" class="add-img-selector">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="entries[]" value="{{ $post->id }}"></label>
                                            </div>
                                        </td>
                                        <td style="width:14%" class="add-img-td">
                                            <a href="{{ $postUrl }}"><img class="img-thumbnail img-fluid"
                                                                          src="{{ $postImg }}" alt="img"></a>
                                        </td>
                                        <td style="width:58%" class="items-details-td">
                                            <div>
                                                <p>
                                                    <strong>
                                                        <a href="{{ $postUrl }}"
                                                           title="{{ $post->title }}">{{ \Illuminate\Support\Str::limit($post->title, 40) }}</a>
                                                    </strong>
                                                    @if (in_array($pagePath, ['my-posts', 'archived', 'pending-approval']))
                                                        @if (isset($post->latestPayment) and !empty($post->latestPayment))
                                                            @if (isset($post->latestPayment->package) and !empty($post->latestPayment->package))
                                                                <?php
                                                                if ($post->featured == 1) {
                                                                    $color = $post->latestPayment->package->ribbon;
                                                                    $packageInfo = '';
                                                                } else {
                                                                    $color = '#ddd';
                                                                    $packageInfo = ' (' . t('Expired') . ')';
                                                                }
                                                                ?>
                                                                <i class="fa fa-check-circle tooltipHere"
                                                                   style="color: {{ $color }};" title=""
                                                                   data-placement="bottom"
                                                                   data-toggle="tooltip"
                                                                   data-original-title="{{ $post->latestPayment->package->short_name . $packageInfo }}"></i>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </p>
                                                <p>
                                                    <strong>
                                                        <i class="icon-clock" title="{{ t('Posted On') }}"></i>
                                                    </strong>&nbsp;{!! $post->created_at_formatted !!}
                                                </p>
                                                <p>
                                                    <strong><i class="icon-eye"
                                                               title="{{ t('Visitors') }}"></i></strong> {{ $post->visits ?? 0 }}
                                                    <strong><i class="icon-location-2"
                                                               title="{{ t('Located In') }}"></i></strong> {{ !empty($post->city) ? $post->city->name : '-' }}
                                                    @if (file_exists(public_path($countryFlagPath)))
                                                        <img src="{{ url($countryFlagPath) }}" data-toggle="tooltip"
                                                             title="{{ $post->country->name }}">
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                        <td style="width:16%" class="price-td">
                                            <div>
                                                <strong>
                                                    @if ($post->price > 0)
                                                        {!! \App\Helpers\Number::money($post->price) !!}
                                                    @else
                                                        {!! \App\Helpers\Number::money(' --') !!}
                                                    @endif
                                                </strong>
                                            </div>
                                        </td>
                                        <td style="width:10%" class="action-td">
                                            <div>
                                                @if (in_array($pagePath, ['my-posts']) and $post->user_id==$user->id and $post->archived==0)
                                                    <p>
                                                        <a class="btn btn-primary btn-sm"
                                                           href="{{ \App\Helpers\UrlGen::editPost($post) }}">
                                                            <i class="fa fa-edit"></i> {{ t('Edit') }}
                                                        </a>
                                                    </p>
                                                @endif
                                                @if (in_array($pagePath, ['my-posts']) and isVerifiedPost($post) and $post->archived==0)
                                                    <p>
                                                        <a class="btn btn-warning btn-sm confirm-action"
                                                           href="{{ url('account/'.$pagePath.'/'.$post->id.'/offline') }}">
                                                            <i class="icon-eye-off"></i> {{ t('Offline') }}
                                                        </a>
                                                    </p>
                                                @endif
                                                @if (in_array($pagePath, ['archived']) and $post->user_id==$user->id and $post->archived==1)
                                                    <p>
                                                        <a class="btn btn-success btn-sm confirm-action"
                                                           href="{{ url('account/'.$pagePath.'/'.$post->id.'/repost') }}">
                                                            <i class="fa fa-recycle"></i> {{ t('Repost') }}
                                                        </a>
                                                    </p>
                                                @endif
                                                <p>
                                                    <a id="rent_modal" class="btn btn-secondary btn-sm "
                                                       onclick="onrent({{auth()->id()}}, {{$post->id}})">
                                                        <i class="fa fa-industry"></i> Rent
                                                    </a>
                                                </p>

                                                <p>
                                                    <a class="btn btn-danger btn-sm delete-action"
                                                       href="{{ url('account/'.$pagePath.'/'.$post->id.'/delete') }}">
                                                        <i class="fa fa-trash"></i> {{ t('Delete') }}
                                                    </a>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModal1Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModal1Label">Rent Scheduler</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?php
                                        ?>
                                        <div class="modal-body">

                                            <div class="col-sm-3">
                                                <div id="endrent_{{@$post->id}}"></div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" id="close"
                                                    data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Ends -->
                        </div>


                        <nav>
                            {{ (isset($posts)) ? $posts->links() : '' }}
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        .action-td p {
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
    <script type="text/javascript">

        $("#rent_modal").click(function (e) {
            // alert()
            e.preventDefault();

        });

        function onrent(user_id, post_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ route('get_rent_data') }}",
                method: 'get',
                data: {
                    post_id: post_id,
                    user_id: user_id

                },
                success: function (response) {
                    console.log(response);
                    $('#exampleModal1').modal('show');
                    var timer_id = '#exampleModal1 .modal-body #endrent_' + post_id;
                    if (response['status'] == 0) {
                        $(timer_id).text("");
                        $('#exampleModal1 .modal-body').html(response['code']);
                    } else {
                        $('#exampleModal1 .modal-body').html("");
                        console.log(response['rent_endtime'])
                        var renttime = response['rent_endtime'];
                        var countDownDate = new Date(renttime).getTime();

                        //creating end rent button
                        var button = document.createElement("button");
                        button.classList.add("btn", "btn-danger");
                        button.innerHTML = "End Rent";
                        button.type = "submit";
                        button.id = "rentcancel"
                        var newdiv2 = document.createElement("div");
                        newdiv2.id = "endrent_" + post_id;

                        $("#exampleModal1 .modal-body").append(newdiv2);

                        // Update the count down every 1 second
                        var x = setInterval(function () {

                            // Get today's date and time
                            var now = new Date().getTime();

                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Output the result in an element with id="demo"
                            var content_timer = "Rent Ends in : " + days + "d " + hours + "h "
                                + minutes + "m " + seconds + "s ";

                            $(timer_id).text(content_timer);



                            // If the count down is over, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                // document.getElementById("demo").innerHTML = "Available";
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                jQuery.ajax({
                                    url: "{{ route('deleteRent') }}",
                                    method: 'post',
                                    data: {
                                        id: response['id'],
                                    },
                                    success: function (response) {
                                        console.log(response);
                                        setTimeout(function () {
                                            location.reload();
                                        }, 800);
                                    }
                                });

                            }
                        }, 1000);

                        $("#exampleModal1 .modal-body ").append('<br>');
                        $("#exampleModal1 .modal-body ").append(response['code']);
                    }


                }
            });
        }

        $(function () {
            $('#addManageTable').footable().bind('footable_filtering', function (e) {
                var selected = $('.filter-status').find(':selected').text();
                if (selected && selected.length > 0) {
                    e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
                    e.clear = !e.filter;
                }
            });

            $('.clear-filter').click(function (e) {
                e.preventDefault();
                $('.filter-status').val('');
                $('table.demo').trigger('footable_clear_filter');
            });

            $('#checkAll').click(function () {
                checkAll(this);
            });

            $('a.delete-action, button.delete-action, a.confirm-action').click(function (e) {
                e.preventDefault(); /* prevents the submit or reload */
                var confirmation = confirm("{{ t('confirm_this_action') }}");

                if (confirmation) {
                    if ($(this).is('a')) {
                        var url = $(this).attr('href');
                        if (url !== 'undefined') {
                            redirect(url);
                        }
                    } else {
                        $('form[name=listForm]').submit();
                    }

                }

                return false;
            });
        });
    </script>
    <!-- include custom script for ads table [select all checkbox]  -->
    <script>
        function checkAll(bx) {
            var chkinput = document.getElementsByTagName('input');
            for (var i = 0; i < chkinput.length; i++) {
                if (chkinput[i].type == 'checkbox') {
                    chkinput[i].checked = bx.checked;
                }
            }
        }
    </script>


    <script>
        $("#setRentForm").submit(function (e) {
            e.preventDefault();
            let url = $(this).attr("action");
            $.post(url, $(this).serialize(), function (response) {

                $("#exampleModal1 .modal-body ").html('<div style="background-color: #80fc77; color:black; padding: 20px; border-radius: 5px;">Rent Schedule Saved successfully </div><br>');
                console.log(response);

                setTimeout(function () {
                    location.reload();
                }, 800);

            })
            //
            //
            //     .then(error,function () {
            //     alert(error)
            // });
            // $("#lottery-data").load(url);
        });
    </script>
    <!--countdown script here   -->
    <script>
        function delete_rent(id) {
            // e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TO	KEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ route('deleteRent') }}",
                method: 'post',
                data: {
                    id: id,
                },
                success: function (response) {
                    console.log(response);
                    $("#exampleModal1 .modal-body ").html('<div style="background-color: #80fc77; color:black; padding: 20px; border-radius: 5px;">Rent Schedule ended successfully </div><br>');
                    // $("#exampleModal1 .modal-body ").append(response);

                    setTimeout(function () {
                        location.reload();
                    }, 800);
                }
            });

        }
    </script>
@endsection
