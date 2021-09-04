@extends('layouts.master')

@section('search')
    @parent
@endsection

@section('content')
    <div class="main-container" id="homepage">
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
        @endif

        @if (isset($sections) and $sections->count() > 0)
            @foreach($sections as $section)
                @if (view()->exists($section->view))
                    @includeFirst([config('larapen.core.customizedViewPath') . $section->view, $section->view], ['firstSection' => $loop->first])
                @endif
            @endforeach
        @endif

        <div class="above-footer-banner mx-auto w-100">
            @php  $above_footer = \App\Models\Setting::where('key', 'above_footer')->first(); @endphp
            @isset($above_footer)
                @foreach($above_footer->value as $image)
                    @if($image['status']=='on')
                         <img class="img-fluid" src="{{asset('images/'.$image['image'])}}" alt="">
                          @break
                    @endif
                 @endforeach
            @endisset
        </div>

    </div>
@endsection

@section('after_scripts')
    <script>
        @if (config('settings.optimization.lazy_loading_activation') == 1)
        $(document).ready(function () {
            $('#postsList').each(function () {
                var $masonry = $(this);
                var update = function () {
                    $.fn.matchHeight._update();
                };
                $('.item-list', $masonry).matchHeight();
                this.addEventListener('load', update, true);
            });
        });
        @endif
    </script>
@endsection

@push('after-scripts')
<script src="//js.pusher.com/3.1/pusher.min.js"></script> 
      <script>
      Pusher.logToConsole = true;
      var pusher = new Pusher('2145dcb18e6bdec67070', {
         cluster: 'ap2',
    encrypted: true
});

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('notification');

// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\NotificationEvent', function(data) {
   checkNewMessages();
   console.log('ok');
   
    // this is called when the event notification is received...
});
      </script>
      @endpush

