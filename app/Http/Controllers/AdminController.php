<?php

namespace App\Http\Controllers;

use App\Models\Annotation;
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
use App\Models\Judgement;
use App\Models\JudgementSummary;
use App\Models\LawOfFederation;
use App\Models\LawOfFedPart;
use App\Models\Transaction;
use App\Models\LawOfFedSection;
use App\Models\LawOfFedSched;
use App\Models\Rule;
use App\Models\Court;
use App\Models\Coram;
use App\Models\JudgementCoram;
use App\Models\JudgementCounsel;
use App\Models\JudgementPartyA;
use App\Models\JudgementPartyB;
use App\Models\JudgementPrinciple;
use App\Models\Principle;
use App\Models\RuleCategory;
use App\Models\State;
use App\Models\SubjectMatterIndex;
use App\Models\Team;
use App\Models\UserTeam;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\License;
use App\Models\SummaryRatio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Notifications\TeamRequest;
use App\Notifications\RequestApproved;
use App\Notifications\RequestDeclined;
use App\Notifications\MemberRemoval;
use App\Notifications\MemberLeft;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\session;
use Whoops\RunInterface;

// use NunoMaduro\Collision\Adapters\Phpunit\State;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        $judgement_count = JudgementSummary::count();
        $fed_count = LawOfFederation::count();
        $rule_count = Rule::count();
        $form_count = FormsPrecedence::count();
        $article_count = Article::count();
        $dict_count = Dictionary::count();
        $maxim_count = Maxim::count();
        $resource_count = Resource::count();
        return view('admin.dashboard', compact('judgement_count', 'fed_count', 'rule_count', 'form_count', 'article_count', 'dict_count', 'maxim_count', 'resource_count'));
    }


    // judgement
    public function judgement(Request $request) {
        $courts = Court::orderBy('court', 'ASC')->get();
        DB::statement("SET SQL_MODE=''");
        $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        if($request->has('fetch_year')) {
            $judgement_summary = JudgementSummary::query();
            if($request->filled('id') && $request->filled('year')) {
                $judge = $judgement_summary->where('court_id', $request->id)->where('judgement_date','LIKE', '%'.$request->year.'%');
            }
            $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->get();
            $judgement_count = $judgement_summaries->count();
            $selected_year = [];
            $selected_year['judgement_date'] = $request->year;
            $selected_court = [];
            $selected_court['court_id'] = $request->id;
            return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
        }
        $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->get();
        $judgement_count = $judgement_summaries->count();
        $selected_court = [];
        $selected_court['court_id'] = '';
        $selected_year = [];
        $selected_year['judgement_date'] = '';
        return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
    }
    public function sbjMatter(Request $request) {
        $courts = Court::orderBy('court', 'ASC')->get();
        DB::statement("SET SQL_MODE=''");
        $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        $subject_matter_indices = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->get();
        if($request->has('fetch_subject')) {
            $judgement_summary = JudgementSummary::query();
            if($request->filled('subject_matter_index')) {
                $sbj = SubjectMatterIndex::where('subject_matter_index', $request->subject_matter_index)->first();
                $principle = Principle::where('subject_matter_index_id', $sbj->id)->first();
                $judg_principle = JudgementPrinciple::where('principle_id', $principle ? $principle->id : '')->first();
                $judge = $judgement_summary->where('suit_no', $judg_principle->suit_no);
            }
            $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->get();
            $judgement_count = $judgement_summaries->count();
            $selected_subject_matter = [];
            $selected_subject_matter['subject_matter_index'] = $request->subject_matter_index;
            return view('admin.judgements.subject-matter', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws', 'subject_matter_indices', 'selected_subject_matter'));
        }
        $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->get();
        $judgement_count = $judgement_summaries->count();
        $selected_subject_matter = [];
        $selected_subject_matter['subject_matter_index'] = '';
        return view('admin.judgements.subject-matter', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws', 'subject_matter_indices', 'selected_subject_matter'));
    }
    public function legalCitation() {
        $courts = Court::orderBy('court', 'ASC')->get();
        DB::statement("SET SQL_MODE=''");
        $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->get();
        $judgement_count = $judgement_summaries->count();
        return view('admin.judgements.legal-citation', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws'));

    }
    public function create() {
        $courts = Court::orderBy('court', 'ASC')->get();
        $categories = Category::orderBy('category', 'ASC')->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->get();
        return view('admin.judgements.create', compact('courts', 'categories', 'area_of_laws'));
    }
    public function storeJudgement(Request $request) {
        $validated = $request->validate([
            'title'=>'required',
            'summary_of_facts'=>'required',
            'suit_no'=>'required',
            'held'=>'required',
            'lp_citation'=>'required',
            'issues'=>'required',
            'cases_cited'=>'required',
            'statutes_cited'=>'required',
            // 'judgement_date'=>'required',
            'other_citations'=>'required',
            // 'holden_at_id'=>'required',
            'court_id'=>'required',
            // 'party_a_type_id'=>'required',
            // 'party_b_type_id'=>'required',
            // 'category'=>'required',
            // 'area_of_law'=>'required',
        ]);
        $judg_input = [
            'title'=>$request->title,
            'summary_of_facts'=>$request->summary_of_facts,
            'suit_no'=>$request->suit_no,
            'held'=>$request->held,
            'lp_citation'=>$request->lp_citation,
            'issues'=>$request->issues,
            'cases_cited'=>$request->cases_cited,
            'statutes_cited'=>$request->statutes_cited,
            'judgement_date'=>$request->judgement_date,
            'other_citations'=>$request->other_citations,
            // 'holden_at_id'=>$request->holden_at_id,
            'court_id'=>$request->court_id,
            // 'party_a_type_id'=>$request->party_a_type_id,
            // 'party_b_type_id'=>$request->party_b_type_id,
            'category'=>$request->category,
            'area_of_law'=>$request->area_of_law
        ];
        $judg = JudgementSummary::create($judg_input);
        // $request->judgement_coram_suit_no = $judg->suit_no;
        $coram_input = [
            'name'=>$request->name,
        ];
        $coram = Coram::create($coram_input);
        $request->coram_id = $coram->id;

        $judg_coram_input = [
            'coram_id'=> $request->coram_id,
            'suit_no'=> $judg->suit_no
        ];
        JudgementCoram::create($judg_coram_input);
        $party_a_input = [
            'party_a_names'=>$request->party_a_names,
            'suit_no'=>$judg->suit_no
        ];
        $party_a = JudgementPartyA::create($party_a_input);
        // $request->party_a_type_id = $party_a->id;
        $party_b_input = [
            'party_b_names'=>$request->party_b_names,
            'suit_no'=>$judg->suit_no
        ];
        $party_b = JudgementPartyB::create($party_b_input);
        // $request->party_a_type_id = $party_b->id;
        $judg->party_a_type_id = $party_a->id;
        $judg->party_b_type_id = $party_b->id;
        $judg->save();

        $judg_counsel_input = [
            'counsels'=>$request->counsels,
            'suit_no'=>$judg->suit_no
        ];
        JudgementCounsel::create($judg_counsel_input);

        $full_judg = [
            'judgement'=>$request->judgement,
            'suit_no'=>$judg->suit_no
        ];
        Judgement::create($full_judg);

        return back()->with('success', 'Judgement added');
    }
    public function updateJudgment(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $input = [
          'name'=> $request->name,
        ];
        DB::table('rule_categories')->where('id', $request->rule_cat_id)->update($input);
        return back()->with('success', 'Rule Category updated');
    }
    public function editJudgement($id) {
        if(Auth::user()->role->name == 'Admin') {
            $judgement_summary = JudgementSummary::findOrFail($id);
            $courts = Court::orderBy('court', 'ASC')->distinct()->get();
            DB::statement("SET SQL_MODE=''");
            $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law','ASC')->get();
            $categories = Category::orderBy('category','ASC')->get();
            return view('admin.judgements.edit', compact('judgement_summary', 'courts', 'years', 'area_of_laws', 'categories'));
        }
        return redirect('admin/judgements');
    }

    public function showJudgement($id) {
        $judgement_summary = JudgementSummary::findOrFail($id);
        $courts = Court::orderBy('court', 'ASC')->distinct()->get();
        DB::statement("SET SQL_MODE=''");
        $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
        $judgement_coram = JudgementCoram::select('suit_no')->first();
        // dd($judgement_coram);
        $corams = Coram::orderBy('name', 'DESC')->limit(5)->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law','ASC')->get();
        // dd($corams);
        return view('admin.judgements.show', compact('judgement_summary', 'courts', 'years', 'corams', 'judgement_coram', 'area_of_laws'));
    }
    public function deleteJudgement($id) {
        $judgement_summary = JudgementSummary::findOrFail($id);
        $judgement_summary->delete();
        return back()->with('success', 'Judgement Deleted');
    }


    //rule categories
    public function ruleCat() {
        $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
        $rule_category_count = RuleCategory::count();
        return view('admin.rules-of-court.categories', compact('rule_categories', 'rule_category_count'));
    }
    public function storeRuleCat(Request $request) {
        $validated = $request->validate([
            'name'=>'required'
        ]);
        $input = $request->all();
        RuleCategory::create($input);
        return back()->with('success', 'Rule Category added');
    }
    public function updateRuleCat(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $input = [
          'name'=> $request->name,
        ];
        DB::table('rule_categories')->where('id', $request->rule_cat_id)->update($input);
        return back()->with('success', 'Rule Category updated');
    }
    public function deleteRuleCat($id) {
        $rule_category = RuleCategory::findOrFail($id);
        $rule_category->delete();
        return back()->with('success', 'Rule Category deleted');
    }


    //rule of court
    public function rules(Request $request) {
        $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
        if($request->has('fetch_rule')) {
            $orders = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'ORDERS')->orderBy('title', 'ASC')->get();
            $appendices = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->get();
            $schedules = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->get();
            $forms = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'FORMS')->orderBy('title', 'ASC')->get();
            $civil_forms = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->get();
            $probate_forms = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->get();
            $parts = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'PARTS')->orderBy('title', 'ASC')->get();
            $appendix_count = $appendices->count();
            $order_count = $orders->count();
            $schedule_count = $schedules->count();
            $form_count = $forms->count();
            $civil_count = $civil_forms->count();
            $probate_count = $probate_forms->count();
            $part_count = $parts->count();
            $selected_name = [];
            $selected_name['name'] = $request->name;
            return view('admin.rules-of-court.index', compact('orders', 'schedules', 'appendices', 'forms', 'civil_forms', 'probate_forms', 'parts', 'rule_categories', 'order_count', 'part_count', 'schedule_count', 'civil_count', 'probate_count', 'appendix_count', 'form_count', 'selected_name'));
        }
        else {
            $orders = Rule::where('section', 'ORDERS')->where('type', 'Other')->orderBy('title', 'ASC')->get();
            $order_count = Rule::where('section', 'ORDERS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
            $schedules = Rule::where('section', 'SCHEDULES')->where('type', 'Other')->orderBy('title', 'ASC')->get();
            $schedule_count = Rule::where('section', 'SCHEDULES')->where('type', 'Other')->orderBy('title', 'ASC')->count();
            $appendices = Rule::where('section', 'APPENDIX')->where('type', 'Other')->orderBy('title', 'ASC')->get();
            $appendix_count = Rule::where('section', 'APPENDIX')->where('type', 'Other')->orderBy('title', 'ASC')->count();
            $forms = Rule::where('section', 'FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->get();
            $form_count = Rule::where('section', 'FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
            $civil_forms = Rule::where('section', 'CIVIL FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->get();
            $civil_count = Rule::where('section', 'CIVIL FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
            $probate_forms = Rule::where('section', 'PROBATE FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->get();
            $probate_count = Rule::where('section', 'PROBATE FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
            $parts = Rule::where('section', 'PARTS')->where('type', 'Other')->orderBy('title', 'ASC')->get();
            $part_count = Rule::where('section', 'PARTS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
            $selected_name = [];
            $selected_name['name'] = '';
            return view('admin.rules-of-court.index', compact('orders', 'schedules', 'appendices', 'forms', 'civil_forms', 'probate_forms', 'parts', 'rule_categories', 'order_count', 'schedule_count', 'part_count', 'appendix_count', 'civil_count', 'probate_count', 'form_count', 'selected_name'));
        }

    }
    public function showRule($id){
        if(Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
            return view('admin.rules-of-court.show', compact('order'));
        }elseif(Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
            return view('admin.rules-of-court.show', compact('schedule'));
        }elseif(Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
            return view('admin.rules-of-court.show', compact('appendix'));
        }elseif(Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
            return view('admin.rules-of-court.show', compact('form'));
        }elseif(Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
            return view('admin.rules-of-court.show', compact('civil_form'));
        }elseif(Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
            return view('admin.rules-of-court.show', compact('probate_form'));
        }elseif(Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
            return view('admin.rules-of-court.show', compact('part'));
        }
    }
    public function storeRule(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'section' => 'required',
            'content' => 'required',
            'type' => 'required',
        ]);
        $input = [
            'name' => $request->name,
            'title' => $request->title,
            'section' => $request->section,
            'content' => $request->content,
            'type' => $request->type,
            'version_no' => $request->version_no
        ];
        Rule::create($input);
        return back()->with('success', 'Rule of court added');
    }
    public function editRule($id) {
        if(Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.rules-of-court.edit', compact('order', 'rule_categories'));
        }elseif(Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.rules-of-court.edit', compact('schedule', 'rule_categories'));
        }elseif(Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.rules-of-court.edit', compact('appendix', 'rule_categories'));
        }elseif(Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.rules-of-court.edit', compact('form', 'rule_categories'));
        }elseif(Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.rules-of-court.edit', compact('civil_form', 'rule_categories'));
        }elseif(Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.rules-of-court.edit', compact('probate_form', 'rule_categories'));
        }elseif(Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.state-rules-of-court.edit', compact('part', 'rule_categories'));
        }
    }
    public function updateRule(Request $request, $id) {
        if(Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
        }
        $validated = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'section' => 'required',
            'content' => 'required',
            'type' => 'required',
        ]);
        $input = [
            'name' => $request->name,
            'title' => $request->title,
            'section' => $request->section,
            'content' => $request->content,
            'type' => $request->type,
            'version_no' => $request->version_no
        ];
        if($order) {
            $order->update($input);
        }elseif($schedule) {
            $schedule->update($input);
        }elseif($part) {
            $part->update($input);
        }elseif($form) {
            $form->update($input);
        }elseif($appendix) {
            $appendix->update($input);
        }elseif($probate_form) {
            $probate_form->update($input);
        }elseif($civil_form) {
            $civil_form->update($input);
        }
        return back()->with('success', 'Rule of court updated');
    }
    public function deleteRule($id) {
        if(Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
            $order->delete();
        }elseif(Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
            $schedule->delete();
        }elseif(Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
            $appendix->delete();
        }elseif(Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
            $form->delete();
        }elseif(Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
            $civil_form->delete();
        }elseif(Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
            $probate_form->delete();
        }elseif(Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
            $part->delete();
        }
        return back()->with('success', 'Rule deleted');
    }




    //state rule of court
    public function state_rules(Request $request) {
        $states = State::orderBy('name', 'ASC')->get();
        if($request->has('fetch_rule')) {
            $orders = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'ORDERS')->orderBy('title', 'ASC')->get();
            $appendices = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->get();
            $schedules = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->get();
            $forms = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'FORMS')->orderBy('title', 'ASC')->get();
            $civil_forms = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->get();
            $probate_forms = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->get();
            $parts = Rule::where( function($query) use($request){
                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
            })->where('section', 'PARTS')->orderBy('title', 'ASC')->get();
            $appendix_count = $appendices->count();
            $order_count = $orders->count();
            $schedule_count = $schedules->count();
            $form_count = $forms->count();
            $civil_count = $civil_forms->count();
            $probate_count = $probate_forms->count();
            $part_count = $parts->count();
            $selected_name = [];
            $selected_name['name'] = $request->name;
            return view('admin.state-rules-of-court.index', compact('orders', 'schedules', 'appendices', 'forms', 'civil_forms', 'probate_forms', 'parts', 'states', 'order_count', 'part_count', 'schedule_count', 'civil_count', 'probate_count', 'appendix_count', 'form_count', 'selected_name'));
        }
        else {
            $orders = Rule::where('section', 'ORDERS')->where('type', 'State')->orderBy('title', 'ASC')->get();
            $order_count = Rule::where('section', 'ORDERS')->where('type', 'State')->orderBy('title', 'ASC')->count();
            $schedules = Rule::where('section', 'SCHEDULES')->where('type', 'State')->orderBy('title', 'ASC')->get();
            $schedule_count = Rule::where('section', 'SCHEDULES')->where('type', 'State')->orderBy('title', 'ASC')->count();
            $appendices = Rule::where('section', 'APPENDIX')->where('type', 'State')->orderBy('title', 'ASC')->get();
            $appendix_count = Rule::where('section', 'APPENDIX')->where('type', 'State')->orderBy('title', 'ASC')->count();
            $forms = Rule::where('section', 'FORMS')->where('type', 'State')->orderBy('title', 'ASC')->get();
            $form_count = Rule::where('section', 'FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
            $civil_forms = Rule::where('section', 'CIVIL FORMS')->where('type', 'State')->orderBy('title', 'ASC')->get();
            $civil_count = Rule::where('section', 'CIVIL FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
            $probate_forms = Rule::where('section', 'PROBATE FORMS')->where('type', 'State')->orderBy('title', 'ASC')->get();
            $probate_count = Rule::where('section', 'PROBATE FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
            $parts = Rule::where('section', 'PARTS')->where('type', 'State')->orderBy('title', 'ASC')->get();
            $part_count = Rule::where('section', 'PARTS')->where('type', 'State')->orderBy('title', 'ASC')->count();
            $selected_name = [];
            $selected_name['name'] = '';
            return view('admin.state-rules-of-court.index', compact('orders', 'schedules', 'appendices', 'forms', 'civil_forms', 'probate_forms', 'parts', 'states', 'order_count', 'schedule_count', 'part_count', 'appendix_count', 'civil_count', 'probate_count', 'form_count', 'selected_name'));
        }
    }
    public function showStateRule($id){
        if(Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
            return view('admin.state-rules-of-court.show', compact('order'));
        }elseif(Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
            return view('admin.state-rules-of-court.show', compact('schedule'));
        }elseif(Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
            return view('admin.state-rules-of-court.show', compact('appendix'));
        }elseif(Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
            return view('admin.state-rules-of-court.show', compact('form'));
        }elseif(Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
            return view('admin.state-rules-of-court.show', compact('civil_form'));
        }elseif(Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
            return view('admin.state-rules-of-court.show', compact('probate_form'));
        }elseif(Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
            return view('admin.state-rules-of-court.show', compact('part'));
        }
    }
    public function storeStateRule(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'section' => 'required',
            'content' => 'required',
            'type' => 'required',
        ]);
        $input = [
            'name' => $request->name,
            'title' => $request->title,
            'section' => $request->section,
            'content' => $request->content,
            'type' => $request->type,
            'version_no' => $request->version_no
        ];
        Rule::create($input);
        return back()->with('success', 'State Rule of court added');
    }
    public function editStateRule($id) {
        if(Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
            $states = State::orderBy('name', 'ASC')->get();
            return view('admin.state-rules-of-court.edit', compact('order', 'states'));
        }elseif(Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
            $states = State::orderBy('name', 'ASC')->get();
            return view('admin.state-rules-of-court.edit', compact('schedule', 'states'));
        }elseif(Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
            $states = State::orderBy('name', 'ASC')->get();
            return view('admin.state-rules-of-court.edit', compact('appendix', 'states'));
        }elseif(Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
            $states = State::orderBy('name', 'ASC')->get();
            return view('admin.state-rules-of-court.edit', compact('form', 'states'));
        }elseif(Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
            $states = State::orderBy('name', 'ASC')->get();
            return view('admin.state-rules-of-court.edit', compact('civil_form', 'states'));
        }elseif(Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
            $states = State::orderBy('name', 'ASC')->get();
            return view('admin.state-rules-of-court.edit', compact('probate_form', 'states'));
        }elseif(Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
            $states = State::orderBy('name', 'ASC')->get();
            return view('admin.state-rules-of-court.edit', compact('part', 'states'));
        }
    }
    public function updateStateRule(Request $request, $id) {
        if(Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
        }elseif(Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
        }
        $validated = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'section' => 'required',
            'content' => 'required',
            'type' => 'required',
        ]);
        $input = [
            'name' => $request->name,
            'title' => $request->title,
            'section' => $request->section,
            'content' => $request->content,
            'type' => $request->type,
            'version_no' => $request->version_no
        ];
        if($order) {
            $order->update($input);
        }elseif($schedule) {
            $schedule->update($input);
        }elseif($part) {
            $part->update($input);
        }elseif($form) {
            $form->update($input);
        }elseif($appendix) {
            $appendix->update($input);
        }elseif($probate_form) {
            $probate_form->update($input);
        }elseif($civil_form) {
            $civil_form->update($input);
        }
        return back()->with('success', 'State Rule of court updated');
    }
    public function deleteStateRule($id) {
        if(Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
            $order->delete();
        }elseif(Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
            $schedule->delete();
        }elseif(Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
            $appendix->delete();
        }elseif(Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
            $form->delete();
        }elseif(Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
            $civil_form->delete();
        }elseif(Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
            $probate_form->delete();
        }elseif(Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
            $part->delete();
        }
        return back()->with('success', 'State rule deleted');
    }



    //laws of federation
    public function fed(Request $request) {
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        if($request->has('fetch_fed')) {
            $fed = LawOfFederation::query();
            if($request->filled('category')) {
                $feds = $fed->where('category', $request->category)->orderBy('title', 'ASC')->get();
                $fed_count = $feds->count();
                $selected_category = [];
                $selected_category['category'] = $request->category;
            }
            return view('admin.laws-of-federation.index', compact('feds', 'area_of_laws', 'categories', 'fed_count', 'selected_category'));
        } else {
            $feds = LawOfFederation::orderBy('title', 'ASC')->get();
            $fed_count = LawOfFederation::count();
            $selected_category = [];
            $selected_category['category'] = '';
            return view('admin.laws-of-federation.index', compact('feds', 'area_of_laws', 'categories', 'fed_count', 'selected_category'));
        }
    }
    public function storeFed(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            // 'area_of_law' => 'required',
            'description' => 'required',
            // 'category' => 'required',
            'law_no' => 'required',
            // 'law_date' => 'required',
            'subsidiary_legislation' => 'required',
            'part_header' => 'required',
            // 'section_header' => 'required',
            // 'section_body' => 'required',
            // 'sched_header' => 'required',
            // 'sched_body' => 'required',
        ]);

        $fed_input = [
            'title' => $request->title,
            'area_of_law' => $request->area_of_law,
            'description' => $request->description,
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
        // dd($request->sched);
        if($request->section) {
            foreach($request->section as $section_input) {
                $data = [
                    'section_header'=>$section_input[0],
                    'section_body'=>$section_input[1],
                    'law_of_federation_id'=> $request->law_of_federation_id,
                    'law_of_fed_part_id'=> $request->law_of_fed_part_id,
                ];
                LawOfFedSection::create($data);
            }
        }

        if($request->sched) {
            foreach($request->sched as $sched_input) {
                $data = [
                    'sched_header'=>$sched_input[0],
                    'sched_body'=>$sched_input[1],
                    'law_of_federation_id'=> $request->law_of_federation_id,
                ];
                LawOfFedSched::create($data);
            }
        }

        return back()->with('success', 'Law added');

    }
    public function editFed($id) {
        $fed = LawOfFederation::findOrFail($id);
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        $fed_part = LawOfFedPart::where('law_of_federation_id', $fed->id)->first();
        $fed_sections = LawOfFedSection::where('law_of_federation_id', $fed->id)->get();
        $fed_section_count = LawOfFedSection::where('law_of_federation_id', $fed->id)->count();
        $fed_scheds = LawOfFedSched::where('law_of_federation_id', $fed->id)->get();
        $fed_sched_count = LawOfFedSched::where('law_of_federation_id', $fed->id)->count();
        return view('admin.laws-of-federation.edit', compact('fed', 'area_of_laws', 'categories', 'fed_part', 'fed_sections', 'fed_section_count', 'fed_scheds', 'fed_sched_count'));
    }
    public function showFed($id) {
        $fed = LawOfFederation::findOrFail($id);
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.laws-of-federation.show', compact('fed', 'area_of_laws', 'categories'));
    }
    public function updateFed(Request $request, $id) {
        $fed = LawOfFederation::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            // 'area_of_law' => 'required',
            'description' => 'required',
            // 'category' => 'required',
            'law_no' => 'required',
            // 'law_date' => 'required',
            'subsidiary_legislation' => 'required',
            'part_header' => 'required',
            // 'section_header' => 'required',
            // 'section_body' => 'required',
            // 'sched_header' => 'required',
            // 'sched_body' => 'required',
        ]);
        $fed_input = [
            'title' => $request->title,
            'area_of_law' => $request->area_of_law,
            'description' => $request->description,
            'category' => $request->category,
            'law_no' => $request->law_no,
            'law_date' => $request->law_date,
            'subsidiary_legislation' => $request->subsidiary_legislation,
        ];
        $fed->update($fed_input);

        $fed_part_input = [
            'part_header' => $request->part_header,
            'law_of_federation_id' => $request->law_of_federation_id
        ];
        $fed_part = DB::table('law_of_fed_parts')->where('law_of_federation_id', $fed->id)->update($fed_part_input);
        $fed_part = LawOfFedPart::where('law_of_federation_id', $fed->id)->first();
        $fed_part_id = $fed_part->id;
        // dd($request->new_section);
        // dd($request->sched);
        if($request->section) {
            foreach($request->section as $key => $section_input) {
                $data = [
                    'section_header'=>$section_input[2],
                    'section_body'=>$section_input[3],
                    'law_of_federation_id'=> $fed->id,
                    'law_of_fed_part_id'=> $fed_part_id,
                ];
                DB::table('law_of_fed_sections')->where('id', $key)->update($data);

                if($request->has('remove_section')) {
                    $fed_section = LawOfFedSection::where('id', $request->fed_section_id);
                    $fed_section->delete();
                    return back()->with('success', 'Law Federation Section removed');
                }
            }
        }

        if($request->new_section) {
            foreach($request->new_section as $section_input) {
                $data = [
                    'section_header'=>$section_input[2],
                    'section_body'=>$section_input[3],
                    'law_of_federation_id'=> $fed->id,
                    'law_of_fed_part_id'=> $fed_part_id,
                ];
                LawOfFedSection::where('law_of_federation_id', $fed->id)->create($data);
            }
        }

        if($request->sched) {
            foreach($request->sched as $key => $sched_input) {
                $data = [
                    'sched_header'=>$sched_input[1],
                    'sched_body'=>$sched_input[2],
                    'law_of_federation_id'=> $fed->id,
                ];
                DB::table('law_of_fed_scheds')->where('id', $key)->update($data);

                if($request->has('remove_sched')) {
                    $fed_sched = LawOfFedSched::where('id', $request->fed_sched_id);
                    $fed_sched->delete();
                    return back()->with('success', 'Law Federation Schedule removed');
                }
            }
        }

        if($request->new_sched) {
            foreach($request->new_sched as $sched_input) {
                $data = [
                    'sched_header'=>$sched_input[1],
                    'sched_body'=>$sched_input[2],
                    'law_of_federation_id'=> $fed->id,
                ];
                LawOfFedSched::where('law_of_federation_id', $fed->id)->create($data);
            }
        }

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


    // Forms and Precedents
    public function forms(Request $request) {
        $categories = Category::orderBy('category', 'ASC')->get();
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        if($request->has('fetch_form')) {
            $form = FormsPrecedence::query();
            if($request->filled('category')) {
                $forms = $form->where('category', $request->category)->get();
                $form_count = $form->where('category', $request->category)->count();
                $selected_category = [];
                $selected_category['category'] = $request->category;
            }
            return view('admin.forms-and-precedents.index', compact('area_of_laws', 'forms', 'categories', 'form_count', 'selected_category'));
        } else {
            $forms = FormsPrecedence::orderBy('title', 'ASC')->get();
            $form_count = FormsPrecedence::count();
            $selected_category = [];
            $selected_category['category'] = '';
            return view('admin.forms-and-precedents.index', compact('area_of_laws', 'forms', 'categories', 'form_count', 'selected_category'));
        }
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
        return view('admin.forms-and-precedents.edit-form', compact('form', 'area_of_laws', 'categories'));
    }
    public function showForm($id) {
        $form = FormsPrecedence::findOrFail($id);
        return view('admin.forms-and-precedents.show', compact('form'));
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
        $articles = Article::where('article_type', 'legalpedia')->orderBy('title', 'ASC')->get();
        $my_articles = Article::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
        $public_articles = Article::where('display_type', 'public')->orderBy('title', 'ASC')->get();
        $article_count = $articles->count();
        $public_article_count = $public_articles->count();
        $categories = Category::orderBy('category', 'ASC')->get();
        return view('admin.legal-articles.index', compact('articles', 'article_count', 'my_articles', 'public_articles', 'categories', 'public_article_count'));
    }
    public function storeArticle(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            'authur' => 'required',
            'link' => 'required',
            'photo' => 'required',
            'category' => 'required',
            // 'area_of_law' => 'required',
            'references' => 'required',
        ]);
        $file = $request->file('photo');
        $path = $file->store('media', 'public');
        $input = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'photo' => $path,
            'content' => $request->content,
            'description' => $request->description,
            'authur' => $request->authur,
            'link' => $request->link,
            'display_type' => $request->display_type,
            'article_type' => $request->article_type,
            'category' => $request->category,
            'area_of_law' => $request->area_of_law,
            'references' => $request->references,
        ];
        Article::create($input);
        return back()->with('success', 'Article added');

    }
    public function editArticle($id) {
        $article = Article::findOrFail($id);
        $categories = Category::orderBy('category', 'ASC')->get();
        return view('admin.legal-articles.edit-article', compact('article', 'categories'));
    }
    public function showArticle($id) {
        $article = Article::findOrFail($id);
        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
        return view('admin.legal-articles.show-article', compact('article', 'teams'));
    }
    public function updateArticle(Request $request, $id) {
        $article = Article::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            'authur' => 'required',
            'link' => 'required',
            'category' => 'required',
            // 'area_of_law' => 'required',
            'references' => 'required',
        ]);
        if($file = $request->file('photo')) {
            $file = $request->file('photo');
            $path = $file->store('media', 'public');
            $input = [
                'user_id' => $request->user_id,
                'title' => $request->title,
                'photo' => $path,
                'content' => $request->content,
                'description' => $request->description,
                'authur' => $request->authur,
                'display_type' => $request->display_type,
                'article_type' => $request->article_type,
                'category' => $request->category,
                'area_of_law' => $request->area_of_law,
                'link' => $request->link,
                'references' => $request->references,
            ];
            $article->update($input);
        }
        $input = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            'authur' => $request->authur,
            'display_type' => $request->display_type,
            'article_type' => $request->article_type,
            'category' => $request->category,
            'area_of_law' => $request->area_of_law,
            'link' => $request->link,
            'references' => $request->references,
        ];
        return back()->with('success', 'Article updated');
    }
    public function deleteArticle($id) {
        $article = Article::findOrFail($id);
        $article->delete();
        return back()->with('success', 'article deleted');
    }
    public function shareArticle(Request $request, $id) {
        $article = Article::find($id);
        $link = route('show.article', $article->id);
        if($request->has('share_all') && !empty($request->checkBoxArray)) {
            foreach($request->checkBoxArray as $team) {
                $input = [
                    'team_id' => $team,
                    'user_id' => $request->user_id,
                    'article_id' => $id,
                    'comment_body' => json_encode([$article->title, $article->description, $link]),
                    'file' => substr($article->photo, 31),
                    'file_type' => 'image',
                ];
                Comment::create($input);
            }
            return back()->with('success', 'Article shared');
        }
        return back()->withErrors('Please select a team to share to');
    }


    //Legal Dictionary

    public function dictionary() {
        $words = Dictionary::orderBy('title', 'ASC')->get();
        $word_count = Dictionary::count();
        $categories = Category::orderBy('category', 'ASC')->get();
        return view('admin.law-dictionary.index', compact('words', 'word_count', 'categories'));
    }
    public function storeDictionary(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'area_of_law' => 'required',
        ]);
        $input = $request->all();
        Dictionary::create($input);
        return back()->with('success', 'Word Added');

    }
    public function editDictionary($id) {
        $word = Dictionary::findOrFail($id);
        $categories = Category::orderBy('category', 'ASC')->get();
        return view('admin.law-dictionary.edit-dictionary', compact('word', 'categories'));
    }
    public function updateDictionary(Request $request, $id) {
        $word = Dictionary::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'area_of_law' => 'required',
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
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.legal-maxims.index', compact('maxims', 'maxim_count', 'categories'));
    }

    public function storeMaxim(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'area_of_law' => 'required',
        ]);
        $input = $request->all();
        Maxim::create($input);
        return back()->with('success', 'Maxim Added');

    }
    public function editMaxim($id) {
        $maxim = Maxim::findOrFail($id);
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.legal-maxims.edit-maxims', compact('maxim', 'categories'));
    }
    public function updateMaxim(Request $request, $id) {
        $maxim = Maxim::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'area_of_law' => 'required',
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
        $courts = Court::orderBy('court', 'ASC')->get();
        $states = State::orderBy('name', 'ASC')->get();
        $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
        return view('admin.subscriptions.index', compact('packages', 'area_of_laws', 'categories', 'courts', 'states', 'rule_categories'));
    }
    public function editPackage($id) {
        $package = Package::findOrFail($id);
        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('admin.subscriptions.edit-package', compact('package', 'area_of_laws', 'categories'));
    }
    public function storePackage(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'validity' => 'required',
            'recur_date' => 'required',
        ]);
        $input = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'validity' => $request->validity,
            'recur_date' => $request->recur_date,
            'judgement_feature' => $request->judgement_feature,
            'judg_single_year' => $request->judg_single_year,
            'judg_start_year' => $request->judg_start_year,
            'judg_end_year' => $request->judg_end_year,
            'judg_cat' => json_encode($request->judg_cat),
            'judg_court' => json_encode($request->judg_court),
            'lfn_feature' => $request->lfn_feature,
            'lfn_single_year' => $request->lfn_single_year,
            'lfn_start_year' => $request->lfn_start_year,
            'lfn_end_year' => $request->lfn_end_year,
            'lfn_cat' => json_encode($request->lfn_cat),
            'roc_feature' => $request->roc_feature,
            'roc_cat' => json_encode($request->roc_cat),
            'sroc_feature' => $request->sroc_feature,
            'sroc_state' => json_encode($request->sroc_state),
            'form_feature' => $request->form_feature,
            'form_cat' => json_encode($request->form_cat),
            'article_feature' => $request->article_feature,
            'article_cat' => json_encode($request->article_cat),
            'maxim_feature' => $request->maxim_feature,
            'maxim_cat' => json_encode($request->maxim_cat),
            'dict_feature' => $request->dict_feature,
            'dict_cat' => json_encode($request->dict_cat),
            'resource_feature' => $request->resource_feature,
            'resource_cat' => json_encode($request->resource_cat),
            'team' => $request->team,
            'share' => $request->share,
            'note' => $request->note,
            'bookmark' => $request->bookamrk,

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
        $discount_code = $this->generateRandomString(6);
        return view('admin.discounts.index', compact('discounts', 'packages', 'discount_code'));
    }
    public function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
    public function updateDiscount(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'validity_start_date' => 'required',
            'validity_end_date' => 'required',
            'discount_code' => 'required',
            'usage' => 'required',
            'percentage' => 'required',
            'package' => 'required',
        ]);
        $input = [
          'name'=> $request->name,
          'validity_start_date'=> $request->validity_start_date,
          'validity_end_date'=> $request->validity_end_date,
          'discount_code'=> $request->discount_code,
          'usage'=> $request->usage,
          'percentage'=> $request->percentage,
          'package'=> $request->package,
        ];
        DB::table('discounts')->where('id', $request->discount_id)->update($input);
        return back()->with('success', 'Discount updated');
    }
    public function useDiscount(Request $request, $id) {
        $package = Package::findOrFail($id);
        $discount = Discount::where('package_id', $package->id)->first();
        $validator = Validator::make(
            $request->all(),
            [
                'used' => 'required',
            ]
        );
        if($validator->fails()) {
            return back()->withErrors('Please enter a valid coupon');
        }
        if($request->used == $discount->discount_code) {
            if($discount->used == null) {
                $input = [
                    'used' => 1,
                ];
                $discount->update($input);

                $discounted_price = ($package->price * $discount->percentage) / 100;
                $new_price = $package->price - $discounted_price;
                // $package->price = $new_price;
                // dd($package->price);

                Session::flash('success', 'Discount applied');
                // return back()->with('updated_price', $new_price);
                return view('checkout.discount', compact('new_price', 'package'));

            } elseif($discount->used < $discount->usage) {
                // dd($request->used);
                $data = 1 + $discount->used;
                // dd($data);
                $discount->used = $data;
                $discount->save();

                $discounted_price = ($package->price * $discount->percentage) / 100;
                $new_price = $package->price - $discounted_price;
                // dd($new_price);

                Session::flash('success', 'Discount applied');
                return view('checkout.discount', compact('new_price', 'package'));
            }
            return back()->withErrors('Coupon already used');
        }
        return back()->withErrors('Invalid coupon');
    }

    public function deleteDiscount($id) {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return back()->with('success', 'Discount deleted');
    }


    // transactions
    public function transaction(Request $request) {
        $packages = Package::orderBy('name', 'ASC')->get();
        if($request->has('fetch_transaction')) {
            $transaction = Transaction::query();
            if($request->filled('end_date')) {
                $start_date = Carbon::parse($request->start_date)->toDateTimeString();
                $end_date = Carbon::parse($request->end_date)->toDateTimeString();
                $transactions = $transaction->whereBetween('created_at', [$start_date, $end_date])->orderBy('created_at', 'DESC')->get();
            }
            if( $request->filled('status')) {
                $transactions = $transaction->where('status', $request->status)->orderBy('created_at', 'DESC')->get();
            }
            if( $request->filled('package')) {
                $transactions = $transaction->where('package', $request->package)->orderBy('created_at', 'DESC')->get();
            }
            $transaction_count = $transactions->count();
            $selected_status = [];
            $selected_status['status'] = $request->status;
            $selected_package = [];
            $selected_package['package'] = $request->package;
            $gross_amount =  $transactions->sum('amount');
            $discounted_sum =  $transactions->sum('discounted_price');
            $net_amount =  $transactions->where('status', 'paid')->sum('amount') - $discounted_sum;
            $bought_package =  $transactions->where('status', 'paid')->count();
            return view('admin.transactions.index', compact('transactions', 'transaction_count', 'gross_amount', 'net_amount', 'bought_package', 'packages', 'selected_status', 'selected_package', 'discounted_sum'));
        }
        $transactions = Transaction::orderBy('created_at', 'DESC')->get();
        $transaction_count = $transactions->count();
        $gross_amount =  $transactions->sum('amount');
        $discounted_sum =  $transactions->sum('discounted_price');
        $net_amount =  $transactions->where('status', 'paid')->sum('amount') - $discounted_sum;
        $bought_package =  $transactions->where('status', 'paid')->count();
        $selected_status = [];
        $selected_status['status'] = '';
        $selected_package = [];
        $selected_package['package'] = '';
        return view('admin.transactions.index', compact('transactions', 'transaction_count', 'gross_amount', 'net_amount', 'bought_package', 'packages', 'selected_status', 'selected_package', 'discounted_sum'));

    }
    public function updateTransaction(Request $request) {
        $validated = $request->validate([
            'status' => 'required',
        ]);
        $input = [
          'status'=> $request->status,
        ];
        DB::table('transactions')->where('id', $request->transaction_id)->update($input);
        return back()->with('success', 'Transaction updated');
    }
    public function deleteTransaction($id) {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return back()->with('success', 'Transaction deleted');
    }


    //Teams
    public function team() {
        $teams = Team::get();
        $my_teams = Team::where('user_id', Auth::user()->id)->get();
        return view('admin.teams.index', compact('teams', 'my_teams'));
    }
    public function storeTeam(Request $request) {
        $validated = $request->validate([
            'photo'=>'required|mimes:png,jpeg,jpg,webp|max:10000',
            'name' => 'required',
            'description' => 'required',
        ]);
        $file = $request->file('photo');
        $path = $file->store('media', 'public');
        $input = [
            'user_id' => $request->user_id,
            'team_owner' => $request->team_owner,
            'photo' => $path,
            'name' => $request->name,
            'description' => $request->description
        ];
        $team = Team::create($input);
        $request->team_id = $team->id;
        $user_team_input = [
            'team_id' => $team->id,
            'user_id' => $request->user_id,
            'send_request' => $request->send_request,
            'approve_request' => $request->approve_request,
        ];
        UserTeam::create($user_team_input);
        return redirect()->back()->with('success', 'Team created');
    }
    public function updateTeam(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        if($file = $request->file('photo')) {
            $path = $file->store('media', 'public');
            $input = [
                'user_id' => $request->user_id,
                'team_owner' => $request->team_owner,
                'photo' => $path,
                'name' => $request->name,
                'description' => $request->description
            ];
            DB::table('teams')->where('id', $request->team_id)->update($input);
            return redirect()->back()->with('success', 'Team updated');
        }
        $input = [
            'user_id' => $request->user_id,
            'team_owner' => $request->team_owner,
            'name' => $request->name,
            'description' => $request->description
        ];
        DB::table('teams')->where('id', $request->team_id)->update($input);
        return redirect()->back()->with('success', 'Team updated');
    }
    public function settingsTeam(Request $request, $id) {
        $team = Team::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $input = $request->all();
        if($file = $request->file('photo')) {
            $path = $file->store('media', 'public');
            $input['photo'] = $path;
        }
        $team->update($input);
        return redirect()->back()->with('success', 'Team updated');
    }
    public function showTeam($id) {
        $team = Team::findOrFail($id);
        $user = Auth::user()->id;
        $users = User::select("*")->whereNotNull('last_seen')->orderBy('last_seen', 'DESC')->get();
        $send_request = UserTeam::where('user_id', Auth::user()->id)->where('team_id', $team->id)->first();
        $approved_members = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->get();
        $some_approved_members = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->limit(4)->get();
        $approved_member = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->first();
        $approved_member_count = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->count();
        $comments = Comment::with('comment_replies')->where('team_id', $team->id)->orderBy('created_at', 'DESC')->get();
        $shared_files = Comment::where('team_id', $team->id)->orderBy('created_at', 'DESC')->limit(4)->get();
        $shared_resources = Comment::where('team_id', $team->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.teams.show', compact('team', 'users', 'send_request', 'approved_members', 'some_approved_members', 'approved_member', 'approved_member_count', 'comments', 'shared_files', 'shared_resources'));
    }
    public function sendRequest(Request $request) {
        $input = [
            'send_request' => $request->send_request,
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
        ];
        UserTeam::create($input);
        $user = Auth::user();
        $team_admin = User::where('id', $request->team_owner_id)->first();
        if ($team_admin) {
            $team_admin->notify(new TeamRequest($user));
        }
        return redirect()->back()->with('success', 'Request sent');
    }
    public function approveMember() {
        if(UserTeam::where('user_id', Auth::user()->id)->first()) {
            $new_members = UserTeam::where('send_request', 1)->where('approve_request', 0)->get();
            return view('admin.teams.approve', compact('new_members'));
        } else
        return redirect('admin/teams');
    }
    public function approveRequest(Request $request, $id) {
        $user = UserTeam::findOrFail($id);
        $input = [
            'approve_request' => $request->approve_request,
        ];
        $user->update($input);
        $approved_member = User::where('id', $user->user_id)->first();
        if($approved_member) {
            $approved_member->notify(new RequestApproved($user));
        }
        return redirect()->back()->with('success', 'You have just approved this member');
    }
    public function declineRequest(Request $request, $id) {
        $user = UserTeam::findOrFail($id);
        $input = [
            'approve_request' => $request->approve_request,
        ];
        $user->update($input);
        $declined_member = User::where('id', $user->user_id)->first();
        if($declined_member) {
            $declined_member->notify(new RequestDeclined($user));
        }
        return redirect()->back()->with('success', 'You declined this member');
    }

    public function remove($id) {
        $approved_member = UserTeam::findOrFail($id);
        $approved_member->delete();
        $removed_user = User::where('id', $approved_member->user_id)->first();
        if($removed_user) {
            $removed_user->notify(new MemberRemoval($approved_member));
        }
        return redirect()->back()->with('success', 'You have just removed a user');
    }
    public function leave($id) {
        $approved_member = UserTeam::findOrFail($id);
        $approved_member->delete();
        $left_user = User::where('id', $approved_member->user_id)->first();
        if($left_user) {
            $left_user->notify(new MemberLeft($approved_member));
        }
        return redirect()->back()->with('success', 'You have just removed a user');
    }
    public function deleteTeam($id) {
        $team = Team::findOrFail($id);
        $user_team = UserTeam::where('team_id', $team->id)->first();
        if($user_team) {
            $user_team->delete();
        }
        $team->delete();
        return back()->with('success', 'Team deleted');
    }


    // comment and replies
    public function comment(Request $request) {
        $validated = $request->validate([
            'comment_body' => 'required',
            // 'file'=>'required|mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg|max:10000',
            // 'file_type' => 'required',
        ]);

        if($file = $request->file('file')) {
            $path = $file->store('media', 'public');
            $input = [
                'user_id' => $request->user_id,
                'team_id' => $request->team_id,
                'file' => $path,
                'pdf_name' => $request->pdf_name,
                'doc_name' => $request->doc_name,
                'zip_name' => $request->zip_name,
                'rar_name' => $request->rar_name,
                'file_type' => $request->file_type,
                'comment_body' => $request->comment_body
            ];
        }
        $input = [
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
            'comment_body' => $request->comment_body
        ];
        Comment::create($input);
        return redirect()->back()->with('success', 'You just posted to this team');
    }
    public function reply(Request $request) {
        if($request->has('reply')) {
            $validated = $request->validate([
                'comment_reply_body' => 'required',
            ]);
            $input = [
                'user_id' => $request->user_id,
                'comment_id' => $request->comment_id,
                'comment_reply_body' => $request->comment_reply_body
            ];
            CommentReply::create($input);
            return redirect()->back()->with('success', 'You just commented to this post');
        }
    }



    public function search(Request $request){
// dd($request->all());
        if($request->input('search')) {
            $search = $request->input('search');

            $query['table'] = 'ratio';
            $query['search'] = SummaryRatio::query()->where('heading', 'LIKE', "%{$search}%")
                        ->orWhere('body', 'LIKE', "%{$search}%")
                        ->orderBy('heading', 'ASC')
                        ->get();
            //             ->withQueryString();
            // $query['count'] = SummaryRatio::query()->where('heading', 'LIKE', "%{$search}%")
            //             ->orWhere('body', 'LIKE', "%{$search}%")
            //             ->orderBy('heading', 'ASC')
            //             ->count();

            $query['subject'] = SummaryRatio::query()->where('heading', 'LIKE', "%{$search}%")
                            ->orWhere('body', 'LIKE', "%{$search}%")
                            ->orderBy('heading', 'ASC')
                            ->get();

            if($query['search']->count() < 1){
                $query['table'] = 'judgement_summary';
                $query['search'] = JudgementSummary::query()
                        ->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('summary_of_facts', 'LIKE', "%{$search}%")
                        ->orWhere('issues', 'LIKE', "%{$search}%")
                        ->orderBy('judgement_date', 'DESC')
                        ->get();
                //         ->withQueryString();
                // $query['count'] = JudgementSummary::query()
                //         ->where('title', 'LIKE', "%{$search}%")
                //         ->orWhere('summary_of_facts', 'LIKE', "%{$search}%")
                //         ->orWhere('issues', 'LIKE', "%{$search}%")
                //         ->orderBy('judgement_date', 'DESC')
                //         ->count();
            }

            if($query['search']->count() < 1){
                $query['table'] = 'judgement';
                $query['search'] = Judgement::query()
                        ->where('judgement', 'LIKE', "%{$search}%")
                        ->orderBy('judgement', 'DESC')
                        ->get();
                //         ->withQueryString();
                // $query['count'] = Judgement::query()
                //         ->where('judgement', 'LIKE', "%{$search}%")
                //         ->orderBy('judgement', 'DESC')
                //         ->count();

                // dd($query['search']);
            }
            return view('admin.search', compact('query'));
        }
    }

    public function autocomplete(Request $request){
        // Get the search value from the request
        $search = $request->input('search');
        $cases = SummaryRatio::query()
        ->where('heading', 'LIKE', "%{$search}%")
        ->orWhere('body', 'LIKE', "%{$search}%")
        ->orderBy('heading', 'ASC')
        ->get();
        return response()->json($cases);
    }

    // annotations
    public function anote(Request $request) {
        $input = [
            'user_id'=> $request->user_id,
            'note_id'=> $request->note_id,
            'content_id'=> $request->content_id,
            'content_type'=> $request->content_type,
            'content'=> $request->content,
            'comment'=> $request->comment,
            'replies'=> $request->replies,
            'text_target'=> $request->text_target,
            'tags'=> $request->tags,
        ];
        Annotation::create($input);
        return back()->with('success', 'Annotation added');
    }




    public function message() {
        return view('admin.messages.index');
    }

    public function license() {
        $licenses = License::orderBy('license_name', 'asc')->get();
        $packages = Package::orderBy('name', 'ASC')->get();
        $license_code = $this->generateLicenseCode(21);
        return view('admin.licenses.index', compact('licenses', 'packages', 'license_code'));
    }
    public function generateLicenseCode($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function storeLicense(Request $request) {
        $validated = $request->validate([
            'license_name' => 'required',
            'license_days' => 'required',
            'license_organisation' => 'required',
            'license_code' => 'required',
            'active_users' => 'required',
            // 'package_id' => 'required',
            'package' => 'required',
        ]);
        $input = $request->all();
        dd($input);
        License::create($input);
        return back()->with('success', 'License created');
    }
    public function updateLicense(Request $request) {
        $validated = $request->validate([
            'license_name' => 'required',
            'license_days' => 'required',
            'license_organisation' => 'required',
            'license_code' => 'required',
            'active_users' => 'required',
            // 'package_id' => 'required',
            'package' => 'required',
        ]);
        $input = [
          'license_name'=> $request->license_name,
          'license_days'=> $request->license_days,
          'license_organisation'=> $request->license_organisation,
          'license_code'=> $request->license_code,
          'active_users'=> $request->active_users,
          'package'=> $request->package,
          'package_id'=> $request->package_id,
        ];
        DB::table('licenses')->where('id', $request->license_id)->update($input);
        return back()->with('success', 'License updated');
    }
    public function deleteLicense($id) {
        $license = License::findOrFail($id);
        $license->delete();
        return back()->with('success', 'License deleted');
    }


    public function checkout($id) {
        $package = Package::where('id', $id)->first();
        return view('checkout', compact('package'));
    }
    public function checkoutDiscount($id) {
        $package = Package::where('id', $id)->first();
        $discount = Discount::where('package_id', $package->id)->first();
        $discounted_price = ($package->price * $discount->percentage) / 100;
        $new_price = $package->price - $discounted_price;
        return view('checkout.discount', compact('package', 'new_price'));

    }
}
