<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index($category, $slug)
    {
        if( Article::whereRelation('language', 'code', app()->getLocale())->where('slug', $slug)->count() > 1 ) {
            $article = Category::where('slug', $category)->categoryArticles()->whereRelation('language', 'code', app()->getLocale())->where('slug', $slug)->first();
        } else {
            $article = Article::whereRelation('language', 'code', app()->getLocale())->where('slug', $slug)->first();
        }

        if( !$article ) abort(404);
        $categories_menu = $this->categoriesMenu();
        $breadcrumb = $this->breadcrumb( $article );

        return view('blog.index', compact('article', 'breadcrumb', 'categories_menu'));
    }

    public function categoriesMenu() {
        //return Category::whereRelation('language', 'code', app()->getLocale())->where('show_menu', 1)->whereDoesntHave('parent')->get();
        return Category::whereRelation('language', 'code', app()->getLocale())->where('show_menu', 1)->get();
    }

    public function category($slug) {
        $category = Category::whereRelation('language', 'code', app()->getLocale())->where('slug', $slug)->first();
        if( !$category ) abort('404');
        $categories_menu = $this->categoriesMenu();
        $articles = $category->categoryArticles()->whereRelation('language', 'code', app()->getLocale())->paginate(9);
        return view('blog.category', compact('articles', 'category', 'categories_menu'));
    }

    public function breadcrumb( $article ) {
        $html = '<div class="breadcrumb">';
        $html .= '<a href="/">' . __('global.home') . '</a> / ';
        if( !$article->category ) {
            return '';
        }

        if( $article->category->parent ) {
            $html .= '<a href="/blog/'. $article->category->parent->slug .'">' . $article->category->parent->name . '</a> / ';
        }

        $html .= '<a href="/blog/'. $article->category->slug .'">' . $article->category->name . '</a>';
        $html .= ' / <span>' . $article->name . '</span>';
        $html .= '</div>';

        return $html;
    }
}
