<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\FormsPrecedence;

class ArticleController extends Controller
{
    public function viewArticle($id) {
        $article = Article::findOrFail($id);
        return view('articles', compact('article'));
    }

    public function viewForm($id) {
        $form = FormsPrecedence::findOrFail($id);
        return view('forms', compact('form'));
    }
}
