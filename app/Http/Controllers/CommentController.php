<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = Comment::with('book')
            ->orderBy('comments.comment_id', 'DESC')
            ->get();

        if (!$comments) {
            return response()->json(['message' => 'Comments not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($comments, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $visible = 1;
        $this->validate($request, [
            'text' => 'required',
            'book_id'=>'required',
            'user_id'=>'required',
        ]);

        $comment = new Comment([
            'text' => $request->input('text', ''),
            'visible' => $visible,
            'book_id' => $request->input('book_id', null),
            'user_id' => $request->input('user_id', null),
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $comment->save();

        if (!$comment) {
            return response()->json(['message' => 'Comment not added'], Response::HTTP_BAD_REQUEST);
        }

        $comments = Comment::where('comments.book_id', '=', $request->input('book_id', null))
            ->get();

        return response()->json($comments, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::where('comments.book_id', '=', $id)
            ->get();

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($comment, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $comment = Comment::find($request->input('id', null));
        $comment->visible = $request->input('visibility', 1);
        $comment->save();

        if (!$comment) {
            return response()->json(['message' => 'Comment not edited'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$comment], Response::HTTP_OK);
    }

    public function getCommentsByUserId(Request $request, $id)
    {
        $comments = Comment::with('book')
            ->where('comments.user_id', $id)
            ->get();

        if (!$comments) {
            return response()->json(['message' => 'Comments not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($comments, Response::HTTP_OK);
    }

}
