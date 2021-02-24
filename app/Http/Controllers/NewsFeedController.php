<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\NewsFeed;
use Illuminate\Support\Facades\DB;

class NewsFeedController extends Controller
{
    public function index()
    {

//      $feed = NewsFeed::orderBy('updated_at', 'desc')->get();
//
//        $news['news_feed'] = News_Feed::select('*','users.*')
//            ->join('users', 'users.id' , '=', 'news_feed.user_id')
//            ->get();

        $feed = NewsFeed::select('news_feed.*', 'users.name AS Username', 'users.id AS UserId')
            ->join('users', 'users.id', '=', 'news_feed.user_id')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($feed);


    }

    public function store(Request $request)
    {

        $post = $request->feed;
        $id = $request->user_id;
        $like = $request->postLike;


        $news = new NewsFeed();
        $news->feed = $post;
        $news->user_id = $id;
        $news->user_like_id = $like;

        $news->save();


        return response()->json($news);
    }

    public function destroy($id)
    {
        $news = NewsFeed::find($id)->delete();

        return response()->json($news);
    }

    public function update(Request $request, $id)
    {

        $post = $request->feed;
        $userid = $request->user_id;
        $user_like_id = $request->user_like_id;
        $news = NewsFeed::find($id);


        $news->feed = $post;
        $news->user_id = $userid;
        $news->user_like_id = $user_like_id;
        $news->save();


        return response()->json($news);


    }

    public function updateLike(Request $request, $id)
    {

        $newsfeed = NewsFeed::find($id);

        if (empty($newsfeed->user_like_id)) {
            $newsfeed->user_like_id = $request->like_user_id;
        }else{
            $newsfeed->user_like_id = null;
        }

        $newsfeed->save();

        return response()->json($newsfeed);


    }
}
