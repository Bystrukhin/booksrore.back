<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function getCommentsByBookId(Request $request, $id)
    {
        $comments = Comment::where('comments.book_id', '=', $id)
            ->get();

        if (!$comments) {
            return response()->json(['message' => 'Comments not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($comments, Response::HTTP_OK);
    }


    public function postAddComment(Request $request)
    {
        $text = $request->input('text', '');
        $visible = 1;
        $book_id = $request->input('book_id', '');
        $user_id = $request->input('user_id', '');
        $date = date("Y-m-d H:i:s");

        $comment = Comment::insert(['text'=>$text, 'visible'=>$visible, 'book_id'=>$book_id,
            'user_id'=>$user_id, 'date'=>$date]);

        if (!$comment) {
            return response()->json(['message' => 'Comment not added'], Response::HTTP_BAD_REQUEST);
        }

        $comments = Comment::where('comments.book_id', '=', $book_id)
            ->get();

        return response()->json([$comments], Response::HTTP_OK);
    }
}
