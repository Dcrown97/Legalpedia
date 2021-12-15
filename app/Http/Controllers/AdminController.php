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
use App\Models\LawOfFederation;
use App\Models\LawOfFedPart;
use App\Models\LawOfFedSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        return view('admin.state-rules-of-court.index');
    }


    //laws of federation
    public function fed() {
        $feds = LawOfFederation::orderBy('Title', 'ASC')->get();
        $area_of_laws = AreaOfLaw::orderBy('AreaOfLaw', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        $fed_count = LawOfFederation::count();
        return view('admin.laws-of-federation.index', compact('feds', 'area_of_laws', 'categories', 'fed_count'));
    }
    public function storeFed(Request $request) {
        $validated = $request->validate([
            'Title' => 'required',
            'area_of_law' => 'required',
            'Descr' => 'required',
            'category' => 'required',
            'LawNo' => 'required',
            'LawDate' => 'required',
            'SubsidiaryLegislation' => 'required',


        ]);
        $fed_input = [
            'Title' => $request->Title,
            'area_of_law' => $request->area_of_law,
            'Descr' => $request->Descr,
            'category' => $request->category,
            'LawNo' => $request->LawNo,
            'LawDate' => $request->LawDate,
            'SubsidiaryLegislation' => $request->SubsidiaryLegislation,
        ];
        $fed = LawOfFederation::create($fed_input);
        $request->LawId = $fed->id;
        $fed_part_input = [
            'PartHeader' => $request->PartHeader,
            'LawId' => $request->LawId
        ];
        $fed_part = LawOfFedPart::create($fed_part_input);
        $request->PartId = $fed_part->id;
        $fed_section_input = [
            'SectionHeader' => $request->SectionHeader,
            'SectionBody' => $request->SectionBody,
            'LawId' =>  $fed->id,
            'PartId' => $fed_part->id
        ];
        LawOfFedSection::create($fed_section_input);

        return back()->with('success', 'Law added');

    }
    public function editFed($id) {
        $fed = LawOfFederation::findOrFail($id);
        $area_of_laws = AreaOfLaw::orderBy('AreaOfLaw', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.laws-of-federation.edit-fed', compact('fed', 'area_of_laws', 'categories'));
    }
    public function showFed($id) {
        $fed = LawOfFederation::findOrFail($id);
        $fed_part = LawOfFedPart::where('LawId', 671)->first();
        // $fed_section = LawOfFedSection::where('LawId', 671)->first();
        dd($fed_part);
        $area_of_laws = AreaOfLaw::orderBy('AreaOfLaw', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.laws-of-federation.show', compact('fed', 'area_of_laws', 'categories'));
    }
    public function updateFed(Request $request, $id) {
        $fed = LawOfFederation::findOrFail($id);
        $validated = $request->validate([
            'Title' => 'required',
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
        $form = FormsPrecedence::findOrFail($id);
        $form->delete();
        return back()->with('success', 'Law deleted');
    }



    // area of law
    public function area_of_law() {
        $area_of_laws = AreaOfLaw::orderBy('AreaOfLaw', 'ASC')->get();
        $area_count = AreaOfLaw::count();
        return view('admin.areas-of-laws.index', compact('area_of_laws', 'area_count'));
    }
    public function storeArea(Request $request) {
        $validated = $request->validate([
            'AreaOfLaw' => 'required',
        ]);
        $input = $request->all();
        AreaOfLaw::create($input);
        return back()->with('success', 'Area of Law added');
    }
    public function updateArea(Request $request) {
        $validated = $request->validate([
            'AreaOfLaw' => 'required',
        ]);
        $input = [
          'AreaOfLaw'=> $request->category,
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
        $area_of_laws = AreaOfLaw::orderBy('AreaOfLaw', 'asc')->get();
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
        $area_of_laws = AreaOfLaw::orderBy('AreaOfLaw', 'asc')->get();
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
        $articles = Article::orderBy('title', 'ASC')->paginate(15);
        return view('admin.legal-articles.index', compact('articles'));
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
        $words = Dictionary::orderBy('title', 'ASC')->paginate(15);
        return view('admin.law-dictionary.index', compact('words'));
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
        $maxims = Maxim::orderBy('title', 'ASC')->paginate(15);
        return view('admin.legal-maxims.index', compact('maxims'));
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
        $resources = Resource::paginate(15);
        return view('admin.resources.index', compact('resources'));
    }
    public function storeResource(Request $request) {
        $validated = $request->validate([
            'Title' => 'required',
            'Url' => 'required',
            'Description' => 'required',
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
            'Title' => 'required',
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




    public function customers() {
        return view('admin.customers.index');
    }

    public function subscription() {
        return view('admin.subscriptions.index');
    }

    public function discount() {
        return view('admin.discounts.index');
    }

    public function message() {
        return view('admin.messages.index');
    }

    public function license() {
        return view('admin.licenses.index');
    }
}
