<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Article as ResourcesArticle;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResourcesArticle::collection(Article::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'title' => 'required|min:3|max:55',
            'content' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return $validator->errors();
        }else
        if (Article::create($request->all())){
            return response()->json([
                "success" => "Article ajouté avec succès !"
            ], 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        if (! Gate::allows('update-article', $article)) {
            return response()->json([
                "message"=>"vous n'ete pas autoriser a modifier cette article "
            ], 403);
        }elseif ($article->update($request->all())) {
            return response()->json([
                "success" => "L'article a ete modifier"
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if (! Gate::allows('update-article', $article)) {
            return response()->json([
                "message"=>"vous n'ete pas autoriser a supprimer cette article "
            ], 403);
        }elseif ($article->delete()) {
            return response()->json([
                "success" => "L'article a ete supprimer"
            ], 200);
        }
    }
}
