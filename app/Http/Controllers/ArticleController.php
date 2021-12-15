<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function storeArticles() {
        $articles = Article::paginate(10);
        dd($articles);
    }
}
