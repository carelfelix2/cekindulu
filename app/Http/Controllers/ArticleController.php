<?php
namespace App\Http\Controllers;use App\Models\Article;
class ArticleController extends Controller{public function index(){return view('pages.articles.index',['articles'=>Article::published()->latest('published_at')->paginate(9)]);}public function show(Article $article){abort_unless($article->status==='published',404);return view('pages.articles.show',['article'=>$article,'relatedArticles'=>Article::published()->where('id','!=',$article->id)->limit(4)->get()]);}}
