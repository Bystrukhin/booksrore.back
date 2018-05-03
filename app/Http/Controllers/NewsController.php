<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.token')->only('update', 'destroy', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();

        if (!$news) {
            return response()->json(['message' => 'News not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($news, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text'=>'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = $image->getClientOriginalName();
            $destinationPath = public_path('images/news_images');
            $image->move($destinationPath, $input['imagename']);
            $imagePath = 'images/news_images/' . $input['imagename'];
        } else {
            $imagePath = null;
        }

        $article = new News([
            'title'=>$request->input('title', ''),
            'text'=>$request->input('text', ''),
            'image'=>$imagePath,
            'created_at'=>date("Y-m-d H:i:s")
        ]);
        $article->save();

        if (!$article) {
            return response()->json(['message' => 'Article not added'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($article, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = News::find($id);

        if (!$article) {
            return response()->json(['message' => 'Document not found'], Response::HTTP_NOT_FOUND); //TODO use trans for const messages
        }

        return response()->json([$article], Response::HTTP_OK);
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
        $this->validate($request, [
            'title' => 'required',
            'text'=>'required',
        ]);

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

        $article = News::find($request->input('id', null));
        $article->title = $request->input('title', '');
        $article->text = $request->input('text', '');
        $article->image = $imagePath;
        $article->updated_at = date("Y-m-d H:i:s");
        $article->save();

        if (!$article) {
            return response()->json(['message' => 'Article not edited'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($article, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = News::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article was not deleted'], Response::HTTP_NOT_FOUND);
        }

        File::delete(public_path($article->image));

        $article->delete();

        return response()->json("Article was deleted", Response::HTTP_OK);
    }

    public function getLastNews()
    {
        $news = News::orderBy('id', 'desc')->take(3)->get();

        if (!$news) {
            return response()->json(['message' => 'News not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($news, Response::HTTP_OK);
    }
}
