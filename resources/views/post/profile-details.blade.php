@extends('layouts.master')

@section('content')

<style >
  .category-list {
    box-shadow: none;
  }
  .main_profile_img {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.profile_img_data {
    display: flex;
    align-items: center;
}
.img_p_data h2 {
  font-size: 16px;
font-weight: 600;
text-transform: capitalize;
display: block;
margin-bottom: 5px;
padding: 0;
line-height: normal;

}
 span.icon-star-empty {
    color: #ffc32b;
}
 span.icon-star-empty {
    margin-top: 5px;
    font-size: 18px;
    margin-right: -9px;
}
  span.icon-star {
      color: #ffc32b;
      font-size: 14px !important;
  }
  span.icon-star-empty {
      font-size: 14px !important;
      margin-right: 0px !important;
  }
</style>

<div class="container">
    <div class="row">
    <div class="col-md-3">
        <div class="card card-user-info sidebar-card">
            <div class="block-cell user">
                <div class="cell-media">
                    <img src="{{ $user->getPhotoUrlAttribute($user->name) }}" alt="{{ $user->getNameAttribute($user->name) }}">
                </div>
                <div class="cell-content">
                        <span class="name">
                            @if (isset($user) and !empty($user))
                                <!-- <a href="{{ \App\Helpers\UrlGen::user($user) }}"> -->
                                <!-- {{$user->id}} -->
                                    <a href="{{route('profile.details',[$user->id]) }}">
                                {{ $user->name }}
                            </a>
                                @else
                                    {{ $user->name }}
                                @endif
                        </span>
                    <?php
                    $tot = 0;
                    $avg = 0;
                    $empty = 0;
                    if($user_reviews->count() > 0){
                        $sum = 0;
                        $tot = $user_reviews->count();
                        foreach($user_reviews as $revie){
                            $sum = $revie->rating + $sum;
                        }
                        $avg = $sum/$tot;
                        $avg = floor($avg);
                    }
                    $empty = 5 - $avg;
                    ?>
                    <div class="main_reviews">
                        <div class="rating">
                            <div class="reviews-widget ratings">
                                <p class="p-0 m-0">
                                    @for($i=0; $i<$avg; $i++)
                                        <span class="icon-star "></span>
                                    @endfor
                                    @for($i=0; $i<$empty; $i++)
                                        <span class="icon-star-empty "></span>
                                    @endfor
                                    <span class="rating-label d-inline"><small>({{$user_reviews->count()}})</small></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="card-body text-left">
                    <div class="grid-col">
                        <div class="col from">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Location</span>
                        </div>
                        <div class="col to">
                            <span>{{$user->country_code}}</span>
                        </div>
                    </div>
                    <div class="grid-col">
                        <div class="col from">
                            <i class="fas fa-user"></i>
                            <span>Joined</span>
                        </div>
                        <div class="col to">
                            <span>
                            <?php
                                $format1 = 'Y-m-d';
                                $format2 = 'H:i:s';
                                $date = Carbon\Carbon::parse($user->created_at)->format($format1);
                                $time = Carbon\Carbon::parse($user->created_at)->format($format2);
                            ?>
                                {{$date}} at {{$time}}
                            </span>
                        </div>
                    </div>
                </div>
{{--                @if(auth()->user()-id)--}}
{{--                    <div class="ev-action" style="border-top: 1px solid #ddd;">--}}
{{--                        <a href="tel:{{$user->phone}}" class="btn btn-warning phoneBlock btn-block"><i class="icon-phone-1"></i>{{$user->phone}}</a>--}}
{{--                    </div>--}}
{{--                @endif--}}

            </div>
        </div>
    </div>
  <div class="col-md-9 page-content col-thin-left">
     <div class="category-list make-grid">




        <div class="menu-overly-mask"></div>
        <!-- Mobile Filter bar End-->
        <div id="postsList" class="adds-wrapper row no-margin ">
          @forelse($posts as $post)
            <?php
              // Main Picture
              if ($post->pictures->count() > 0) {
                  $postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
              } else {
                  $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
              }
            ?>
           <div class="item-list" style="height: 364px;">
               @if($post->featured == 1)
                <div class="cornerRibbons orange">
                   <a href="#"> Premium</a>
                </div>
              @endif
              <div class="row-wrapper cat-wrap">
                 <div class="no-padding photobox mnh-unset mhp-100">
                    <div class="add-image">
                       <div class="fixed-fav d-flex align-items-center">
                           <span>
                               @if($post->rent)
                                  @php $rent_date = strtotime($post->rent->rent_endtime); $today = strtotime(date('Y-m-d h:i A')); @endphp
                                   @if($rent_date > $today)
                                       Unavailable
                                   @else
                                       Available
                                   @endif
                               @else
                                   Available
                               @endif
                           </span>
                          <span class="photo-count"><i class="fa fa-camera"></i> {{$post->pictures->count()}} </span>
                          @if($post->featured == 1)
                            <a class="btn btn-danger btn-sm make-favorite">
                              <i class="fa fa-certificate"></i>
                              <span> Premium </span>
                            </a>&nbsp;
                          @endif
                          <a class="btn btn-default btn-sm make-favorite" id="5">
                          <i class="fa fa-heart"></i><span> Save </span>
                          </a>
                       </div>
                       <a href="{{getPostUrl($post)}}">
                       <img class="lazyload img-thumbnail no-margin border-0" src="{{$postImg}}" alt="{{ $post->title }}">
                       </a>
                    </div>
                 </div>
                 <div class="text-center price-box mt-3" style="white-space: nowrap;">
                    <h4 class="item-price">
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
                 <div class="add-desc-box col-sm-9">
                    <div class="items-details">
                       <h5 class="add-title text-center">
                          {!! getPostUrl($post) !!}
                       </h5>
                       <span class="info-row d-flex flex-column align-items-center text-center">
                       <span class="date">
                       <i class="icon-clock"></i> {{$post->created_at}}
                       </span>
                       <span class="category">
                       <i class="icon-folder-circled"></i>&nbsp;
                       <a href="{{ \App\Helpers\UrlGen::category($post->category) }}" class="info-link">
                         {{$post->category->name}}
                       </a>
                       </span>
                       <span class="item-location">
                       <i class="icon-location-2"></i>&nbsp;
                       {!! $post->getCityHtml() !!}
                       </span>
                       </span>
                    </div>
                    <div class="reviews-widget ratings info-row text-center d-flex flex-column">
                      <?php
                      $avg = 0;
                      $empty = 0;
                      if($post->reviews->count() > 0){
                        $sum = 0;
                        $tot = $post->reviews->count();
                        foreach($post->reviews as $revie){
                          $sum = $revie->rating + $sum;
                        }
                        $avg = $sum/$tot;
                        $avg = floor($avg);

                        // dd($avg);
                      }
                      $empty = 5 - $avg;
                       ?>
                       <span class="stars-wrap">
                         @for($i=0; $i<$avg; $i++)
                            <span class="icon-star "></span>
                         @endfor
                         @for($i=0; $i<$empty; $i++)
                            <span class="icon-star-empty "></span>
                         @endfor

                       </span>
                       <span class="rating-label">{{$post->reviews->count()}} review(s)</span>
                    </div>
                 </div>
              </div>
           </div>
         @empty
            <p>There is not any ad(s) available. </p>
         @endforelse

        </div>
        <hr>
        @if ($user_reviews)
            @foreach($user_reviews as $review)
                <div class="row comments">
                    <div class="col-md-12">
                        @for ($i=1; $i <= 5 ; $i++)
                            <span class="icon-star{{ ($i <= $review->rating) ? '' : '-empty'}}"></span>
                        @endfor

                        <span class="rating-label">
                            @if($review->reviewer_id)
                                <a href="{{route('profile.details',[$review->reviewer->id]) }}">
                                    {{ $review->reviewer->name }}
                                </a>
                                ( {!! getPostUrl($review->post) !!} )
                            @else
                                <a href="{{route('profile.details',[$review->user->id]) }}">
                                    {{ $review->user->name }}
                                </a>
                                on {!! getPostUrl($review->post) !!}
                            @endif

{{--                            {{ $review->user ? $review->user->name : trans('reviews::messages.Anonymous') }}--}}
{{--                            @if (auth()->check() and isset($review->user))--}}
{{--                                @if (auth()->user()->id == $review->user->id)--}}
{{--                                    [<a href="{{ lurl('review/delete/' . $review->id) }}" class="delete-comment">{{ trans('reviews::messages.Delete') }}</a>]--}}
{{--                                @endif--}}
{{--                            @endif--}}
                        </span>
                        <br>
                        <br>
                        <span class="pull-right">{{ $review->timeago }}</span>

                        <p>{!! $review->comment !!}</p>

                    </div>
                </div>
                <hr>
            @endforeach

            <nav class="mb-3">
            </nav>

        @endif
        <!-- <h3 class="text-left float-left font-weight-bold">Reviews <small>5 (2)</small></h3>
        <div class="adds-wrapper row no-margin justify-content-center pb-3 ">
           <div class="card mb-3 adds-wrapper row no-margin justify-content-center ">
              <div class="row no-gutters">
                 <div class="col-md-1">
                    <img src="http://rentfirst.ivylabtech.com/images/site/cat.png" height="50px" class="ml-3 mt-3 " alt="...">
                 </div>
                 <div class="col-md-10">
                    <div class="card-body pb-0">
                       <p class="card-text float-right text-right"><small class="text-muted">6 hours ago</small></p>
                       <h5 class="card-title p-0 m-0">Ali Hassan</h5>
                       <p class="card-text p-0 m-0">Aute voluptatibus ut</p>
                       <div class="rating">
                          <div class="reviews-widget ratings text-warning">
                             <p class="p-0 m-0">
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                             </p>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="card mb-3 adds-wrapper row no-margin justify-content-center ">
              <div class="row no-gutters">
                 <div class="col-md-1">
                    <img src="http://rentfirst.ivylabtech.com/images/site/cat.png" height="50px" class="ml-3 mt-3 " alt="...">
                 </div>
                 <div class="col-md-10">
                    <div class="card-body pb-0">
                       <p class="card-text float-right text-right"><small class="text-muted">6 hours ago</small></p>
                       <h5 class="card-title p-0 m-0">Ali Hassan</h5>
                       <p class="card-text p-0 m-0">Aute voluptatibus ut</p>
                       <div class="rating">
                          <div class="reviews-widget ratings text-warning">
                             <p class="p-0 m-0">
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                             </p>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div> -->
     </div>
     <nav class="pagination-bar mb-5 pagination-sm" aria-label="">
     </nav>
  </div>
    </div>
</div>

@endsection
