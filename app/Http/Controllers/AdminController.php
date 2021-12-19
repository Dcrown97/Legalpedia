<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Resource;
use App\Models\Maxim;
use App\Models\Dictionary;
use App\Models\FormsPrecedence;
use App\Models\AreaOfLaw;
use App\Models\Category;
use App\Models\Package;
use App\Models\Discount;
use App\Models\LawOfFederation;
use App\Models\LawOfFedPart;
use App\Models\LawOfFedSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        return view('admin.dashboard');
    }

    public function judgement() {
        return view('admin.judgements.index');
    }


    public function rules() {
        return view('admin.rules-of-court.index');
    }

    public function state_rules() {
        $state_rules = StateRule::orderBy()->get();
        return view('admin.state-rules-of-court.index');
    }


    //laws of federation
    public function fed() {
        $feds = LawOfFederation::orderBy('title', 'ASC')->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        $fed_count = LawOfFederation::count();
        return view('admin.laws-of-federation.index', compact('feds', 'area_of_laws', 'categories', 'fed_count'));
    }
    public function storeFed(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'area_of_law' => 'required',
            'description' => 'required',
            'category' => 'required',
            'law_no' => 'required',
            'law_date' => 'required',
            'subsidiary_legislation' => 'required',


        ]);
        $fed_input = [
            'title' => $request->title,
            'area_of_law' => $request->area_of_law,
            'Descr' => $request->description,
            'category' => $request->category,
            'law_no' => $request->law_no,
            'law_date' => $request->law_date,
            'subsidiary_legislation' => $request->subsidiary_legislation,
        ];
        $fed = LawOfFederation::create($fed_input);
        $request->law_of_federation_id = $fed->id;
        $fed_part_input = [
            'part_header' => $request->part_header,
            'law_of_federation_id' => $request->law_of_federation_id
        ];
        $fed_part = LawOfFedPart::create($fed_part_input);
        $request->law_of_fed_part_id = $fed_part->id;
        $fed_section_input = [
            'section_header' => $request->section_header,
            'section_body' => $request->section_body,
            'law_of_federation_id' =>  $fed->id,
            'law_of_fed_part_id' => $fed_part->id
        ];
        LawOfFedSection::create($fed_section_input);

        return back()->with('success', 'Law added');

    }
    public function editFed($id) {
        $fed = LawOfFederation::findOrFail($id);
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.laws-of-federation.edit-fed', compact('fed', 'area_of_laws', 'categories'));
    }
    public function showFed($id) {
        $fed = LawOfFederation::findOrFail($id);
        $fed_part = LawOfFedPart::where('law_of_federation_id', 671)->first();
        // $fed_section = LawOfFedSection::where('law_of_federation_id', 671)->first();
        // dd($fed_part);
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.laws-of-federation.show', compact('fed', 'area_of_laws', 'categories'));
    }
    public function updateFed(Request $request, $id) {
        $fed = LawOfFederation::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'area_of_law' => 'required',
            'Descr' => 'required',
            'category' => 'required',
            'LawNo' => 'required',
            'LawDate' => 'required',
            'SubsidiaryLegislation' => 'required',
        ]);
        $input = $request->all();
        $fed->update($input);
        return back()->with('success', 'Law updated');
    }
    public function deleteFed($id) {
        $fed = LawOfFederation::findOrFail($id);
        $fed->delete();
        return back()->with('success', 'Law deleted');
    }



    // area of law
    public function area_of_law() {
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->get();
        $area_count = AreaOfLaw::count();
        return view('admin.areas-of-laws.index', compact('area_of_laws', 'area_count'));
    }
    public function storeArea(Request $request) {
        $validated = $request->validate([
            'area_of_law' => 'required',
        ]);
        $input = $request->all();
        AreaOfLaw::create($input);
        return back()->with('success', 'Area of Law added');
    }
    public function updateArea(Request $request) {
        $validated = $request->validate([
            'area_of_law' => 'required',
        ]);
        $input = [
          'area_of_law'=> $request->category,
        ];
        DB::table('areas_of_laws')->where('id', $request->area_id)->update($input);
        return back()->with('success', 'Area of law updated');
    }
    public function deleteArea($id) {
        $area_of_law = AreaOfLaw::findOrFail($id);
        $area_of_law->delete();
        return back()->with('success', 'Area of law deleted');
    }

    // categories
    public function category() {
        $categories = Category::orderBy('category', 'ASC')->get();
        $category_count = Category::count();
        return view('admin.categories.index', compact('categories', 'category_count'));
    }
    public function storeCategory(Request $request) {
        $validated = $request->validate([
            'category' => 'required',
        ]);
        $input = $request->all();
        Category::create($input);
        return back()->with('success', 'Category added');
    }
    public function updateCategory(Request $request) {
        $validated = $request->validate([
            'category' => 'required',
        ]);
        $input = [
          'category'=> $request->category,
        ];
        DB::table('categories')->where('id', $request->category_id)->update($input);
        return back()->with('success', 'Category updated');
    }
    public function deleteCategory($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return back()->with('success', 'Category deleted');
    }


    // Forms and precedences
    public function forms() {
        $forms = FormsPrecedence::orderBy('title', 'ASC')->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        $form_count = FormsPrecedence::count();
        return view('admin.forms-and-precedences.index', compact('area_of_laws', 'forms', 'categories', 'form_count'));
    }
    public function storeForm(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            // 'version_no' => 'required',
            // 'author' => 'required',
            // 'area_of_law' => 'required',
            'content' => 'required',
            'category' => 'required',
        ]);
        $input = $request->all();
        FormsPrecedence::create($input);
        return back()->with('success', 'Form added');

    }
    public function editForm($id) {
        $form = FormsPrecedence::findOrFail($id);
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.forms-and-precedences.edit-form', compact('form', 'area_of_laws', 'categories'));
    }
    public function showForm($id) {
        $form = FormsPrecedence::findOrFail($id);
        return view('admin.forms-and-precedences.show', compact('form'));
    }
    public function updateForm(Request $request, $id) {
        $form = FormsPrecedence::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            // 'version_no' => 'required',
            // 'author' => 'required',
            // 'area_of_law' => 'required',
            'content' => 'required',
            'category' => 'required',
        ]);
        $input = $request->all();
        $form->update($input);
        return back()->with('success', 'Form updated');
    }
    public function deleteForm($id) {
        $form = FormsPrecedence::findOrFail($id);
        $form->delete();
        return back()->with('success', 'form deleted');
    }


    //Legal Articles
    public function articles() {
        $articles = Article::orderBy('title', 'ASC')->get();
        $article_count = Article::count();
        return view('admin.legal-articles.index', compact('articles', 'article_count'));
    }
    public function storeArticle(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            // 'version_no' => 'required',
            'content' => 'required',
        ]);
        $input = $request->all();
        Article::create($input);
        return back()->with('success', 'Article added');

    }
    public function editArticle($id) {
        $article = Article::findOrFail($id);
        return view('admin.legal-articles.edit-article', compact('article'));
    }
    public function showArticle($id) {
        $article = Article::findOrFail($id);
        return view('admin.legal-articles.show', compact('article'));
    }
    public function updateArticle(Request $request, $id) {
        $article = Article::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $input = $request->all();
        $article->update($input);
        return back()->with('success', 'Article updated');
    }
    public function deleteArticle($id) {
        $article = Article::findOrFail($id);
        $article->delete();
        return back()->with('success', 'article deleted');
    }


    //Legal Dictionary

    public function dictionary() {
        $words = Dictionary::orderBy('title', 'ASC')->get();
        $word_count = Dictionary::count();
        return view('admin.law-dictionary.index', compact('words', 'word_count'));
    }
    public function storeDictionary(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $input = $request->all();
        Dictionary::create($input);
        return back()->with('success', 'Word Added');

    }
    public function editDictionary($id) {
        $word = Dictionary::findOrFail($id);
        return view('admin.law-dictionary.edit-dictionary', compact('word'));
    }
    public function updateDictionary(Request $request, $id) {
        $word = Dictionary::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $input = $request->all();
        $word->update($input);
        return back()->with('success', 'Dictionary updated');
    }
    public function deleteDictionary($id) {
        $word = Dictionary::findOrFail($id);
        $word->delete();
        return back()->with('success', 'Word deleted');
    }



    // Legal Maxims

    public function maxim() {
        $maxims = Maxim::orderBy('title', 'ASC')->get();
        $maxim_count = Maxim::count();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.legal-maxims.index', compact('maxims', 'maxim_count', 'area_of_laws', 'categories'));
    }

    public function fetch_maxim(Request $request)
    {
        if ($request->ajax())
        {
            $maxims = Maxim::orderBy('title', 'ASC')->paginate(15);
            return response()->json([
                'maxims'=>$maxims,
            ]);
        }
    }
    public function storeMaxim(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            // 'version_no' => 'required',
            'content' => 'required',
        ]);
        $input = $request->all();
        Maxim::create($input);
        return back()->with('success', 'Maxim Added');

    }
    public function editMaxim($id) {
        $maxim = Maxim::findOrFail($id);
        return view('admin.legal-maxims.edit-maxims', compact('maxim'));
    }
    public function updateMaxim(Request $request, $id) {
        $maxim = Maxim::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            // 'version_no' => 'required',
            'content' => 'required',
        ]);
        $input = $request->all();
        $maxim->update($input);
        return back()->with('success', 'Maxim updated');
    }
    public function deleteMaxim($id) {
        $maxim = Maxim::findOrFail($id);
        $maxim->delete();
        return back()->with('success', 'Maxim deleted');
    }


    // Foreign resources

    public function resource() {
        $resources = Resource::OrderBy('title', 'ASC')->get();
        $resource_count = Resource::count();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        return view('admin.resources.index', compact('resources', 'resource_count', 'area_of_laws'));
    }
    public function storeResource(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'url' => 'required',
            'description' => 'required',
            'area_of_law' => 'required',
        ]);
        $input = $request->all();
        Resource::create($input);
        return back()->with('success', 'Resource Added');

    }
    public function editResource($id) {
        $resource = Resource::findOrFail($id);
        return view('admin.resources.edit-resources', compact('resource'));
    }
    public function updateResource(Request $request, $id) {
        $resource = Resource::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'Url' => 'required',
            'Description' => 'required',
        ]);
        $input = $request->all();
        $resource->update($input);
        return back()->with('success', 'Resource updated');
    }
    public function deleteResource($id) {
        $resource = Resource::findOrFail($id);
        $resource->delete();
        return back()->with('success', 'Resource deleted');
    }

    //subscription package
    public function subscription() {
        $packages = Package::orderBy('name', 'ASC')->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.subscriptions.index', compact('packages', 'area_of_laws', 'categories'));
    }

    public function storePackage(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'validity' => 'required',
            'recur_date' => 'required',
        ]);

        $judgement_feature = collect([
            [
                'judg_cat' => $request->judg_cat,
                'judg_area_of_law' => $request->judg_area_of_law
            ]
        ]);
        $lfn_feature = collect([
            [
                'lfn_cat' => $request->lfn_cat,
                'lfn_area_of_law' => $request->lfn_area_of_law
            ]
        ]);
        $roc_feature = collect([
            [
                'roc_cat' => $request->roc_cat
            ]
        ]);
        $sroc_feature = collect([
            [
                'sroc_cat' => $request->sroc_cat
            ]
        ]);
        $form_feature = collect([
            [
                'form_cat' => $request->form_cat
            ]
        ]);
        $article_feature = collect([
            [
                'article_cat' => $request->article_cat,
                'article_area_of_law' => $request->article_area_of_law
            ]
        ]);
        $maxim_feature = collect([
            [
                'maxim_area_of_law' => $request->maxim_area_of_law
            ]
        ]);
        $dict_feature = collect([
            [
                'dict_area_of_law' => $request->dict_area_of_law
            ]
        ]);
        $resource_feature = collect([
            [
                'resource_area_of_law' => $request->resource_area_of_law
            ]
        ]);

        // if($judgement_feature || $lfn_feature || $roc_feature || $sroc_feature || $form_feature || $article_feature || $maxim_feature || $dict_feature || $resource_feature) {
        //     $input = [
        //         'name' => $request->name,
        //         'description' => $request->description,
        //         'price' => $request->price,
        //         'validity' => $request->validity,
        //         'recur_date' => $request->recur_date,
        //         'judgement_feature' => $judgement_feature,
        //         'judg_start_year' => $request->judg_start_year,
        //         'judg_end_year' => $request->judg_end_year,
        //         'lfn_feature' => $lfn_feature,
        //         'roc_feature' => $roc_feature,
        //         'sroc_feature' => $sroc_feature,
        //         'form_feature' => $form_feature,
        //         'article_feature' => $article_feature,
        //         'maxim_feature' => $maxim_feature,
        //         'dict_feature' => $dict_feature,
        //         'resource_feature' => $resource_feature,
        //     ];
        // }

        $input = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'validity' => $request->validity,
            'recur_date' => $request->recur_date,
            'judgement_feature' => $judgement_feature,
            'judg_start_year' => $request->judg_start_year,
            'judg_end_year' => $request->judg_end_year,
            'lfn_feature' => $lfn_feature,
            'roc_feature' => $roc_feature,
            'sroc_feature' => $sroc_feature,
            'form_feature' => $form_feature,
            'article_feature' => $article_feature,
            'maxim_feature' => $maxim_feature,
            'dict_feature' => $dict_feature,
            'resource_feature' => $resource_feature,
        ];

        // dd($input);

        Package::create($input);
        return back()->with('success', 'Package created');
    }

    public function deletePackage($id) {
        $package = Package::findOrFail($id);
        $package->delete();
        return back()->with('success', 'Subscription package deleted');
    }




    // discount
    public function discount() {
        $discounts = Discount::orderBy('name', 'asc')->get();
        $packages = Package::orderBy('name', 'asc')->get();
        return view('admin.discounts.index', compact('discounts', 'packages'));
    }
    public function storeDiscount(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'validity_start_date' => 'required',
            'validity_end_date' => 'required',
            'discount_code' => 'required',
            'usage' => 'required',
            'percentage' => 'required',
            'package' => 'required',
        ]);
        $input = $request->all();
        Discount::create($input);
        return back()->with('success', 'Discount Added');

    }

    

    public function message() {
        return view('admin.messages.index');
    }

    public function license() {
        return view('admin.licenses.index');
    }
}
