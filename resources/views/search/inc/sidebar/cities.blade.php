<!-- City -->
<div class="block-title has-arrow sidebar-header">
    <h5>
		<span class="font-weight-bold">
			{{ t('locations') }}
		</span>
    </h5>
</div>
<div class="block-content list-filter locations-list">
    <ul class="browse-list list-unstyled long-list">
        @if (isset($cities) && $cities->count() > 0)
            @foreach ($cities as $iCity)
                <li>
                    @if ((isset($city) && !empty($city) && $city->id == $iCity->id) || (request()->input('l') == $iCity->id))
                        <strong>
                            <a href="{!! \App\Helpers\UrlGen::city($iCity, null, $cat ?? null) !!}"
                               title="{{ $iCity->name }}">
                                {{ $iCity->name }}
                                @if (config('settings.listing.count_cities_posts'))
                                    <span class="count">{{ $iCity->posts_count ?? 0 }}</span>
                                @endif
                            </a>
                        </strong>
                    @else
                        <a href="{!! \App\Helpers\UrlGen::city($iCity, null, $cat ?? null) !!}"
                           title="{{ $iCity->name }}">
                            {{ $iCity->name }}
                            @if (config('settings.listing.count_cities_posts'))
                                <span class="count">{{ $iCity->posts_count ?? 0 }}</span>
                            @endif
                        </a>
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</div>
<div style="clear:both"></div>