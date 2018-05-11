<?php

namespace App\Http\Controllers;

use App\Model\PostLogs;
use Illuminate\Http\Request;

class PostLogsController extends Controller
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
        $data = $request->all();
        $post_id = isset($data['post_id']) ? $data['post_id'] : 0;
        $time = 10;
        $ip = $request->ip();

        $logs = PostLogs::where('post_id', '=', $post_id)
            ->where('ip', '=', $ip)
            ->first();
        if (!$logs) {
            $logs = new PostLogs();
            $logs->post_id = $post_id;
            $logs->ip = $ip;
            $logs->viewed_time = $time;
        } else {
            $logs->viewed_time += $time;
        }
        $logs->save();

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
        //
    }
}
