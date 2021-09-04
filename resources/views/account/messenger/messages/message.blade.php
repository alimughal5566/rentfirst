@if (auth()->id() == $message->user->id)
    <div class="chat-item object-me">
        <div class="chat-item-content">
            <div class="msg" style="padding-bottom: 10px">
                @isset($message->giftMessage->msg_id)
                    @if($message->giftMessage->msg_id == $message->id)
                        <h5 style="background-color: white;padding: 5px; text-align: center; margin-bottom: 5px; border-radius: 8px; color: black ">You sent an offer</h5>

                        <p style="margin-bottom: 1px">{{$message->body}}</p>
                        @if($message->giftMessage->status == 0) <br>
                            <span style="padding: 5px; width: 100%; border-radius: 8px; background-color: white; color: red !important; " class="btn btn-danger">Pending</span>
                        @endif
                        @if($message->giftMessage->status == 1) <br>
                            <span style="padding: 5px; width: 100%; border-radius: 8px; background-color: white; color: green !important; " class="btn">Accepted</span>
                        @endif
                        @if($message->giftMessage->status == 2) <br>
                            <span style="padding: 5px; width: 100%; border-radius: 8px; background-color: white; color: red !important; " class="btn">Rejected</span>
                        @endif
                        @if (!empty($message->filename) and $disk->exists($message->filename))
                            <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>
                            <div class="{{ $mt2Class }}">
                                <i class="fas fa-paperclip" aria-hidden="true"></i>
                                <a class="text-light"
                                   href="{{ fileUrl($message->filename) }}"
                                   target="_blank"
                                   data-toggle="tooltip"
                                   data-placement="left"
                                   title="{{ basename($message->filename) }}"
                                >
                                    {{ \Illuminate\Support\Str::limit(basename($message->filename), 20) }}
                                </a>
                            </div>
                        @endif
                    @endif
                @else
                    {!! createAutoLink(nlToBr($message->body), ['class' => 'text-light']) !!}
                    @if (!empty($message->filename) and $disk->exists($message->filename))
                        <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>
                        <div class="{{ $mt2Class }}">
                            <i class="fas fa-paperclip" aria-hidden="true"></i>
                            <a class="text-light"
                               href="{{ fileUrl($message->filename) }}"
                               target="_blank"
                               data-toggle="tooltip"
                               data-placement="left"
                               title="{{ basename($message->filename) }}"
                            >
                                {{ \Illuminate\Support\Str::limit(basename($message->filename), 20) }}
                            </a>
                        </div>
                    @endif
                @endisset
            </div>
            <span class="time-and-date">
				{{ $message->created_at_formatted }}
                <?php $recipient = $message->recipients()->first(); ?>
                @if (!empty($recipient) && !$message->thread->isUnread($recipient->user_id))
                    &nbsp;<i class="fas fa-check-double"></i>
                @endif
			</span>
        </div>
    </div>
@else
    <div class="chat-item object-user">
        <div class="object-user-img">
            <a href="{{ \App\Helpers\UrlGen::user($message->user) }}">
                <img src="{{ url($message->user->photo_url) }}" alt="{{ $message->user->name }}">
            </a>
        </div>
        <div class="chat-item-content">
            <div class="chat-item-content-inner">
                <div class="msg bg-white" style="padding-bottom: 10px">
                    @isset($message->giftMessage->msg_id)
                        @if($message->giftMessage->msg_id == $message->id)
                            <h5 style="background-color: #4682b4;padding: 5px; margin-bottom: 5px; border-radius: 8px; color: white ">{{$message->giftMessage->user->name}} made an offer</h5>
                            <p style="margin-bottom: 0px">{!! createAutoLink(nlToBr($message->body)) !!}</p>
                            @if($message->giftMessage->status == 0) <br>
                                <a href="{{route('accept_offer',[$message->giftMessage->id])}}" style="background-color: #4682b4; color: white; padding: 5px; border-radius: 8px">Accept</a>
                                <a href="{{route('reject_offer',[$message->giftMessage->id])}}" style="background-color: red; color: white; padding: 5px; border-radius: 8px">Reject</a>
                            @endif
                            @if($message->giftMessage->status == 1) <br>
                                <span style="padding: 5px; width: 100%; width: 100%; border-radius: 8px; background-color: white; color: green !important; border: 1px solid green;" >You Accepted</span>
                            @endif
                            @if($message->giftMessage->status == 2) <br>
                                <span style="padding: 5px; width: 100%; width: 100%; border-radius: 8px; background-color: white; color: red !important; border: 1px solid red;" >You Rejected</span>
                            @endif
                            @if (!empty($message->filename) and $disk->exists($message->filename))
                                <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>
                                <div class="{{ $mt2Class }}">
                                    <i class="fas fa-paperclip" aria-hidden="true"></i>
                                    <a class="text-light"
                                       href="{{ fileUrl($message->filename) }}"
                                       target="_blank"
                                       data-toggle="tooltip"
                                       data-placement="left"
                                       title="{{ basename($message->filename) }}"
                                    >
                                        {{ \Illuminate\Support\Str::limit(basename($message->filename), 20) }}
                                    </a>
                                </div>
                            @endif
                        @endif
                    @else
                        {!! createAutoLink(nlToBr($message->body)) !!}
                        @if (!empty($message->filename) and $disk->exists($message->filename))
                            <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>
                            <div class="{{ $mt2Class }}">
                                <i class="fas fa-paperclip" aria-hidden="true"></i>
                                <a class="text-light"
                                   href="{{ fileUrl($message->filename) }}"
                                   target="_blank"
                                   data-toggle="tooltip"
                                   data-placement="left"
                                   title="{{ basename($message->filename) }}"
                                >
                                    {{ \Illuminate\Support\Str::limit(basename($message->filename), 20) }}
                                </a>
                            </div>
                        @endif
                    @endisset
{{--                    {!! createAutoLink(nlToBr($message->body)) !!}--}}
{{--                    @if (!empty($message->filename) and $disk->exists($message->filename))--}}
{{--                        <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>--}}
{{--                        <div class="{{ $mt2Class }}">--}}
{{--                            <i class="fas fa-paperclip" aria-hidden="true"></i>--}}
{{--                            <a class=""--}}
{{--                               href="{{ fileUrl($message->filename) }}"--}}
{{--                               target="_blank"--}}
{{--                               data-toggle="tooltip"--}}
{{--                               data-placement="left"--}}
{{--                               title="{{ basename($message->filename) }}"--}}
{{--                            >--}}
{{--                                {{ \Illuminate\Support\Str::limit(basename($message->filename), 20) }}--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
                <?php $userIsOnline = isUserOnline($message->user); ?>
                <span class="time-and-date ml-0">
					@if ($userIsOnline)
                        <i class="fa fa-circle color-success"></i>&nbsp;
                    @endif
                    {{ $message->created_at_formatted }}
				</span>
            </div>
        </div>
    </div>
@endif