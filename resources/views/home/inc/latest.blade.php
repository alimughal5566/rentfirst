<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
if (config('settings.listing.display_mode') == '.compact-view') {
    $colDescBox = 'col-sm-9 col-12';
    $colPriceBox = 'col-sm-3 col-12';
} else {
    $colDescBox = 'col-sm-7 col-12';
    $colPriceBox = 'col-sm-3 col-12';
}
$hideOnMobile = '';
if (isset($latestOptions, $latestOptions['hide_on_mobile']) and $latestOptions['hide_on_mobile'] == '1') {
    $hideOnMobile = ' hidden-sm';
}
?>
@if (isset($latest) && !empty($latest) && $latest->posts->count() > 0)
    @includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile])
    <div class="container{{ $hideOnMobile }}">
        <div class="col-xl-12 content-box layout-section">
            <div class="row row-featured row-featured-category">

                <div class="col-xl-12 box-title no-border">
                    <div class="inner">
                        <h2>
                            <span class="title-3">{!! $latest->title !!}</span>
                            <a href="{{ $latest->link }}" class="sell-your-item">
                                {{ t('View more') }} <i class="icon-th-list"></i>
                            </a>
                        </h2>
                    </div>
                </div>

                <div id="postsList" class="adds-wrapper noSideBar category-list pt-3">
                    @foreach($latest->posts as $key => $post)
                        @continue(empty($post->city))
                        <?php
                        // Main Picture
                        if ($post->pictures->count() > 0) {
                            $postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
                        } else {
                            $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
                        }
                        ?>
                        <div class="item-list">
                            @if ($post->featured == 1)
                                @if (isset($post->latestPayment, $post->latestPayment->package) && !empty($post->latestPayment->package))
                                    @if ($post->latestPayment->package->ribbon != '')
                                        <div class="cornerRibbons {{ $post->latestPayment->package->ribbon }}">
                                            <a href="#"> {{ $post->latestPayment->package->short_name }}</a>
                                        </div>
                                    @endif
                                @endif
                            @endif

                            <div class="row-wrapper">
                                <div class="no-padding photobox">
                                    <div class="add-image">
                                        <div class="fixed-fav d-flex align-items-center">
                                            @if (isset($post->latestPayment, $post->latestPayment->package) && !empty($post->latestPayment->package))
                                                @if ($post->latestPayment->package->has_badge == 1)
                                                    <a class="btn btn-danger btn-sm make-favorite">
                                                        <i class="fa fa-certificate"></i>
                                                        <span> {{ $post->latestPayment->package->short_name }} </span>
                                                    </a>&nbsp;
                                                @endif
                                            @endif
                                            @if (isset($post->savedByLoggedUser) && $post->savedByLoggedUser->count() > 0)
                                                <a class="btn btn-success btn-sm make-favorite" id="{{ $post->id }}">
                                                    <i class="fa fa-heart"></i><span> {{ t('Saved') }} </span>
                                                </a>
                                            @else
                                                <a class="btn btn-default btn-sm make-favorite mx-2"
                                                   id="{{ $post->id }}">
                                                    <i class="fa fa-heart"></i><span> {{ t('Save') }} </span>
                                                </a>
                                            @endif
                                            <span class="photo-count position-unset"><i class="fa fa-camera"></i> {{ $post->pictures->count() }} </span>
                                        </div>

                                        <a class="img-wrap" href="{{ \App\Helpers\UrlGen::post($post) }}">
                                            <img class="lazyload img-thumbnail no-margin border-0" src="{{ $postImg }}"
                                                 alt="{{ $post->title }}">
                                        </a>
                                        @if(isset($post->rent))
                                            <h5 class="mt-3 tick_time" data-date="{{$post->rent->rent_endtime}}"
                                                id="timer_{{$post->rent->id}}">
                                                {{--                                                {{$post->rent->rent_endtime}}--}}
                                                <span class="days"></span>
                                                <span class="hours"></span>
                                                <span class="minutes"></span>
                                                <span class="seconds"></span>
                                            </h5>

                                            <script>
                                                document.addEventListener('readystatechange', event => {
                                                    if (event.target.readyState === "complete") {
                                                        var clockdiv = document.getElementsByClassName("tick_time");
                                                        var countDownDate = new Array();
                                                        for (var i = 0; i < clockdiv.length; i++) {
                                                            countDownDate[i] = new Array();
                                                            countDownDate[i]['el'] = clockdiv[i];
                                                            countDownDate[i]['time'] = new Date(clockdiv[i].getAttribute('data-date')).getTime();
                                                            countDownDate[i]['days'] = 0;
                                                            countDownDate[i]['hours'] = 0;
                                                            countDownDate[i]['seconds'] = 0;
                                                            countDownDate[i]['minutes'] = 0;
                                                        }

                                                        var countdownfunction = setInterval(function () {
                                                            for (var i = 0; i < countDownDate.length; i++) {
                                                                var now = new Date().getTime();
                                                                var distance = countDownDate[i]['time'] - now;
                                                                countDownDate[i]['days'] = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                countDownDate[i]['hours'] = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                countDownDate[i]['minutes'] = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                countDownDate[i]['seconds'] = Math.floor((distance % (1000 * 60)) / 1000);

                                                                if (distance < 0) {
                                                                    countDownDate[i]['el'].querySelector('.days').innerHTML = "";
                                                                    countDownDate[i]['el'].querySelector('.hours').innerHTML = "";
                                                                    countDownDate[i]['el'].querySelector('.minutes').innerHTML = "";
                                                                    countDownDate[i]['el'].querySelector('.seconds').innerHTML = "";
                                                                } else {
                                                                    countDownDate[i]['el'].querySelector('.days').innerHTML = countDownDate[i]['days'] + 'd';
                                                                    countDownDate[i]['el'].querySelector('.hours').innerHTML = countDownDate[i]['hours'] + 'h';
                                                                    countDownDate[i]['el'].querySelector('.minutes').innerHTML = countDownDate[i]['minutes'] + 'm';
                                                                    countDownDate[i]['el'].querySelector('.seconds').innerHTML = countDownDate[i]['seconds'] + 's';
                                                                }

                                                            }
                                                        }, 1000);
                                                    }
                                                });
                                            </script>
                                        @endif

                                    </div>
                                </div>

                                <div class="price-box mt-3">
                                    <h4 class="item-price pb-0 text-center d-flex align-items-center justify-content-center">
                                        @if (isset($post->category, $post->category->type))
                                            @if (!in_array($post->category->type, ['not-salable']))
                                                @if (is_numeric($post->price) && $post->price > 0)
                                                    {!! \App\Helpers\Number::money($post->price) !!}
                                                @elseif(is_numeric($post->price) && $post->price == 0)
                                                    {!! t('free_as_price') !!}
                                                @else
                                                    {!! \App\Helpers\Number::money(' --') !!}
                                                @endif
                                            @endif
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </h4>
                                </div>

                                <div class="add-desc-box">
                                    <div class="items-details">
                                        <h5 class="add-title text-center">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}">{{ \Illuminate\Support\Str::limit($post->title, 70) }}</a>
                                        </h5>

                                        <span class="info-row d-flex flex-column align-items-center text-center">
											@if (isset($post->postType) && !empty($post->postType))
                                                <span class="add-type business-ads tooltipHere"
                                                      data-toggle="tooltip" data-placement="bottom"
                                                      title="{{ $post->postType->name }}">
													{{ strtoupper(mb_substr($post->postType->name, 0, 1)) }}
												</span>&nbsp;
                                            @endif
                                            @if (!config('settings.listing.hide_dates'))
                                                <span class="date">
													<i class="icon-clock"></i> {!! $post->created_at_formatted !!}
												</span>
                                            @endif
											<span class="category"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
												<i class="icon-folder-circled"></i>&nbsp;
												@if (isset($post->category->parent) && !empty($post->category->parent))
                                                    <a href="{!! \App\Helpers\UrlGen::category($post->category->parent) !!}"
                                                       class="info-link">
														{{ $post->category->parent->name }}
													</a>&nbsp;&raquo;&nbsp;
                                                @endif
												<a href="{!! \App\Helpers\UrlGen::category($post->category) !!}"
                                                   class="info-link">
													{{ $post->category->name }}
												</a>
											</span>
											<span class="item-location"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
												<i class="icon-location-2"></i>&nbsp;
												<a href="{!! \App\Helpers\UrlGen::city($post->city) !!}"
                                                   class="info-link">
													{{ $post->city->name }}
												</a>
												{{ (isset($post->distance)) ? '- ' . round($post->distance, 2) . getDistanceUnit() : '' }}
											</span>
										</span>
                                    </div>

                                    @if (config('plugins.reviews.installed'))
                                        @if (view()->exists('reviews::ratings-list'))
                                            @include('reviews::ratings-list')
                                        @endif
                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                    <div style="clear: both"></div>

                    @if (isset($latestOptions) && isset($latestOptions['show_view_more_btn']) && $latestOptions['show_view_more_btn'] == '1')
                        <div class="mt10 mb10 text-center wp-100 load-more">
                            <a href="{{ \App\Helpers\UrlGen::search() }}" class="btn btn-default mt10 px-4 px-md-5">
                                {{--                                <i class="fa fa-arrow-circle-right"></i> --}}
                                {{ 'Load more' }}
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endif

@section('after_scripts')
    @parent
    <script>
        /* Default view (See in /js/script.js) */
        @if (isset($posts) && count($posts) > 0)
        @if (config('settings.listing.display_mode') == '.grid-view')
        gridView('.grid-view');
        @elseif (config('settings.listing.display_mode') == '.list-view')
        listView('.list-view');
        @elseif (config('settings.listing.display_mode') == '.compact-view')
        compactView('.compact-view');
        @else
        gridView('.grid-view');
        @endif
        @else
        listView('.list-view');
        @endif
        /* Save the Search page display mode */
        var listingDisplayMode = readCookie('listing_display_mode');
        if (!listingDisplayMode) {
            createCookie('listing_display_mode', '{{ config('settings.listing.display_mode', '.grid-view') }}', 7);
        }

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
    </script>

@endsection