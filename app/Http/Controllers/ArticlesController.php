<?php

namespace App\Http\Controllers;

use App\Articles;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Articles as ArticlesResource;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Articles

        $articles = Articles::paginate(15);

        // Return collection of articles as a resource
        return ArticlesResource::collection($articles);
        
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'body' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
            }

        $article = $request->isMethod('create') ? Articles::findOrFail
        ($request->article_id) : new Articles;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');

        if($article->save()) {
            return new ArticlesResource($article);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'body' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
            }


        $article = $request->isMethod('put') ? Articles::findOrFail
        ($request->article_id) : new Articles;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');

        if($article->save()) {
            return new ArticlesResource($article);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get article
        $article = Articles::findOrFail($id);

        // Return single article as a resource
        return new ArticlesResource($article);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // Get article
         $article = Articles::findOrFail($id);

        if($article->delete()) {
            return new ArticlesResource($article);
        }  
    }
}
