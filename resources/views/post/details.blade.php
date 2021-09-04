@extends('layouts.master')

@section('content')
<script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>

<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

<style>
.carousel-container {
  position: relative;
}
.carousel-item img {
  object-fit: cover;
}
#carousel-thumbs {
  background: rgba(255,255,255,.3);
  bottom: 0;
  left: 0;
  padding: 0 50px;
  position: absolute;
  right: 0;
}
#carousel-thumbs img {
  border: 5px solid transparent;
  cursor: pointer;
}
#carousel-thumbs img:hover {
  border-color: rgba(255,255,255,.3);
}
#carousel-thumbs .selected img {
  border-color: #fff;
}
.carousel-control-prev,
.carousel-control-next {
  width: 50px;
}

</style>


    {!! csrf_field() !!}
    <input type="hidden" id="postId" name="post_id" value="{{ $post->id }}">

    @if (Session::has('flash_notification'))
        @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
        <?php $paddingTopExists = true; ?>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    @include('flash::message')
                </div>
            </div>
        </div>
        <?php Session::forget('flash_notification.message'); ?>
    @endif

    <div class="main-container">

        <?php if (\App\Models\Advertising::where('slug', 'top')->count() > 0): ?>
        @includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.top', 'layouts.inc.advertising.top'], ['paddingTopExists' => (isset($paddingTopExists)) ? $paddingTopExists : false])
        <?php
        $paddingTopExists = false;
    endif;
    ?>
        @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])

        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <nav aria-label="breadcrumb" role="navigation" class="pull-left">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home fa"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ config('country.name') }}</a></li>
                            @if (isset($catBreadcrumb) and is_array($catBreadcrumb) and count($catBreadcrumb) > 0)
                                @foreach($catBreadcrumb as $key => $value)
                                    <li class="breadcrumb-item">
                                        <a href="{{ $value->get('url') }}">
                                            {!! $value->get('name') !!}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            <li class="breadcrumb-item active"
                                aria-current="page">{{ \Illuminate\Support\Str::limit($post->title, 70) }}</li>
                        </ol>
                    </nav>

                    <div class="pull-right backtolist">
                        <a href="{{ rawurldecode(url()->previous()) }}">
                            <i class="fa fa-angle-double-left"></i> {{ t('back_to_results') }}</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-9 page-content col-thin-right">
                    <div class="inner inner-box items-details-wrapper pb-0">
                        <h2 class="enable-long-words">
                            <strong>
                                <a href="{{ \App\Helpers\UrlGen::post($post) }}" title="{{ $post->title }}">
                                    {{ $post->title }}
                                </a>
                            </strong>
                            @if (isset($post->postType) and !empty($post->postType))
                                <small class="label label-default adlistingtype">{{ $post->postType->name }}</small>
                            @endif
                            @if ($post->featured==1 and !empty($post->latestPayment))
                                @if (isset($post->latestPayment->package) and !empty($post->latestPayment->package))
                                    <i class="icon-ok-circled tooltipHere"
                                       style="color: {{ $post->latestPayment->package->ribbon }};" title=""
                                       data-placement="bottom" data-toggle="tooltip"
                                       data-original-title="{{ $post->latestPayment->package->short_name }}"></i>
                                @endif
                            @endif
                        </h2>

<?php $titleSlug = \Illuminate\Support\Str::slug($post->title); ?>
                        <div class="container">
      <div class="carousel-container row">

      <!-- Sorry! Lightbox doesn't work - yet. -->

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          @if (count($post->pictures) > 0)
            @foreach($post->pictures as $key => $image)
              @if($key == 0)
                <div class="carousel-item active" data-slide-number="{{$key}}">
                  <img src="{{ imgUrl($image->filename)}}" class="d-block w-100"  alt="{{ $titleSlug}} " data-remote="{{ imgUrl($image->filename)}}" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                </div>
              @else
                <div class="carousel-item " data-slide-number="{{$key}}">
                  <img src="{{ imgUrl($image->filename)}}" class="d-block w-100" alt="{{ $titleSlug}}" data-remote="{{ imgUrl($image->filename)}}" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                </div>
              @endif
            @endforeach
          @endif
        </div>
      </div>

      <!-- Carousel Navigation -->
      <div id="carousel-thumbs" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row mx-0">
              @if (count($post->pictures) > 0)
                @foreach($post->pictures as $key => $image)
                  @if($key < 6)
                    <div id="carousel-selector-{{$key}}" class="thumb col-2 px-1 py-2 {{ $key == 0 ? 'selected' : '' }}" data-target="#myCarousel" data-slide-to="0">
                      <img src="{{ imgUrl($image->filename) }}" class="img-fluid" alt="">
                    </div>
                  @endif
                @endforeach
              @endif
            </div>
          </div>
          @if(count($post->pictures)>6)
          <div class="carousel-item">
            <div class="row mx-0">
              @if (count($post->pictures) > 0)
                @foreach($post->pictures as $key => $image)
                  @if($key > 5)
                    <div id="carousel-selector-{{$key}}" class="thumb col-2 px-1 py-2 {{ $key == 0 ? 'selected' : '' }}" data-target="#myCarousel" data-slide-to="0">
                      <img src="{{ imgUrl($image->filename) }}" class="img-fluid" alt="">
                    </div>
                  @endif
                @endforeach
              @endif
              <div class="col-2 px-1 py-2"></div>
              <div class="col-2 px-1 py-2"></div>
            </div>
          </div>
          @endif
        </div>
        <a class="carousel-control-prev" href="#carousel-thumbs" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-thumbs" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      </div> <!-- /row -->
      </div> <!-- /container -->



                        <!-- <div class="posts-image">
                            <?php $titleSlug = \Illuminate\Support\Str::slug($post->title); ?>

                            @if (count($post->pictures) > 0)
                                <ul class="bxslider">
                                    @foreach($post->pictures as $key => $image)
                                        <li>
                                            <img src="{{ imgUrl($image->filename, 'big') }}"
                                                 alt="{{ $titleSlug . '-big-' . $key }}">
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="product-view-thumb-wrapper">
                                    <ul id="bx-pager" class="product-view-thumb">
                                        @foreach($post->pictures as $key => $image)
                                            <li>
                                                <a class="thumb-item-link" data-slide-index="{{ $key }}" href="">
                                                    <img src="{{ imgUrl($image->filename, 'small') }}"
                                                         alt="{{ $titleSlug . '-small-' . $key }}">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <ul class="bxslider">
                                    <li>
                                        <img src="{{ imgUrl(config('larapen.core.picture.default'), 'big') }}"
                                             alt="img">
                                    </li>
                                </ul>
                                <div class="product-view-thumb-wrapper">
                                    <ul id="bx-pager" class="product-view-thumb">
                                        <li>
                                            <a class="thumb-item-link" data-slide-index="0" href="">
                                                <img src="{{ imgUrl(config('larapen.core.picture.default'), 'small') }}"
                                                     alt="img">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div> -->
                        <!--posts-image-->

                        <div class="items-details">
                            <ul class="nav nav-tabs" id="itemsDetailsTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="item-details-tab" data-toggle="tab"
                                       href="#item-details" role="tab" aria-controls="item-details"
                                       aria-selected="true">
                                        <h4>{{ t('ad_details') }}</h4>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="item-description-tab" data-toggle="tab"
                                       href="#item-description" role="tab" aria-controls="item-description"
                                       aria-selected="false">
                                        <h4>{{ 'Description' }}</h4>
                                    </a>
                                </li>
                                {{--                                @if (config('plugins.reviews.installed'))--}}
                                {{--                                    <li class="nav-item">--}}
                                {{--                                        <a class="nav-link" id="item-{{ config('plugins.reviews.name') }}-tab"--}}
                                {{--                                           data-toggle="tab" href="#item-{{ config('plugins.reviews.name') }}"--}}
                                {{--                                           role="tab" aria-controls="item-{{ config('plugins.reviews.name') }}"--}}
                                {{--                                           aria-selected="false">--}}
                                {{--                                            <h4>--}}
                                {{--                                                {{ trans('reviews::messages.Reviews') }}--}}
                                {{--                                                @if (isset($rvPost) and !empty($rvPost))--}}
                                {{--                                                    ({{ $rvPost->rating_count }})--}}
                                {{--                                                @endif--}}
                                {{--                                            </h4>--}}
                                {{--                                        </a>--}}
                                {{--                                    </li>--}}
                                {{--                                @endif--}}
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 mt-4 mb-3" id="itemsDetailsTabsContent">
                                <div class="tab-pane show active" id="item-details" role="tabpanel"
                                     aria-labelledby="item-details-tab">
                                    <div class="row">
                                        <div class="items-details-info col-md-12 col-sm-12 col-xs-12 enable-long-words from-wysiwyg">


                                            <!-- Custom Fields -->
                                        @includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.fields-values', 'post.inc.fields-values'])

                                        <!-- Tags -->
                                            @if (!empty($post->tags))
                                                <?php $tags = array_map('trim', explode(',', $post->tags)); ?>
                                                @if (!empty($tags))
                                                    <div class="row">
                                                        <div class="tags col-12">
                                                            <h4><i class="icon-tag"></i> {{ t('Tags') }}:</h4>
                                                            @foreach($tags as $iTag)
                                                                <a href="{{ \App\Helpers\UrlGen::tag($iTag) }}">
                                                                    {{ $iTag }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                        </div>

                                        <br>
                                    </div>
                                </div>

                                <div class="tab-pane" id="item-description" role="tabpanel"
                                     aria-labelledby="item-description-tab">
                                    <div class="row">
                                        <div class="items-details-info col-md-12 col-sm-12 col-xs-12 enable-long-words from-wysiwyg">
                                            <div class="row">
                                                <!-- Location -->
                                                <div class="detail-line-lite col-md-6 col-sm-6 col-xs-6">
                                                    <div>
                                                        <span><i class="fas fa-map-marker-alt"></i> {{ t('location') }}: </span>
                                                        <span>
															<a href="{!! \App\Helpers\UrlGen::city($post->city) !!}">
																{{ $post->city->name }}
															</a>
														</span>
                                                    </div>
                                                </div>

                                            @if (!in_array($post->category->type, ['not-salable']))
                                                <!-- Price / Salary -->
                                                    <div class="detail-line-lite col-md-6 col-sm-6 col-xs-6">
                                                        <div>
															<span>
																{{ (!in_array($post->category->type, ['job-offer', 'job-search'])) ? t('price') : t('Salary') }}:
															</span>
                                                            <span>
																@if ($post->price > 0)
                                                                    {!! \App\Helpers\Number::money($post->price) !!}
                                                                @else
                                                                    {!! \App\Helpers\Number::money(' --') !!}
                                                                @endif
                                                                @if ($post->negotiable == 1)
                                                                    <small class="label badge-success"> {{ t('negotiable') }}</small>
                                                                @endif
															</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <hr>

                                            <!-- Description -->
                                            <div class="row">
                                                <div class="col-12 detail-line-content">
                                                    {!! transformDescription($post->description) !!}
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="row detail-line-action text-center">
                                                <div class="col-4">
                                                    @if (auth()->check())
                                                        @if (auth()->user()->id == $post->user_id)
                                                            <a href="{{ url('posts/' . $post->id . '/edit') }}">
                                                                <i class="icon-pencil-circled tooltipHere"
                                                                   data-toggle="tooltip"
                                                                   data-original-title="{{ t('Edit') }}"></i>
                                                            </a>
                                                        @else
                                                            {{--															{!! genEmailContactBtn($post, false, true) !!}--}}
                                                        @endif
                                                    @else
                                                        {{--														{!! genEmailContactBtn($post, false, true) !!}--}}
                                                    @endif
                                                </div>
                                                <div class="col-4">
                                                    <!-- <a class="make-favorite" id="{{ $post->id }}"
                                                       href="javascript:void(0)">
                                                        @if (auth()->check())
                                                            @if (\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() > 0)
                                                                <i class="fa fa-heart tooltipHere" data-toggle="tooltip"
                                                                   data-original-title="{{ t('Remove favorite') }}"></i>
                                                            @else
                                                                <i class="tooltipHere far fa-heart"
                                                                   data-toggle="tooltip"
                                                                   data-original-title="{{ t('Save ad') }}"></i>
                                                            @endif
                                                        @else
                                                            <i class="tooltipHere far fa-heart"
                                                               data-toggle="tooltip"
                                                               data-original-title="{{ t('Save ad') }}"></i>
                                                        @endif
                                                    </a> -->
                                                </div>
                                                <div class="col-4">
                                                    <a href="{{ url('posts/' . $post->id . '/report') }}">
                                                        <i class="fa icon-info-circled-alt tooltipHere"
                                                           data-toggle="tooltip"
                                                           data-original-title="{{ t('Report abuse') }}"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.tab content -->

                            <div class="content-footer text-left">
                                @if (auth()->check())
                                    @if (auth()->user()->id == $post->user_id)
                                        <a class="btn btn-default" href="{{ \App\Helpers\UrlGen::editPost($post) }}">
                                            <i class="fa fa-pencil-square-o"></i> {{ t('Edit') }}</a>
                                    @else
                                        {!! genPhoneNumberBtn($post) !!}
                                        {{--										{!! genEmailContactBtn($post) !!}--}}
                                    @endif
                                @else
                                    {!! genPhoneNumberBtn($post) !!}
                                    {{--									{!! genEmailContactBtn($post) !!}--}}
                                @endif
                            </div>
                        </div>

                        <div class="items-details pb-3">
                            <div class="mt-3">
                                @if (config('plugins.reviews.installed'))
                                    @if (view()->exists('reviews::ratings-single'))
                                        @include('reviews::ratings-single')
                                    @endif
                                @endif
                            </div>

                            <h4>
                                {{ trans('reviews::messages.Reviews') }}
                                @if (isset($rvPost) and !empty($rvPost))
                                    ({{ $rvPost->rating_count }})
                                @endif
                            </h4>

                            @if (config('plugins.reviews.installed'))
                                @if (view()->exists('reviews::comments'))
                                    @include('reviews::comments')
                                @endif
                            @endif

                        </div>
                    </div>
                    <!--/.items-details-wrapper-->
                </div>
                <!--/.page-content-->

                <div class="col-lg-3 page-sidebar-right">
                    <aside>
                    <div class="main_price">
                        <div class="p_price">
                            @if (!in_array($post->category->type, ['not-salable']))
                                <h1 class="price_rs">
                                    @if ($post->price > 0)
                                        {!! \App\Helpers\Number::money($post->price) !!}
                                    @else
                                        {!! \App\Helpers\Number::money(' --') !!}
                                    @endif
                                </h1>
                            @endif
                            <a class="make-favorite" id="{{ $post->id }}"
                                href="javascript:void(0)">
                                @if (auth()->check())
                                    @if (\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() > 0)
                                        <i class="fa fa-heart tooltipHere" data-toggle="tooltip"
                                            data-original-title="{{ t('Remove favorite') }}"></i>
                                    @else
                                        <i class="tooltipHere far fa-heart"
                                            data-toggle="tooltip"
                                            data-original-title="{{ t('Save ad') }}"></i>
                                    @endif
                                @else
                                    <i class="tooltipHere far fa-heart"
                                        data-toggle="tooltip"
                                        data-original-title="{{ t('Save ad') }}"></i>
                                @endif
                            </a>
                        </div>
                        <div class="detail_det">
                            <span class="info-row">
                                @if (!config('settings.single.hide_dates'))
                                    <span class="date"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
                                    <i class="icon-clock"></i> {!! $post->created_at_formatted !!}
                                </span>
                                @endif
                                <span class="category"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
                                    <i class="icon-folder-circled"></i> {{ (!empty($post->category->parent)) ? $post->category->parent->name : $post->category->name }}
                                </span>
                                <span class="item-location"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
                                    <i class="fas fa-map-marker-alt"></i> {{ $post->city->name }}
                                </span>
                                <span class="category"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
                                    <i class="icon-eye-3"></i> {{ \App\Helpers\Number::short($post->visits) }} {{ trans_choice('global.count_views', getPlural($post->visits)) }}
                                </span>
                            </span>
                        </div>
                    </div>
                        <div class="card card-user-info sidebar-card">
                            @if (auth()->check() and auth()->id() == $post->user_id)
                                <div class="card-header">{{ t('Manage Ad') }}</div>
                            @else
                                <div class="block-cell user">
                                    <div class="cell-media">
                                        <img src="{{ $post->user_photo_url }}" alt="{{ $post->contact_name }}">
                                    </div>
                                    <div class="cell-content">
                                        <h5 class="title">{{ t('Posted by') }}</h5>
                                        <span class="name">
											@if (isset($user) and !empty($user))
                                                <!-- <a href="{{ \App\Helpers\UrlGen::user($user) }}"> -->
                                                <!-- {{$user->id}} -->
                                                  <a href="{{route('profile.details',[$user->id]) }}">
													{{ $post->contact_name }}
												</a>
                                            @else
                                                {{ $post->contact_name }}
                                            @endif
										</span>

                                        @if (config('plugins.reviews.installed'))
                                            @if (view()->exists('reviews::ratings-user'))
                                              @php $post_reviews = \App\Models\Post::with('reviews.user')->whereHas('reviews')->where('user_id',$post->user_id )->get();
                                                $rating=0;$total=0;
                                              @endphp
                                              @foreach($post_reviews as $post_review)
                                                @foreach($post_review->reviews as $review)
                                                    @php $rating+=$review->rating; $total+=1 @endphp
                                                @endforeach
                                              @endforeach
                                              @if (config('plugins.reviews.installed'))
                                                  @if (view()->exists('reviews::ratings-user'))
                                                      <div class="rating">
                                                          <div class="reviews-widget ratings">
                                                              <p class="p-0 m-0">
                                                                  @for ($i=1; $i <= 5 ; $i++)
                                                                      @if($total == 0)
                                                                          <span class="icon-star-empty"></span>
                                                                      @else
                                                                          <span class="icon-star{{ ($i <=  $rating/$total) ? '' : '-empty' }}"></span>
                                                                      @endif
                                                                  @endfor
                                                                  @if($total != 0 )
                                                                      <span class="rating-label d-inline"><small>({{$total}})</small></span>
                                                                  @else
                                                                      <span class="rating-label d-inline"><small>(0)</small></span>
                                                                  @endif
                                                              </p>
                                                          </div>
                                                      </div>
                                                  @endif
                                              @endif
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            @endif

                            <div class="card-content">
                                <?php $evActionStyle = 'style="border-top: 0;"'; ?>
                                @if (!auth()->check() or (auth()->check() and auth()->user()->getAuthIdentifier() != $post->user_id))
                                    <div class="card-body text-left">
                                        <div class="grid-col">
                                            <div class="col from">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>{{ t('location') }}</span>
                                            </div>
                                            <div class="col to">
												<span>
													<a href="{!! \App\Helpers\UrlGen::city($post->city) !!}">
														{{ $post->city->name }}
													</a>
												</span>
                                            </div>
                                        </div>
                                        @if (!config('settings.single.hide_dates'))
                                            @if (isset($user) and !empty($user) and !is_null($user->created_at_formatted))
                                                <div class="grid-col">
                                                    <div class="col from">
                                                        <i class="fas fa-user"></i>
                                                        <span>{{ t('Joined') }}</span>
                                                    </div>
                                                    <div class="col to">
                                                        <span>{!! $user->created_at_formatted !!}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <?php $evActionStyle = 'style="border-top: 1px solid #ddd;"'; ?>
                                @endif

                                <div class="ev-action" {!! $evActionStyle !!}>
                                    @if (auth()->check())
                                        @if (auth()->user()->id == $post->user_id)
                                            <a href="{{ \App\Helpers\UrlGen::editPost($post) }}"
                                               class="btn btn-default btn-block">
                                                <i class="fa fa-pencil-square-o"></i> {{ t('Update the Details') }}
                                            </a>
                                            @if (config('settings.single.publication_form_type') == '1')
                                                <a href="{{ url('posts/' . $post->id . '/photos') }}"
                                                   class="btn btn-default btn-block">
                                                    <i class="icon-camera-1"></i> {{ t('Update Photos') }}
                                                </a>
                                                @if (isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0)
                                                    <a href="{{ url('posts/' . $post->id . '/payment') }}"
                                                       class="btn btn-success btn-block">
                                                        <i class="icon-ok-circled2"></i> {{ t('Make It Premium') }}
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            <?php
                                            $req = App\Models\MessageRequest::where('user_id', auth()->id())->where('post_id', $post->id)->where('status', 0)->get();
                                            $check = App\Models\MessageRequest::where('user_id', auth()->id())->where('post_id', $post->id)->get();
                                            //											dd($post->id);
                                            ?>
                                            {!! genPhoneNumberBtn($post, true) !!}
                                            @php $rent_date = ''; if (isset($post->rent)){$rent_date = $post->rent->rent_endtime; } @endphp
                                            {!! sendRequest($rent_date) !!}
                                            {!! genEmailContactBtn($post, true) !!}
                                            <a class="btn btn-default btn-block" data-toggle="modal" data-target="#send_offer_request"><i class="far fa-envelope-open"></i> Send Offer Request</a>
                                            
                                            @if( $check->isEmpty() == 'asdfasdf')
                                                <form method="POST" action="{{route('sendRequest')}}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{auth()->id()}}">
                                                    <input type="hidden" name="post" value="{{$post}}">

                                                </form>
                                            @elseif(!$req->isEmpty() == 'asdfasdfasdf')
                                                {!! pendingRequest() !!}
                                            @else
                                              <!-- @php $rent_date = ''; if (isset($post->rent)){$rent_date = $post->rent->rent_endtime; } @endphp
                                              {!! sendRequest($rent_date) !!}
                                              {!! genEmailContactBtn($post, true) !!} -->
                                            @endif
                                        @endif

                                        <?php
                                        try {
                                            if (auth()->user()->can(\App\Models\Permission::getStaffPermissions())) {
                                                $btnUrl = admin_url('blacklists/add') . '?email=' . $post->email;

                                                if (!isDemo($btnUrl)) {
                                                    $cMsg = trans('admin.confirm_this_action');
                                                    $cLink = "window.location.replace('" . $btnUrl . "'); window.location.href = '" . $btnUrl . "';";
                                                    $cHref = "javascript: if (confirm('" . addcslashes($cMsg, "'") . "')) { " . $cLink . " } else { void('') }; void('')";

                                                    $btnText = trans('admin.ban_the_user');
                                                    $btnHint = trans('admin.ban_the_user_email', ['email' => $post->email]);
                                                    $tooltip = ' data-toggle="tooltip" data-placement="bottom" title="' . $btnHint . '"';

                                                    $btnOut = '';
                                                    $btnOut .= '<a href="' . $cHref . '" class="btn btn-danger btn-block"' . $tooltip . '>';
                                                    $btnOut .= $btnText;
                                                    $btnOut .= '</a>';

                                                    echo $btnOut;
                                                }
                                            }
                                        } catch (\Exception $e) {
                                        }
                                        ?>
                                    @else
                                        {!! genPhoneNumberBtn($post, true) !!}
                                        {{--										{!! genEmailContactBtn($post, true) !!}--}}
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (config('settings.single.show_post_on_googlemap'))
                            <div class="card sidebar-card">
                                <div class="card-header">{{ t('location_map') }}</div>
                                <div class="card-content">
                                    <div class="card-body text-left p-0">
                                        <div class="ads-googlemaps">
                                            <iframe id="googleMaps" width="100%" height="250" frameborder="0"
                                                    scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (isVerifiedPost($post))
                            @includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.social.horizontal', 'layouts.inc.social.horizontal'])
                        @endif

                        <div class="card sidebar-card">
                            <div class="card-header">{{ t('Safety Tips for Buyers') }}</div>
                            <div class="card-content">
                                <div class="card-body text-left">
                                    <ul class="list-check">
                                        <li> {{ t('Meet seller at a public place') }} </li>
                                        <li> {{ t('Check the item before you buy') }} </li>
                                        <li> {{ t('Pay only after collecting the item') }} </li>
                                    </ul>
                                    <?php $tipsLinkAttributes = getUrlPageByType('tips'); ?>
                                    @if (!\Illuminate\Support\Str::contains($tipsLinkAttributes, 'href="#"') and !\Illuminate\Support\Str::contains($tipsLinkAttributes, 'href=""'))
                                        <p>
                                            <a class="pull-right" {!! $tipsLinkAttributes !!}>
                                                {{ t('Know more') }}
                                                <i class="fa fa-angle-double-right"></i>
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

        </div>

        @if (config('settings.single.similar_posts') == '1' || config('settings.single.similar_posts') == '2')
            @includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.featured', 'home.inc.featured'], ['firstSection' => false])
        @endif

        @includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.bottom', 'layouts.inc.advertising.bottom'], ['firstSection' => false])

        @if (isVerifiedPost($post))
            @includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.facebook-comments', 'layouts.inc.tools.facebook-comments'], ['firstSection' => false])
        @endif

    </div>
@endsection

@section('modal_message')
    @if (config('settings.single.show_security_tips') == '1')
        @includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.security-tips', 'post.inc.security-tips'])
    @endif
    @if (auth()->check() or config('settings.single.guests_can_contact_ads_authors')=='1')
        @includeFirst([config('larapen.core.customizedViewPath') . 'account.messenger.modal.create', 'account.messenger.modal.create'])
    @endif
@endsection

@section('after_styles')
    <!-- bxSlider CSS file -->
    @if (config('lang.direction') == 'rtl')
        <link href="{{ url('assets/plugins/bxslider/jquery.bxslider.rtl.css') }}" rel="stylesheet"/>
    @else
        <link href="{{ url('assets/plugins/bxslider/jquery.bxslider.css') }}" rel="stylesheet"/>
    @endif
@endsection

@section('before_scripts')
    <script>
        var showSecurityTips = '{{ config('settings.single.show_security_tips', '0') }}';
    </script>
@endsection

@section('after_scripts')
    @if (config('services.googlemaps.key'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}"
                type="text/javascript"></script>
    @endif

    <!-- bxSlider Javascript file -->
    <script src="{{ url('assets/plugins/bxslider/jquery.bxslider.min.js') }}"></script>

    <script>
    $('#myCarousel').carousel({
  interval: false
});
$('#carousel-thumbs').carousel({
  interval: false
});

// handles the carousel thumbnails
// https://stackoverflow.com/questions/25752187/bootstrap-carousel-with-thumbnails-multiple-carousel
$('[id^=carousel-selector-]').click(function() {
  var id_selector = $(this).attr('id');
  var id = parseInt( id_selector.substr(id_selector.lastIndexOf('-') + 1) );
  $('#myCarousel').carousel(id);
});
// when the carousel slides, auto update
$('#myCarousel').on('slide.bs.carousel', function(e) {
  var id = parseInt( $(e.relatedTarget).attr('data-slide-number') );
  $('[id^=carousel-selector-]').removeClass('selected');
  $('[id=carousel-selector-'+id+']').addClass('selected');
});
// when user swipes, go next or previous
$('#myCarousel').swipe({
  fallbackToMouseEvents: true,
  swipeLeft: function(e) {
    $('#myCarousel').carousel('next');
  },
  swipeRight: function(e) {
    $('#myCarousel').carousel('prev');
  },
  allowPageScroll: 'vertical',
  preventDefaultEvents: false,
  threshold: 75
});
/*
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
  event.preventDefault();
  $(this).ekkoLightbox();
});
*/

$('#myCarousel .carousel-item img').on('click', function(e) {
  var src = $(e.target).attr('data-remote');
  if (src) $(this).ekkoLightbox();
});
</script>


    <script>
        /* Favorites Translation */
        var lang = {
            labelSavePostSave: "{!! t('Save ad') !!}",
            labelSavePostRemove: "{!! t('Remove favorite') !!}",
            loginToSavePost: "{!! t('Please log in to save the Ads') !!}",
            loginToSaveSearch: "{!! t('Please log in to save your search') !!}",
            confirmationSavePost: "{!! t('Post saved in favorites successfully') !!}",
            confirmationRemoveSavePost: "{!! t('Post deleted from favorites successfully') !!}",
            confirmationSaveSearch: "{!! t('Search saved successfully') !!}",
            confirmationRemoveSaveSearch: "{!! t('Search deleted successfully') !!}"
        };

        $(document).ready(function () {
            $('[rel="tooltip"]').tooltip({trigger: "hover"});

            /* bxSlider - Main Images */
            $('.bxslider').bxSlider({
                touchEnabled: {{ (count($post->pictures) > 1) ? 'true' : 'false' }},
                speed: 1000,
                pagerCustom: '#bx-pager',
                adaptiveHeight: true,
                nextText: '{{ t('bxslider.nextText') }}',
                prevText: '{{ t('bxslider.prevText') }}',
                startText: '{{ t('bxslider.startText') }}',
                stopText: '{{ t('bxslider.stopText') }}',
                onSlideAfter: function ($slideElement, oldIndex, newIndex) {
                    @if (!userBrowser('Chrome'))
                    $('#bx-pager li:not(.bx-clone)').eq(newIndex).find('a.thumb-item-link').addClass('active');
                    @endif
                }
            });

            /* bxSlider - Thumbnails */
            @if (userBrowser('Chrome'))
            $('#bx-pager').addClass('m-3');
            $('#bx-pager .thumb-item-link').unwrap();
                    @else
            var thumbSlider = $('.product-view-thumb').bxSlider(bxSliderSettings());
            $(window).on('resize', function () {
                thumbSlider.reloadSlider(bxSliderSettings());
            });
            @endif

            @if (config('settings.single.show_post_on_googlemap'))
            /* Google Maps */
            getGoogleMaps(
                '{{ config('services.googlemaps.key') }}',
                '{{ (isset($post->city) and !empty($post->city)) ? addslashes($post->city->name) . ',' . config('country.name') : config('country.name') }}',
                '{{ config('app.locale') }}'
            );
            @endif

            /* Keep the current tab active with Twitter Bootstrap after a page reload */
            /* For bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line */
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                /* save the latest tab; use cookies if you like 'em better: */
                localStorage.setItem('lastTab', $(this).attr('href'));
            });
            /* Go to the latest tab, if it exists: */
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
        });

        /* bxSlider - Initiates Responsive Carousel */
        function bxSliderSettings() {
            var smSettings = {
                slideWidth: 65,
                minSlides: 1,
                maxSlides: 4,
                slideMargin: 5,
                adaptiveHeight: true,
                pager: false
            };
            var mdSettings = {
                slideWidth: 100,
                minSlides: 1,
                maxSlides: 4,
                slideMargin: 5,
                adaptiveHeight: true,
                pager: false
            };
            var lgSettings = {
                slideWidth: 100,
                minSlides: 3,
                maxSlides: 6,
                pager: false,
                slideMargin: 10,
                adaptiveHeight: true
            };

            if ($(window).width() <= 640) {
                return smSettings;
            } else if ($(window).width() > 640 && $(window).width() < 768) {
                return mdSettings;
            } else {
                return lgSettings;
            }
        }
    </script>
@endsection
