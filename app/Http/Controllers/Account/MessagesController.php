<?php
/**
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
 */

namespace App\Http\Controllers\Account;

use App\Events\NotificationEvent;
use App\Helpers\UrlGen;
use App\Http\Controllers\Account\Traits\MessagesTrait;
use App\Http\Requests\ReplyMessageRequest;
use App\Http\Requests\SendMessageRequest;
use App\Models\GiftMessage;
use App\Models\Post;
use App\Models\Thread;
use App\Models\ThreadMessage;
use App\Models\ThreadParticipant;
use App\Models\User;
use App\Notifications\ReplySent;
use App\Notifications\SellerContacted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Torann\LaravelMetaTags\Facades\MetaTag;

class MessagesController extends AccountBaseController
{
	use MessagesTrait;

	private $perPage = 10;

	public function __construct()
	{
		parent::__construct();

		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

		// Set the Page Path
		view()->share('pagePath', 'messenger');
	}

	/**
	 * Show all of the message threads to the user.
	 *
	 * @return mixed
	 */
	public function index()
	{
		// All threads that user is participating in
		$threads = $this->threads;

		// Get threads that have new messages or that are marked as unread
		if (request()->get('filter') == 'unread') {
			$threads = $this->threadsWithNewMessage;
		}

		// Get threads started by this user
		if (request()->get('filter') == 'started') {
			$threadTable = (new Thread())->getTable();
			$messageTable = (new ThreadMessage())->getTable();

			$threads->where(function ($query) use ($threadTable, $messageTable) {
				$query->select('user_id')
					->from($messageTable)
					->whereColumn($messageTable . '.thread_id', $threadTable . '.id')
					->orderBy($messageTable . '.created_at', 'ASC')
					->limit(1);
			}, auth()->id());
		}

		// Get this user's important thread
		if (request()->get('filter') == 'important') {
			$threads->where('is_important', 1);
		}

		// Get rows & paginate
		$threads = $threads->paginate($this->perPage);

		// Meta Tags
		MetaTag::set('title', t('messenger_inbox'));
		MetaTag::set('description', t('messenger_inbox'));

		if (request()->ajax()) {

			$result = [];
			$result['threads'] = view('account.messenger.threads.threads', ['threads' => $threads])->render();
			$result['links'] = view('account.messenger.threads.links', ['threads' => $threads])->render();

			return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
		}

		return view('account.messenger.index', compact('threads'));
	}
	/**
	 * Shows a message thread.
	 *
	 * @param $id
	 * @return mixed
	 */
	public function show($id)
	{
		try {
			$threadTable = (new Thread())->getTable();
			$thread = Thread::forUser(auth()->id())->where($threadTable . '.id', $id)->firstOrFail($id);

			// Get the Thread's Messages
			$messages = ThreadMessage::query()
				->notDeletedByUser(auth()->id())
				->where('thread_id', $thread->id)
				->orderByDesc('id');
            $messages = $messages->paginate($this->perPage);
            $linksRender = $messages->links('account.messenger.messages.pagination')->render();
            $messages = $messages->items();
//            dd($messages);

        } catch (ModelNotFoundException $e) {
			$msg = t('thread_not_found', ['id' => $id]);
			flash($msg)->error();

			return redirect('account/messages');
		}

		// Mark the Thread as read
		$thread->markAsRead(auth()->id());

		// Meta Tags
		MetaTag::set('title', t('Messages Received'));
		MetaTag::set('description', t('Messages Received'));

		$gift = DB::table('threads_messages')->join('gift_message','threads_messages.id','=','gift_message.msg_id')->select('gift_message.*')->get();

		// Reverse the collection order like Messenger
		$messages = collect($messages)->reverse();

//		dd();

		if (request()->ajax()) {
			$result = [];
			$result['messages'] = view('account.messenger.messages.messages', ['messages' => $messages, 'gift' => $gift])->render();
			$result['links'] = $linksRender;
//			$result['gift'] = $gift;

			return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
		}

		return view('account.messenger.show', compact('thread', 'messages', 'linksRender', 'gift'));
	}
	/**
	 * Stores a new message thread.
	 * Contact the Post's Author
	 * NOT use AJAX
	 *
	 * @param $postId
	 * @param \App\Http\Requests\SendMessageRequest $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store($postId, SendMessageRequest $request)
	{
//	    dd($request);
//	    exit();

	    //	    dd($request->all());
		// Get the Post
		$post = Post::unarchived()->findOrFail($postId);
//		dd($post);
		// Create Message Array
		$messageArray = $request->all();

		// Logged User
		if (auth()->check() && !empty($post->user)) {
			// Thread
            $thread=Thread::where('post_id',$post->id)->where('user_id', auth()->id())->first();
            if(!$thread) {
                $thread = new Thread();
            }
			$thread->post_id = $post->id;
			$thread->subject = $post->title;
			$thread->user_id = auth()->id();
			$thread->save();

			// Message
			$message = new ThreadMessage();
			$message->thread_id = $thread->id;
			$message->user_id = auth()->id();
			$message->body = $request->input('body');
			$message->save();

			if($request->offer_request){
				$offer = new GiftMessage();
				$offer->msg_id = $message->id;
				$offer->sender_id = auth()->user()->id;
				$offer->receiver_id = $request->receiver_id;
				$offer->status = 0;
				$offer->review_status = 0;
				$offer->save();
			}

			// Save and Send user's resume
			if ($request->hasFile('filename')) {
				$message->filename = $request->file('filename');
				$message->save();
			}

			// Update Message Array
			$messageArray['from_name'] = auth()->user()->name;
			$messageArray['from_email'] = auth()->user()->email;
			$messageArray['from_phone'] = auth()->user()->phone;
			$messageArray['country_code'] = config('country.code');
			if (!empty($message->filename)) {
				$messageArray['filename'] = $message->filename;
			}

			// Sender
			$sender = new ThreadParticipant();
			$sender->thread_id = $thread->id;
			$sender->user_id = auth()->id();
			$sender->last_read = new Carbon;
			$sender->save();

			// Recipients
			if ($request->has('recipients')) {

				$thread->addParticipant($request->input('recipients'));
			} else {
				$thread->addParticipant($post->user->id);

			}
		} else {
			// Guest (Non Logged User)
			// Update the filename
			if ($request->hasFile('filename')) {
				$file = $request->file('filename');
				$messageArray['filename'] = $file->getClientOriginalName();
				$messageArray['fileData'] = base64_encode(File::get($file->getRealPath()));
			}
		}

		// Remove input file to prevent Laravel Queue serialization issue
		if (isset($messageArray['filename']) && !is_string($messageArray['filename'])) {
			unset($messageArray['filename']);
		}

		$errorFound = false;

		// Send a message to publisher
		if (isset($messageArray['post_id'], $messageArray['from_email'], $messageArray['from_name'], $messageArray['body'])) {
			try {
				if (!isDemo()) {
					$post->notify(new SellerContacted($post, $messageArray));
				}
			} catch (\Exception $e) {
//                dd($e);
				$errorFound = true;
				flash($e->getMessage())->error();
			}
		}

//		dd($e);
		if (!$errorFound) {
			$msg = t('message_has_sent_successfully_to', ['contact_name' => $post->contact_name]);
			flash($msg)->success();
		}

		return redirect(UrlGen::postUri($post));
	}
	/**
	 * Adds a new message to a current thread.
	 *
	 * @param $id
	 * @param \App\Http\Requests\ReplyMessageRequest $request
	 * @return \Illuminate\Http\JsonResponse|void
	 */
	public function update($id, ReplyMessageRequest $request)
	{
		if (!request()->ajax()) {
			return;
		}
		$result = ['success' => false];

		try {
			// We use with([users => fn()]) to prevent email sending
			// to the message sender (which is the current user)
			$thread = Thread::with([
				'post',
				'users' => function ($query) {
					$query->where((new User())->getTable() . '.id', '!=', auth()->id());
				},
			])->findOrFail($id);
		} catch (ModelNotFoundException $e) {
			$result['msg'] = t('thread_not_found', ['id' => $id]);

			return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
		}

		// Re-activate the Thread for all participants
		$thread->deleted_by = null;
		$thread->save();

		$thread->activateAllParticipants();

		// Create Message Array
		$messageArray = $request->all();

		// Message
		$message = new ThreadMessage();
		$message->thread_id = $thread->id;
		$message->user_id = auth()->id();
		$message->body = $request->input('body');
		$message->save();

        if (isset($request->gift_offer)){
//            dd($request->all());
            $gift_msg = new GiftMessage();
            $gift_msg->msg_id = $message->id;
            $gift_msg->sender_id = auth()->id();
            $gift_msg->receiver_id = $message->thread->post->user_id;
            $gift_msg->status = 0;
            $gift_msg->save();
        }
//        if(isset($message)){
            $noti=[];
            $noti['sender_id']=$message['sender_id'];
            $noti['receiver_id']=$message['receiver_id'];
            $noti['message']=$message['body'];
            event(new NotificationEvent($noti));
//        }

            // Save and Send user's resume
		if ($request->hasFile('filename')) {
			$message->filename = $request->file('filename');
			$message->save();
		}

		// Update Message Array
		$messageArray['country_code'] = config('country.code');
		$messageArray['post_id'] = (!empty($thread->post)) ? $thread->post->id : null;
		$messageArray['from_name'] = auth()->user()->name;
		$messageArray['from_email'] = auth()->user()->email;
		$messageArray['from_phone'] = auth()->user()->phone;
		$messageArray['subject'] = t('New message about') . ': ' . $thread->post->title;
		if (!empty($message->filename)) {
			$messageArray['filename'] = $message->filename;
		}

		// Add replier as a participant
		$participant = ThreadParticipant::firstOrCreate([
			'thread_id' => $thread->id,
			'user_id'   => auth()->id(),
		]);
		$participant->last_read = new Carbon;
		$participant->save();

		// Recipients
		if ($request->has('recipients')) {
			$thread->addParticipant($request->input('recipients'));
		} else {
			$thread->addParticipant($thread->post->user->id);
		}

		// Remove input file to prevent Laravel Queue serialization issue
		if (isset($messageArray['filename']) && !is_string($messageArray['filename'])) {
			unset($messageArray['filename']);
		}

		$errorFound = false;

		// Send Reply Email
		if (isset($messageArray['post_id'], $messageArray['from_email'], $messageArray['from_name'], $messageArray['body'])) {
			try {
				// $thread->notify(new ReplySent($messageArray));
				if (isset($thread->users) && $thread->users->count() > 0) {
					foreach ($thread->users as $user) {
						$messageArray['to_email'] = $user->email ?? '';
						$messageArray['to_phone'] = $user->phone ?? '';
						Notification::send($user, new ReplySent($messageArray));
					}
				}
			} catch (\Exception $e) {
				$errorFound = true;
				$result['msg'] = $e->getMessage();
			}
		}

		if (!$errorFound) {
			$result['success'] = true;
			$result['msg'] = t('Your reply has been sent');
		}

		return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}
	public function accept_offer($id){
	    GiftMessage::where('id', $id)->update([
	        'status' => 1
        ]);
	    return redirect()->back();
    }
	public function reject_offer($id){
	    GiftMessage::where('id', $id)->update([
	        'status' => 2
        ]);
	    return redirect()->back();
    }

	/**
	 * Actions on the Threads
	 *
	 * @param null $threadId
	 * @return \Illuminate\Http\JsonResponse|void
	 */
	public function actions($threadId = null)
	{
		if (!request()->ajax()) {
			return;
		}
		$result = ['success' => false];
		if (request()->get('type') == 'markAsRead') {
			$res = $this->markAsRead($threadId);
		}
		if (request()->get('type') == 'markAsUnread') {
			$res = $this->markAsUnread($threadId);
		}
		if (request()->get('type') == 'markAsImportant') {
			$res = $this->markAsImportant($threadId);
		}
		if (request()->get('type') == 'markAsNotImportant') {
			$res = $this->markAsNotImportant($threadId);
		}
		if (request()->get('type') == 'delete') {
			$res = $this->delete($threadId);
		}

		if (
			isset($res)
			&& array_key_exists('success', $res)
			&& array_key_exists('msg', $res)
		) {
			if (!empty($threadId)) {
				$result['baseUrl'] = request()->url();
			}
			$result['type'] = request()->get('type');
			$result['success'] = $res['success'];
			$result['msg'] = $res['msg'];
		}

		return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}
	/**
	 * Check Threads with New Messages
	 *
	 * @return \Illuminate\Http\JsonResponse|void
	 */
	public function checkNew()
	{
		if (!request()->ajax()) {
			return;
		}

		$countLimit = 20;
		$countThreadsWithNewMessages = 0;
		$oldValue = request()->input('oldValue');
		$languageCode = request()->input('languageCode');

		if (auth()->check()) {
			$countThreadsWithNewMessages = Thread::whereHas('post', function ($query) {
				$query->currentCountry()->unarchived();
			})->forUserWithNewMessages(auth()->id())->count();
		}

		$result = [
			'logged'                      => (auth()->check()) ? auth()->user()->id : 0,
			'countLimit'                  => (int)$countLimit,
			'countThreadsWithNewMessages' => (int)$countThreadsWithNewMessages,
			'oldValue'                    => (int)$oldValue,
			'loginUrl'                    => UrlGen::login(),
		];

		return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}
}
