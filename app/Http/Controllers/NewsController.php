<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Psy\Util\Json;

class NewsController extends Controller
{
    public function getLastNews()
    {
        $news = News::orderBy('id', 'desc')->take(3)->get();
        return response()->json($news, Response::HTTP_OK);
    }

    public function getNews()
    {
        $news = News::all();
        return response()->json($news, 200);
    }

    public function getArticle(Request $request, $id)
    {
        $article = News::find($id);

        if (!$article) {
            return response()->json(['message' => 'Document not found'], Response::HTTP_NOT_FOUND); //TODO use trans for const messages
        }
        return response()->json([$article], 200);
    }

    public function postEditArticle(Request $request)
    {
        $id = $request->input('id', '');
        $title = $request->input('title', '');
        $content = $request->input('text', '');
        $date = date("Y-m-d H:i:s");
        $article_old_image = $request->input('article_old_image', '');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = $image->getClientOriginalName();
            $destinationPath = public_path('images/news_images');
            $image->move($destinationPath, $input['imagename']);
            File::delete(public_path($article_old_image));
            $imagePath = 'images/news_images/' . $input['imagename'];
        } else {
            $imagePath = $article_old_image;
        }

        $article = DB::table('news')
            ->where('news.id', $id)
            ->update(['title' => $title, 'text'=>$content, 'image'=>$imagePath, 'updated_at'=>$date]);

        return response()->json([$article], 200);
    }

    public function getDeleteArticle($id)
    {
        $article = DB::table('news')
            ->where('news.id', $id)
            ->get();

        foreach ($article as $item) {
            File::delete(public_path($item->image));
        }

        DB::table('news')
            ->where('news.id', $id)
            ->delete();

        return response()->json("Article was deleted", 200);
    }

    public function postAddArticle(Request $request)
    {
        $title = $request->input('title', '');
        $content = $request->input('text', '');
        $date = $date = date("Y-m-d H:i:s");

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = $image->getClientOriginalName();
            $destinationPath = public_path('images/news_images');
            $image->move($destinationPath, $input['imagename']);
            $imagePath = 'images/news_images/' . $input['imagename'];
        } else {
            $imagePath = null;
        }

        $article = DB::table('news')
            ->insert(['title'=>$title, 'text'=>$content, 'image'=>$imagePath, 'created_at'=>$date]);

        return response()->json([$article], 200);
    }
}
