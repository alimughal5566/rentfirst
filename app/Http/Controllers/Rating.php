<?php

namespace App\Http\Controllers;

use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use extras\plugins\reviews\app\Http\Requests\ReviewRequest;
use extras\plugins\reviews\app\Models\Post;
use extras\plugins\reviews\app\Models\Review;
use Illuminate\Http\Request;
use App\Models\GiftMessage;
use App\Models\ReviewReply;


class Rating extends Controller
{

    public function store($postId, $gift_id, ReviewRequest $request)
    {


        $post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->find($postId);
        if (empty($post)) {
            abort(404, t('Post not found'));
        }
        // Instantiate Rating model
        $review = new Review();

        // Store the review in DB, otherwise return to product page with error message
        $review->storeReviewForItem($post->id, $request->input('comment'), $request->input('rating'));
        $gift = GiftMessage::where('id', $gift_id)->first();
        $gift->review_status = 1;
        $gift->update();

      return redirect()->back()->with('success','successfully');
    }
    public function store_reviewer($postId, $gift_id, ReviewRequest $request)
    {
        $post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->find($postId);
        if (empty($post)) {
            abort(404, t('Post not found'));
        }
        // Instantiate Rating model
        $review = new Review();

        // Store the review in DB, otherwise return to product page with error message
        $review->storeReviewerForItem($post->id, $request->input('comment'), $request->input('rating'));
        $gift = GiftMessage::where('id', $gift_id)->first();
        $gift->review_status = 2;
        $gift->update();

      return redirect()->back()->with('success','successfully');
    }
    public function save_reply(Request $request){
//       dd($request->all());
      $reply = new ReviewReply();
      $reply->review_id = $request->review_id;
      $reply->user_id = $request->user_id;
      $reply->reply = $request->comment_reply;
      $reply->save();
      return response()->json([
        'success' => 'true',
        'reply' => $reply
      ],200);
  	}
}
