<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = \Auth::user();

        $post = Post::find($request->post_id);
        if (!$post) {
            abort(404);
        }

        $favorite = Favorite::where('user_id', '=', $user->user_id)
            ->where('post_id', '=', $request->post_id)
            ->first();

        if ($favorite) {
            $favorite->status = 1 ^ $favorite->status;
            $favorite->save();
        } else {
            $favorite = new Favorite();
            $favorite->user_id = $user->id;
            $favorite->post_id = $request->post_id;
            $favorite->status = 1;
            $favorite->save();
        }

        return [];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \Auth::user();
        Favorite::where('user_id', '=', $user->id)
            ->where('post_id', '=', $id)
            ->delete();

        return [];
    }
}
