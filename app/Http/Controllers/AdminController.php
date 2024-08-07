<?php

namespace App\Http\Controllers;

use PDO;
use DateTime;
use Carbon\Carbon;
use App\Models\Like;
use App\Models\Role;
use App\Models\Rule;
use App\Models\Team;
use App\Models\User;
use Mailgun\Mailgun;
use App\Models\Coram;
use App\Models\Court;
use App\Models\Maxim;
use App\Models\State;
use App\Models\Holden;
use App\Models\Report;
use App\Models\Article;
use App\Models\Comment;
use App\Models\License;
use App\Models\Setting;
use App\Models\Message;
use App\Models\Package;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Resource;
use App\Models\UserTeam;
use Whoops\RunInterface;
use App\Models\AreaOfLaw;
use App\Models\ChMessage;
use App\Models\Judgement;
use App\Models\Principle;
use App\Models\SavedPost;
use App\Models\Annotation;
use App\Models\Dictionary;
use App\Models\PartyAType;
use App\Models\PartyBType;
use App\Models\MailMessage;
use App\Models\Transaction;
use App\Models\CommentReply;
use App\Models\LawOfFedPart;
use App\Models\RuleCategory;
use App\Models\SummaryRatio;
use Illuminate\Http\Request;
use App\Models\LawOfFedSched;
use App\Models\JudgementCoram;
use App\Models\RecentActivity;
use App\Models\FeaturedContent;
use App\Models\FormsPrecedence;
use App\Models\JudgementPartyA;
use App\Models\JudgementPartyB;
use App\Models\LawOfFederation;
use App\Models\LawOfFedSection;
use App\Jobs\SendBulkQueueEmail;
use App\Models\JudgementCounsel;
use App\Models\JudgementSummary;
use App\Notifications\NewReport;
use App\Notifications\MemberLeft;
use App\Notifications\NewMessage;
use App\Models\JudgementPrinciple;
use App\Models\SubjectMatterIndex;
use App\Notifications\TeamRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\LicensedUserSession;
use App\Notifications\MemberRemoval;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ExpiredPackage;
use App\Notifications\RequestApproved;
use App\Notifications\RequestDeclined;
use App\Notifications\FailedSubscriber;
use App\Notifications\LegalpediaReport;
use Illuminate\Support\Facades\Session;
use App\Notifications\LastRenewalNotice;
use App\Notifications\PendingSubscriber;
use App\Notifications\FirstRenewalNotice;
use App\Notifications\LicenseCredentials;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ActivatedSubscriber;
use App\Notifications\SecondRenewalNotice;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UpdatedLicenseCredentials;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Smalot\PdfParser\Parser;
// use NunoMaduro\Collision\Adapters\Phpunit\State;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware(['auth', 'subscribedUser', 'verified']);
    }

    /////////////////////////AI Assistant////////////////////////////////////////
    public function ask(Request $request){
        $question = $request->query('question');
        
    }

    private function uploadPdfToStorage($pdfFile)
    {
        $imageName = rand(10000,99999).time().'.'.$pdfFile->extension();  
        $path = Storage::disk('s3')->put('/', $pdfFile);
        $path = Storage::disk('s3')->url($path);

        return $path;
    }


    public function aiAssistant(Request $request)
    {
        if (Auth::user()->subscribedUser() && Auth::user()->canUseAi()){
            return view('admin.ai_assistant');
        }
        
        return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
    }

    public function aiAssistantSummary(Request $request)
    {

        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    // 'uploadedFile' => 'required|mimes:pdf',
                    'uploadedFile' => 'required|mimes:pdf|max:10000',
                ]
            );

            if ($validateUser->fails()) {
                return back()->withErrors($validateUser->errors()->first(),);
            }
            $pdfPath = $request->file('uploadedFile');
            $name_gen = time() . '.' . $pdfPath->getClientOriginalExtension();
            $data = $pdfPath->storeAs('pdfs', $name_gen, 'public');
            // dd($data);
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile('storage/' . $data);
            $text = $pdf->getText();
            if($request->type == 'judgement'){
                // $res = AiDocumentSummarizerController::summarize($text);
                $res = AiDocumentSummarizerController::summarizeText($text);
                
            }else if($request->type == 'lfn'){
                $res = AiDocumentSummarizerController::summarizeLFN($text);
            }else{
                $res = AiDocumentSummarizerController::summarizeAgreement($text);
            }   
            // dd($res);
            $summary = implode(' ', $res);
            $summary = nl2br($summary);
            $teams = Team::where('user_id', Auth::user()->id)->get();
            $result_title = 'AI Analysis Result';
            return view('admin.ai_assistant_result', compact('summary', 'teams', 'result_title'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function aiAssistantJudgementSummary(Request $request, $id)
    {
        try {
            $judgement_summary = JudgementSummary::find($id);
            $full_judgement = Judgement::where('suit_no', 'LIKE', '%' . $judgement_summary->suit_no . '%')->first();
            $text = 'Hello AI';
            if($full_judgement !== null){
                $text = $full_judgement->judgement;
            }
            $res = AiDocumentSummarizerController::summarize($text);
            // dd($res);
            $summary = implode(' ', $res);
            $summary = nl2br($summary);
            $teams = Team::where('user_id', Auth::user()->id)->get();
            $result_title = $judgement_summary->title;
            return view('admin.ai_assistant_result', compact('summary', 'teams','result_title'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }


    public function aiAssistantLawsOfFedSummary(Request $request, $id)
    {
        try {
            $text = '';
            $fed = LawOfFederation::findOrFail($id);
            $fed_part = LawOfFedPart::where('law_of_federation_id', $id)->orderBy('id', 'ASC')->get() ;
            $fed_sections = LawOfFedSection::where('law_of_federation_id', $id)->orderBy('id', 'ASC')->get() ;
            $fed_schedules = LawOfFedSched::where('law_of_federation_id', $id)->orderBy('id', 'ASC')->get() ;

            foreach($fed_sections as $fed_section){
                $text .= '\n ' . $fed_section->section_body;
            }

            foreach($fed_schedules as $fed_schedule){
                $text .= '\n ' . $fed_schedule->sched_body;
            }

            $res = AiDocumentSummarizerController::summarizeLFN($text);
            $summary = implode(' ', $res);
            $summary = nl2br($summary);
            $teams = Team::where('user_id', Auth::user()->id)->get();
            $result_title = $fed->title;
            return view('admin.ai_assistant_result', compact('summary', 'teams','result_title'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    ///////////////////////dashboard///////////////////////////////////////////////
    public function index(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $judgement_count = JudgementSummary::count();
        $fed_count = LawOfFederation::count();
        $rule_count = Rule::count();
        $form_count = FormsPrecedence::count();
        $article_count = Article::count();
        $dict_count = Dictionary::count();
        $maxim_count = Maxim::count();
        $resource_count = Resource::count();
        $team_count = Team::count();
        $pop_message = Message::where('type', 'in-app')->orderBy('created_at', 'DESC')->orderBy('created_at', 'DESC')->first();
        $latest_judgements = JudgementSummary::orderBy('judgement_date', 'DESC')->limit(5)->get();
        $notes = Annotation::where('user_id', Auth::user()->id)->where('resource_type', '!=', 'admin-note')->orderBy('created_at', 'DESC')->limit(5)->get();
        $admin_notes = Annotation::where('resource_type', 'admin-note')->orderBy('created_at', 'DESC')->limit(5)->get();
        $recent_activities = RecentActivity::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->limit(5)->get();
        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
        $new_chat_count = ChMessage::where('to_id', Auth::user()->id)->where('seen', 0)->count();
        $all_count = $judgement_count + $fed_count + $rule_count + $form_count + $article_count + $dict_count + $maxim_count + $resource_count;
        DB::statement("SET SQL_MODE=''");
        $featured_team = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('featured', 1)->first();
        $featured_user = FeaturedContent::where('type', 'user')->where('review_type', 'rating')->where('featured', 1)->first();
        $featured_article = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('featured', 1)->first();
        $featured_form = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('featured', 1)->first();
        $featured_note = FeaturedContent::where('type', 'note')->where('review_type', 'rating')->where('featured', 1)->first();
        return view('admin.dashboard', compact('judgement_count', 'fed_count', 'rule_count', 'form_count', 'article_count', 'dict_count', 'maxim_count', 'resource_count', 'all_count', 'team_count', 'latest_judgements', 'notes', 'admin_notes', 'recent_activities', 'teams', 'pop_message', 'new_chat_count', 'featured_user', 'featured_team', 'featured_article', 'featured_form', 'featured_note'));
    }


    //////////////////////////////////judgement//////////////////////////////////////
    public function judgement(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $courts = Court::orderBy('rank', 'ASC')->get();
            DB::statement("SET SQL_MODE=''");
            $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            $judgement_summary = JudgementSummary::query();
            if ($request->filled('id') && !$request->filled('year')) {
                $judge = $judgement_summary->where('court_id', $request->id);
                $judgement_count = $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                $selected_year = [];
                $selected_year['judgement_date'] = '';
                $selected_court = [];
                $selected_court['court_id'] = $request->id;
                return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
            }
            if (!$request->filled('id') && $request->filled('year')) {
                $judge = $judgement_summary->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                $selected_year = [];
                $selected_year['judgement_date'] = $request->year;
                $selected_court = [];
                $selected_court['court_id'] = '';
                return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
            }
            if ($request->filled('id') && $request->filled('year')) {
                $judge = $judgement_summary->where('court_id', $request->id)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                $selected_year = [];
                $selected_year['judgement_date'] = $request->year;
                $selected_court = [];
                $selected_court['court_id'] = $request->id;
                return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
            }
            if ($request->search_case) {
                $search = $request->search_case;
                $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->orderBy('judgement_date', 'DESC')
                    ->simplePaginate()
                    ->withQueryString();
                $selected_court = [];
                $selected_court['court_id'] = '';
                $selected_year = [];
                $selected_year['judgement_date'] = '';
                return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
            }
            $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
            $judgement_count = JudgementSummary::orderBy('judgement_date', 'DESC')->count();
            $selected_court = [];
            $selected_court['court_id'] = '';
            $selected_year = [];
            $selected_year['judgement_date'] = '';
            return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->judgement_feature) {
                    $courts = Package::where('id', Auth::user()->package_id)->first();
                    $years = Package::where('id', Auth::user()->package_id)->first();
                    $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                    $categories = Category::orderBy('category', 'asc')->get();
                    $judgement_summary = JudgementSummary::query();
                    if ($request->filled('id') && !$request->filled('year')) {
                        $judge = $judgement_summary->where('court_id', $request->id);
                        $judgement_count = $judge->count();
                        $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                        $selected_year = [];
                        $selected_year['judgement_date'] = '';
                        $selected_court = [];
                        $selected_court['court_id'] = $request->id;
                        return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
                    }
                    if (!$request->filled('id') && $request->filled('year')) {
                        $judge = $judgement_summary->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                        $judgement_count =  $judge->count();
                        $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                        $selected_year = [];
                        $selected_year['judgement_date'] = $request->year;
                        $selected_court = [];
                        $selected_court['court_id'] = '';
                        return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
                    }
                    if ($request->filled('id') && $request->filled('year')) {
                        $judge = $judgement_summary->where('court_id', $request->id)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                        $judgement_count =  $judge->count();
                        $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                        $selected_year = [];
                        $selected_year['judgement_date'] = $request->year;
                        $selected_court = [];
                        $selected_court['court_id'] = $request->id;
                        return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
                    }
                    if ($request->search_case) {
                        $search = $request->search_case;
                        $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                            ->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                        $judgement_count =  $judge->count();
                        $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                            ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                            ->orderBy('judgement_date', 'DESC')
                            ->simplePaginate()
                            ->withQueryString();
                        $selected_court = [];
                        $selected_court['court_id'] = '';
                        $selected_year = [];
                        $selected_year['judgement_date'] = '';
                        return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
                    }
                    $start_date = date('Y-m-d H:i:s', strtotime($years ? $years->judg_start_year . '-01-00 24:00:00' : ''));
                    $end_date = date('Y-m-d H:i:s', strtotime($years ? $years->judg_end_year . '-12-31 00:00:00' : ''));
                    $judgement_summaries = JudgementSummary::whereBetween('judgement_date', [$start_date, $end_date])->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                    $judgement_count = JudgementSummary::whereBetween('judgement_date', [$start_date, $end_date])->count();
                    $selected_court = [];
                    $selected_court['court_id'] = '';
                    $selected_year = [];
                    $selected_year['judgement_date'] = '';
                    // dd($judgement_summaries, 'web');
                    return view('admin.judgements.index', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
                }
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }

    public function sbjMatter(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $courts = Court::orderBy('court', 'ASC')->get();
            DB::statement("SET SQL_MODE=''");
            $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            $subject_matter_indices = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->get();
            $judgement_summary = JudgementSummary::query();
            if ($request->filled('subject_matter_index')) {
                $sbj = SubjectMatterIndex::where('subject_matter_index', $request->subject_matter_index)->first();
                $principle = Principle::where('subject_matter_index_id', $sbj->id)->first();
                $judg_principle = JudgementPrinciple::where('principle_id', $principle ? $principle->id : '')->first();
                $judge = $judgement_summary->where('suit_no', $judg_principle->suit_no);
                $judgement_count = $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                $selected_subject_matter = [];
                $selected_subject_matter['subject_matter_index'] = $request->subject_matter_index;
                return view('admin.judgements.subject-matter', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws', 'subject_matter_indices', 'selected_subject_matter'));
            }
            if ($request->search_case) {
                $search = $request->search_case;
                $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->orderBy('judgement_date', 'DESC')
                    ->simplePaginate()
                    ->withQueryString();
                $selected_subject_matter = [];
                $selected_subject_matter['subject_matter_index'] = '';
                return view('admin.judgements.subject-matter', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws', 'subject_matter_indices', 'selected_subject_matter'));
            }
            $count = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->get();
            $judgement_count = $count->count();
            $judgement_summaries = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->simplePaginate()->withQueryString();
            $selected_subject_matter = [];
            $selected_subject_matter['subject_matter_index'] = '';
            return view('admin.judgements.subject-matter', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws', 'subject_matter_indices', 'selected_subject_matter'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $courts = Package::where('id', Auth::user()->package_id)->first();
                $years = Package::where('id', Auth::user()->package_id)->first();
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                $categories = Category::orderBy('category', 'asc')->get();
                $subject_matter_indices = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->get();
                // dd($subject_matter_indices);
                $judgement_summary = JudgementSummary::query();
                if ($request->filled('subject_matter_index')) {
                    $sbj = SubjectMatterIndex::where('subject_matter_index', $request->subject_matter_index)->first();
                    $principle = Principle::where('subject_matter_index_id', $sbj->id)->first();
                    $judg_principle = JudgementPrinciple::where('principle_id', $principle ? $principle->id : '')->first();
                    $judge = $judgement_summary->where('suit_no', $judg_principle->suit_no);
                    $judgement_count = $judge->count();
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                    $selected_subject_matter = [];
                    $selected_subject_matter['subject_matter_index'] = $request->subject_matter_index;
                    return view('admin.judgements.subject-matter', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws', 'subject_matter_indices', 'selected_subject_matter'));
                }
                if ($request->search_case) {
                    $search = $request->search_case;
                    $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                    $judgement_count =  $judge->count();
                    $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                        ->orderBy('judgement_date', 'DESC')
                        ->simplePaginate()
                        ->withQueryString();
                    $selected_subject_matter = [];
                    $selected_subject_matter['subject_matter_index'] = '';
                    return view('admin.judgements.subject-matter', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws', 'subject_matter_indices', 'selected_subject_matter'));
                }
                $count = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->get();
                $judgement_count = $count->count();
                $judgement_summaries = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->simplePaginate()->withQueryString();
                $selected_subject_matter = [];
                $selected_subject_matter['subject_matter_index'] = '';
                //  dd($judgement_summaries, 'web');
                return view('admin.judgements.subject-matter', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws', 'subject_matter_indices', 'selected_subject_matter'));
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function legalCitation(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $courts = Court::orderBy('court', 'ASC')->get();
            DB::statement("SET SQL_MODE=''");
            $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            if ($request->search_case) {
                $search = $request->search_case;
                $judge = JudgementSummary::where('title', 'LIKE', '%' . $search . '%')->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = JudgementSummary::where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->orderBy('judgement_date', 'DESC')
                    ->simplePaginate()
                    ->withQueryString();
                return view('admin.judgements.legal-citation',  compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws'));
            }
            $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
            $judgement_count = JudgementSummary::orderBy('judgement_date', 'DESC')->count();
            return view('admin.judgements.legal-citation', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $courts = Package::where('id', Auth::user()->package_id)->first();
                $years = Package::where('id', Auth::user()->package_id)->first();
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                $categories = Category::orderBy('category', 'asc')->get();
                $start_date = date('Y-m-d H:i:s', strtotime($years ? $years->judg_start_year . '-01-00 24:00:00' : ''));
                $end_date = date('Y-m-d H:i:s', strtotime($years ? $years->judg_end_year . '-12-31 00:00:00' : ''));

                if ($request->search_case) {
                    $search = $request->search_case;
                    $judge = JudgementSummary::query()->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                        ->whereBetween('judgement_date', [$start_date, $end_date]);
                    $judgement_count =  $judge->count();
                    $judgement_summaries = JudgementSummary::query()->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                        ->whereBetween('judgement_date', [$start_date, $end_date])
                        ->orderBy('judgement_date', 'DESC')
                        ->simplePaginate()
                        ->withQueryString();
                    return view('admin.judgements.legal-citation',  compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws'));
                }
                $judgement_summaries = JudgementSummary::whereBetween('judgement_date', [$start_date, $end_date])->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                $judgement_count = JudgementSummary::whereBetween('judgement_date', [$start_date, $end_date])->count();
                return view('admin.judgements.legal-citation', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'area_of_laws'));
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function noSummary(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {

            $courts = Court::orderBy('rank', 'ASC')->get();
            DB::statement("SET SQL_MODE=''");
            $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            $judgement_summary = JudgementSummary::query();
            if ($request->filled('id') && !$request->filled('year')) {
                $judge = $judgement_summary->where('summary_of_facts', NULL)->where('court_id', $request->id);
                $judgement_count = $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                $selected_year = [];
                $selected_year['judgement_date'] = '';
                $selected_court = [];
                $selected_court['court_id'] = $request->id;
                return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
            }
            if (!$request->filled('id') && $request->filled('year')) {
                $judge = $judgement_summary->where('summary_of_facts', NULL)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                $selected_year = [];
                $selected_year['judgement_date'] = $request->year;
                $selected_court = [];
                $selected_court['court_id'] = '';
                return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
            }
            if ($request->filled('id') && $request->filled('year')) {
                $judge = $judgement_summary->where('summary_of_facts', NULL)->where('court_id', $request->id)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
                $selected_year = [];
                $selected_year['judgement_date'] = $request->year;
                $selected_court = [];
                $selected_court['court_id'] = $request->id;
                return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
            }
            if ($request->search_case) {
                $search = $request->search_case;
                $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->where('summary_of_facts', NULL);
                $judgement_count =  $judge->count();
                $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->where('summary_of_facts', NULL)
                    ->orderBy('judgement_date', 'DESC')
                    ->simplePaginate()
                    ->withQueryString();
                $selected_court = [];
                $selected_court['court_id'] = '';
                $selected_year = [];
                $selected_year['judgement_date'] = '';
                return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
            }
            $judgement_summaries = JudgementSummary::where('summary_of_facts', NULL)->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
            $judgement_count = JudgementSummary::where('summary_of_facts', NULL)->count();
            $selected_court = [];
            $selected_court['court_id'] = '';
            $selected_year = [];
            $selected_year['judgement_date'] = '';
            return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
        }
        return redirect('admin/judgements');
    }
    public function create()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $courts = Court::orderBy('court', 'ASC')->get();
            $categories = Category::orderBy('category', 'ASC')->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->get();
            $subject_matters = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->get();
            $party_a_types = PartyAType::orderBy('party_a_type', 'ASC')->get();
            $party_b_types = PartyBType::orderBy('party_b_type', 'ASC')->get();
            return view('admin.judgements.create', compact('courts', 'categories', 'area_of_laws', 'subject_matters', 'party_a_types', 'party_b_types'));
        }
        return redirect('admin/judgements');
    }
    public function storeJudgement(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        // DB::beginTransaction();

        $validated = $request->validate([
            'title' => 'required',
            // 'summary_of_facts'=>'required',
            'suit_no' => 'required',
            // 'held'=>'required',
            'lp_citation' => 'required',
            // 'issues'=>'required',
            // 'cases_cited'=>'required',
            // 'statutes_cited'=>'required',
            // 'judgement_date'=>'required',
            // 'other_citations'=>'required',
            // 'holden_at_id'=>'required',
            'court_id' => 'required',
            // 'party_a_type_id'=>'required',
            // 'party_b_type_id'=>'required',
            // 'category'=>'required',
            // 'area_of_law'=>'required',
        ]);

        if (JudgementSummary::where('suit_no', 'LIKE', '%' . $request->suit_no . '%')->first()) {
            return back()->withErrors('A judgement with this suit no already exists');
        }

        $holden_input = [
            'holden_at' => $request->holden_at,
        ];
        $holden = Holden::create($holden_input);

        $judg_input = [
            'title' => $request->title,
            'summary_of_facts' => $request->summary_of_facts,
            'suit_no' => $request->suit_no,
            'held' => $request->held,
            'lp_citation' => $request->lp_citation,
            'issues' => $request->issues,
            'cases_cited' => $request->cases_cited,
            'statutes_cited' => $request->statutes_cited,
            'judgement_date' => Carbon::parse($request->judgement_date),
            'other_citations' => $request->other_citations,
            'holden_at_id' => $holden->id,
            'court_id' => $request->court_id,
            'party_a_type_id' => $request->party_a_type,
            'party_b_type_id' => $request->party_b_type,
            'category' => $request->category,
            'area_of_law' => $request->area_of_law
        ];
        $judg = JudgementSummary::create($judg_input);

        if ($request->subject) {
            foreach ($request->subject as $subject_input) {
                $principle_input = [
                    'subject_matter_index_id' => $subject_input[0],
                    'principle' => $subject_input[1]
                ];
                $principle = Principle::create($principle_input);

                $judg_principle_input = [
                    'principle_id' => $principle->id,
                    'suit_no' => $judg->suit_no,
                ];
                JudgementPrinciple::create($judg_principle_input);
            }
        }

        if ($request->coram) {
            foreach ($request->coram as $coram_input) {
                $coram_data = [
                    'name' => $coram_input[0]
                ];
                $coram = Coram::create($coram_data);

                $judg_coram_data = [
                    'coram_id' => $coram->id,
                    'suit_no' => $judg->suit_no,
                ];
                JudgementCoram::create($judg_coram_data);
            }
        }
        // dd($request->party_a_names);
        $party_a_input = [
            'party_a_names' => $request->party_a_names,
            'suit_no' => $judg->suit_no
        ];
        JudgementPartyA::create($party_a_input);
        $party_b_input = [
            'party_b_names' => $request->party_b_names,
            'suit_no' => $judg->suit_no
        ];
        JudgementPartyB::create($party_b_input);

        $judg_counsel_input = [
            'counsels' => $request->counsels,
            'suit_no' => $judg->suit_no
        ];
        JudgementCounsel::create($judg_counsel_input);

        if ($request->ratio) {
            foreach ($request->ratio as $ratio_input) {
                $ratio_data = [
                    'heading' => $ratio_input[0],
                    'body' => $ratio_input[1],
                    'suit_no' => $judg->suit_no
                ];
                SummaryRatio::create($ratio_data);
            }
        }

        $full_judg = [
            'judgement' => $request->judgement,
            'suit_no' => $judg->suit_no
        ];
        Judgement::create($full_judg);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        // DB::commit();
        return back()->with('success', 'Judgement added');
    }
    public function updateJudgement(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $judg = JudgementSummary::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            // 'summary_of_facts'=>'required',
            'suit_no' => 'required',
            // 'held'=>'required',
            'lp_citation' => 'required',
            // 'issues'=>'required',
            // 'cases_cited'=>'required',
            // 'statutes_cited'=>'required',
            // 'judgement_date'=>'required',
            // 'other_citations'=>'required',
            // 'holden_at_id'=>'required',
            'court_id' => 'required',
            // 'party_a_type_id'=>'required',
            // 'party_b_type_id'=>'required',
            // 'category'=>'required',
            // 'area_of_law'=>'required',
        ]);

        $holden_input = [
            'holden_at' => $request->holden_at,
        ];
        DB::table('holdens')->where('id', $judg->holden_at_id)->update($holden_input);

        $judg_input = [
            'title' => $request->title,
            'summary_of_facts' => $request->summary_of_facts,
            'suit_no' => $request->suit_no,
            'held' => $request->held,
            'lp_citation' => $request->lp_citation,
            'issues' => $request->issues,
            'cases_cited' => $request->cases_cited,
            'statutes_cited' => $request->statutes_cited,
            'judgement_date' => Carbon::parse($request->judgement_date),
            'other_citations' => $request->other_citations,
            'holden_at_id' => $judg->holden_at_id,
            'court_id' => $request->court_id,
            'party_a_type_id' => $request->party_a_type,
            'party_b_type_id' => $request->party_b_type,
            'category' => $request->category,
            'area_of_law' => $request->area_of_law
        ];
        $judg->update($judg_input);

        if ($request->subject) {
            foreach ($request->subject as $key => $subject_input) {
                $principle_input = [
                    'subject_matter_index_id' => $subject_input[0],
                    'principle' => $subject_input[1]
                ];
                DB::table('principles')->where('id', $key)->update($principle_input);

                $judg_principle_input = [
                    'principle_id' => $request->principle_id,
                    'suit_no' => $judg->suit_no,
                ];
                DB::table('judgement_principles')->where('id', $request->judg_principle_id)->update($judg_principle_input);

                if ($request->has('remove_principle')) {
                    $judg_principle = JudgementPrinciple::where('id', $request->judg_principle_id);
                    $judg_principle->delete();
                    $principle = Principle::where('id', $request->principle_id);
                    $principle->delete();
                    return back()->with('success', 'Principle removed');
                }
            }
        }

        if ($request->new_subject) {
            foreach ($request->new_subject as $subject_input) {
                $principle_input = [
                    'subject_matter_index_id' => $subject_input[0],
                    'principle' => $subject_input[1]
                ];
                $principle = Principle::create($principle_input);

                $judg_principle_input = [
                    'principle_id' => $principle->id,
                    'suit_no' => $judg->suit_no,
                ];
                JudgementPrinciple::create($judg_principle_input);
            }
        }



        if ($request->coram) {
            foreach ($request->coram as $key => $coram_input) {
                $coram_data = [
                    'name' => $coram_input[1]
                ];
                DB::table('corams')->where('id', $key)->update($coram_data);

                $judg_coram_data = [
                    'coram_id' => $key,
                    'suit_no' => $judg->suit_no,
                ];
                DB::table('judgement_corams')->where('id', $coram_input[1])->update($judg_coram_data);

                if ($request->has('remove_coram')) {
                    $judg_coram = JudgementCoram::where('id', $request->judg_coram_id);
                    $judg_coram->delete();
                    $coram = Coram::where('id', $request->main_coram_id);
                    $coram->delete();
                    return back()->with('success', 'Coram removed');
                }
            }
        }


        if ($request->new_coram) {
            foreach ($request->new_coram as $coram_input) {
                $coram_data = [
                    'name' => $coram_input[0]
                ];
                $coram = Coram::create($coram_data);

                $judg_coram_data = [
                    'coram_id' => $coram->id,
                    'suit_no' => $judg->suit_no,
                ];
                JudgementCoram::create($judg_coram_data);
            }
        }

        // dd($request->party_a_names);

        $party_a_input = [
            'party_a_names' => $request->party_a_names,
            'suit_no' => $judg->suit_no
        ];
        if ($request->party_a_name_id == null) {
            JudgementPartyA::create($party_a_input);
        } else {
            DB::table('judgement_party_a_s')->where('id', $request->party_a_name_id)->update($party_a_input);
        }

        $party_b_input = [
            'party_b_names' => $request->party_b_names,
            'suit_no' => $judg->suit_no
        ];
        if ($request->party_b_name_id == null) {
            JudgementPartyB::create($party_b_input);
        } else {
            DB::table('judgement_party_b_s')->where('id', $request->party_b_name_id)->update($party_b_input);
        }

        $judg_counsel_input = [
            'counsels' => $request->counsels,
            'suit_no' => $judg->suit_no
        ];
        if ($request->counsel_id == null) {
            JudgementCounsel::create($judg_counsel_input);
        } else {
            DB::table('judgement_counsels')->where('id', $request->counsel_id)->update($judg_counsel_input);
        }

        // dd($request->ratio);
        if ($request->ratio) {
            foreach ($request->ratio as $key => $ratio_input) {
                $ratio_data = [
                    'heading' => $ratio_input[0],
                    'body' => $ratio_input[1],
                    'suit_no' => $judg->suit_no
                ];
                DB::table('summary_ratios')->where('id', $key)->update($ratio_data);

                if ($request->has('remove_ratio')) {
                    $ratio = SummaryRatio::where('id', $request->ratio_id);
                    $ratio->delete();
                    return back()->with('success', 'Ratio removed');
                }
            }
        }

        if ($request->new_ratio) {
            foreach ($request->new_ratio as $ratio_input) {
                $ratio_data = [
                    'heading' => $ratio_input[0],
                    'body' => $ratio_input[1],
                    'suit_no' => $judg->suit_no
                ];
                SummaryRatio::create($ratio_data);
            }
        }

        // dd($request->judgement_id);

        $full_judg = [
            'judgement' => $request->judgement,
            'suit_no' => $judg->suit_no
        ];
        if ($request->judgement_id == null) {
            Judgement::create($full_judg);
        } else {
            DB::table('judgements')->where('id', $request->judgement_id)->update($full_judg);
        }

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Judgement updated');
    }
    public function editJudgement($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $judgement_summary = JudgementSummary::findOrFail($id);
            $courts = Court::orderBy('rank', 'ASC')->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->get();
            $categories = Category::orderBy('category', 'ASC')->get();
            $subject_matters = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->get();
            $party_a_types = PartyAType::orderBy('party_a_type', 'ASC')->get();
            $party_b_types = PartyBType::orderBy('party_b_type', 'ASC')->get();
            return view('admin.judgements.edit', compact('judgement_summary', 'courts', 'area_of_laws', 'categories', 'subject_matters', 'party_a_types', 'party_b_types'));
        }
        return redirect('admin/judgements');
    }
    public function showJudgement($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $judgement_summary = JudgementSummary::findOrFail($id);
            $notes = Annotation::where('user_id', Auth::user()->id)->where('content_id', 'LIKE', '%' . trim($judgement_summary->suit_no) . '%')->get();
            $admin_notes = Annotation::where('resource_type', 'admin-note')->orderBy('created_at', 'DESC')->limit(5)->get();
            $courts = Court::orderBy('rank', 'ASC')->get();
            DB::statement("SET SQL_MODE=''");
            $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
            $judgement_coram = JudgementCoram::select('suit_no')->first();
            // dd($judgement_coram);
            $corams = Coram::orderBy('name', 'DESC')->limit(5)->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->get();
            // dd($corams);
            $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();

            return view('admin.judgements.show', compact('judgement_summary', 'courts', 'years', 'corams', 'judgement_coram', 'area_of_laws', 'notes', 'admin_notes', 'teams'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $judgement_summary = JudgementSummary::findOrFail($id);
                $courts = Court::orderBy('rank', 'ASC')->get();
                DB::statement("SET SQL_MODE=''");
                $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
                $judgement_coram = JudgementCoram::select('suit_no')->first();
                // dd($judgement_coram);
                $corams = Coram::orderBy('name', 'DESC')->limit(5)->get();
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->get();
                $admin_notes = Annotation::where('resource_type', 'admin-note')->orderBy('created_at', 'DESC')->limit(5)->get();
                // dd($corams);
                $notes = Annotation::where('user_id', Auth::user()->id)->where('content_id', 'LIKE', '%' . trim($judgement_summary->suit_no) . '%')->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();

                return view('admin.judgements.show', compact('judgement_summary', 'courts', 'years', 'corams', 'judgement_coram', 'area_of_laws', 'notes', 'admin_notes', 'teams'));
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function deleteJudgement($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $judgement_summary = JudgementSummary::findOrFail($id);
        $judgement_summary->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Judgement Deleted');
    }



    ////////////////////////////////////courts///////////////////////////////////////
    public function court()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $courts = Court::orderBy('rank', 'ASC')->get();
            $court_count = Court::count();
            return view('admin.judgements.courts', compact('courts', 'court_count'));
        }
        return redirect('admin/judgements');
    }
    public function storeCourt(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'court' => 'required',
            'rank' => 'required',
        ]);
        if (Court::where('rank', $request->rank)->first()) {
            return back()->withErrors('Court rank already exists, choose another rank');
        }
        $input = $request->all();
        Court::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Court added');
    }
    public function updateCourt(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'court' => 'required',
            'rank' => 'required',
        ]);
        if (Court::where('rank', $request->rank)->first()) {
            return back()->withErrors('Court rank already exists, choose another rank');
        }
        $input = [
            'court' => $request->court,
            'rank' => $request->rank,
        ];
        DB::table('courts')->where('id', $request->court_id)->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Court updated');
    }
    public function deleteCourt($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $court = Court::findOrFail($id);
        $court->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Court deleted');
    }



    /////////////////////subject matter index///////////////////////////////////////
    public function getSbj()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $subject_matter_indices = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->get();
            $subject_count = SubjectMatterIndex::count();
            return view('admin.judgements.subject-matter-index', compact('subject_matter_indices', 'subject_count'));
        }
        return redirect('admin/judgements');
    }
    public function storeSbj(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'subject_matter_index' => 'required',
        ]);
        $input = $request->all();
        SubjectMatterIndex::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Subject Matter Index added');
    }
    public function updateSbj(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'subject_matter_index' => 'required',
        ]);
        $input = [
            'subject_matter_index' => $request->subject_matter_index,
        ];
        DB::table('subject_matter_indices')->where('id', $request->subject_id)->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Subject Matter Index updated');
    }
    public function deleteSbj($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $subject_matter_index = SubjectMatterIndex::findOrFail($id);
        $subject_matter_index->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Subject Matter Index deleted');
    }



    /////////////////////////////rule categories//////////////////////////////////////////
    public function ruleCat()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            $rule_category_count = RuleCategory::count();
            return view('admin.rules-of-court.categories', compact('rule_categories', 'rule_category_count'));
        }
        return redirect('admin/rules-of-court');
    }
    public function storeRuleCat(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'name' => 'required'
        ]);
        $input = $request->all();
        RuleCategory::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Rule Category added');
    }
    public function updateRuleCat(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'name' => 'required',
        ]);
        $input = [
            'name' => $request->name,
        ];
        DB::table('rule_categories')->where('id', $request->rule_cat_id)->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Rule Category updated');
    }
    public function deleteRuleCat($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $rule_category = RuleCategory::findOrFail($id);
        $rule_category->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Rule Category deleted');
    }


    ////////////////////////rule of court/////////////////////////////////////////////////
    public function rules(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            if ($request->has('fetch_rule')) {
                $orders = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'ORDERS')->orderBy('title', 'ASC')->get();
                $appendices = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->get();
                $schedules = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->get();
                $forms = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'FORMS')->orderBy('title', 'ASC')->get();
                $civil_forms = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->get();
                $probate_forms = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->get();
                $parts = Rule::where(function ($query) use ($request) {
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
            } else {
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
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->roc_feature) {
                    // $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
                    $rule_categories = Package::where('id', Auth::user()->package_id)->first();
                    if ($request->has('fetch_rule')) {
                        $orders = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'ORDERS')->orderBy('title', 'ASC')->get();
                        $appendices = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->get();
                        $schedules = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->get();
                        $forms = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'FORMS')->orderBy('title', 'ASC')->get();
                        $civil_forms = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->get();
                        $probate_forms = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->get();
                        $parts = Rule::where(function ($query) use ($request) {
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
                    } else {
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
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function showRule($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            if (Rule::where('section', 'ORDERS')->first()) {
                $order = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $order->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.rules-of-court.show', compact('order', 'notes', 'teams'));
            } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                $schedule = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $schedule->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.rules-of-court.show', compact('schedule', 'notes', 'teams'));
            } elseif (Rule::where('section', 'APPENDIX')->first()) {
                $appendix = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $appendix->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.rules-of-court.show', compact('appendix', 'notes', 'teams'));
            } elseif (Rule::where('section', 'FORMS')->first()) {
                $form = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.rules-of-court.show', compact('form', 'notes', 'teams'));
            } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                $civil_form = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $civil_form->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.rules-of-court.show', compact('civil_form', 'notes', 'teams'));
            } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                $probate_form = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $probate_form->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.rules-of-court.show', compact('probate_form', 'notes', 'teams'));
            } elseif (Rule::where('section', 'PARTS')->first()) {
                $part = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $part->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.rules-of-court.show', compact('part', 'notes', 'teams'));
            }
        } else {
            if (Auth::user()->subscribedUser()) {
                if (Rule::where('section', 'ORDERS')->first()) {
                    $order = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $order->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.rules-of-court.show', compact('order', 'notes', 'teams'));
                } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                    $schedule = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $schedule->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.rules-of-court.show', compact('schedule', 'notes', 'teams'));
                } elseif (Rule::where('section', 'APPENDIX')->first()) {
                    $appendix = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $appendix->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.rules-of-court.show', compact('appendix', 'notes', 'teams'));
                } elseif (Rule::where('section', 'FORMS')->first()) {
                    $form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.rules-of-court.show', compact('form', 'notes', 'teams'));
                } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                    $civil_form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $civil_form->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.rules-of-court.show', compact('civil_form', 'notes', 'teams'));
                } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                    $probate_form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $probate_form->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.rules-of-court.show', compact('probate_form', 'notes', 'teams'));
                } elseif (Rule::where('section', 'PARTS')->first()) {
                    $part = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $part->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.rules-of-court.show', compact('part', 'notes', 'teams'));
                }
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function fetchRuleAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $rule = Rule::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $rule->id)->where('resource_type', 'rule')->get();
        return response()->json([
            'anotes' => $anotes,
        ]);
    }
    public function storeRule(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

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

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Rule of court added');
    }
    public function editRule($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            if (Rule::where('section', 'ORDERS')->first()) {
                $order = Rule::findOrFail($id);
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
                return view('admin.rules-of-court.edit', compact('order', 'rule_categories'));
            } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                $schedule = Rule::findOrFail($id);
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
                return view('admin.rules-of-court.edit', compact('schedule', 'rule_categories'));
            } elseif (Rule::where('section', 'APPENDIX')->first()) {
                $appendix = Rule::findOrFail($id);
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
                return view('admin.rules-of-court.edit', compact('appendix', 'rule_categories'));
            } elseif (Rule::where('section', 'FORMS')->first()) {
                $form = Rule::findOrFail($id);
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
                return view('admin.rules-of-court.edit', compact('form', 'rule_categories'));
            } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                $civil_form = Rule::findOrFail($id);
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
                return view('admin.rules-of-court.edit', compact('civil_form', 'rule_categories'));
            } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                $probate_form = Rule::findOrFail($id);
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
                return view('admin.rules-of-court.edit', compact('probate_form', 'rule_categories'));
            } elseif (Rule::where('section', 'PARTS')->first()) {
                $part = Rule::findOrFail($id);
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
                return view('admin.rules-of-court.edit', compact('part', 'rule_categories'));
            }
        }
        return redirect('admin/rules-of-court');
    }
    public function updateRule(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'PARTS')->first()) {
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
        if ($order) {
            $order->update($input);
        } elseif ($schedule) {
            $schedule->update($input);
        } elseif ($part) {
            $part->update($input);
        } elseif ($form) {
            $form->update($input);
        } elseif ($appendix) {
            $appendix->update($input);
        } elseif ($probate_form) {
            $probate_form->update($input);
        } elseif ($civil_form) {
            $civil_form->update($input);
        }

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Rule of court updated');
    }
    public function deleteRule($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
            $order->delete();
        } elseif (Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
            $schedule->delete();
        } elseif (Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
            $appendix->delete();
        } elseif (Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
            $form->delete();
        } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
            $civil_form->delete();
        } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
            $probate_form->delete();
        } elseif (Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
            $part->delete();
        }

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Rule deleted');
    }



    ///////////////////////////state rule of court////////////////////////////////////////
    public function state_rules(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $states = State::orderBy('name', 'ASC')->get();
            if ($request->has('fetch_rule')) {
                $orders = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'ORDERS')->orderBy('title', 'ASC')->get();
                $appendices = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->get();
                $schedules = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->get();
                $forms = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'FORMS')->orderBy('title', 'ASC')->get();
                $civil_forms = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->get();
                $probate_forms = Rule::where(function ($query) use ($request) {
                    return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->get();
                $parts = Rule::where(function ($query) use ($request) {
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
            } else {
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
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->sroc_feature) {
                    // $states = State::orderBy('name', 'ASC')->get();
                    $states = Package::where('id', Auth::user()->package_id)->first();
                    if ($request->has('fetch_rule')) {
                        $orders = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'ORDERS')->orderBy('title', 'ASC')->get();
                        $appendices = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->get();
                        $schedules = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->get();
                        $forms = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'FORMS')->orderBy('title', 'ASC')->get();
                        $civil_forms = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->get();
                        $probate_forms = Rule::where(function ($query) use ($request) {
                            return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                        })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->get();
                        $parts = Rule::where(function ($query) use ($request) {
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
                    } else {
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
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function showStateRule($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            if (Rule::where('section', 'ORDERS')->first()) {
                $order = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $order->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.state-rules-of-court.show', compact('order', 'notes', 'teams'));
            } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                $schedule = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $schedule->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.state-rules-of-court.show', compact('schedule', 'notes', 'teams'));
            } elseif (Rule::where('section', 'APPENDIX')->first()) {
                $appendix = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $appendix->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.state-rules-of-court.show', compact('appendix', 'notes', 'teams'));
            } elseif (Rule::where('section', 'FORMS')->first()) {
                $form = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.state-rules-of-court.show', compact('form', 'notes', 'teams'));
            } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                $civil_form = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $civil_form->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.state-rules-of-court.show', compact('civil_form', 'notes', 'teams'));
            } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                $probate_form = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $probate_form->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.state-rules-of-court.show', compact('probate_form', 'notes', 'teams'));
            } elseif (Rule::where('section', 'PARTS')->first()) {
                $part = Rule::findOrFail($id);
                $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $part->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.state-rules-of-court.show', compact('part', 'notes', 'teams'));
            }
        } else {
            if (Auth::user()->subscribedUser()) {
                if (Rule::where('section', 'ORDERS')->first()) {
                    $order = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $order->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.state-rules-of-court.show', compact('order', 'notes', 'teams'));
                } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                    $schedule = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $schedule->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.state-rules-of-court.show', compact('schedule', 'notes', 'teams'));
                } elseif (Rule::where('section', 'APPENDIX')->first()) {
                    $appendix = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $appendix->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.state-rules-of-court.show', compact('appendix', 'notes', 'teams'));
                } elseif (Rule::where('section', 'FORMS')->first()) {
                    $form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.state-rules-of-court.show', compact('form', 'notes', 'teams'));
                } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                    $civil_form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $civil_form->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.state-rules-of-court.show', compact('civil_form', 'notes', 'teams'));
                } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                    $probate_form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $probate_form->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.state-rules-of-court.show', compact('probate_form', 'notes', 'teams'));
                } elseif (Rule::where('section', 'PARTS')->first()) {
                    $part = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $part->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return view('admin.state-rules-of-court.show', compact('part', 'notes', 'teams'));
                }
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function fetchStateRuleAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $state_rule = Rule::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $state_rule->id)->where('resource_type', 'state-rule')->get();
        return response()->json([
            'anotes' => $anotes,
        ]);
    }
    public function storeStateRule(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

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

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'State Rule of court added');
    }
    public function editStateRule($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            if (Rule::where('section', 'ORDERS')->first()) {
                $order = Rule::findOrFail($id);
                $states = State::orderBy('name', 'ASC')->get();
                return view('admin.state-rules-of-court.edit', compact('order', 'states'));
            } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                $schedule = Rule::findOrFail($id);
                $states = State::orderBy('name', 'ASC')->get();
                return view('admin.state-rules-of-court.edit', compact('schedule', 'states'));
            } elseif (Rule::where('section', 'APPENDIX')->first()) {
                $appendix = Rule::findOrFail($id);
                $states = State::orderBy('name', 'ASC')->get();
                return view('admin.state-rules-of-court.edit', compact('appendix', 'states'));
            } elseif (Rule::where('section', 'FORMS')->first()) {
                $form = Rule::findOrFail($id);
                $states = State::orderBy('name', 'ASC')->get();
                return view('admin.state-rules-of-court.edit', compact('form', 'states'));
            } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                $civil_form = Rule::findOrFail($id);
                $states = State::orderBy('name', 'ASC')->get();
                return view('admin.state-rules-of-court.edit', compact('civil_form', 'states'));
            } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                $probate_form = Rule::findOrFail($id);
                $states = State::orderBy('name', 'ASC')->get();
                return view('admin.state-rules-of-court.edit', compact('probate_form', 'states'));
            } elseif (Rule::where('section', 'PARTS')->first()) {
                $part = Rule::findOrFail($id);
                $states = State::orderBy('name', 'ASC')->get();
                return view('admin.state-rules-of-court.edit', compact('part', 'states'));
            }
        }
        return redirect('admin/state-rules-of-court');
    }
    public function updateStateRule(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
        } elseif (Rule::where('section', 'PARTS')->first()) {
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
        if ($order) {
            $order->update($input);
        } elseif ($schedule) {
            $schedule->update($input);
        } elseif ($part) {
            $part->update($input);
        } elseif ($form) {
            $form->update($input);
        } elseif ($appendix) {
            $appendix->update($input);
        } elseif ($probate_form) {
            $probate_form->update($input);
        } elseif ($civil_form) {
            $civil_form->update($input);
        }

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'State Rule of court updated');
    }
    public function deleteStateRule($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Rule::where('section', 'ORDERS')->first()) {
            $order = Rule::findOrFail($id);
            $order->delete();
        } elseif (Rule::where('section', 'SCHEDULES')->first()) {
            $schedule = Rule::findOrFail($id);
            $schedule->delete();
        } elseif (Rule::where('section', 'APPENDIX')->first()) {
            $appendix = Rule::findOrFail($id);
            $appendix->delete();
        } elseif (Rule::where('section', 'FORMS')->first()) {
            $form = Rule::findOrFail($id);
            $form->delete();
        } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
            $civil_form = Rule::findOrFail($id);
            $civil_form->delete();
        } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
            $probate_form = Rule::findOrFail($id);
            $probate_form->delete();
        } elseif (Rule::where('section', 'PARTS')->first()) {
            $part = Rule::findOrFail($id);
            $part->delete();
        }

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'State rule deleted');
    }



    ////////////////////////////laws of federation/////////////////////////////////////////
    public function fed(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            if ($request->has('fetch_fed')) {
                $fed = LawOfFederation::query();
                if ($request->filled('category')) {
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
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->lfn_feature) {
                    $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                    // $categories = Category::orderBy('category', 'asc')->get();
                    $categories = Package::where('id', Auth::user()->package_id)->first();
                    // dd($categories->lfn_cat);
                    if ($request->has('fetch_fed')) {
                        $fed = LawOfFederation::query();
                        if ($request->filled('category')) {
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
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function storeFed(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'title' => 'required',
            // 'area_of_law' => 'required',
            'description' => 'required',
            // 'category' => 'required',
            'law_no' => 'required',
            // 'law_date' => 'required',
            // 'subsidiary_legislation' => 'required',
            // 'part_header' => 'required',
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

        // dd($request->part_header);

        if ($request->part_header) {
            foreach ($request->part_header as $part_header) {
                $fed_part_input = [
                    'part_header' => $part_header[0],
                    'law_of_federation_id' => $fed->id
                ];
                $fed_part = LawOfFedPart::create($fed_part_input);
                foreach ($part_header[10] as $section_input) {
                    $data = [
                        'section_header' => $section_input[0],
                        'section_body' => $section_input[1],
                        'law_of_federation_id' => $fed->id,
                        'law_of_fed_part_id' => $fed_part->id,
                    ];
                    LawOfFedSection::create($data);
                }
            }
        }

        if ($request->sched) {
            foreach ($request->sched as $sched_input) {
                $data = [
                    'sched_header' => $sched_input[0],
                    'sched_body' => $sched_input[1],
                    'law_of_federation_id' => $fed->id,
                ];
                LawOfFedSched::create($data);
            }
        }

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Law added');
    }
    public function editFed($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $fed = LawOfFederation::findOrFail($id);
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            // $fed_part = LawOfFedPart::where('law_of_federation_id', $fed->id)->first();
            $fed_parts = LawOfFedPart::where('law_of_federation_id', $fed->id)->get();
            // $fed_sections = LawOfFedSection::where('law_of_federation_id', $fed->id)->get();
            $fed_section_count = LawOfFedSection::where('law_of_federation_id', $fed->id)->count();
            $fed_scheds = LawOfFedSched::where('law_of_federation_id', $fed->id)->get();
            $fed_sched_count = LawOfFedSched::where('law_of_federation_id', $fed->id)->count();
            return view('admin.laws-of-federation.edit', compact('fed', 'area_of_laws', 'categories', 'fed_parts', 'fed_section_count', 'fed_scheds', 'fed_sched_count'));
        }
        return redirect('admin/laws-of-federation');
    }
    public function showFed($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $fed = LawOfFederation::findOrFail($id);
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            $notes = Annotation::where('resource_type', 'fed')->where('user_id', Auth::user()->id)->where('content_id', $fed->id)->get();
            $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
            return view('admin.laws-of-federation.show', compact('fed', 'area_of_laws', 'categories', 'notes', 'teams'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $fed = LawOfFederation::findOrFail($id);
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                $categories = Category::orderBy('category', 'asc')->get();
                $notes = Annotation::where('resource_type', 'fed')->where('user_id', Auth::user()->id)->where('content_id', $fed->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return view('admin.laws-of-federation.show', compact('fed', 'area_of_laws', 'categories', 'notes', 'teams'));
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function fetchLawAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $fed = LawOfFederation::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $fed->id)->where('resource_type', 'fed')->get();
        return response()->json([
            'anotes' => $anotes,
        ]);
    }
    public function updateFed(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $fed = LawOfFederation::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            // 'area_of_law' => 'required',
            'description' => 'required',
            // 'category' => 'required',
            'law_no' => 'required',
            // 'law_date' => 'required',
            // 'subsidiary_legislation' => 'required',
            // 'part_header' => 'required',
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

        // dd($request->section_part_header);


        if ($request->part_header) {
            foreach ($request->part_header as $key => $part_header) {
                $fed_part_input = [
                    'part_header' => $part_header[0],
                    'law_of_federation_id' => $fed->id
                ];
                DB::table('law_of_fed_parts')->where('id', $key)->update($fed_part_input);
                $fed_part = LawOfFedPart::where('id', $key)->first();
                foreach ($part_header[10] as $section_key => $section_input) {
                    $data = [
                        'section_header' => $section_input[0],
                        'section_body' => $section_input[1],
                        'law_of_federation_id' => $fed->id,
                        'law_of_fed_part_id' => $fed_part->id,
                    ];
                    DB::table('law_of_fed_sections')->where('id', $section_key)->update($data);
                }
            }
        }

        //// saving a new section in a part
        if ($request->section_part_header) {
            $fed_part = LawOfFedPart::where('id', $request->fed_section_part_id)->first();
            foreach ($request->section_part_header[$fed_part->id][10] as $key => $section_input) {
                $data = [
                    'section_header' => $section_input[0],
                    'section_body' => $section_input[1],
                    'law_of_federation_id' => $fed->id,
                    'law_of_fed_part_id' => $fed_part->id,
                ];
                LawOfFedSection::create($data);
            }
        }


        // saving a new part and new section
        if ($request->new_part_header) {
            foreach ($request->new_part_header as $part_header) {
                $fed_part_input = [
                    'part_header' => $part_header[0],
                    'law_of_federation_id' => $fed->id
                ];
                $fed_part = LawOfFedPart::create($fed_part_input);
                foreach ($part_header[10] as $section_input) {
                    $data = [
                        'section_header' => $section_input[0],
                        'section_body' => $section_input[1],
                        'law_of_federation_id' => $fed->id,
                        'law_of_fed_part_id' => $fed_part->id,
                    ];
                    LawOfFedSection::create($data);
                }
            }
        }

        // $fed_part_input = [
        //     'part_header' => $request->part_header,
        //     'law_of_federation_id' => $fed->id
        // ];
        // DB::table('law_of_fed_parts')->where('law_of_federation_id', $fed->id)->update($fed_part_input);
        // $fed_part = LawOfFedPart::where('law_of_federation_id', $fed->id)->first();
        // $fed_part_id = $fed_part->id;
        // if($request->section) {
        //     foreach($request->section as $key => $section_input) {
        //         $data = [
        //             'section_header'=>$section_input[2],
        //             'section_body'=>$section_input[3],
        //             'law_of_federation_id'=> $fed->id,
        //             'law_of_fed_part_id'=> $fed_part_id,
        //         ];
        //         DB::table('law_of_fed_sections')->where('id', $key)->update($data);

        //         if($request->has('remove_section')) {
        //             $fed_section = LawOfFedSection::where('id', $request->fed_section_id);
        //             $fed_section->delete();
        //             return back()->with('success', 'Law Federation Section removed');
        //         }
        //     }
        // }

        // if($request->new_section) {
        //     foreach($request->new_section as $section_input) {
        //         $data = [
        //             'section_header'=>$section_input[2],
        //             'section_body'=>$section_input[3],
        //             'law_of_federation_id'=> $fed->id,
        //             'law_of_fed_part_id'=> $fed_part_id,
        //         ];
        //         LawOfFedSection::where('law_of_federation_id', $fed->id)->create($data);
        //     }
        // }

        if ($request->sched) {
            foreach ($request->sched as $key => $sched_input) {
                $data = [
                    'sched_header' => $sched_input[1],
                    'sched_body' => $sched_input[2],
                    'law_of_federation_id' => $fed->id,
                ];
                DB::table('law_of_fed_scheds')->where('id', $key)->update($data);

                if ($request->has('remove_sched')) {
                    $fed_sched = LawOfFedSched::where('id', $request->fed_sched_id);
                    $fed_sched->delete();
                    return back()->with('success', 'Law Federation Schedule removed');
                }
            }
        }

        if ($request->new_sched) {
            foreach ($request->new_sched as $sched_input) {
                $data = [
                    'sched_header' => $sched_input[1],
                    'sched_body' => $sched_input[2],
                    'law_of_federation_id' => $fed->id,
                ];
                LawOfFedSched::where('law_of_federation_id', $fed->id)->create($data);
            }
        }

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Law updated');
    }
    public function removeSection(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $fed_section = LawOfFedSection::where('id', $request->id)->first();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        $fed_section->delete();
        return response()->json(['success', 'Law Federation Section removed']);
    }
    public function removePart(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $fed_part = LawOfFedPart::where('id', $request->id)->first();
        LawOfFedSection::where('law_of_fed_part_id', $request->id)->delete();
        $fed_part->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return response()->json(['success', 'Law Federation Part removed']);
    }
    public function deleteFed($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $fed = LawOfFederation::findOrFail($id);
        LawOfFedPart::where('law_of_federation_id', $fed->id)->delete();
        LawOfFedSection::where('law_of_federation_id', $fed->id)->delete();
        LawOfFedSched::where('law_of_federation_id', $fed->id)->delete();
        $fed->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Law deleted');
    }



    ///////////////////////////area of law/////////////////////////////////////////////////
    public function area_of_law()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->get();
            $area_count = AreaOfLaw::count();
            return view('admin.areas-of-laws.index', compact('area_of_laws', 'area_count'));
        }
    }
    public function storeArea(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'area_of_law' => 'required',
        ]);
        $input = $request->all();
        AreaOfLaw::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Area of Law added');
    }
    public function updateArea(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'area_of_law' => 'required',
        ]);
        $input = [
            'area_of_law' => $request->category,
        ];
        DB::table('areas_of_laws')->where('id', $request->area_id)->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Area of law updated');
    }
    public function deleteArea($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $area_of_law = AreaOfLaw::findOrFail($id);
        $area_of_law->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Area of law deleted');
    }

    /////////////////////////////////////categories////////////////////////////////////////
    public function category()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $categories = Category::orderBy('category', 'ASC')->get();
            $category_count = Category::count();
            return view('admin.categories.index', compact('categories', 'category_count'));
        }
        return redirect('admin/dashboard');
    }
    public function storeCategory(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'category' => 'required',
        ]);
        $input = $request->all();
        Category::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Category added');
    }
    public function updateCategory(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'category' => 'required',
        ]);
        $input = [
            'category' => $request->category,
        ];
        DB::table('categories')->where('id', $request->category_id)->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Category updated');
    }
    public function deleteCategory($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $category = Category::findOrFail($id);
        $category->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Category deleted');
    }


    /////////////////////////////////////Forms and Precedents///////////////////////////////
    public function forms(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $categories = Category::orderBy('category', 'ASC')->get();
            if ($request->has('fetch_form')) {
                $forms = FormsPrecedence::where(function ($query) use ($request) {
                    return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                })->where('form_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                $my_forms = FormsPrecedence::where(function ($query) use ($request) {
                    return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                })->where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                $public_forms = FormsPrecedence::where(function ($query) use ($request) {
                    return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                })->where('display_type', 'public')->orderBy('title', 'ASC')->get();
                $form_count = $forms->count();
                $public_form_count = $public_forms->count();
                $selected_category = [];
                $selected_category['category'] = $request->category;
                return view('admin.forms-and-precedents.index', compact('forms', 'public_forms', 'my_forms', 'form_count', 'public_form_count', 'categories', 'selected_category'));
            } else {
                $forms = FormsPrecedence::where('form_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                $form_count = $forms->count();
                $public_forms = FormsPrecedence::where('display_type', 'public')->orderBy('title', 'ASC')->get();
                $public_form_count = $public_forms->count();
                $my_forms = FormsPrecedence::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                $selected_category = [];
                $selected_category['category'] = '';
                return view('admin.forms-and-precedents.index', compact('forms', 'public_forms', 'my_forms', 'form_count', 'public_form_count', 'categories', 'selected_category'));
            }
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->form_feature) {
                    // $categories = Category::orderBy('category', 'ASC')->get();
                    $categories = Package::where('id', Auth::user()->package_id)->first();
                    if ($request->has('fetch_form')) {
                        $forms = FormsPrecedence::where(function ($query) use ($request) {
                            return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                        })->where('form_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                        $my_forms = FormsPrecedence::where(function ($query) use ($request) {
                            return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                        })->where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                        $public_forms = FormsPrecedence::where(function ($query) use ($request) {
                            return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                        })->where('display_type', 'public')->orderBy('title', 'ASC')->get();
                        $form_count = $forms->count();
                        $public_form_count = $public_forms->count();
                        $selected_category = [];
                        $selected_category['category'] = $request->category;
                        return view('admin.forms-and-precedents.index', compact('forms', 'public_forms', 'my_forms', 'form_count', 'public_form_count', 'categories', 'selected_category'));
                    } else {
                        $forms = FormsPrecedence::where('form_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                        $form_count = $forms->count();
                        $public_forms = FormsPrecedence::where('display_type', 'public')->orderBy('title', 'ASC')->get();
                        $public_form_count = $public_forms->count();
                        $my_forms = FormsPrecedence::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                        $selected_category = [];
                        $selected_category['category'] = '';
                        return view('admin.forms-and-precedents.index', compact('forms', 'public_forms', 'my_forms', 'form_count', 'public_form_count', 'categories', 'selected_category'));
                    }
                }
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function storeForm(Request $request)
    {

        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'title' => 'required',
            // 'version_no' => 'required',
            // 'author' => 'required',
            // 'area_of_law' => 'required',
            'content' => 'required',
            // 'category' => 'required',
        ]);
        $input = $request->all();
        FormsPrecedence::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Form added');
    }
    public function editForm($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $form = FormsPrecedence::findOrFail($id);
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            return view('admin.forms-and-precedents.edit-form', compact('form', 'area_of_laws', 'categories'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $form = FormsPrecedence::where('user_id', Auth::user()->id)->find($id);
                if ($form) {
                    $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                    $categories = Package::where('id', Auth::user()->package_id)->first();
                    return view('admin.forms-and-precedents.edit-form', compact('form', 'area_of_laws', 'categories'));
                }
                return redirect('admin/forms-and-precedents')->with('error1', 'Access denied, you cannot edit this form');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function showForm($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $form = FormsPrecedence::findOrFail($id);
            $notes = Annotation::where('resource_type', 'form')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->get();
            $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
            $comments = FeaturedContent::where('type', 'form')->where('review_type', 'comment')->where('reference_id', $form->id)->orderBy('created_at', 'DESC')->get();
            $reviews = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->orderBy('created_at', 'DESC')->get();
            $rating_count = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->count();
            $rating = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->max('rating');

            return view('admin.forms-and-precedents.show', compact('form', 'notes', 'comments', 'reviews', 'rating_count', 'rating', 'teams'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $form = FormsPrecedence::findOrFail($id);
                $notes = Annotation::where('resource_type', 'form')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                $comments = FeaturedContent::where('type', 'form')->where('review_type', 'comment')->where('reference_id', $form->id)->orderBy('created_at', 'DESC')->get();
                $reviews = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->orderBy('created_at', 'DESC')->get();
                $rating_count = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->count();
                $rating = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->max('rating');

                return view('admin.forms-and-precedents.show', compact('form', 'notes', 'comments', 'reviews', 'rating_count', 'rating', 'teams'));
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function fetchFormAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $form = FormsPrecedence::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $form->id)->where('resource_type', 'form')->get();
        return response()->json([
            'anotes' => $anotes,
        ]);
    }
    public function updateForm(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $form = FormsPrecedence::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            // 'version_no' => 'required',
            // 'author' => 'required',
            // 'area_of_law' => 'required',
            'content' => 'required',
            // 'category' => 'required',
        ]);
        $input = $request->all();
        $form->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Form updated');
    }
    public function deleteForm($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $form = FormsPrecedence::findOrFail($id);
        $form->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'form deleted');
    }
    public function featureForm(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $form = FormsPrecedence::find($id);
        $input = $request->all();
        if ($request->has('make_featured')) {
            $form->update($input);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return back()->with('success', 'Form featured');
        }
        if ($request->has('remove_featured')) {
            $form->update($input);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return back()->with('success', 'Form not featured');
        }
    }
    public function rateForm(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        FeaturedContent::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Review sent');
    }
    public function likeForm(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        if ($request->form_precedence_id) {
            $like = Like::where('user_id', $request->user_id)->where('form_precedence_id', $request->form_precedence_id)->first();
            if ($like) {
                $like->update($input);

                $version = Setting::first();
                $input = [
                    'version' => $version->version + 0.1,
                ];
                $version->update($input);
            } else {
                Like::create($input);

                $version = Setting::first();
                $input = [
                    'version' => $version->version + 0.1,
                ];
                $version->update($input);
            }
            return response()->json(['success' => 'Form liked']);
        }
    }
    public function shareForm(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $form = FormsPrecedence::find($id);
        $link = route('show.form', $form->id);
        if ($request->has('share_all') && !empty($request->checkBoxArray)) {
            foreach ($request->checkBoxArray as $team) {
                $input = [
                    'team_id' => $team,
                    'user_id' => $request->user_id,
                    'form_precedence_id' => $id,
                    'comment_body' => json_encode([$form->title, $form->description, $link]),
                ];
                Comment::create($input);
            }
            RecentActivity::create([
                'user_id' => Auth::user()->id,
                'type' => 'shared form',
                'name' => 'You recently shared a form',
                'description' => $form->title
            ]);
            return back()->with('success', 'Article shared');
        }
        return back()->withErrors('Please select a team to share to');
    }

    ///////////////////////////////////////Legal Articles///////////////////////////////////
    public function articles(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $categories = Category::orderBy('category', 'ASC')->get();
            if ($request->has('fetch_category')) {
                $articles = Article::where(function ($query) use ($request) {
                    return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                })->where('article_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                $my_articles = Article::where(function ($query) use ($request) {
                    return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                })->where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                $public_articles = Article::where(function ($query) use ($request) {
                    return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                })->where('display_type', 'public')->orderBy('title', 'ASC')->get();

                $article_count = $articles->count();
                $public_article_count = $public_articles->count();
                $selected_category = [];
                $selected_category['category'] = $request->category;

                return view('admin.legal-articles.index', compact('articles', 'article_count', 'my_articles', 'public_articles', 'categories', 'public_article_count', 'selected_category'));
            } else {
                $articles = Article::where('article_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                $my_articles = Article::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                $public_articles = Article::where('display_type', 'public')->orderBy('title', 'ASC')->get();
                $categories = Category::orderBy('category', 'ASC')->get();
                $article_count = $articles->count();
                $public_article_count = $public_articles->count();
                $selected_category = [];
                $selected_category['category'] = $request->category;
                return view('admin.legal-articles.index', compact('articles', 'article_count', 'my_articles', 'public_articles', 'categories', 'public_article_count', 'selected_category'));
            }
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->article_feature) {
                    // $categories = Category::orderBy('category', 'ASC')->get();
                    $categories = Package::where('id', Auth::user()->package_id)->first();
                    // dd($categories);
                    if ($request->has('fetch_category')) {
                        $articles = Article::where(function ($query) use ($request) {
                            return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                        })->where('article_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                        $my_articles = Article::where(function ($query) use ($request) {
                            return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                        })->where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                        $public_articles = Article::where(function ($query) use ($request) {
                            return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                        })->where('display_type', 'public')->orderBy('title', 'ASC')->get();

                        $article_count = $articles->count();
                        $public_article_count = $public_articles->count();
                        $selected_category = [];
                        $selected_category['category'] = $request->category;

                        return view('admin.legal-articles.index', compact('articles', 'article_count', 'my_articles', 'public_articles', 'categories', 'public_article_count', 'selected_category'));
                    } else {
                        $articles = Article::where('article_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                        $my_articles = Article::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                        $public_articles = Article::where('display_type', 'public')->orderBy('title', 'ASC')->get();
                        $article_count = $articles->count();
                        $public_article_count = $public_articles->count();
                        $selected_category = [];
                        $selected_category['category'] = $request->category;
                        return view('admin.legal-articles.index', compact('articles', 'article_count', 'my_articles', 'public_articles', 'categories', 'public_article_count', 'selected_category'));
                    }
                }
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function storeArticle(Request $request)
    {
        // dd($request->all());
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            'authur' => 'required',
            // 'link' => 'required',
            'photo' => 'required',
            'category' => 'required',
            // 'area_of_law' => 'required',
            // 'references' => 'required',
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
        $article = Article::create($input);
        RecentActivity::create([
            'user_id' => Auth::user()->id,
            'type' => 'article',
            'name' => 'You recently published an article',
            'description' => $article->title
        ]);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Article added');
    }
    public function editArticle($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $article = Article::findOrFail($id);
            $categories = Category::orderBy('category', 'ASC')->get();
            return view('admin.legal-articles.edit-article', compact('article', 'categories'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $article = Article::where('user_id', Auth::user()->id)->find($id);
                if ($article) {
                    $categories = Package::where('id', Auth::user()->package_id)->first();
                    return view('admin.legal-articles.edit-article', compact('article', 'categories'));
                }
                return redirect('admin/legal-articles')->with('error1', 'Access denied, you cannot edit this article');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function showArticle($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $article = Article::findOrFail($id);
            $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
            $notes = Annotation::where('content_id', $article->id)->where('user_id', Auth::user()->id)->get();
            $admin_notes = Annotation::where('resource_type', 'admin-note')->orderBy('created_at', 'DESC')->limit(5)->get();
            $comments = FeaturedContent::where('type', 'article')->where('review_type', 'comment')->where('reference_id', $article->id)->orderBy('created_at', 'DESC')->get();
            $reviews = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->orderBy('created_at', 'DESC')->get();
            $rating_count = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->count();
            $rating = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->max('rating');
            return view('admin.legal-articles.show-article', compact('article', 'teams', 'notes', 'admin_notes', 'rating', 'rating_count', 'reviews', 'comments'));
        } else {
            if (Auth::user()->subscribedUser()) {
                $article = Article::findOrFail($id);
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                $notes = Annotation::where('content_id', $article->id)->where('user_id', Auth::user()->id)->get();
                $admin_notes = Annotation::where('resource_type', 'admin-note')->orderBy('created_at', 'DESC')->limit(5)->get();
                $comments = FeaturedContent::where('type', 'article')->where('review_type', 'comment')->where('reference_id', $article->id)->orderBy('created_at', 'DESC')->get();
                $reviews = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->orderBy('created_at', 'DESC')->get();
                $rating_count = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->count();
                $rating = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->max('rating');
                return view('admin.legal-articles.show-article', compact('article', 'teams', 'notes', 'admin_notes', 'rating', 'rating_count', 'reviews', 'comments'));
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function fetchArticleAnote($id)
    {
        // dd($id);
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $article = Article::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $article->id)->where('resource_type', 'article')->get();
        return response()->json([
            'anotes' => $anotes,
        ]);
    }
    public function updateArticle(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $article = Article::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            'authur' => 'required',
            // 'link' => 'required',
            'category' => 'required',
            // 'area_of_law' => 'required',
            // 'references' => 'required',
        ]);

        if ($file = $request->file('photo')) {
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
        $article->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Article updated');
    }
    public function featureArticle(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $article = Article::find($id);
        $input = $request->all();
        if ($request->has('make_featured')) {
            $article->update($input);

            $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);
            
            return back()->with('success', 'Article featured');
        }
        if ($request->has('remove_featured')) {
            $article->update($input);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return back()->with('success', 'Article not featured');
        }
    }
    public function rateArticle(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        FeaturedContent::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Review sent');
    }
    public function likeArticle(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        if ($request->article_id) {
            $like = Like::where('user_id', $request->user_id)->where('article_id', $request->article_id)->first();
            if ($like) {
                $like->update($input);

                $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

            } else {
                Like::create($input);

                $version = Setting::first();
                $input = [
                        'version' => $version->version + 0.1,
                    ];
                $version->update($input);

            }
            return response()->json(['success' => 'Article liked']);
        }
    }
    public function deleteArticle($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $article = Article::findOrFail($id);
        $article->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'article deleted');
    }
    public function shareArticle(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $article = Article::find($id);
        $link = route('show.article', $article->id);
        if ($request->has('share_all') && !empty($request->checkBoxArray)) {
            foreach ($request->checkBoxArray as $team) {
                $input = [
                    'team_id' => $team,
                    'user_id' => $request->user_id,
                    'article_id' => $id,
                    'comment_body' => json_encode([$article->title, $article->description, $link]),
                    'file' => substr($article->photo, 40), //40 on live server 31 on localhost
                    'file_type' => 'image',
                ];
                Comment::create($input);

                $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

            }
            RecentActivity::create([
                'user_id' => Auth::user()->id,
                'type' => 'shared article',
                'name' => 'You recently shared an article',
                'description' => $article->title
            ]);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return back()->with('success', 'Article shared');
        }
        return back()->withErrors('Please select a team to share to');
    }


    ////////////////////////////////////Legal Dictionary////////////////////////////////////
    public function dictionary(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $categories = Category::orderBy('category', 'ASC')->get();
            if ($request->has('fetch_category')) {
                $words = Dictionary::where(function ($query) use ($request) {
                    return $request->category ? $query->from('dictionaries')->where('category', $request->category) : '';
                })->orderBy('title', 'ASC')->get();
                $word_count = $words->count();
                $selected_category = [];
                $selected_category['category'] = $request->category;
                return view('admin.law-dictionary.index', compact('words', 'word_count', 'categories', 'selected_category'));
            } else {
                $words = Dictionary::orderBy('title', 'ASC')->get();
                $word_count = Dictionary::count();
                $selected_category = [];
                $selected_category['category'] = '';
                return view('admin.law-dictionary.index', compact('words', 'word_count', 'categories', 'selected_category'));
            }
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->dict_feature) {
                    // $categories = Category::orderBy('category', 'ASC')->get();
                    $categories = Package::where('id', Auth::user()->package_id)->first();
                    if ($request->has('fetch_category')) {
                        $words = Dictionary::where(function ($query) use ($request) {
                            return $request->category ? $query->from('dictionaries')->where('category', $request->category) : '';
                        })->orderBy('title', 'ASC')->get();
                        $word_count = $words->count();
                        $selected_category = [];
                        $selected_category['category'] = $request->category;
                        return view('admin.law-dictionary.index', compact('words', 'word_count', 'categories', 'selected_category'));
                    } else {
                        $words = Dictionary::orderBy('title', 'ASC')->get();
                        $word_count = Dictionary::count();
                        $selected_category = [];
                        $selected_category['category'] = '';
                        return view('admin.law-dictionary.index', compact('words', 'word_count', 'categories', 'selected_category'));
                    }
                }
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function storeDictionary(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            // 'area_of_law' => 'required',
        ]);
        $input = $request->all();
        Dictionary::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Word Added');
    }
    public function editDictionary($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $word = Dictionary::findOrFail($id);
            $categories = Category::orderBy('category', 'ASC')->get();
            return view('admin.law-dictionary.edit-dictionary', compact('word', 'categories'));
        }
        return redirect('admin/law-dictionary');
    }
    public function updateDictionary(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $word = Dictionary::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            // 'area_of_law' => 'required',
        ]);
        $input = $request->all();
        $word->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Dictionary updated');
    }
    public function deleteDictionary($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $word = Dictionary::findOrFail($id);
        $word->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Word deleted');
    }



    ////////////////////////////////////Legal Maxims///////////////////////////////////////
    public function maxim(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $categories = Category::orderBy('category', 'ASC')->get();
            if ($request->has('fetch_category')) {
                $maxims = Maxim::where(function ($query) use ($request) {
                    return $request->category ? $query->from('maxims')->where('category', $request->category) : '';
                })->orderBy('title', 'ASC')->get();
                $maxim_count = $maxims->count();
                $selected_category = [];
                $selected_category['category'] = $request->category;
                return view('admin.legal-maxims.index', compact('maxims', 'maxim_count', 'categories', 'selected_category'));
            } else {
                $maxims = Maxim::orderBy('title', 'ASC')->get();
                $maxim_count = Maxim::count();
                $selected_category = [];
                $selected_category['category'] = '';
                return view('admin.legal-maxims.index', compact('maxims', 'maxim_count', 'categories', 'selected_category'));
            }
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->maxim_feature) {
                    // $categories = Category::orderBy('category', 'ASC')->get();
                    $categories = Package::where('id', Auth::user()->package_id)->first();
                    if ($request->has('fetch_category')) {
                        $maxims = Maxim::where(function ($query) use ($request) {
                            return $request->category ? $query->from('maxims')->where('category', $request->category) : '';
                        })->orderBy('title', 'ASC')->get();
                        $maxim_count = $maxims->count();
                        $selected_category = [];
                        $selected_category['category'] = $request->category;
                        return view('admin.legal-maxims.index', compact('maxims', 'maxim_count', 'categories', 'selected_category'));
                    } else {
                        $maxims = Maxim::orderBy('title', 'ASC')->get();
                        $maxim_count = Maxim::count();
                        $selected_category = [];
                        $selected_category['category'] = '';
                        return view('admin.legal-maxims.index', compact('maxims', 'maxim_count', 'categories', 'selected_category'));
                    }
                }
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function storeMaxim(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            // 'area_of_law' => 'required',
        ]);
        $input = $request->all();
        Maxim::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Maxim Added');
    }
    public function editMaxim($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $maxim = Maxim::findOrFail($id);
            $categories = Category::orderBy('category', 'asc')->get();
            return view('admin.legal-maxims.edit-maxims', compact('maxim', 'categories'));
        }
        return redirect('admin/legal-maxims');
    }
    public function updateMaxim(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $maxim = Maxim::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            // 'area_of_law' => 'required',
        ]);
        $input = $request->all();
        $maxim->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Maxim updated');
    }
    public function deleteMaxim($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $maxim = Maxim::findOrFail($id);
        $maxim->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Maxim deleted');
    }



    ///////////////////////////////////Foreign resources///////////////////////////////////
    public function resource(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $categories = Category::orderBy('category', 'ASC')->get();
            if ($request->has('fetch_category')) {
                $resources = Resource::where(function ($query) use ($request) {
                    return $request->category ? $query->from('resources')->where('category', $request->category) : '';
                })->orderBy('title', 'ASC')->get();
                $resource_count = $resources->count();
                $selected_category = [];
                $selected_category['category'] = $request->category;
                return view('admin.resources.index', compact('resources', 'resource_count', 'categories', 'selected_category'));
            } else {
                $resources = Resource::OrderBy('title', 'ASC')->get();
                $resource_count = Resource::count();
                $selected_category = [];
                $selected_category['category'] = '';
                return view('admin.resources.index', compact('resources', 'resource_count', 'categories', 'selected_category'));
            }
        } else {
            if (Auth::user()->subscribedUser()) {
                $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                if ($subscribed_package->resource_feature) {
                    // $categories = Category::orderBy('category', 'ASC')->get();
                    $categories = Package::where('id', Auth::user()->package_id)->first();
                    if ($request->has('fetch_category')) {
                        $resources = Resource::where(function ($query) use ($request) {
                            return $request->category ? $query->from('resources')->where('category', $request->category) : '';
                        })->orderBy('title', 'ASC')->get();
                        $resource_count = $resources->count();
                        $selected_category = [];
                        $selected_category['category'] = $request->category;
                        return view('admin.resources.index', compact('resources', 'resource_count', 'categories', 'selected_category'));
                    } else {
                        $resources = Resource::OrderBy('title', 'ASC')->get();
                        $resource_count = Resource::count();
                        $selected_category = [];
                        $selected_category['category'] = '';
                        return view('admin.resources.index', compact('resources', 'resource_count', 'categories', 'selected_category'));
                    }
                }
                return redirect('admin/dashboard')->with('error1', 'You need to upgrade your package to get access');
            }
            return redirect('admin/dashboard')->with('error1', 'You need to subscribe to a package to get access');
        }
    }
    public function storeResource(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'title' => 'required',
            'url' => 'required',
            'description' => 'required',
            // 'area_of_law' => 'required',
        ]);
        $input = $request->all();
        Resource::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Resource Added');
    }
    public function editResource($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $resource = Resource::findOrFail($id);
            $categories = Category::orderBy('category', 'ASC')->get();
            return view('admin.resources.edit-resources', compact('resource', 'categories'));
        }
        return redirect('admin/resources');
    }
    public function updateResource(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $resource = Resource::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'url' => 'required',
            'description' => 'required',
        ]);
        $input = $request->all();
        $resource->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Resource updated');
    }
    public function deleteResource($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $resource = Resource::findOrFail($id);
        $resource->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Resource deleted');
    }





    ////////////////////////////// featured content //////////////////////////////////////
    public function featuredContent()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        DB::statement("SET SQL_MODE=''");
        $featured_teams = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->groupBy('reference_id')->get();
        $featured_users = FeaturedContent::where('type', 'user')->where('review_type', 'rating')->groupBy('reference_id')->get();
        $featured_articles = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->groupBy('reference_id')->get();
        $featured_forms = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->groupBy('reference_id')->get();
        $featured_notes = FeaturedContent::where('type', 'note')->where('review_type', 'rating')->groupBy('reference_id')->get();
        return view('admin.featured-content', [
            'featured_teams' => $featured_teams,
            'featured_users' => $featured_users,
            'featured_articles' => $featured_articles,
            'featured_forms' => $featured_forms,
            'featured_notes' => $featured_notes,
        ]);
    }
    public function saveFeature(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if ($request->has('make_featured')) {
            FeaturedContent::where('reference_id', $id)->where('type', $request->type)->where('review_type', 'rating')->update(array('featured' => $request->featured));
            FeaturedContent::where('reference_id', '<>', $id)->where('type', $request->type)->where('review_type', 'rating')->update(array('featured' => 0));
            return back()->with('success', 'Featured on Dashboard');
        }
        if ($request->has('remove_featured')) {
            FeaturedContent::where('reference_id', $id)->where('type', $request->type)->where('review_type', 'rating')->update(array('featured' => $request->featured));
            return back()->with('success', 'Feature removed from dashboard');
        }
    }



    ///////////////////////////////////subscription package///////////////////////////////
    public function subscription()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $packages = Package::orderBy('name', 'ASC')->get();
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            $courts = Court::orderBy('court', 'ASC')->get();
            $states = State::orderBy('name', 'ASC')->get();
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.subscriptions.index', compact('packages', 'area_of_laws', 'categories', 'courts', 'states', 'rule_categories'));
        }
        return redirect('admin/dashboard');
    }
    public function editPackage($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $package = Package::findOrFail($id);
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            $courts = Court::orderBy('court', 'ASC')->get();
            $states = State::orderBy('name', 'ASC')->get();
            $rule_categories = RuleCategory::orderBy('name', 'ASC')->get();
            return view('admin.subscriptions.edit-package', compact('package', 'area_of_laws', 'categories', 'courts', 'states', 'rule_categories'));
        }
        return redirect('admin/dashboard');
    }
    public function storePackage(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

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
            'ai_feature' => $request->ai_feature,
            'ai_cat' => json_encode($request->ai_cat),
            'ai_counsel' => $request->ai_counsel,
            'ai_counsel_cat' => json_encode($request->ai_counsel_cat),
            'team' => $request->team,
            'share' => $request->share,
            'note' => $request->note,
            'bookmark' => $request->bookamrk,
            'is_active' => $request->is_active,
        ];
        if (!$request->maxim_cat) {
            $input['maxim_cat'] = $request->maxim_cat;
        }
        if (!$request->article_cat) {
            $input['article_cat'] = $request->article_cat;
        }
        if (!$request->form_cat) {
            $input['form_cat'] = $request->form_cat;
        }
        if (!$request->dict_cat) {
            $input['dict_cat'] = $request->dict_cat;
        }
        if (!$request->resource_cat) {
            $input['resource_cat'] = $request->resource_cat;
        }
        if (!$request->roc_cat) {
            $input['roc_cat'] = $request->roc_cat;
        }
        if (!$request->sroc_state) {
            $input['sroc_state'] = $request->sroc_state;
        }
        if (!$request->lfn_cat) {
            $input['lfn_cat'] = $request->lfn_cat;
        }
        if (!$request->judg_cat) {
            $input['judg_cat'] = $request->judg_cat;
        }
        if (!$request->judg_court) {
            $input['judg_court'] = $request->judg_court;
        }
        if (!$request->ai_feature) {
            $input['ai_feature'] = $request->ai_feature;
        }
        if (!$request->ai_counsel) {
            $input['ai_counsel'] = $request->ai_counsel;
        }

        // dd($input);
        Package::create($input);
        return back()->with('success', 'Package created');
    }
    public function updatePackage(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $package = Package::findOrFail($id);
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
            'ai_cat' => json_encode($request->ai_cat),
            'ai_feature' => $request->ai_feature,
            'ai_counsel' => $request->ai_counsel,
            'ai_counsel_cat' => json_encode($request->ai_counsel_cat),
            'team' => $request->team,
            'share' => $request->share,
            'note' => $request->note,
            'bookmark' => $request->bookamrk,
            'is_active' => $request->is_active,
        ];
        if (!$request->maxim_cat) {
            $input['maxim_cat'] = $request->maxim_cat;
        }
        if (!$request->article_cat) {
            $input['article_cat'] = $request->article_cat;
        }
        if (!$request->form_cat) {
            $input['form_cat'] = $request->form_cat;
        }
        if (!$request->dict_cat) {
            $input['dict_cat'] = $request->dict_cat;
        }
        if (!$request->resource_cat) {
            $input['resource_cat'] = $request->resource_cat;
        }
        if (!$request->roc_cat) {
            $input['roc_cat'] = $request->roc_cat;
        }
        if (!$request->sroc_state) {
            $input['sroc_state'] = $request->sroc_state;
        }
        if (!$request->lfn_cat) {
            $input['lfn_cat'] = $request->lfn_cat;
        }
       
        if (!$request->judg_cat) {
            $input['judg_cat'] = $request->judg_cat;
        }
        if (!$request->judg_court) {
            $input['judg_court'] = $request->judg_court;
        }
        if (!$request->maxim_cat) {
            $input['maxim_cat'] = $request->maxim_cat;
        }
        if (!$request->team) {
            $input['team'] = $request->team;
        }
        if (!$request->note) {
            $input['note'] = $request->note;
        }
        if (!$request->share) {
            $input['share'] = $request->share;
        }
        if (!$request->judgement_feature) {
            $input['judgement_feature'] = $request->judgement_feature;
            $input['judg_cat'] = NULL;
            $input['judg_court'] = NULL;
            $input['judg_single_year'] = NULL;
            $input['judg_start_year'] = NULL;
            $input['judg_end_year'] = NULL;
        }
        if (!$request->lfn_feature) {
            $input['lfn_feature'] = $request->lfn_feature;
            $input['lfn_cat'] = NULL;
            $input['lfn_single_year'] = NULL;
            $input['lfn_start_year'] = NULL;
            $input['lfn_end_year'] = NULL;
        }
        if (!$request->roc_feature) {
            $input['roc_feature'] = $request->roc_feature;
            $input['roc_cat'] = NULL;
        }
        if (!$request->sroc_feature) {
            $input['sroc_feature'] = $request->sroc_feature;
            $input['sroc_state'] = NULL;
        }
        if (!$request->dict_feature) {
            $input['dict_feature'] = $request->dict_feature;
            $input['dict_cat'] = NULL;
        }
        if (!$request->resource_feature) {
            $input['resource_feature'] = $request->resource_feature;
            $input['resource_cat'] = NULL;
        }
        if (!$request->maxim_feature) {
            $input['maxim_feature'] = $request->maxim_feature;
            $input['maxim_cat'] = NULL;
        }
        if (!$request->article_feature) {
            $input['article_feature'] = $request->article_feature;
            $input['article_cat'] = NULL;
        }
        if (!$request->form_feature) {
            $input['form_feature'] = $request->form_feature;
            $input['form_cat'] = NULL;
        }

        if (!$request->ai_feature) {
            $input['ai_feature'] = $request->ai_feature;
            $input['ai_cat'] = null;
        }
        if (!$request->ai_counsel) {
            $input['ai_counsel'] = $request->ai_counsel;
            $input['ai_counsel_cat'] = null;
        }
        // dd($input, $request->ai_feature, $request->ai_cat);
        $package->update($input);
        return back()->with('success', 'Package updated');
    }
    public function deletePackage($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $package = Package::findOrFail($id);
        if (User::where('package_id', $package->id)->first()) {
            return back()->with('error', 'Subscription package cannot be deleted as a user is already subscribed to the package');
        }
        $package->delete();
        return back()->with('success', 'Subscription package deleted');
    }



    ////////////////////////////////////discount//////////////////////////////////////////
    public function discount()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $discounts = Discount::orderBy('name', 'asc')->get();
            $packages = Package::orderBy('name', 'asc')->get();
            $discount_code = $this->generateRandomString(6);
            return view('admin.discounts.index', compact('discounts', 'packages', 'discount_code'));
        }
        return redirect('admin/dashboard');
    }
    public function generateRandomString($length = 20)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function storeDiscount(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

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
    public function updateDiscount(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

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
            'name' => $request->name,
            'validity_start_date' => $request->validity_start_date,
            'validity_end_date' => $request->validity_end_date,
            'discount_code' => $request->discount_code,
            'usage' => $request->usage,
            'percentage' => $request->percentage,
            'package' => $request->package,
            'package_id' => $request->package_id,
        ];
        DB::table('discounts')->where('id', $request->discount_id)->update($input);
        return back()->with('success', 'Discount updated');
    }
    public function useDiscount(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $package = Package::findOrFail($id);
        $discount = Discount::where('package_id', $package->id)->where('discount_code', $request->used)->first();
        // dd($discount);
        $validator = Validator::make(
            $request->all(),
            [
                'used' => 'required',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors('Please enter a valid coupon');
        }
        if (isset($discount->package_id)) {
            if ($discount->package_id == $package->id) {
                // dd($discount->discount_code);
                if ($request->used == $discount->discount_code) {
                    if ($discount->validity_end_date > now()) {
                        if ($discount->used == null) {
                            $input = [
                                'used' => 1,
                            ];
                            $discount->update($input);
                            $discounted_price = ($package->price * $discount->percentage) / 100;
                            $new_price = $package->price - $discounted_price;
                            Session::flash('success1', 'Discount applied');
                            return view('checkout.discount', compact('new_price', 'package'));
                        } elseif ($discount->used < $discount->usage) {
                            $data = 1 + $discount->used;
                            $discount->used = $data;
                            $discount->save();
                            $discounted_price = ($package->price * $discount->percentage) / 100;
                            $new_price = $package->price - $discounted_price;
                            Session::flash('success1', 'Discount applied');
                            return view('checkout.discount', compact('new_price', 'package'));
                        }
                        return back()->with('error', 'Coupon already used');
                    }
                    return back()->with('error', 'Coupon has expired');
                }
                return back()->with('error', 'Invalid coupon');
            }
            return back()->with('error', 'Invalid coupon');
        }
        return back()->with('error', 'Invalid coupon');
    }
    public function deleteDiscount($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $discount = Discount::findOrFail($id);
        $discount->delete();
        return back()->with('success', 'Discount deleted');
    }


    /////////////////////////////////////transactions///////////////////////////////////////
    public function transaction(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $packages = Package::orderBy('name', 'ASC')->get();
            if ($request->has('fetch_transaction')) {
                $transaction = Transaction::query();
                if ($request->filled('end_date')) {
                    $start_date = Carbon::parse($request->start_date)->toDateTimeString();
                    $end_date = Carbon::parse($request->end_date)->toDateTimeString();
                    $transactions = $transaction->whereBetween('created_at', [$start_date, $end_date])->orderBy('created_at', 'DESC')->get();
                }
                if ($request->filled('status')) {
                    $transactions = $transaction->where('status', $request->status)->orderBy('created_at', 'DESC')->get();
                }
                if ($request->filled('package')) {
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
        return redirect('admin/dashboard');
    }
    public function updateTransaction(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'status' => 'required',
        ]);
        $input = [
            'status' => $request->status,
        ];
        $transaction = Transaction::where('id', $request->transaction_id)->first();
        $transaction->update($input);
        // DB::table('transactions')->where('id', $request->transaction_id)->update($input);
        $user = User::where('id', $transaction->user_id)->first();
        $explodedMail =  $user->email;
        $activesubject = 'Package Activated';
        $pendingsubject = 'Pending Transaction';
        $failedsubject = 'Transaction Failed';
        $newContent =  [
            'user' => $user->name,
            'package' => $transaction->package,
            'amount' => $transaction->amount,
            'reference' => $transaction->reference,
        ];
        $activated = view("emails.activatedSubscriber", $newContent)->render();
        $pending = view("emails.pendingSubscriber", $newContent)->render();
        $failed = view("emails.failedSubscriber", $newContent)->render();

        if ($transaction->status == 'paid') {
            $user->status = 'active';
            // $user->notify(new ActivatedSubscriber($transaction, $user));
            tribearcSendMail($activesubject, $activated, $explodedMail);
        } elseif ($transaction->status == 'pending') {
            $user->status = 'inactive';
            // $user->notify(new PendingSubscriber($transaction, $user));
            tribearcSendMail($pendingsubject, $pending, $explodedMail);
        } elseif ($transaction->status == 'failed') {
            $user->status = 'inactive';
            // $user->notify(new FailedSubscriber($transaction, $user));
            tribearcSendMail($failedsubject, $failed, $explodedMail);
        }
        $user->save();

        return back()->with('success', 'Transaction updated');
    }
    public function deleteTransaction($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return back()->with('success', 'Transaction deleted');
    }



    //////////////////////////////////////Teams/////////////////////////////////////////////
    public function team()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $teams = Team::get();
        $my_teams = Team::where('user_id', Auth::user()->id)->get();
        return view('admin.teams.index', compact('teams', 'my_teams'));
    }
    public function storeTeam(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'photo' => 'required|mimes:png,jpeg,jpg,webp|max:10000',
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

        RecentActivity::create([
            'user_id' => Auth::user()->id,
            'type' => 'team',
            'name' => 'You recently created a team',
            'description' => $team->name
        ]);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return redirect()->back()->with('success', 'Team created');
    }
    public function updateTeam(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($file = $request->file('photo')) {
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

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return redirect()->back()->with('success', 'Team updated');
    }
    public function settingsTeam(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $team = Team::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $input = $request->all();
        if ($file = $request->file('photo')) {
            $path = $file->store('media', 'public');
            $input['photo'] = $path;
        }
        $team->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return redirect()->back()->with('success', 'Team updated');
    }
    public function showTeam(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $team = Team::findOrFail($id);
        $user = Auth::user()->id;
        $users = User::select("*")->whereNotNull('last_seen')->orderBy('last_seen', 'DESC')->get();
        $send_request = UserTeam::where('user_id', Auth::user()->id)->where('team_id', $team->id)->first();
        $approved_members = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->get();
        $some_approved_members = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->limit(4)->get();
        $approved_member = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->first();
        $approved_member_count = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->count();
        $comment = Comment::with('comment_replies')->where('team_id', $team->id)->where('pinned_post', 1)->first(); // pinned post
        $shared_files = Comment::where('team_id', $team->id)->orderBy('created_at', 'DESC')->limit(4)->get();
        $shared_resources = Comment::where('team_id', $team->id)->orderBy('created_at', 'DESC')->get();
        $saved_posts = SavedPost::where('team_id', $team->id)->where('user_id', Auth::user()->id)->where('status', 1)->orderBy('created_at', 'DESC')->get();

        $team_member = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->where('user_id', Auth::user()->id)->first();
        $rating_count = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->count();
        $rating = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->max('rating');
        $reviews = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->orderBy('created_at', 'DESC')->get();

        if (isset($request->search_post) && !empty($request->search_post)) {
            $search = $request->search_post;
            $query_comment = Comment::query();
            $comments = $query_comment->with('comment_replies')
                ->where('team_id', $team->id)
                ->where('comment_body', 'LIKE', '%' . $search . '%')
                ->orderBy('created_at', 'DESC')
                ->get();
            return view('admin.teams.show', compact('team', 'users', 'send_request', 'approved_members', 'some_approved_members', 'approved_member', 'approved_member_count', 'comments', 'shared_files', 'shared_resources', 'comment', 'saved_posts', 'rating_count', 'rating', 'reviews', 'team_member'));
        }
        $comments = Comment::with('comment_replies')->where('team_id', $team->id)->where('id', '<>', @$comment->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.teams.show', compact('team', 'users', 'send_request', 'approved_members', 'some_approved_members', 'approved_member', 'approved_member_count', 'comments', 'shared_files', 'shared_resources', 'comment', 'saved_posts', 'rating_count', 'rating', 'reviews', 'team_member'));
    }
    public function teamMeeting($teamId)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $team = Team::find($teamId);
        return view('admin.teams.meeting', [
            'team' => $team
        ]);
    }
    public function likeTeamPost(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        if ($request->comment_id) {
            $like = Like::where('user_id', $request->user_id)->where('comment_id', $request->comment_id)->first();
            if ($like) {
                $like->update($input);

                $version = Setting::first();
                $input = [
                        'version' => $version->version + 0.1,
                    ];
                $version->update($input);

            } else {
                Like::create($input);

                $version = Setting::first();
                $input = [
                        'version' => $version->version + 0.1,
                    ];
                $version->update($input);

            }
            return response()->json(['success' => 'Team Post liked']);
        }
    }
    public function saveTeamPost(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        if ($request->comment_id) {
            $saved_post = SavedPost::where('user_id', $request->user_id)->where('comment_id', $request->comment_id)->first();
            if ($saved_post) {
                if ($request->status == 1) {
                    $saved_post->update($input);

                    $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

                    return back()->with('success', 'Post saved');
                } else {
                    $saved_post->update($input);

                    $version = Setting::first();
                    $input = [
                        'version' => $version->version + 0.1,
                    ];
                    $version->update($input);

                    return back()->with('success', 'Post unsaved');
                }
            } else {
                SavedPost::create($input);
            }
            return back()->with('success', 'Post saved');
        }
    }
    public function joinTeam($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

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
    public function joinedTeam(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $team = Team::findOrFail($id);
        $input = [
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
            'send_request' => $request->send_request,
            'approve_request' => $request->approve_request,
        ];
        UserTeam::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return redirect()->route('show.team', $team->id)->with('success', 'You have joined this team');
    }
    public function sendRequest(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = [
            'send_request' => $request->send_request,
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
        ];
        $team = UserTeam::create($input);
        $user = Auth::user();
        $team_admin = User::where('id', $request->team_owner_id)->first();
        if ($team_admin) {
            // $team_admin->notify(new TeamRequest($user, $team));
            $explodedMail =  $team_admin->email;
            $subject = 'New Team Member';
            $newContent =  [
                'user' => $team_admin->name,
                'member_name' => $user->name,
                'member_email' => $user->email,
                'team_id' => $team->team_id,
            ];
            $content = view("emails.teamRequest", $newContent)->render();
            tribearcSendMail($subject, $content, $explodedMail);
        }
        return redirect()->back()->with('success', 'Request sent');
    }
    public function approveMember($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (UserTeam::where('user_id', Auth::user()->id)->first()) {
            $team = Team::findOrFail($id);
            $new_members = UserTeam::where('send_request', 1)->where('approve_request', 0)->where('team_id', $team->id)->get();
            return view('admin.teams.approve', compact('new_members'));
        } else
            return redirect('admin/teams');
    }
    public function approveRequest(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $user = UserTeam::findOrFail($id);
        $input = [
            'approve_request' => $request->approve_request,
        ];
        $user->update($input);
        $approved_member = User::where('id', $user->user_id)->first();
        if ($approved_member) {
            // $approved_member->notify(new RequestApproved($user));
            $explodedMail =  $approved_member->email;
            $subject = 'Your request has been approved';
            $newContent =  [
                'user' => $approved_member->name
            ];
            $content = view("emails.requestApproved", $newContent)->render();
            tribearcSendMail($subject, $content, $explodedMail);
        }
        return redirect()->back()->with('success', 'You have just approved this member');
    }
    public function declineRequest(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $user = UserTeam::findOrFail($id);
        $input = [
            'approve_request' => $request->approve_request,
        ];
        $user->update($input);
        $declined_member = User::where('id', $user->user_id)->first();
        if ($declined_member) {
            // $declined_member->notify(new RequestDeclined($user));
            $explodedMail =  $declined_member->email;
            $subject = 'Your request has been declined';
            $newContent =  [
                'user' => $declined_member->name
            ];
            $content = view("emails.requestDeclined", $newContent)->render();
            tribearcSendMail($subject, $content, $explodedMail);
        }
        return redirect()->back()->with('success', 'You declined this member');
    }
    public function remove($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $approved_member = UserTeam::findOrFail($id);
        $approved_member->delete();
        $removed_user = User::where('id', $approved_member->user_id)->first();
        if ($removed_user) {
            // $removed_user->notify(new MemberRemoval($approved_member));
            $explodedMail =  $removed_user->email;
            $subject = 'Your have been removed';
            $newContent =  [
                'user' => $removed_user->name
            ];
            $content = view("emails.memberRemoval", $newContent)->render();
            tribearcSendMail($subject, $content, $explodedMail);
        }
        return redirect()->back()->with('success', 'You have just removed a user');
    }
    public function leave($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $approved_member = UserTeam::findOrFail($id);
        $approved_member->delete();
        $left_user = User::where('id', $approved_member->user_id)->first();
        if ($left_user) {
            // $left_user->notify(new MemberLeft($approved_member));
            $explodedMail =  $left_user->email;
            $subject = 'Your just left a team';
            $newContent =  [
                'user' => $left_user->name
            ];
            $content = view("emails.memberLeft", $newContent)->render();
            tribearcSendMail($subject, $content, $explodedMail);
        }
        return redirect()->back()->with('success', 'You just left this team');
    }
    public function deleteTeam($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $team = Team::findOrFail($id);
        UserTeam::where('team_id', $team->id)->delete();
        $team->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return redirect('admin/teams')->with('success', 'Team deleted');
    }
    public function featureTeam(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $team = Team::find($id);
        $input = $request->all();
        if ($request->has('make_featured')) {
            $team->update($input);
            return back()->with('success', 'Team featured');
        }
        if ($request->has('remove_featured')) {
            $team->update($input);
            return back()->with('success', 'Team not featured');
        }
    }
    public function rateTeam(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        FeaturedContent::create($input);
        return back()->with('success', 'Review sent');
    }


    ///////////////////////////////////////comment and replies/////////////////////////
    public function commentApi(Request $request){
        $input = [
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
            'comment_body' => $request->comment_body
        ];
        Comment::create($input);
        return response()->json([ 'data' => true]);
    }

    public function comment(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if ($file = $request->file('file')) {
            $validated = $request->validate(
                [
                    // 'comment_body' => 'required',
                    'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg,gif,mp4|max:50000',
                    'file_type' => 'required',
                ],
                [
                    'file.max' => 'The maximum file upload size is 50mb', // custom message
                ]
            );

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
            Comment::create($input);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return redirect()->back()->with('success', 'You just posted to this team');
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'comment_body' => 'required',
                ]
            );
            if ($validator->fails()) {
                return back()->withErrors('Your post is empty');
            }
            $input = [
                'user_id' => $request->user_id,
                'team_id' => $request->team_id,
                'comment_body' => $request->comment_body
            ];
            Comment::create($input);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return redirect()->back()->with('success', 'You just posted to this team');
        }
    }
    public function reply(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if ($request->has('reply')) {
            $validated = $request->validate([
                'comment_reply_body' => 'required',
            ]);
            $input = [
                'user_id' => $request->user_id,
                'comment_id' => $request->comment_id,
                'comment_reply_body' => $request->comment_reply_body
            ];
            CommentReply::create($input);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return redirect()->back()->with('success', 'You just commented to this post');
        }
    }
    public function updateComment(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if ($request->has('pin_post')) {
            $input = [
                'pinned_post' => $request->pinned_post,
            ];
            DB::table('comments')->where('team_id', $request->team_id)->where('pinned_post', 1)->update(array('pinned_post' => 0));
            $comment = Comment::where('id', $request->comment_id)->first();
            $comment->update($input);

            $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

            return back()->with('success', 'Post pinned');
        } elseif ($request->has('unpin_post')) {
            $input = [
                'pinned_post' => $request->pinned_post,
            ];
            $comment = Comment::where('id', $request->comment_id)->first();
            $comment->update($input);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return back()->with('success', 'Post unpinned');
        } else {
            $validated = $request->validate([
                'comment_body' => 'required'
            ]);
            $input = [
                'user_id' => $request->user_id,
                'team_id' => $request->team_id,
                'comment_body' => $request->comment_body
            ];
            DB::table('comments')->where('id', $request->comment_id)->update($input);

            $version = Setting::first();
            $input = [
                'version' => $version->version + 0.1,
            ];
            $version->update($input);

            return redirect()->back()->with('success', 'Post reposted');
        }
    }
    public function deleteComment($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $comment = Comment::findorFail($id);
        $comment->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return redirect()->back()->with('success', 'Post deleted');
    }



    ///////////////////////////////////////Global search///////////////////////////////
    public function search(Request $request)
    {
        // $empty_search = $request->input('search');
        // if($empty_search == '') {
        //     return back()->with('error1', 'No search input found');
        // }

        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if ($request->input('search')) {
            $search = $request->input('search');
            $first_search = $request->input('search');
            $second_search = '';



            /////////////// Judgement search //////////////////////

            $query_case['table'] = 'ratio';
            $query_case['search'] = SummaryRatio::query()->where('heading', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                // ->orderBy('heading', 'ASC')
                ->orderByRaw('CHAR_LENGTH(heading)')
                ->simplePaginate(15)
                ->withQueryString();
            // ->get();


            $query_ratio_count = SummaryRatio::query()
                ->where('heading', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                ->count();


            if (count($query_case['search']) < 1) {
                $query_case['table'] = 'sum';
                $query_case['search'] = JudgementSummary::query()
                    ->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->orWhere('summary_of_facts', 'LIKE', '%' . $search . '%')
                    ->orWhere('issues', 'LIKE', '%' . $search . '%')
                    ->orderBy('judgement_date', 'DESC')
                    ->simplePaginate(5)
                    ->withQueryString();
            }

            $query_sum_count = JudgementSummary::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                ->orWhere('summary_of_facts', 'LIKE', '%' . $search . '%')
                ->orWhere('issues', 'LIKE', '%' . $search . '%')
                ->count();

            $query_case_count = $query_sum_count + $query_ratio_count;

            /////////////// Law of Federation search //////////////////////

            $query_law['table'] = 'lfn';
            $query_law['search'] = LawOfFederation::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%')
                ->orWhere('subsidiary_legislation', 'LIKE', '%' . $search . '%')
                ->orderBy('law_date', 'DESC')
                ->simplePaginate(5)
                ->withQueryString();
            // ->get();

            // dd($query_law['search']);
            $query_fed_count = LawOfFederation::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%')
                ->orWhere('subsidiary_legislation', 'LIKE', '%' . $search . '%')
                ->count();

            if (count($query_law['search']) < 1) {
                $query_law['table'] = 'sched';
                $query_law['search'] = LawOfFedSched::query()
                    ->where('sched_header', 'LIKE', '%' . $search . '%')
                    ->orWhere('sched_body', 'LIKE', '%' . $search . '%')
                    ->orderBy('sched_header', 'ASC')
                    ->simplePaginate(5)
                    ->withQueryString();
                // ->get();
            }

            $query_sched_count = LawOfFedSched::query()
                ->where('sched_header', 'LIKE', '%' . $search . '%')
                ->orWhere('sched_body', 'LIKE', '%' . $search . '%')
                ->count();

            if (count($query_law['search']) < 1) {
                $query_law['table'] = 'sec';
                $query_law['search'] = LawOfFedSection::query()
                    ->where('section_header', 'LIKE', '%' . $search . '%')
                    ->orWhere('section_body', 'LIKE', '%' . $search . '%')
                    ->orderBy('section_header', 'ASC')
                    ->simplePaginate(5)
                    ->withQueryString();
                // ->get();
            }
            $query_sec_count = LawOfFedSection::query()
                ->where('section_header', 'LIKE', '%' . $search . '%')
                ->orWhere('section_body', 'LIKE', '%' . $search . '%')
                ->count();

            // dd($query_sec_count);

            $query_law_count = $query_fed_count + $query_sched_count + $query_sec_count;



            /////////////// Rules of court and state rules search //////////////////////

            $query_rule['search'] = Rule::query()
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('title', 'LIKE', '%' . $search . '%')
                ->orWhere('section', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('type', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_rule_count = Rule::query()
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('title', 'LIKE', '%' . $search . '%')
                ->orWhere('section', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('type', 'LIKE', '%' . $search . '%')
                ->count();


            /////////////// forms and precedents search //////////////////////

            $query_form['search'] = FormsPrecedence::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('category', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_form_count = FormsPrecedence::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('category', 'LIKE', '%' . $search . '%')
                ->count();


            /////////////// articles search //////////////////////

            $query_article['search'] = Article::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_article_count = Article::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->count();



            /////////////// public notes search //////////////////////
            $query_note['search'] = Annotation::query()
                ->where('content', 'LIKE', '%' . $search . '%')
                ->orWhere('comment', 'LIKE', '%' . $search . '%')
                ->where('display', 'public')
                ->where('resource_type', '!=', 'admin-note')
                ->orderBy('comment', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_note_count = Annotation::query()
                ->where('content', 'LIKE', '%' . $search . '%')
                ->orWhere('comment', 'LIKE', '%' . $search . '%')
                ->where('resource_type', '!=', 'admin-note')
                ->where('display', 'public')
                ->count();


            RecentActivity::create([
                'user_id' => Auth::user()->id,
                'type' => 'search',
                'name' => 'You recently made a search',
                'description' => $search,
            ]);


            $selected_year = [];
            $selected_year['judgement_date'] = '';

            return view('admin.search', compact('query_case', 'search', 'selected_year', 'first_search', 'second_search', 'query_law', 'query_case_count', 'query_law_count', 'query_rule', 'query_rule_count', 'query_form', 'query_form_count', 'query_article', 'query_article_count', 'query_note', 'query_note_count'));
        }

        if ($request->input('year_result')) {
            // $query_case['search'] = collect();
            $search = $request->input('year_result');
            $first_search = $request->input('search');
            $second_search = '';



            /////////////// Law of Federation search //////////////////////

            $query_law['table'] = 'lfn';
            $query_law['search'] = LawOfFederation::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%')
                ->orWhere('subsidiary_legislation', 'LIKE', '%' . $search . '%')
                ->orderBy('law_date', 'DESC')
                ->simplePaginate(5)
                ->withQueryString();
            // ->get();

            // dd($query_law['search']);
            $query_fed_count = LawOfFederation::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%')
                ->orWhere('subsidiary_legislation', 'LIKE', '%' . $search . '%')
                ->count();

            if (count($query_law['search']) < 1) {
                $query_law['table'] = 'sched';
                $query_law['search'] = LawOfFedSched::query()
                    ->where('sched_header', 'LIKE', '%' . $search . '%')
                    ->orWhere('sched_body', 'LIKE', '%' . $search . '%')
                    ->orderBy('sched_header', 'ASC')
                    ->simplePaginate(5)
                    ->withQueryString();
                // ->get();
            }

            $query_sched_count = LawOfFedSched::query()
                ->where('sched_header', 'LIKE', '%' . $search . '%')
                ->orWhere('sched_body', 'LIKE', '%' . $search . '%')
                ->count();

            if (count($query_law['search']) < 1) {
                $query_law['table'] = 'sec';
                $query_law['search'] = LawOfFedSection::query()
                    ->where('section_header', 'LIKE', '%' . $search . '%')
                    ->orWhere('section_body', 'LIKE', '%' . $search . '%')
                    ->orderBy('section_header', 'ASC')
                    ->simplePaginate(5)
                    ->withQueryString();
                // ->get();
            }
            $query_sec_count = LawOfFedSection::query()
                ->where('section_header', 'LIKE', '%' . $search . '%')
                ->orWhere('section_body', 'LIKE', '%' . $search . '%')
                ->count();

            // dd($query_sec_count);

            $query_law_count = $query_fed_count + $query_sched_count + $query_sec_count;



            /////////////// Rules of court and state rules search //////////////////////

            $query_rule['search'] = Rule::query()
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('title', 'LIKE', '%' . $search . '%')
                ->orWhere('section', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('type', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_rule_count = Rule::query()
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('title', 'LIKE', '%' . $search . '%')
                ->orWhere('section', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('type', 'LIKE', '%' . $search . '%')
                ->count();


            /////////////// forms and precedents search //////////////////////

            $query_form['search'] = FormsPrecedence::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('category', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_form_count = FormsPrecedence::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('category', 'LIKE', '%' . $search . '%')
                ->count();


            /////////////// articles search //////////////////////

            $query_article['search'] = Article::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_article_count = Article::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->count();



            /////////////// public notes search //////////////////////
            $query_note['search'] = Annotation::query()
                ->where('content', 'LIKE', '%' . $search . '%')
                ->orWhere('comment', 'LIKE', '%' . $search . '%')
                ->where('display', 'public')
                ->where('resource_type', '!=', 'admin-note')
                ->orderBy('comment', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_note_count = Annotation::query()
                ->where('content', 'LIKE', '%' . $search . '%')
                ->orWhere('comment', 'LIKE', '%' . $search . '%')
                ->where('resource_type', '!=', 'admin-note')
                ->where('display', 'public')
                ->count();

            if ($request->filled('year')) {
                $suitNumbers = JudgementSummary::query()->where('judgement_date', 'LIKE', '%' . $request->year . '%')->get()->pluck('suit_no');
                $query_case['table'] = 'ratio';
                $heading = SummaryRatio::whereIn('suit_no', $suitNumbers)->where('heading', 'LIKE', '%' . $search . '%')->orderByRaw('CHAR_LENGTH(heading)')->get();
                $body = SummaryRatio::whereIn('suit_no', $suitNumbers)->where('body', 'LIKE', '%' . $search . '%')->orderByRaw('CHAR_LENGTH(heading)')->get();
                $together = $heading->merge($body);
                $query_case_count = $together->count();
                $query_case['search'] =  $this->customPaginate($together)->withPath(url()->current())->withQueryString();
                $selected_year = [];
                $selected_year['judgement_date'] = $request->year;
                return view('admin.search', compact('query_case', 'search', 'selected_year', 'first_search', 'second_search', 'query_law', 'query_case_count', 'query_law_count', 'query_rule', 'query_rule_count', 'query_form', 'query_form_count', 'query_article', 'query_article_count', 'query_note', 'query_note_count'));
            }
            $query_case['table'] = 'ratio';
            $query_case['search'] = SummaryRatio::query()->where('heading', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                ->orderByRaw('CHAR_LENGTH(heading)')
                ->simplePaginate(15)
                ->withQueryString();


            $query_ratio_count = SummaryRatio::query()
                ->where('heading', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                ->count();
            $query_case_count = $query_ratio_count;

            $selected_year = [];
            $selected_year['judgement_date'] = '';
            return view('admin.search', compact('query_case', 'search', 'selected_year', 'first_search', 'second_search', 'query_law', 'query_case_count', 'query_law_count', 'query_rule', 'query_rule_count', 'query_form', 'query_form_count', 'query_article', 'query_article_count', 'query_note', 'query_note_count'));
        }

        if ($request->input('more_result')) {
            $search = $request->input('more_result');
            $second_search = $request->input('more_result');
            $first_search = '';

            /////////////// Judgement search //////////////////////

            $query_case['table'] = 'ratio';
            $query_case['search'] = SummaryRatio::query()->where('heading', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                ->orderByRaw('CHAR_LENGTH(heading)')
                ->simplePaginate(5)
                ->withQueryString();
            // ->get();


            $query_ratio_count = SummaryRatio::query()
                ->where('heading', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                ->count();

            if (count($query_case['search']) < 1) {
                $query_case['table'] = 'sum';
                $query_case['search'] = JudgementSummary::query()
                    ->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->orWhere('summary_of_facts', 'LIKE', '%' . $search . '%')
                    ->orWhere('issues', 'LIKE', '%' . $search . '%')
                    ->orderBy('judgement_date', 'DESC')
                    ->simplePaginate(5)
                    ->withQueryString();
            }

            $query_sum_count = JudgementSummary::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                ->orWhere('summary_of_facts', 'LIKE', '%' . $search . '%')
                ->orWhere('issues', 'LIKE', '%' . $search . '%')
                ->count();

            if (count($query_case['search']) < 1) {
                $query_case['table'] = 'judgement';
                $query_case['search'] = Judgement::query()
                    ->where('judgement', 'LIKE', '%' . $search . '%')
                    ->orderBy('judgement', 'DESC')
                    ->simplePaginate(5)
                    ->withQueryString();
                // ->get();
            }

            $query_judg_count = Judgement::query()
                ->where('judgement', 'LIKE', '%' . $search . '%')
                ->count();

            $query_case_count = $query_ratio_count + $query_judg_count + $query_sum_count;



            /////////////// Law of Federation search //////////////////////

            $query_law['table'] = 'lfn';
            $query_law['search'] = LawOfFederation::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%')
                ->orWhere('subsidiary_legislation', 'LIKE', '%' . $search . '%')
                ->orderBy('law_date', 'DESC')
                ->simplePaginate(5)
                ->withQueryString();
            // ->get();

            // dd($query_law['search']);
            $query_fed_count = LawOfFederation::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%')
                ->orWhere('subsidiary_legislation', 'LIKE', '%' . $search . '%')
                ->count();

            if (count($query_law['search']) < 1) {
                $query_law['table'] = 'sched';
                $query_law['search'] = LawOfFedSched::query()
                    ->where('sched_header', 'LIKE', '%' . $search . '%')
                    ->orWhere('sched_body', 'LIKE', '%' . $search . '%')
                    ->orderBy('sched_header', 'ASC')
                    ->simplePaginate(5)
                    ->withQueryString();
                // ->get();
            }

            $query_sched_count = LawOfFedSched::query()
                ->where('sched_header', 'LIKE', '%' . $search . '%')
                ->orWhere('sched_body', 'LIKE', '%' . $search . '%')
                ->count();

            if (count($query_law['search']) < 1) {
                $query_law['table'] = 'sec';
                $query_law['search'] = LawOfFedSection::query()
                    ->where('section_header', 'LIKE', '%' . $search . '%')
                    ->orWhere('section_body', 'LIKE', '%' . $search . '%')
                    ->orderBy('section_header', 'ASC')
                    ->simplePaginate(5)
                    ->withQueryString();
                // ->get();
            }
            $query_sec_count = LawOfFedSection::query()
                ->where('section_header', 'LIKE', '%' . $search . '%')
                ->orWhere('section_body', 'LIKE', '%' . $search . '%')
                ->count();

            // dd($query_sec_count);

            $query_law_count = $query_fed_count + $query_sched_count + $query_sec_count;



            /////////////// Rules of court and state rules search //////////////////////

            $query_rule['search'] = Rule::query()
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('title', 'LIKE', '%' . $search . '%')
                ->orWhere('section', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('type', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_rule_count = Rule::query()
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('title', 'LIKE', '%' . $search . '%')
                ->orWhere('section', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('type', 'LIKE', '%' . $search . '%')
                ->count();


            /////////////// forms and precedents search //////////////////////

            $query_form['search'] = FormsPrecedence::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('category', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_form_count = FormsPrecedence::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orWhere('category', 'LIKE', '%' . $search . '%')
                ->count();


            /////////////// articles search //////////////////////

            $query_article['search'] = Article::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->orderBy('title', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_article_count = Article::query()
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%')
                ->count();



            /////////////// public notes search //////////////////////
            $query_note['search'] = Annotation::query()
                ->where('content', 'LIKE', '%' . $search . '%')
                ->orWhere('comment', 'LIKE', '%' . $search . '%')
                ->where('display', 'public')
                ->where('resource_type', '!=', 'admin-note')
                ->orderBy('comment', 'ASC')
                ->simplePaginate()
                ->withQueryString();
            // ->get();

            $query_note_count = Annotation::query()
                ->where('content', 'LIKE', '%' . $search . '%')
                ->orWhere('comment', 'LIKE', '%' . $search . '%')
                ->where('display', 'public')
                ->where('resource_type', '!=', 'admin-note')
                ->count();

            $selected_year = [];
            $selected_year['judgement_date'] = '';

            return view('admin.search', compact('query_case', 'selected_year', 'search', 'first_search', 'second_search', 'query_law', 'query_case_count', 'query_law_count', 'query_rule', 'query_rule_count', 'query_form', 'query_form_count', 'query_article', 'query_article_count', 'query_note', 'query_note_count'));
        }


        /////////// for more year results////////////
        // if($request->filled('years')) {
        //     $suitNumbers = JudgementSummary::query()->where('judgement_date','LIKE', '%'.$request->year.'%')->get()->pluck('suit_no');

        //     $query_case['table'] = 'ratio';
        //     $heading = SummaryRatio::whereIn('suit_no', $suitNumbers)->where('heading', 'LIKE', '%'.$search.'%')->orderByRaw('CHAR_LENGTH(heading)')->get();
        //     $body = SummaryRatio::whereIn('suit_no', $suitNumbers)->where('body', 'LIKE', '%'.$search.'%')->orderByRaw('CHAR_LENGTH(heading)')->get();
        //     $together = $heading->merge($body);
        //     $query_ratio_count = $together->count();
        //     $query_case['search'] =  $together;
        //     // $query_case['search'] =  $this->customPaginate($together)->withPath(url()->current())->withQueryString();

        //     if(count($query_case['search']) < 1 || count($query_case['search']) > 1) {
        //         $query_case['table'] = 'sum';
        //         $query_case['search'] =  $query_case['search']->merge(JudgementSummary::query()
        //         ->where('judgement_date','LIKE', '%'.$request->year.'%')
        //         ->where('title', 'LIKE', '%'.$search.'%')
        //         ->orWhere('summary_of_facts', 'LIKE', '%'.$search.'%')
        //         ->orWhere('issues', 'LIKE', '%'.$search.'%')
        //         ->orderBy('judgement_date', 'DESC')
        //         // ->simplePaginate(5)
        //         // ->withQueryString();
        //         ->get());
        //     }

        //     $query_sum_count = JudgementSummary::query()
        //         ->where('judgement_date','LIKE', '%'.$request->year.'%')
        //         ->where('title', 'LIKE', '%'.$search.'%')
        //         ->orWhere('summary_of_facts', 'LIKE', '%'.$search.'%')
        //         ->orWhere('issues', 'LIKE', '%'.$search.'%')
        //         ->count();

        //     if(count($query_case['search']) < 1 || count($query_case['search']) > 1) {
        //         $query_case['table'] = 'judgement';
        //         $query_case['search'] = $query_case['search']->merge(Judgement::whereIn('suit_no', $suitNumbers)
        //         ->where('judgement', 'LIKE', '%'.$search.'%')
        //         ->orderBy('judgement', 'DESC')
        //         // ->simplePaginate(5)
        //         // ->withQueryString();
        //         ->get());
        //     }

        //     $query_judg_count = Judgement::whereIn('suit_no', $suitNumbers)
        //     ->where('judgement', 'LIKE', '%'.$search.'%')
        //     ->count();

        //     $query_case_count = $query_ratio_count + $query_judg_count + $query_sum_count;

        //     $query_case['search'] =  $this->customPaginate($query_case['search'])->withPath(url()->current())->withQueryString();

        //     // dd($query_case['search']->toArray());

        //     $selected_year = [];
        //     $selected_year['judgement_date'] = $request->year;
        //     return view('admin.search', compact('query_case', 'search', 'selected_year', 'first_search', 'second_search', 'query_law', 'query_case_count', 'query_law_count', 'query_rule', 'query_rule_count', 'query_form', 'query_form_count', 'query_article', 'query_article_count', 'query_note', 'query_note_count'));
        // }

    }


    ////not in use/////
    public function autocomplete(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $search = $request->input('search');
        $cases = SummaryRatio::query()
            ->where('heading', 'LIKE', '%' . $search . '%')
            ->orWhere('body', 'LIKE', '%' . $search . '%')
            ->orderBy('heading', 'ASC')
            ->get();
        return response()->json($cases);
    }



    ///////////////////////////////////////annotations//////////////////////////////////
    public function anote(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = [
            'user_id' => $request->user_id,
            'note_id' => $request->note_id,
            'content_id' => $request->content_id,
            'content_type' => $request->content_type,
            'content' => json_encode($request->content),
            'comment' => json_encode($request->comment),
            'replies' => $request->replies,
            'text_target' => $request->text_target,
            'tags' => $request->tags,
            'resource_type' => $request->resource_type,
        ];
        $anote = Annotation::create($input);

        RecentActivity::create([
            'user_id' => Auth::user()->id,
            'type' => 'note',
            'name' => 'You recently made a note',
            'description' => $anote->content
        ]);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);
        
        return response()->json([
            'success' => 'Note added',
            'anote' => json_decode($anote->content),
        ]);
    }
    public function updateAnote(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        // dd($request->all());
        $input = [
            'display' => $request->display
        ];
        DB::table('annotations')->where('note_id', $request->note_id)->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Note saved');
        // return response()->json(['success', 'Annotation added']);
    }
    public function shareAnote(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if ($request->has('share_all') && !empty($request->checkBoxArray)) {
            foreach ($request->checkBoxArray as $team) {
                $input = [
                    'team_id' => $team,
                    'user_id' => $request->user_id,
                    'anote_id' => $request->anote_id,
                    'comment_body' => $request->comment_body
                ];
                $comment = Comment::create($input);
            }
            RecentActivity::create([
                'user_id' => Auth::user()->id,
                'type' => 'shared noted',
                'name' => 'You recently shared a note',
                'description' => $comment->comment_body
            ]);
            return back()->with('success', 'Note shared');
        }
        return back()->withErrors('Please select a team to share to');
    }
    public function note()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $public_notes = Annotation::where('display', 'public')->where('resource_type', '!=', 'admin-note')->orderBy('created_at', 'DESC')->get();
        $public_note_count = $public_notes->count();
        $notes = Annotation::where('user_id', Auth::user()->id)->where('resource_type', '!=', 'admin-note')->orderBy('created_at', 'DESC')->get();
        $note_count = $notes->count();
        $admin_notes = Annotation::where('resource_type', 'admin-note')->orderBy('created_at', 'DESC')->get();
        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
        $admin_note_id = $this->generateAdminNoteId(21);
        return view('admin.notes', compact('public_notes', 'notes', 'public_note_count', 'note_count', 'teams', 'admin_note_id', 'admin_notes'));
    }
    public function generateAdminNoteId($length = 32)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function storeNote(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'comment' => 'required',
            'content' => 'required'
        ]);
        $input = $request->all();
        // dd($input);
        Annotation::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Note added');
    }
    public function updateNote(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'comment' => 'required',
            'content' => 'required'
        ]);
        $input = $request->all();
        // dd($input);
        DB::table('annotations')->where('id', $request->admin_note_id)->update($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Note updated');
    }
    public function deleteNote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $note = Annotation::findOrFail($id);
        $note->delete();

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Note deleted');
    }
    public function featureNote(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $note = Annotation::find($id);
        $input = $request->all();
        if ($request->has('make_featured')) {
            $note->update($input);
            return back()->with('success', 'Note featured');
        }
        if ($request->has('remove_featured')) {
            $note->update($input);
            return back()->with('success', 'Note not featured');
        }
    }
    public function rateNote(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        FeaturedContent::create($input);
        return back()->with('success', 'Review sent');
    }
    public function likeNote(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $input = $request->all();
        if ($request->annotation_id) {
            $like = Like::where('user_id', $request->user_id)->where('annotation_id', $request->annotation_id)->first();
            if ($like) {
                $like->update($input);
            } else {
                Like::create($input);
            }
            return response()->json(['success' => 'Note liked']);
        }
    }

    public function fetchAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $judgement_summary = JudgementSummary::whereId($id)->first();
        $suit_no = trim($judgement_summary->suit_no);
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $suit_no)->where('resource_type', 'judgement')->get();
        return response()->json([
            'anotes' => $anotes,
        ]);
    }



    ///////////////////////////////////////messages//////////////////////////////////
    public function message(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $messages = Message::where('type', 'normal')->orderBy('created_at', 'DESC')->get();
            $all_messages = Message::orderBy('created_at', 'DESC')->get();
            $message_count = $all_messages->count();
            $packages = Package::orderBy('name', 'ASC')->get();
            $user = User::query();
            if ($request->filled('end_date')) {
                $start_date = Carbon::parse($request->start_date)->toDateTimeString();
                $end_date = Carbon::parse($request->end_date)->toDateTimeString();
                $users = $user->whereBetween('active_date', [$start_date, $end_date])->orderBy('active_date', 'DESC')->simplePaginate(10)->withQueryString();
                $user_array = User::whereBetween('active_date', [$start_date, $end_date])->orderBy('active_date', 'DESC')->pluck('email')->toArray();
                $data_array = User::whereBetween('active_date', [$start_date, $end_date])->orderBy('active_date', 'DESC')->pluck('email', 'name')->toArray();
                $user_count = User::whereBetween('active_date', [$start_date, $end_date])->orderBy('active_date', 'DESC')->count();
            }
            if ($request->filled('status') && !$request->filled('package')) {
                if ($request->status == 'null') {
                    $users = $user->where('status', null)->orderBy('active_date', 'DESC')->simplePaginate(10)->withQueryString();
                    $user_array = User::where('status', null)->orderBy('active_date', 'DESC')->pluck('email')->toArray();
                    $data_array = User::where('status', null)->orderBy('active_date', 'DESC')->pluck('name', 'email')->toArray();
                    $user_count = User::where('status', null)->orderBy('active_date', 'DESC')->count();
                } else {
                    $users = $user->where('status', $request->status)->orderBy('active_date', 'DESC')->simplePaginate(10)->withQueryString();
                    $user_array = User::where('status', $request->status)->orderBy('active_date', 'DESC')->pluck('email')->toArray();
                    $data_array = User::where('status', $request->status)->orderBy('active_date', 'DESC')->pluck('name', 'email')->toArray();
                    $user_count = User::where('status', $request->status)->orderBy('active_date', 'DESC')->count();
                }

                $active_user_count = User::where('status', 'active')->count();
                $inactive_user_count = User::where('status', '=', null)->orWhere('status', '<>', 'active')->count();
                $selected_status = [];
                $selected_status['status'] = $request->status;
                $selected_package = [];
                $selected_package['package'] = '';
                return view('admin.messages.index', compact('all_messages', 'message_count', 'messages', 'users', 'user_array', 'data_array', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package'));
            }
            if (!$request->filled('status') && $request->filled('package')) {
                $package = Package::where('name', $request->package)->first();
                $users = $user->where('package_id', $package->id)->orderBy('active_date', 'DESC')->simplePaginate(10)->withQueryString();
                $user_array = User::where('package_id', $package->id)->orderBy('active_date', 'DESC')->pluck('email')->toArray();
                $data_array = User::where('package_id', $package->id)->orderBy('active_date', 'DESC')->pluck('email', 'name')->toArray();
                $user_count = User::where('package_id', $package->id)->orderBy('active_date', 'DESC')->count();
                $active_user_count = User::where('status', 'active')->where('package_id', $package->id)->count();
                $inactive_user_count = User::where('package_id', $package->id)->where('status', '<>', 'active')->count();
                $selected_status = [];
                $selected_status['status'] = '';
                $selected_package = [];
                $selected_package['package'] = $request->package;
                return view('admin.messages.index', compact('all_messages', 'message_count', 'messages', 'users', 'user_array', 'data_array', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package'));
            }
            if ($request->filled('status') && $request->filled('package')) {
                $package = Package::where('name', $request->package)->first();
                $users = $user->where('package_id', $package->id)->where('status', $request->status)->orderBy('active_date', 'DESC')->simplePaginate(10)->withQueryString();
                $user_array = User::where('package_id', $package->id)->where('status', $request->status)->orderBy('active_date', 'DESC')->pluck('email')->toArray();
                // dd($user_array);
                $data_array = User::where('package_id', $package->id)->where('status', $request->status)->orderBy('active_date', 'DESC')->pluck('email', 'name')->toArray();
                $user_count = User::where('package_id', $package->id)->orderBy('active_date', 'DESC')->count();
                // dd($user_count);
                $active_user_count = User::where('status', 'active')->where('package_id', $package->id)->count();
                $inactive_user_count = User::where('package_id', $package->id)->where('status', '<>', 'active')->count();
                $selected_status = [];
                $selected_status['status'] = $request->status;
                $selected_package = [];
                $selected_package['package'] = $request->package;
                return view('admin.messages.index', compact('all_messages', 'message_count', 'messages', 'users', 'user_array', 'data_array', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package'));
            }

            if ($request->search_customer) {
                $search = $request->search_customer;
                $user = User::query();
                $users = $user->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('surname', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orderBy('name', 'ASC')
                    ->simplePaginate(10)
                    ->withQueryString();

                $users_get = $user->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('surname', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orderBy('name', 'ASC')
                    ->get();

                $user_count = $user->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('surname', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orderBy('name', 'ASC')
                    ->count();
                $active_user_count = $users_get->where('status', 'active')->count();
                $inactive_user_count = $users_get->where('status', '!=', 'active')->count();
                $selected_status = [];
                $selected_status['status'] = '';
                $selected_package = [];
                $selected_package['package'] = '';
                $user_array = $user->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('surname', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orderBy('name', 'ASC')
                    ->pluck('email')->toArray();
                $data_array = $user->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('surname', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orderBy('name', 'ASC')
                    ->pluck('email', 'name')->toArray();
                return view('admin.messages.index', compact('all_messages', 'message_count', 'messages', 'users', 'user_array', 'data_array', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package'));
            }
            $users = User::orderBy('created_at', 'DESC')->simplePaginate(10)->withQueryString();
            $user_array = User::orderBy('created_at', 'DESC')->pluck('email')->toArray();
            $data_array = User::orderBy('created_at', 'DESC')->pluck('email', 'name')->toArray();
            $user_count = User::orderBy('created_at', 'DESC')->count();
            $active_user_count = User::orderBy('created_at', 'DESC')->where('status', 'active')->count();
            $inactive_user_count = User::orderBy('created_at', 'DESC')->where('status', '=', null)->orWhere('status', '<>', 'active')->count();
            $selected_status = [];
            $selected_status['status'] = '';
            $selected_package = [];
            $selected_package['package'] = '';
            return view('admin.messages.index', compact('all_messages', 'message_count', 'messages', 'users', 'user_array', 'data_array', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package'));
        }
        return redirect('admin/dashboard');
    }
    public function createMessage()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            return view('admin.messages.create');
        }
        return redirect('admin/dashboard');
    }
    public function storeMessage(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'body' => 'required',
            'type' => 'required',
            // 'receipient' => 'required',
            // 'receipient_type' => 'required',
        ]);
        $input = $request->all();
        // dd($input);
        Message::create($input);

        $version = Setting::first();
        $input = [
            'version' => $version->version + 0.1,
        ];
        $version->update($input);

        return back()->with('success', 'Message created');
    }
    public function sendMessages(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if ($request->has('send_single_message')) {
            if (!empty($request->message_id)) {
                if (!empty($request->checkBoxArray)) {

                    $message = Message::where('id', $request->message_id)->first();
                    $input = [
                        'users' => json_encode($request->checkBoxArray),
                        'message_id' => $request->message_id,
                        'content' => json_encode([$message->name, $message->subject, $message->body])
                    ];
                    MailMessage::create($input);

                    $newUsersEmail = User::whereIn('id', $request->checkBoxArray)->get(['name', 'email'])->toArray();

                    $user = [];
                    foreach ($newUsersEmail as $key => $value) {
                        $user[] = $value['name'] . '|' . $value['email'];
                    }

                    // Notification::send($newUsers, new NewMessage($message, $newUsers));

                    $explodedMails = implode(',', $user);

                    $newContent =  [
                        'body' => strip_tags($message->body),
                    ];

                    $content = view("emails.mainMessage", $newContent)->render();

                    tribearcMail($message->subject, $content, $explodedMails);

                    return back()->with('success', 'Message sent!');
                }
                return back()->with('error1', 'Please select a user to send a message to');
            }
            return back()->with('error1', 'Please select a message to send');
        }

        if ($request->has('send_multiple_message')) {
            if (!empty($request->message_id)) {
                if (!empty($request->checkBoxArray)) {

                    $message = Message::where('id', $request->message_id)->first();
                    $input = [
                        'users' => $request->users,
                        'message_id' => $request->message_id,
                        'content' => json_encode([$message->name, $message->subject, $message->body])
                    ];
                    MailMessage::create($input);
                    $users = json_decode($request->users); // users emails only
                    $data = (array) json_decode($request->data); // users emails and names

                    $chunked_users = array_chunk($data, 500, true);  // chunk the array to 500 users per send

                    foreach ($chunked_users as $single_chunk) {

                        $user = [];
                        foreach ($single_chunk as $key => $value) {
                            $user[] = $value . '|' . $key;
                        }

                        $explodedMails = implode(',', $user);

                        $newContent =  [
                            'body' => strip_tags($message->body),
                        ];

                        $content = view("emails.mainMessage", $newContent)->render();

                        tribearcMail($message->subject, $content, $explodedMails);
                    }


                    return back()->with('success', 'Messages are being sent');
                    // Session::flash('success1', 'Messages are being sent');
                    // return redirect()->route('send.bulk');
                }
                return back()->with('error1', 'Please select a user to send a message to');
            }
            return back()->with('error1', 'Please select a message to send');
        }
    }

    public function sendBulk(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $message = MailMessage::orderBy('created_at', 'DESC')->first();
        dd($message);
        $details = [
            'subject' => $message->content,
            'body' => 'How far'
        ];

        $users = json_decode($request->users);
        // dd($users);

        // send all mail in the queue.
        $job = (new SendBulkQueueEmail($details, $users))
            ->delay(
                now()
                    ->addSeconds(1)
            );

        dispatch($job);

        echo "Bulk mail send successfully in the background...";








        // return back()->with('success', 'Messages are being sent');

    }
    ///////send new subscribers to active campaign subscriber list//////
    public function sendEmail()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ivendmc.api-us1.com/api/3/contacts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "contact": {
                "email": "akpanemmanueledidiong99@yahoo.com",
                "firstName": "Edidiong",
                "lastName": "Akpan",
                "phone": "08127131208"
            }
        }',
            CURLOPT_HTTPHEADER => array(
                'Api-Token: 9bb4a3a2a06332474aeb0909b0e624411f1f652e1b61be8acb80b278e0d711e92462dbea',
                'Content-Type: application/json',
                'Cookie: PHPSESSID=f5fe8b31b9008a5c64608178b66b5a27; em_acp_globalauth_cookie=df1330e2-35cc-4d82-8e34-4e6f7e895792'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function editMessage($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $message = Message::findOrFail($id);
            return view('admin.messages.edit', ['message' => $message]);
        }
        return redirect('admin/dashboard');
    }
    public function updateMessage(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $message = Message::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'body' => 'required',
            'type' => 'required',
            // 'receipient' => 'required',
            // 'receipient_type' => 'required',
        ]);
        $input = $request->all();
        $message->update($input);
        return back()->with('success', 'Message updated');
    }
    public function deleteMessage($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $message = Message::find($id);
        $mail_message = MailMessage::where('message_id', $message->id)->delete();
        $message->delete();
        return back()->with('success', 'Message deleted');
    }



    ///////////////////////////////////////licenses//////////////////////////////////
    public function license()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        if (Auth::user()->role->name == 'Admin') {
            $licenses = License::orderBy('license_name', 'asc')->get();
            $packages = Package::orderBy('name', 'ASC')->get();
            return view('admin.licenses.index', compact('licenses', 'packages'));
        }
        return redirect('admin/dashboard');
    }
    public function storeLicense(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'license_name' => 'required',
            'license_days' => 'required',
            'licensed_organisation' => 'required',
            'licensed_email' => 'required|email',
            'license_code' => 'required',
            'active_users' => 'required',
            'package_id' => 'required'
        ]);
        if (User::where('email', $request->licensed_email)->first()) {
            return back()->withErrors('This email already exists');
        }
        $input = [
            'license_name' => $request->license_name,
            'license_days' => $request->license_days,
            'licensed_organisation' => $request->licensed_organisation,
            'licensed_email' => $request->licensed_email,
            'license_code' => $request->license_code,
            'active_users' => $request->active_users,
            'package' => $request->package,
            'package_id' => $request->package_id,
        ];
        $license = License::create($input);
        $role = Role::where('name', 'Customer')->first();
        $user_input = [
            'name' => $license->licensed_organisation,
            'password' => bcrypt($license->license_code),
            'email' => $license->licensed_email,
            'license_code' => $license->license_code,
            'package_id' => $license->package_id,
            'role_id' => $role->id,
            'active_date' => $license->created_at,
            'expiry_date' => $license->created_at->addDays($license->license_days),
        ];
        $exp = $license->created_at->addDays($license->license_days);
        if ($exp > now()) {
            $user_input['status'] = 'active';
        } else {
            $user_input['status'] = 'inactive';
        }
        $user_creds = User::create($user_input);
        $licensed_user = User::where('license_code', $license->license_code)->first();
        if ($licensed_user) {
            // $licensed_user->notify(new LicenseCredentials($user_creds, $licensed_user));

            $explodedMails = $licensed_user->email;

            $subject = 'License Credentials';
            $newContent =  [
                'user' => $licensed_user->name,
                'email' => $licensed_user->email,
                'code' => $user_creds->license_code,
                'validity' => $license->license_days,
            ];

            $content = view("emails.licensedEmail", $newContent)->render();

            tribearcSendMail($subject, $content, $explodedMails);
        }
        return back()->with('success', 'License created');
    }
    public function updateLicense(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $validated = $request->validate([
            'license_name' => 'required',
            'license_days' => 'required',
            'licensed_organisation' => 'required',
            'licensed_email' => 'required',
            'license_code' => 'required',
            'active_users' => 'required',
            'package_id' => 'required',
        ]);
        $input = [
            'license_name' => $request->license_name,
            'license_days' => $request->license_days,
            'licensed_organisation' => $request->licensed_organisation,
            'licensed_email' => $request->licensed_email,
            'license_code' => $request->license_code,
            'active_users' => $request->active_users,
            'package' => $request->package,
            'package_id' => $request->package_id,
        ];
        DB::table('licenses')->where('id', $request->license_id)->update($input);
        $license =  License::where('id', $request->license_id)->first();
        $user = User::where('email', $license->licensed_email)->first();
        $user->name = $license->licensed_organisation;
        $user->password = bcrypt($license->license_code);
        $user->license_code = $license->license_code;
        $user->package_id = $license->package_id;
        $user->expiry_date = $license->created_at->addDays($license->license_days);

        $exp = $license->created_at->addDays($license->license_days);
        if ($exp > now()) {
            $user_input['status'] = 'active';
        } else {
            $user_input['status'] = 'inactive';
        }
        $user->save();
        $licensed_user = User::where('license_code', $license->license_code)->first();
        if ($licensed_user) {
            // $licensed_user->notify(new UpdatedLicenseCredentials($user, $licensed_user));

            $explodedMails = $licensed_user->email;

            $subject = 'Updated License Credentials';
            $newContent =  [
                'user' => $licensed_user->name,
                'email' => $licensed_user->email,
                'code' => $user->license_code,
                'validity' => $license->license_days,
            ];

            $content = view("emails.updatedLicensedEmail", $newContent)->render();

            tribearcSendMail($subject, $content, $explodedMails);
        }
        return back()->with('success', 'License updated');
    }
    public function deleteLicense($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $license = License::findOrFail($id);
        $user = User::where('license_code', $license->license_code)->first();
        LicensedUserSession::where('user_id', $user->id)->delete();
        $user->delete();
        $license->delete();
        return back()->with('success', 'License deleted');
    }



    ///////////////////////////////////////checkout//////////////////////////////////
    public function checkout($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $package = Package::where('id', $id)->first();
        return view('checkout', compact('package'));
    }
    public function checkoutDiscount($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $package = Package::where('id', $id)->first();
        $discount = Discount::where('package_id', $package->id)->first();
        $discounted_price = ($package->price * $discount->percentage) / 100;
        $new_price = $package->price - $discounted_price;
        return view('checkout.discount', compact('package', 'new_price'));
    }




    ///////////////////////////////////////pricing//////////////////////////////////
    public function pricing()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $packages = Package::where('is_active', 1)->orderBy('price', 'ASC')->get();
        return view('admin.pricing', compact('packages'));
    }


    ///////////////////////////////////////send report//////////////////////////////////
    public function sendReport(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'report_type' => 'required',
        ]);
        if (!isset($request->report_type)) {
            return back()->withErrors('error', 'Please select a report type');
        }
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'report_type' => $request->report_type,
            'report_message' => strip_tags($request->report_message),
            'other_message' => strip_tags($request->other_message),
        ];
        $report = Report::create($input);
        // Notification::route('mail', $request->input('to_email'))->notify(new NewReport($report, $user));
        // $user->notify(new LegalpediaReport($user));
        $explodedMails = $request->to_email;
        $explodedMail =  $report->email;

        $subject = 'New Report';
        $newsubject = 'Legalpedia Report';
        $newContent =  [
            'user' => $report->name,
            'email' => $report->email,
            'report_type' => $report->report_type,
            'report_message' => $report->report_message,
            'other_message' => $report->other_message,
        ];
        $getContent = [
            'user' => $report->name
        ];
        $content = view("emails.newReport", $newContent)->render();
        $usercontent = view("emails.legapediaReport", $getContent)->render();

        tribearcSendMail($subject, $content, $explodedMails); // send to admin
        tribearcSendMail($newsubject, $usercontent, $explodedMail); // send to user

        return back()->with('success', 'Report sent, We\'ll get to you shortly');
    }
}
