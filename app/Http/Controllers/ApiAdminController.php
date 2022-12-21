<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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


class ApiAdminController extends Controller
{
    public function index(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
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
            $package = Package::where('id', Auth::user()->package_id)->first();
            return response(["judgement_count" => $judgement_count, 'fed_count' => $fed_count, "rule_count" => $rule_count, "form_count" => $form_count, "article_count" => $article_count, "dict_count" => $dict_count, "maxim_count" => $maxim_count, "resource_count" => $resource_count, "all_count" => $all_count, "team_count" => $team_count, "latest_judgements" => $latest_judgements, "notes" => $notes, "admin_notes" => $admin_notes, "recent_activities" => $recent_activities, "teams" => $teams, "pop_message" => $pop_message, "new_chat_count" => $new_chat_count, "featured_user" => $featured_user, "featured_team" => $featured_team, "featured_article" => $featured_article, "featured_form" => $featured_form, "featured_note" => $featured_note]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    //////////////////////////////////judgement//////////////////////////////////////
    public function judgement(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $courts = Court::orderBy('rank', 'ASC')->paginate(10);
                DB::statement("SET SQL_MODE=''");
                $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->paginate(10);
                $categories = Category::orderBy('category', 'asc')->paginate(10);
                $judgement_summary = JudgementSummary::query();
                if ($request->filled('id') && !$request->filled('year')) {
                    $judge = $judgement_summary->where('court_id', $request->id);
                    $judgement_count = $judge->count();
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $selected_year = [];
                    $selected_year['judgement_date'] = '';
                    $selected_court = [];
                    $selected_court['court_id'] = $request->id;
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                }
                if (!$request->filled('id') && $request->filled('year')) {
                    $judge = $judgement_summary->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                    $judgement_count =  $judge->count();
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $selected_year = [];
                    $selected_year['judgement_date'] = $request->year;
                    $selected_court = [];
                    $selected_court['court_id'] = '';
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                }
                if ($request->filled('id') && $request->filled('year')) {
                    $judge = $judgement_summary->where('court_id', $request->id)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                    $judgement_count =  $judge->count();
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $selected_year = [];
                    $selected_year['judgement_date'] = $request->year;
                    $selected_court = [];
                    $selected_court['court_id'] = $request->id;
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                }
                if ($request->search_case) {
                    $search = $request->search_case;
                    $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                    $judgement_count =  $judge->count();
                    $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                        ->orderBy('judgement_date', 'DESC')
                        ->paginate(10)
                        ->withQueryString();
                    $selected_court = [];
                    $selected_court['court_id'] = '';
                    $selected_year = [];
                    $selected_year['judgement_date'] = '';
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                }
                $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                $judgement_count = JudgementSummary::orderBy('judgement_date', 'DESC')->count();
                $selected_court = [];
                $selected_court['court_id'] = '';
                $selected_year = [];
                $selected_year['judgement_date'] = '';
                return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->judgement_feature) {
                        $courts = Court::orderBy('rank', 'ASC')->paginate(10);
                        $years = Package::where('id', Auth::user()->package_id)->first();
                        $year_range = range($years->judg_start_year, $years->judg_end_year);
                        $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->paginate(10);
                        $categories = Category::orderBy('category', 'asc')->paginate(10);
                        $judgement_summary = JudgementSummary::query();
                        if ($request->filled('id') && !$request->filled('year')) {
                            $judge = $judgement_summary->where('court_id', $request->id);
                            $judgement_count = $judge->count();
                            $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                            $selected_year = [];
                            $selected_year['judgement_date'] = '';
                            $selected_court = [];
                            $selected_court['court_id'] = $request->id;
                            return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'year_range' => $year_range, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                        }
                        if (!$request->filled('id') && $request->filled('year')) {
                            $judge = $judgement_summary->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                            $judgement_count =  $judge->count();
                            $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                            $selected_year = [];
                            $selected_year['judgement_date'] = $request->year;
                            $selected_court = [];
                            $selected_court['court_id'] = '';
                            return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'year_range' => $year_range, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                        }
                        if ($request->filled('id') && $request->filled('year')) {
                            $judge = $judgement_summary->where('court_id', $request->id)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                            $judgement_count =  $judge->count();
                            $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                            $selected_year = [];
                            $selected_year['judgement_date'] = $request->year;
                            $selected_court = [];
                            $selected_court['court_id'] = $request->id;
                            return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'year_range' => $year_range, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                        }
                        if ($request->search_case) {
                            $search = $request->search_case;
                            $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                                ->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                            $judgement_count =  $judge->count();
                            $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                                ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                                ->orderBy('judgement_date', 'DESC')
                                ->paginate(10)
                                ->withQueryString();
                            $selected_court = [];
                            $selected_court['court_id'] = '';
                            $selected_year = [];
                            $selected_year['judgement_date'] = '';
                            return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'year_range' => $year_range, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                        }
                        $start_date = date('Y-m-d H:i:s', strtotime($years ? $years->judg_start_year . '-01-00 24:00:00' : ''));
                        $end_date = date('Y-m-d H:i:s', strtotime($years ? $years->judg_end_year . '-12-31 00:00:00' : ''));
                        $judgement_summaries = JudgementSummary::whereBetween('judgement_date', [$start_date, $end_date])->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                        $judgement_count = JudgementSummary::whereBetween('judgement_date', [$start_date, $end_date])->count();
                        $selected_court = [];
                        $selected_court['court_id'] = '';
                        $selected_year = [];
                        $selected_year['judgement_date'] = '';
                        // dd($judgement_summaries, 'api');
                        return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'year_range' => $year_range, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function years()
    {
        if (Auth::user()->subscribedUser()) {
            $years = Package::where('id', Auth::user()->package_id)->first();
            $year_range = range($years->judg_start_year, $years->judg_end_year);
            return response(['year_range' => $year_range]);
        }
    }

    public function allJudgement(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        try {
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $courts = Court::orderBy('rank', 'ASC')->get();
            $categories = Category::orderBy('category', 'asc')->get();
            $judgement_summary = JudgementSummary::query();
            if ($request->filled('id') && !$request->filled('year')) {
                $judge = $judgement_summary->where('court_id', $request->id);
                $judgement_count = $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->get();
                $selected_year = [];
                $selected_year['judgement_date'] = '';
                $selected_court = [];
                $selected_court['court_id'] = $request->id;
                return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
            }
            if (!$request->filled('id') && $request->filled('year')) {
                $judge = $judgement_summary->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->get();
                $selected_year = [];
                $selected_year['judgement_date'] = $request->year;
                $selected_court = [];
                $selected_court['court_id'] = '';
                return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
            }
            if ($request->filled('id') && $request->filled('year')) {
                $judge = $judgement_summary->where('court_id', $request->id)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->get();
                $selected_year = [];
                $selected_year['judgement_date'] = $request->year;
                $selected_court = [];
                $selected_court['court_id'] = $request->id;
                return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
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
                return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
            }
            $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->get();
            $judgement_count = JudgementSummary::count();
            $selected_court = [];
            $selected_court['court_id'] = '';
            $selected_year = [];
            $selected_year['judgement_date'] = '';
            return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sbjMatter(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
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
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $selected_subject_matter = [];
                    $selected_subject_matter['subject_matter_index'] = $request->subject_matter_index;
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);
                }
                if ($request->search_case) {
                    $search = $request->search_case;
                    $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                    $judgement_count =  $judge->count();
                    $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                        ->orderBy('judgement_date', 'DESC')
                        ->paginate(10)
                        ->withQueryString();
                    $selected_subject_matter = [];
                    $selected_subject_matter['subject_matter_index'] = '';
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);
                }
                $count = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->paginate(10);
                $judgement_count = $count->count();
                $judgement_summaries = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->paginate(10)->withQueryString();
                $selected_subject_matter = [];
                $selected_subject_matter['subject_matter_index'] = '';
                // dd('fsdf');
                return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $courts = Court::orderBy('rank', 'ASC')->paginate(10);
                    $years = Package::where('id', Auth::user()->package_id)->first();
                    $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->paginate(10);
                    $categories = Category::orderBy('category', 'asc')->paginate(10);
                    $subject_matter_indices = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->paginate(10);
                    $judgement_summary = JudgementSummary::query();
                    if ($request->search_case) {
                        $search = $request->search_case;
                        $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                            ->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                        $judgement_count =  $judge->count();
                        $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                            ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                            ->orderBy('judgement_date', 'DESC')
                            ->paginate(10)
                            ->withQueryString();
                        $selected_subject_matter = [];
                        $selected_subject_matter['subject_matter_index'] = '';
                        return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);
                    }
                    $count = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->get();
                    $judgement_count = $count->count();
                    $judgement_summaries = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->simplePaginate()->withQueryString();
                    $judge_summary = [];
                    if (count($judgement_summaries) > 0) {
                        foreach ($judgement_summaries as $judge) {
                            $judgement_sum  = JudgementSummary::where('suit_no', $judge->suit_no)->first();
                            $judge_summary[] = $judgement_sum->paginate(10);
                        }
                    }

                    $selected_subject_matter = [];
                    $selected_subject_matter['subject_matter_index'] = '';
                    //  dd($judgement_summaries, 'api');
                    return response(['judge_summary' => $judge_summary, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);
                }
                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function filterSbj(Request $request)
    {
        $judgement_summary = JudgementSummary::query();
        if ($request->filled('subject_matter_index')) {
            $sbj = SubjectMatterIndex::where('subject_matter_index', $request->subject_matter_index)->first();
            $principle = Principle::where('subject_matter_index_id', $sbj->id)->first();
            $judg_principle = JudgementPrinciple::where('principle_id', $principle ? $principle->id : '')->first();
            $judge = $judgement_summary->where('suit_no', $judg_principle->suit_no);
            $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->get();
            $selected_subject_matter = [];
            $selected_subject_matter['subject_matter_index'] = $request->subject_matter_index;
            return response(['judgement_summaries' => $judgement_summaries,]);
        }
    }

    public function subject_matter_indices()
    {
        $subject_matter_indices = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->get();
        $courts = Court::get();
        return response(['subject_matter_indices' => $subject_matter_indices, 'courts' => $courts,]);
    }

    public function allSbjMatter(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        try {
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
                $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->get();
                $selected_subject_matter = [];
                $selected_subject_matter['subject_matter_index'] = $request->subject_matter_index;
                return response(['judgement_summaries' => $judgement_summaries, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);
            }
            if ($request->search_case) {
                $search = $request->search_case;
                $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->orderBy('judgement_date', 'DESC')
                    ->get();
                $selected_subject_matter = [];
                $selected_subject_matter['subject_matter_index'] = '';
                return response(['judgement_summaries' => $judgement_summaries, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);
            }
            $count = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->get();
            $judgement_count = $count->count();
            $selected_subject_matter = [];
            $selected_subject_matter['subject_matter_index'] = '';
            $judgement_summaries = JudgementPrinciple::select('suit_no')->groupBy('suit_no')->get();
            $judge_summary = [];
            if (count($judgement_summaries) > 0) {
                foreach ($judgement_summaries as $judge) {
                    $judgement_sum  = JudgementSummary::where('suit_no', $judge->suit_no)->first();
                    $judge_summary[] = $judgement_sum;
                }
            }
            return response(['judge_summary' => $judge_summary, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function legalCitation(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $courts = Court::orderBy('court', 'ASC')->paginate(10);
                DB::statement("SET SQL_MODE=''");
                $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->paginate(10);
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->paginate(10);
                $categories = Category::orderBy('category', 'asc')->paginate(10);
                if ($request->search_case) {
                    $search = $request->search_case;
                    $judge = JudgementSummary::where('title', 'LIKE', '%' . $search . '%')->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                    $judgement_count =  $judge->count();
                    $judgement_summaries = JudgementSummary::where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                        ->orderBy('judgement_date', 'DESC')
                        ->paginate(10)
                        ->withQueryString();
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws]);
                }
                $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                $judgement_count = JudgementSummary::orderBy('judgement_date', 'DESC')->count();
                return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $courts = Court::orderBy('rank', 'ASC')->paginate(10);
                    $years = Package::where('id', Auth::user()->package_id)->first();
                    $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->paginate(10);
                    $categories = Category::orderBy('category', 'asc')->paginate(10);
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
                            ->paginate(10)
                            ->withQueryString();
                        return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws]);
                    }
                    $judgement_summaries = JudgementSummary::whereBetween('judgement_date', [$start_date, $end_date])->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $judgement_count = JudgementSummary::whereBetween('judgement_date', [$start_date, $end_date])->count();
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws]);
                }
                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allLegalCitation(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };
        try {

            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
            $categories = Category::orderBy('category', 'asc')->get();

            if ($request->search_case) {
                $search = $request->search_case;
                $judge = JudgementSummary::query()->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%');
                $judgement_count =  $judge->count();
                $judgement_summaries = JudgementSummary::query()->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
                    ->orderBy('judgement_date', 'DESC')
                    ->get();
                return response(['judgement_summaries' => $judgement_summaries, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws]);
            }
            $judgement_summaries = JudgementSummary::orderBy('judgement_date', 'DESC')->get();
            $judgement_count = JudgementSummary::count();
            return response(['judgement_summaries' => $judgement_summaries, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function allNoSummary(Request $request)
    // {
    //     if (checkUser() == false) {
    //         Session::flash('error', 'You have been logged out by another user');
    //         return redirect('/login')->withErrors('You have been logged out by another user');
    //     };

    //     try {
    //         if (Auth::user()->role->name == 'Admin') {

    //             $courts = Court::orderBy('rank', 'ASC')->get();
    //             DB::statement("SET SQL_MODE=''");
    //             $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
    //             $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
    //             $categories = Category::orderBy('category', 'asc')->get();
    //             $judgement_summary = JudgementSummary::query();
    //             if ($request->filled('id') && !$request->filled('year')) {
    //                 $judge = $judgement_summary->where('summary_of_facts', NULL)->where('court_id', $request->id);
    //                 $judgement_count = $judge->count();
    //                 $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
    //                 $selected_year = [];
    //                 $selected_year['judgement_date'] = '';
    //                 $selected_court = [];
    //                 $selected_court['court_id'] = $request->id;
    //                 return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
    //             }
    //             if (!$request->filled('id') && $request->filled('year')) {
    //                 $judge = $judgement_summary->where('summary_of_facts', NULL)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
    //                 $judgement_count =  $judge->count();
    //                 $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
    //                 $selected_year = [];
    //                 $selected_year['judgement_date'] = $request->year;
    //                 $selected_court = [];
    //                 $selected_court['court_id'] = '';
    //                 return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
    //             }
    //             if ($request->filled('id') && $request->filled('year')) {
    //                 $judge = $judgement_summary->where('summary_of_facts', NULL)->where('court_id', $request->id)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
    //                 $judgement_count =  $judge->count();
    //                 $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
    //                 $selected_year = [];
    //                 $selected_year['judgement_date'] = $request->year;
    //                 $selected_court = [];
    //                 $selected_court['court_id'] = $request->id;
    //                 return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
    //             }
    //             if ($request->search_case) {
    //                 $search = $request->search_case;
    //                 $judge = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
    //                     ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
    //                     ->where('summary_of_facts', NULL);
    //                 $judgement_count =  $judge->count();
    //                 $judgement_summaries = $judgement_summary->where('title', 'LIKE', '%' . $search . '%')
    //                     ->orWhere('suit_no', 'LIKE', '%' . $search . '%')
    //                     ->where('summary_of_facts', NULL)
    //                     ->orderBy('judgement_date', 'DESC')
    //                     ->simplePaginate()
    //                     ->withQueryString();
    //                 $selected_court = [];
    //                 $selected_court['court_id'] = '';
    //                 $selected_year = [];
    //                 $selected_year['judgement_date'] = '';
    //                 return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
    //             }
    //             $judgement_summaries = JudgementSummary::where('summary_of_facts', NULL)->orderBy('judgement_date', 'DESC')->simplePaginate()->withQueryString();
    //             $judgement_count = JudgementSummary::where('summary_of_facts', NULL)->count();
    //             $selected_court = [];
    //             $selected_court['court_id'] = '';
    //             $selected_year = [];
    //             $selected_year['judgement_date'] = '';
    //             return view('admin.judgements.no-summary', compact('judgement_summaries', 'courts', 'years', 'judgement_count', 'categories', 'selected_court', 'area_of_laws', 'selected_year'));
    //         }
    //         return redirect('admin/judgements');
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function noSummary(Request $request)
    {
        // dd($request->all());
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {

                $courts = Court::orderBy('rank', 'ASC')->paginate(10);
                DB::statement("SET SQL_MODE=''");
                $years = JudgementSummary::orderBy('judgement_date', 'ASC')->groupBy('judgement_date')->get();
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->paginate(10);
                $categories = Category::orderBy('category', 'asc')->paginate(10);
                $judgement_summary = JudgementSummary::query();
                if ($request->filled('id') && !$request->filled('year')) {
                    $judge = $judgement_summary->where('summary_of_facts', NULL)->where('court_id', $request->id);
                    $judgement_count = $judge->count();
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $selected_year = [];
                    $selected_year['judgement_date'] = '';
                    $selected_court = [];
                    $selected_court['court_id'] = $request->id;
                    return response((['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]));
                }
                if (!$request->filled('id') && $request->filled('year')) {
                    $judge = $judgement_summary->where('summary_of_facts', NULL)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                    $judgement_count =  $judge->count();
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $selected_year = [];
                    $selected_year['judgement_date'] = $request->year;
                    $selected_court = [];
                    $selected_court['court_id'] = '';
                    return response((['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]));
                }
                if ($request->filled('id') && $request->filled('year')) {
                    $judge = $judgement_summary->where('summary_of_facts', NULL)->where('court_id', $request->id)->where('judgement_date', 'LIKE', '%' . $request->year . '%');
                    $judgement_count =  $judge->count();
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $selected_year = [];
                    $selected_year['judgement_date'] = $request->year;
                    $selected_court = [];
                    $selected_court['court_id'] = $request->id;
                    return response((['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]));
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
                        ->paginate(10)
                        ->withQueryString();
                    $selected_court = [];
                    $selected_court['court_id'] = '';
                    $selected_year = [];
                    $selected_year['judgement_date'] = '';
                    return response((['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]));
                }
                $judgement_summaries = JudgementSummary::where('summary_of_facts', NULL)->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                $judgement_count = JudgementSummary::where('summary_of_facts', NULL)->count();
                $selected_court = [];
                $selected_court['court_id'] = '';
                $selected_year = [];
                $selected_year['judgement_date'] = '';
                return response((['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'selected_court' => $selected_court, 'area_of_laws' => $area_of_laws, 'selected_year' => $selected_year]));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'redirect to admin/judgements']);
    }

    public function create(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $courts = Court::orderBy('court', 'ASC')->paginate(10);
                $categories = Category::orderBy('category', 'ASC')->paginate(10);
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->paginate(10);
                $subject_matters = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->paginate(10);
                $party_a_types = PartyAType::orderBy('party_a_type', 'ASC')->paginate(10);
                $party_b_types = PartyBType::orderBy('party_b_type', 'ASC')->paginate(10);
                return response(['courts' => $courts, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matters' => $subject_matters, 'party_a_types' => $party_a_types, 'party_b_types' => $party_b_types]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'redirect to admin/judgements']);
    }

    public function storeJudgement(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

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
            // return back()->withErrors('A judgement with this suit no already exists');
            return response(['error' => 'A judgement with this suit no already exists']);
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

        // return back()->with('success', 'Judgement added');
        return response(['success' => 'Judgement added']);
    }

    public function updateJudgement(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
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
                    // return back()->with('success', 'Principle removed');
                    return response(['success' => 'Principle removed']);
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
                    // return back()->with('success', 'Coram removed');
                    return response(['success' => 'Coram removed']);
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
                    // return back()->with('success', 'Ratio removed');
                    return response(['success' => 'Ratio removed']);
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

        // return back()->with('success', 'Judgement updated');
        return response(['success' => 'Judgement updated']);
    }

    public function editJudgement($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        if (Auth::user()->role->name == 'Admin') {
            $judgement_summary = JudgementSummary::findOrFail($id);
            $courts = Court::orderBy('rank', 'ASC')->paginate(10);
            $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->paginate(10);
            $categories = Category::orderBy('category', 'ASC')->paginate(10);
            $subject_matters = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->paginate(10);
            $party_a_types = PartyAType::orderBy('party_a_type', 'ASC')->paginate(10);
            $party_b_types = PartyBType::orderBy('party_b_type', 'ASC')->paginate(10);
            return response(['judgement_summary' => $judgement_summary, 'courts' => $courts, 'area_of_laws' => $area_of_laws, 'categories' => $categories, 'subject_matters' => $subject_matters, 'party_a_types' => $party_a_types, 'party_b_types' => $party_b_types]);
        }
        // return redirect('admin/judgements');
        return response(['redirect: redirect admin/judgement']);
    }

    public function showJudgement($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
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
                return response(['judgement_summary' => $judgement_summary, 'courts' => $courts, 'years' => $years, 'corams' => $corams, 'judgement_coram' => $judgement_coram, 'area_of_laws' => $area_of_laws, 'notes' => $notes, 'admin_notes' => $admin_notes, 'teams' => $teams]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $judgement_summary = JudgementSummary::with('areaOfLaw')->findOrFail($id);
                    $courts = Court::orderBy('rank', 'ASC')->get();
                    $court_name = Court::where('id', $judgement_summary->court_id)->first();
                    $holden = Holden::where('id', $judgement_summary->holden_at_id)->first();
                    DB::statement("SET SQL_MODE=''");
                    $judg_coram = JudgementCoram::with('coram')->where('suit_no', $judgement_summary->suit_no)->get();
                    $judgement_coram = JudgementCoram::select('suit_no')->first();
                    $notes = Annotation::where('user_id', Auth::user()->id)->where('content_id', 'LIKE', '%' . trim($judgement_summary->suit_no) . '%')->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    $party_a_name = JudgementPartyA::where('suit_no', $judgement_summary->suit_no)->first();
                    $party_a_type = PartyAType::where('id', $judgement_summary->party_a_type_id)->first();
                    $party_b_name = JudgementPartyB::where('suit_no', $judgement_summary->suit_no)->first();
                    $party_b_type = PartyBType::where('id', $judgement_summary->party_b_type_id)->first();
                    $ratios = SummaryRatio::where('suit_no', $judgement_summary->suit_no)->get();
                    $full_judgement = Judgement::where('suit_no', 'LIKE', '%' . $judgement_summary->suit_no . '%')->first();
                    $counsels = JudgementCounsel::where('suit_no', $judgement_summary->suit_no)->first();

                    return response(['judgement_summary' => $judgement_summary, 'full_judgement' => $full_judgement, 'court_name' => $court_name, 'holden' => $holden, 'judg_coram' => $judg_coram, 'judgement_coram' => $judgement_coram, 'party_a_name' => $party_a_name, 'party_a_type' => $party_a_type, 'party_b_name' => $party_b_name, 'party_b_type' => $party_b_type, 'ratios' => $ratios, 'counsels' => $counsels, 'notes' => $notes]);
                }
                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteJudgement($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        $judgement_summary = JudgementSummary::findOrFail($id);
        $judgement_summary->delete();
        return response(['success' => 'Judgement Deleted']);
    }

    ////////////////////////////////////courts///////////////////////////////////////
    public function court()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $courts = Court::orderBy('rank', 'ASC')->paginate(10);
                $court_count = Court::count();
                return response(['courts' => $courts, 'court_count' => $court_count]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'admin/judgements']);
    }

    /////////////////////subject matter index///////////////////////////////////////
    public function getSbj()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $subject_matter_indices = SubjectMatterIndex::orderBy('subject_matter_index', 'ASC')->paginate(10);
                $subject_count = SubjectMatterIndex::count();
                return response(['subject_matter_indices' => $subject_matter_indices, 'subject_count' => $subject_count]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'admin/judgements']);
    }

    /////////////////////////////rule categories//////////////////////////////////////////
    public function ruleCat()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->paginate(10);
                $rule_category_count = RuleCategory::count();
                return response(['rule_categories' => $rule_categories, 'rule_category_count' => $rule_category_count]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'admin/judgements']);
    }

    ////////////////////////rule of court/////////////////////////////////////////////////
    public function rules(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->paginate(10);
                if ($request->has('fetch_rule')) {
                    $orders = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'ORDERS')->orderBy('title', 'ASC')->paginate(10);
                    $appendices = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->paginate(10);
                    $schedules = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->paginate(10);
                    $forms = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'FORMS')->orderBy('title', 'ASC')->paginate(10);
                    $civil_forms = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->paginate(10);
                    $probate_forms = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->paginate(10);
                    $parts = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'PARTS')->orderBy('title', 'ASC')->paginate(10);
                    $appendix_count = $appendices->count();
                    $order_count = $orders->count();
                    $schedule_count = $schedules->count();
                    $form_count = $forms->count();
                    $civil_count = $civil_forms->count();
                    $probate_count = $probate_forms->count();
                    $part_count = $parts->count();
                    $selected_name = [];
                    $selected_name['name'] = $request->name;
                    return response(['orders' => $orders, 'schedules' => $schedules, 'appendices' => $appendices, 'forms' => $forms, 'civil_forms' => $civil_forms, 'probate_forms' => $probate_forms, 'parts' => $parts, 'rule_categories' => $rule_categories, 'order_count' => $order_count, 'part_count' => $part_count, 'schedule_count' => $schedule_count, 'civil_count' => $civil_count, 'probate_count' => $probate_count, 'appendix_count' => $appendix_count, 'form_count' => $form_count, 'selected_name' => $selected_name]);
                } else {
                    $orders = Rule::where('section', 'ORDERS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                    $order_count = Rule::where('section', 'ORDERS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                    $schedules = Rule::where('section', 'SCHEDULES')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                    $schedule_count = Rule::where('section', 'SCHEDULES')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                    $appendices = Rule::where('section', 'APPENDIX')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                    $appendix_count = Rule::where('section', 'APPENDIX')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                    $forms = Rule::where('section', 'FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                    $form_count = Rule::where('section', 'FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                    $civil_forms = Rule::where('section', 'CIVIL FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                    $civil_count = Rule::where('section', 'CIVIL FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                    $probate_forms = Rule::where('section', 'PROBATE FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                    $probate_count = Rule::where('section', 'PROBATE FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                    $parts = Rule::where('section', 'PARTS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                    $part_count = Rule::where('section', 'PARTS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                    $selected_name = [];
                    $selected_name['name'] = '';
                    return response(['orders' => $orders, 'schedules' => $schedules, 'appendices' => $appendices, 'forms' => $forms, 'civil_forms' => $civil_forms, 'probate_forms' => $probate_forms, 'parts' => $parts, 'rule_categories' => $rule_categories, 'order_count' => $order_count, 'schedule_count' => $schedule_count, 'part_count' => $part_count, 'appendix_count' => $appendix_count, 'civil_count' => $civil_count, 'probate_count' => $probate_count, 'form_count' => $form_count, 'selected_name' => $selected_name]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->roc_feature) {
                        // $rule_categories = RuleCategory::orderBy('name', 'ASC')->paginate(10);
                        $rule_categories = Package::where('id', Auth::user()->package_id)->first();
                        $all_rule_categories = json_decode($rule_categories->roc_cat);
                        $main_category = [];
                        foreach ($all_rule_categories as $rule_category) {
                            $main_category[] = RuleCategory::where('name', $rule_category)->first();
                        }
                        if ($request->has('fetch_rule')) {
                            $orders = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'ORDERS')->orderBy('title', 'ASC')->paginate(10);
                            $appendices = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->paginate(10);
                            $schedules = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->paginate(10);
                            $forms = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'FORMS')->orderBy('title', 'ASC')->paginate(10);
                            $civil_forms = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->paginate(10);
                            $probate_forms = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->paginate(10);
                            $parts = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'PARTS')->orderBy('title', 'ASC')->paginate(10);
                            $appendix_count = $appendices->count();
                            $order_count = $orders->count();
                            $schedule_count = $schedules->count();
                            $form_count = $forms->count();
                            $civil_count = $civil_forms->count();
                            $probate_count = $probate_forms->count();
                            $part_count = $parts->count();
                            $selected_name = [];
                            $selected_name['name'] = $request->name;
                            return response(['orders' => $orders, 'main_category' => $main_category, 'schedules' => $schedules, 'appendices' => $appendices, 'forms' => $forms, 'civil_forms' => $civil_forms, 'probate_forms' => $probate_forms, 'parts' => $parts, 'rule_categories' => $rule_categories, 'order_count' => $order_count, 'part_count' => $part_count, 'schedule_count' => $schedule_count, 'civil_count' => $civil_count, 'probate_count' => $probate_count, 'appendix_count' => $appendix_count, 'form_count' => $form_count, 'selected_name' => $selected_name]);
                        } else {
                            $orders = Rule::where('section', 'ORDERS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                            $order_count = Rule::where('section', 'ORDERS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                            $schedules = Rule::where('section', 'SCHEDULES')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                            $schedule_count = Rule::where('section', 'SCHEDULES')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                            $appendices = Rule::where('section', 'APPENDIX')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                            $appendix_count = Rule::where('section', 'APPENDIX')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                            $forms = Rule::where('section', 'FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                            $form_count = Rule::where('section', 'FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                            $civil_forms = Rule::where('section', 'CIVIL FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                            $civil_count = Rule::where('section', 'CIVIL FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                            $probate_forms = Rule::where('section', 'PROBATE FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                            $probate_count = Rule::where('section', 'PROBATE FORMS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                            $parts = Rule::where('section', 'PARTS')->where('type', 'Other')->orderBy('title', 'ASC')->paginate(10);
                            $part_count = Rule::where('section', 'PARTS')->where('type', 'Other')->orderBy('title', 'ASC')->count();
                            $selected_name = [];
                            $selected_name['name'] = '';
                            return response(['orders' => $orders, 'main_category' => $main_category, 'schedules' => $schedules, 'appendices' => $appendices, 'forms' => $forms, 'civil_forms' => $civil_forms, 'probate_forms' => $probate_forms, 'parts' => $parts, 'rule_categories' => $rule_categories, 'order_count' => $order_count, 'schedule_count' => $schedule_count, 'part_count' => $part_count, 'appendix_count' => $appendix_count, 'civil_count' => $civil_count, 'probate_count' => $probate_count, 'form_count' => $form_count, 'selected_name' => $selected_name]);
                        }
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allRules()
    {
        $allRules = Rule::get();
        return response(['allRules' => $allRules]);
    }

    public function allRuleCategorie () {
        $all_rule_categories = RuleCategory::get();
        $all_state = State::get();
        return response(['all_rule_categories' => $all_rule_categories, 'all_state' => $all_state]);
    }

    public function showRule($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                if (Rule::where('section', 'ORDERS')->first()) {
                    $order = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $order->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['order' => $order, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                    $schedule = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $schedule->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['schedule' => $schedule, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'APPENDIX')->first()) {
                    $appendix = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $appendix->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['appendix' => $appendix, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'FORMS')->first()) {
                    $form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['form' => $form, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                    $civil_form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $civil_form->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['civil_form' => $civil_form, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                    $probate_form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $probate_form->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['probate_form' => $probate_form, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'PARTS')->first()) {
                    $part = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $part->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['part' => $part, 'notes' => $notes, 'teams' => $teams]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    if (Rule::where('section', 'ORDERS')->first()) {
                        $order = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $order->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['order' => $order, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                        $schedule = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $schedule->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['schedule' => $schedule, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'APPENDIX')->first()) {
                        $appendix = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $appendix->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['appendix' => $appendix, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'FORMS')->first()) {
                        $form = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $form->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['form' => $form, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                        $civil_form = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $civil_form->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['civil_form' => $civil_form, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                        $probate_form = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $probate_form->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['probate_form' => $probate_form, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'PARTS')->first()) {
                        $part = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'rule')->where('user_id', Auth::user()->id)->where('content_id', $part->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['part' => $part, 'notes' => $notes, 'teams' => $teams]);
                    }
                }
                return response(['errorr' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchRuleAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        $rule = Rule::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $rule->id)->where('resource_type', 'rule');
        return response()->json([
            'anotes' => $anotes,
        ]);
    }

    ///////////////////////////state rule of court////////////////////////////////////////
    public function state_rules(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $states = State::orderBy('name', 'ASC')->paginate(10);
                if ($request->has('fetch_rule')) {
                    $orders = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'ORDERS')->orderBy('title', 'ASC')->paginate(10);
                    $appendices = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->paginate(10);
                    $schedules = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->paginate(10);
                    $forms = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'FORMS')->orderBy('title', 'ASC')->paginate(10);
                    $civil_forms = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->paginate(10);
                    $probate_forms = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->paginate(10);
                    $parts = Rule::where(function ($query) use ($request) {
                        return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                    })->where('section', 'PARTS')->orderBy('title', 'ASC')->paginate(10);
                    $appendix_count = $appendices->count();
                    $order_count = $orders->count();
                    $schedule_count = $schedules->count();
                    $form_count = $forms->count();
                    $civil_count = $civil_forms->count();
                    $probate_count = $probate_forms->count();
                    $part_count = $parts->count();
                    $selected_name = [];
                    $selected_name['name'] = $request->name;
                    return response(['orders' => $orders, 'schedules' => $schedules, 'appendices' => $appendices, 'forms' => $forms, 'civil_forms' => $civil_forms, 'probate_forms' => $probate_forms, 'parts' => $parts, 'states' => $states, 'order_count' => $order_count, 'part_count' => $part_count, 'schedule_count' => $schedule_count, 'civil_count' => $civil_count, 'probate_count' => $probate_count, 'appendix_count' => $appendix_count, 'form_count' => $form_count, 'selected_name' => $selected_name]);
                } else {
                    $orders = Rule::where('section', 'ORDERS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                    $order_count = Rule::where('section', 'ORDERS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                    $schedules = Rule::where('section', 'SCHEDULES')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                    $schedule_count = Rule::where('section', 'SCHEDULES')->where('type', 'State')->orderBy('title', 'ASC')->count();
                    $appendices = Rule::where('section', 'APPENDIX')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                    $appendix_count = Rule::where('section', 'APPENDIX')->where('type', 'State')->orderBy('title', 'ASC')->count();
                    $forms = Rule::where('section', 'FORMS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                    $form_count = Rule::where('section', 'FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                    $civil_forms = Rule::where('section', 'CIVIL FORMS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                    $civil_count = Rule::where('section', 'CIVIL FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                    $probate_forms = Rule::where('section', 'PROBATE FORMS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                    $probate_count = Rule::where('section', 'PROBATE FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                    $parts = Rule::where('section', 'PARTS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                    $part_count = Rule::where('section', 'PARTS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                    $selected_name = [];
                    $selected_name['name'] = '';
                    return response(['orders' => $orders, 'schedules' => $schedules, 'appendices' => $appendices, 'forms' => $forms, 'civil_forms' => $civil_forms, 'probate_forms' => $probate_forms, 'parts' => $parts, 'states' => $states, 'order_count' => $order_count, 'schedule_count' => $schedule_count, 'part_count' => $part_count, 'appendix_count' => $appendix_count, 'civil_count' => $civil_count, 'probate_count' => $probate_count, 'form_count' => $form_count, 'selected_name' => $selected_name]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->sroc_feature) {
                        // $states = State::orderBy('name', 'ASC')->paginate(10);
                        $states = Package::where('id', Auth::user()->package_id)->first();
                        $all_states = json_decode($states->sroc_state);
                        $main_state = [];
                        foreach ($all_states as $states) {
                            $main_state[] = State::where('name', $states)->first();
                        }
                        if ($request->has('fetch_rule')) {
                            $orders = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'ORDERS')->orderBy('title', 'ASC')->paginate(10);
                            $appendices = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'APPENDIX')->orderBy('title', 'ASC')->paginate(10);
                            $schedules = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'SCHEDULES')->orderBy('title', 'ASC')->paginate(10);
                            $forms = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'FORMS')->orderBy('title', 'ASC')->paginate(10);
                            $civil_forms = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'CIVIL FORMS')->orderBy('title', 'ASC')->paginate(10);
                            $probate_forms = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'PROBATE FORMS')->orderBy('title', 'ASC')->paginate(10);
                            $parts = Rule::where(function ($query) use ($request) {
                                return $request->name ? $query->from('rules')->where('name', $request->name) : '';
                            })->where('section', 'PARTS')->orderBy('title', 'ASC')->paginate(10);
                            $appendix_count = $appendices->count();
                            $order_count = $orders->count();
                            $schedule_count = $schedules->count();
                            $form_count = $forms->count();
                            $civil_count = $civil_forms->count();
                            $probate_count = $probate_forms->count();
                            $part_count = $parts->count();
                            $selected_name = [];
                            $selected_name['name'] = $request->name;
                            return response(['orders' => $orders, 'schedules' => $schedules, 'appendices' => $appendices, 'forms' => $forms, 'civil_forms' => $civil_forms, 'probate_forms' => $probate_forms, 'parts' => $parts, 'states' => $states, 'main_state' => $main_state, 'order_count' => $order_count, 'part_count' => $part_count, 'schedule_count' => $schedule_count, 'civil_count' => $civil_count, 'probate_count' => $probate_count, 'appendix_count' => $appendix_count, 'form_count' => $form_count, 'selected_name' => $selected_name]);
                        } else {
                            $orders = Rule::where('section', 'ORDERS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                            $order_count = Rule::where('section', 'ORDERS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                            $schedules = Rule::where('section', 'SCHEDULES')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                            $schedule_count = Rule::where('section', 'SCHEDULES')->where('type', 'State')->orderBy('title', 'ASC')->count();
                            $appendices = Rule::where('section', 'APPENDIX')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                            $appendix_count = Rule::where('section', 'APPENDIX')->where('type', 'State')->orderBy('title', 'ASC')->count();
                            $forms = Rule::where('section', 'FORMS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                            $form_count = Rule::where('section', 'FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                            $civil_forms = Rule::where('section', 'CIVIL FORMS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                            $civil_count = Rule::where('section', 'CIVIL FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                            $probate_forms = Rule::where('section', 'PROBATE FORMS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                            $probate_count = Rule::where('section', 'PROBATE FORMS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                            $parts = Rule::where('section', 'PARTS')->where('type', 'State')->orderBy('title', 'ASC')->paginate(10);
                            $part_count = Rule::where('section', 'PARTS')->where('type', 'State')->orderBy('title', 'ASC')->count();
                            $selected_name = [];
                            $selected_name['name'] = '';
                            return response(['orders' => $orders, 'schedules' => $schedules, 'appendices' => $appendices, 'forms' => $forms, 'civil_forms' => $civil_forms, 'probate_forms' => $probate_forms, 'parts' => $parts, 'states' => $states, 'main_state' => $main_state, 'order_count' => $order_count, 'schedule_count' => $schedule_count, 'part_count' => $part_count, 'appendix_count' => $appendix_count, 'civil_count' => $civil_count, 'probate_count' => $probate_count, 'form_count' => $form_count, 'selected_name' => $selected_name]);
                        }
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function allState() {
    //     $all_state = State::get();
    //     return response(['all_state' => $all_state]);
    // }

    public function showStateRule($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                if (Rule::where('section', 'ORDERS')->first()) {
                    $order = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $order->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['order' => $order, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                    $schedule = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $schedule->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['schedule' => $schedule, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'APPENDIX')->first()) {
                    $appendix = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $appendix->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['appendix' => $appendix, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'FORMS')->first()) {
                    $form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['form' => $form, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                    $civil_form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $civil_form->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['civil_form' => $civil_form, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                    $probate_form = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $probate_form->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['probate_form' => $probate_form, 'notes' => $notes, 'teams' => $teams]);
                } elseif (Rule::where('section', 'PARTS')->first()) {
                    $part = Rule::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $part->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    return response(['part' => $part, 'notes' => $notes, 'teams' => $teams]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    if (Rule::where('section', 'ORDERS')->first()) {
                        $order = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $order->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['order' => $order, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'SCHEDULES')->first()) {
                        $schedule = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $schedule->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['schedule' => $schedule, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'APPENDIX')->first()) {
                        $appendix = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $appendix->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['appendix' => $appendix, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'FORMS')->first()) {
                        $form = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $form->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['form' => $form, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'CIVIL FORMS')->first()) {
                        $civil_form = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $civil_form->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['civil_form' => $civil_form, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'PROBATE FORMS')->first()) {
                        $probate_form = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $probate_form->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['probate_form' => $probate_form, 'notes' => $notes, 'teams' => $teams]);
                    } elseif (Rule::where('section', 'PARTS')->first()) {
                        $part = Rule::findOrFail($id);
                        $notes = Annotation::where('resource_type', 'state-rule')->where('user_id', Auth::user()->id)->where('content_id', $part->id);
                        $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id);
                        return response(['part' => $part, 'notes' => $notes, 'teams' => $teams]);
                    }
                }
                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchStateRuleAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        $state_rule = Rule::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $state_rule->id)->where('resource_type', 'state-rule')->paginate(10);
        return response()->json([
            'anotes' => $anotes,
        ]);
    }

    ////////////////////////////laws of federation/////////////////////////////////////////
    public function fed(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
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
                    return response(['feds' => $feds, 'area_of_laws' => $area_of_laws, 'categories' => $categories, 'fed_count' => $fed_count, 'selected_category' => $selected_category]);
                } else {
                    $feds = LawOfFederation::orderBy('title', 'ASC')->get();
                    $fed_count = LawOfFederation::count();
                    $selected_category = [];
                    $selected_category['category'] = '';
                    return response(['feds' => $feds, 'area_of_laws' => $area_of_laws, 'categories' => $categories, 'fed_count' => $fed_count, 'selected_category' => $selected_category]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->lfn_feature) {
                        // $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                        // $categories = Category::orderBy('category', 'asc')->get();
                        $categories = Package::where('id', Auth::user()->package_id)->first();
                        $all_categories = json_decode($categories->lfn_cat);
                        $main_category = [];
                        foreach ($all_categories as $category) {
                            $main_category[] = Category::where('category', $category)->first();
                        }
                        if ($request->has('fetch_fed')) {
                            $fed = LawOfFederation::query();
                            if ($request->filled('category')) {
                                $feds = $fed->where('category', $request->category)->orderBy('title', 'ASC')->paginate(10);
                                $fed_count = $feds->count();
                                $selected_category = [];
                                $selected_category['category'] = $request->category;
                            }
                            return response(['feds' => $feds, 'main_category' => $main_category, 'categories' => $categories, 'fed_count' => $fed_count, 'selected_category' => $selected_category]);
                        } else {
                            $feds = LawOfFederation::orderBy('title', 'ASC')->paginate(10);
                            $fed_count = LawOfFederation::count();
                            $selected_category = [];
                            $selected_category['category'] = '';
                            return response(['feds' => $feds, 'main_category' => $main_category, 'categories' => $categories, 'fed_count' => $fed_count, 'selected_category' => $selected_category]);
                        }
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allFed()
    {
        $all_laws_of_federation = LawOfFederation::get();
        $categories = Category::orderBy('category', 'asc')->get();
        return response(['all_laws_of_federation' => $all_laws_of_federation, 'categories' => $categories]);
    }

    public function showFed($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $fed = LawOfFederation::findOrFail($id);
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                $categories = Category::orderBy('category', 'asc')->get();
                $notes = Annotation::where('resource_type', 'fed')->where('user_id', Auth::user()->id)->where('content_id', $fed->id)->get();
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                return response(['fed' => $fed, 'area_of_laws' => $area_of_laws, 'categories' => $categories, 'notes' => $notes, 'teams' => $teams]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $fed = LawOfFederation::findOrFail($id);
                    $fed_part = LawOfFedPart::where('law_of_federation_id', $fed->id)->orderBy('id', 'ASC')->get();
                    $fed_sections = LawOfFedSection::where('law_of_federation_id', $fed->id)->orderBy('id', 'ASC')->get();
                    $fed_schedules = LawOfFedSched::where('law_of_federation_id', $fed->id)->orderBy('id', 'ASC')->get();
                    // $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->get();
                    $categories = Category::orderBy('category', 'asc')->get();
                    $notes = Annotation::where('resource_type', 'fed')->where('user_id', Auth::user()->id)->where('content_id', $fed->id)->get();
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->get();
                    return response(['fed' => $fed, 'fed_part' => $fed_part, 'fed_sections' => $fed_sections, 'fed_schedules' => $fed_schedules, 'categories' => $categories, 'notes' => $notes, 'teams' => $teams]);
                }
                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchLawAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        $fed = LawOfFederation::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $fed->id)->where('resource_type', 'fed')->paginate(10);
        return response()->json([
            'anotes' => $anotes,
        ]);
    }

    ///////////////////////////area of law/////////////////////////////////////////////////
    public function area_of_law()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'ASC')->paginate(10);
                $area_count = AreaOfLaw::count();
                return response(['area_of_laws' => $area_of_laws, 'area_count' => $area_count]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /////////////////////////////////////categories////////////////////////////////////////
    public function category()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $categories = Category::orderBy('category', 'ASC')->paginate(10);
                $category_count = Category::count();
                return response(['categories' => $categories, 'category_count' => $category_count]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'admin/dashboard']);
    }

    /////////////////////////////////////Forms and Precedents///////////////////////////////
    public function forms(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $categories = Category::orderBy('category', 'ASC')->paginate(10);
                if ($request->has('fetch_form')) {
                    $forms = FormsPrecedence::where(function ($query) use ($request) {
                        return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                    })->where('form_type', 'legalpedia')->orderBy('title', 'ASC')->paginate(10);
                    $my_forms = FormsPrecedence::where(function ($query) use ($request) {
                        return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                    })->where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->paginate(10);
                    $public_forms = FormsPrecedence::where(function ($query) use ($request) {
                        return $request->category ? $query->from('form_precedences')->where('category', $request->category) : '';
                    })->where('display_type', 'public')->orderBy('title', 'ASC')->paginate(10);
                    $form_count = $forms->count();
                    $public_form_count = $public_forms->count();
                    $selected_category = [];
                    $selected_category['category'] = $request->category;
                    return response(['forms' => $forms, 'public_forms' => $public_forms, 'my_forms' => $my_forms, 'form_count' => $form_count, 'public_form_count' => $public_form_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                } else {
                    $forms = FormsPrecedence::where('form_type', 'legalpedia')->orderBy('title', 'ASC')->paginate(10);
                    $form_count = $forms->count();
                    $public_forms = FormsPrecedence::where('display_type', 'public')->orderBy('title', 'ASC')->paginate(10);
                    $public_form_count = $public_forms->count();
                    $my_forms = FormsPrecedence::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->paginate(10);
                    $selected_category = [];
                    $selected_category['category'] = '';
                    return response(['forms' => $forms, 'public_forms' => $public_forms, 'my_forms' => $my_forms, 'form_count' => $form_count, 'public_form_count' => $public_form_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->form_feature) {
                        // $categories = Category::orderBy('category', 'ASC')->paginate(10);
                        $categories = Package::where('id', Auth::user()->package_id)->first();
                        $all_categories = json_decode($categories->lfn_cat);
                        $main_category = [];
                        foreach ($all_categories as $category) {
                            $main_category[] = Category::where('category', $category)->first();
                        }

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
                            return response(['forms' => $forms, 'public_forms' => $public_forms, 'my_forms' => $my_forms, 'form_count' => $form_count, 'public_form_count' => $public_form_count, 'categories' => $categories, 'main_category' => $main_category, 'selected_category' => $selected_category]);
                        } else {    
                            $forms = FormsPrecedence::where('form_type', 'legalpedia')->orderBy('title', 'ASC')->get();
                            $form_count = $forms->count();
                            $public_forms = FormsPrecedence::where('display_type', 'public')->orderBy('title', 'ASC')->get();
                            $public_form_count = $public_forms->count();
                            $my_forms = FormsPrecedence::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
                            $selected_category = [];
                            $selected_category['category'] = '';
                            return response(['forms' => $forms, 'public_forms' => $public_forms, 'my_forms' => $my_forms, 'form_count' => $form_count, 'public_form_count' => $public_form_count, 'categories' => $categories, 'main_category' => $main_category, 'selected_category' => $selected_category]);
                        }
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allForms() {
        $all_forms = FormsPrecedence::get();
        return response(['all_forms' => $all_forms]);
    }

    public function showForm($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $form = FormsPrecedence::findOrFail($id);
                $notes = Annotation::where('resource_type', 'form')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->paginate(10);
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                $comments = FeaturedContent::where('type', 'form')->where('review_type', 'comment')->where('reference_id', $form->id)->orderBy('created_at', 'DESC')->paginate(10);
                $reviews = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->orderBy('created_at', 'DESC')->paginate(10);
                $rating_count = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->count();
                $rating = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->max('rating');
                return response(['form' => $form, 'notes' => $notes, 'comments' => $comments, 'reviews' => $reviews, 'rating_count' => $rating_count, 'rating' => $rating, 'teams' => $teams]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $form = FormsPrecedence::findOrFail($id);
                    $notes = Annotation::where('resource_type', 'form')->where('user_id', Auth::user()->id)->where('content_id', $form->id)->paginate(10);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    $comments = FeaturedContent::where('type', 'form')->where('review_type', 'comment')->where('reference_id', $form->id)->orderBy('created_at', 'DESC')->paginate(10);
                    $reviews = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->orderBy('created_at', 'DESC')->paginate(10);
                    $rating_count = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->count();
                    $rating = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->max('rating');
                    return response(['form' => $form, 'notes' => $notes, 'comments' => $comments, 'reviews' => $reviews, 'rating_count' => $rating_count, 'rating' => $rating, 'teams' => $teams]);
                }
                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchFormAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        $form = FormsPrecedence::whereId($id)->first();
        $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $form->id)->where('resource_type', 'form')->paginate(10);
        return response()->json([
            'anotes' => $anotes,
        ]);
    }

    ///////////////////////////////////////Legal Articles///////////////////////////////////
    public function articles(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $categories = Category::orderBy('category', 'ASC')->paginate(10);
                if ($request->has('fetch_category')) {
                    $articles = Article::where(function ($query) use ($request) {
                        return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                    })->where('article_type', 'legalpedia')->orderBy('title', 'ASC')->paginate(10);
                    $my_articles = Article::where(function ($query) use ($request) {
                        return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                    })->where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->paginate(10);
                    $public_articles = Article::where(function ($query) use ($request) {
                        return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                    })->where('display_type', 'public')->orderBy('title', 'ASC')->paginate(10);

                    $article_count = $articles->count();
                    $public_article_count = $public_articles->count();
                    $selected_category = [];
                    $selected_category['category'] = $request->category;
                    return response(['articles' => $articles, 'article_count' => $article_count, 'my_articles' => $my_articles, 'public_articles' => $public_articles, 'categories' => $categories, 'public_article_count' => $public_article_count, 'selected_category' => $selected_category]);
                } else {
                    $articles = Article::where('article_type', 'legalpedia')->orderBy('title', 'ASC')->paginate(10);
                    $my_articles = Article::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->paginate(10);
                    $public_articles = Article::where('display_type', 'public')->orderBy('title', 'ASC')->paginate(10);
                    $categories = Category::orderBy('category', 'ASC')->paginate(10);
                    $article_count = $articles->count();
                    $public_article_count = $public_articles->count();
                    $selected_category = [];
                    $selected_category['category'] = $request->category;
                    return response(['articles' => $articles, 'article_count' => $article_count, 'my_articles' => $my_articles, 'public_articles' => $public_articles, 'categories' => $categories, 'public_article_count' => $public_article_count, 'selected_category' => $selected_category]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->article_feature) {
                        // $categories = Category::orderBy('category', 'ASC')->paginate(10);
                        $categories = Package::where('id', Auth::user()->package_id)->first();
                        // dd($categories);
                        if ($request->has('fetch_category')) {
                            $articles = Article::where(function ($query) use ($request) {
                                return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                            })->where('article_type', 'legalpedia')->orderBy('title', 'ASC')->paginate(10);
                            $my_articles = Article::where(function ($query) use ($request) {
                                return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                            })->where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->paginate(10);
                            $public_articles = Article::where(function ($query) use ($request) {
                                return $request->category ? $query->from('articles')->where('category', $request->category) : '';
                            })->where('display_type', 'public')->orderBy('title', 'ASC')->paginate(10);

                            $article_count = $articles->count();
                            $public_article_count = $public_articles->count();
                            $selected_category = [];
                            $selected_category['category'] = $request->category;
                            return response(['articles' => $articles, 'article_count' => $article_count, 'my_articles' => $my_articles, 'public_articles' => $public_articles, 'categories' => $categories, 'public_article_count' => $public_article_count, 'selected_category' => $selected_category]);
                        } else {
                            $articles = Article::where('article_type', 'legalpedia')->orderBy('title', 'ASC')->paginate(10);
                            $my_articles = Article::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->paginate(10);
                            $public_articles = Article::where('display_type', 'public')->orderBy('title', 'ASC')->paginate(10);
                            $article_count = $articles->count();
                            $public_article_count = $public_articles->count();
                            $selected_category = [];
                            $selected_category['category'] = $request->category;
                            return response(['articles' => $articles, 'article_count' => $article_count, 'my_articles' => $my_articles, 'public_articles' => $public_articles, 'categories' => $categories, 'public_article_count' => $public_article_count, 'selected_category' => $selected_category]);
                        }
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allArticles () {
        $all_articles = Article::get();
        return response(['all_articles' => $all_articles]);
    }

    public function showArticle($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $article = Article::findOrFail($id);
                $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                $notes = Annotation::where('content_id', $article->id)->where('user_id', Auth::user()->id)->paginate(10);
                $admin_notes = Annotation::where('resource_type', 'admin-note')->orderBy('created_at', 'DESC')->limit(5)->paginate(10);
                $comments = FeaturedContent::where('type', 'article')->where('review_type', 'comment')->where('reference_id', $article->id)->orderBy('created_at', 'DESC')->paginate(10);
                $reviews = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->orderBy('created_at', 'DESC')->paginate(10);
                $rating_count = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->count();
                $rating = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->max('rating');
                return response(['article' => $article, 'teams' => $teams, 'notes' => $notes, 'admin_notes' => $admin_notes, 'rating' => $rating, 'rating_count' => $rating_count, 'reviews' => $reviews, 'comments' => $comments]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $article = Article::findOrFail($id);
                    $teams = UserTeam::where('approve_request', 1)->where('user_id', Auth::user()->id)->paginate(10);
                    $notes = Annotation::where('content_id', $article->id)->where('user_id', Auth::user()->id)->paginate(10);
                    $admin_notes = Annotation::where('resource_type', 'admin-note')->orderBy('created_at', 'DESC')->limit(5)->paginate(10);
                    $comments = FeaturedContent::where('type', 'article')->where('review_type', 'comment')->where('reference_id', $article->id)->orderBy('created_at', 'DESC')->paginate(10);
                    $reviews = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->orderBy('created_at', 'DESC')->paginate(10);
                    $rating_count = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->count();
                    $rating = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->max('rating');
                    return response(['article' => $article, 'teams' => $teams, 'notes' => $notes, 'admin_notes' => $admin_notes, 'rating' => $rating, 'rating_count' => $rating_count, 'reviews' => $reviews, 'comments' => $comments]);
                }
                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchArticleAnote($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            $article = Article::whereId($id)->first();
            $anotes = Annotation::where('user_id', Auth::user()->id)->where('content_id', $article->id)->where('resource_type', 'article')->paginate(10);
            return response()->json([
                'anotes' => $anotes,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    ////////////////////////////////////Legal Dictionary////////////////////////////////////
    public function dictionary(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['errror' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $categories = Category::orderBy('category', 'ASC')->paginate(10);
                if ($request->has('fetch_category')) {
                    $words = Dictionary::where(function ($query) use ($request) {
                        return $request->category ? $query->from('dictionaries')->where('category', $request->category) : '';
                    })->orderBy('title', 'ASC')->paginate(10);
                    $word_count = $words->count();
                    $selected_category = [];
                    $selected_category['category'] = $request->category;
                    return response(['words' => $words, 'word_count' => $word_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                } else {
                    $words = Dictionary::orderBy('title', 'ASC')->paginate(10);
                    $word_count = Dictionary::count();
                    $selected_category = [];
                    $selected_category['category'] = '';
                    return response(['words' => $words, 'word_count' => $word_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->dict_feature) {
                        // $categories = Category::orderBy('category', 'ASC')->paginate(10);
                        $categories = Package::where('id', Auth::user()->package_id)->first();
                        if ($request->has('fetch_category')) {
                            $words = Dictionary::where(function ($query) use ($request) {
                                return $request->category ? $query->from('dictionaries')->where('category', $request->category) : '';
                            })->orderBy('title', 'ASC')->paginate(10);
                            $word_count = $words->count();
                            $selected_category = [];
                            $selected_category['category'] = $request->category;
                            return response(['words' => $words, 'word_count' => $word_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                        } else {
                            $words = Dictionary::orderBy('title', 'ASC')->paginate(10);
                            $word_count = Dictionary::count();
                            $selected_category = [];
                            $selected_category['category'] = '';
                            return response(['words' => $words, 'word_count' => $word_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                        }
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allDictionary()
    {
        $allDictionary = Dictionary::get();
        return response(['allDicitonary' => $allDictionary]);
    }

    ////////////////////////////////////Legal Maxims///////////////////////////////////////
    public function maxim(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $categories = Category::orderBy('category', 'ASC')->paginate(10);
                if ($request->has('fetch_category')) {
                    $maxims = Maxim::where(function ($query) use ($request) {
                        return $request->category ? $query->from('maxims')->where('category', $request->category) : '';
                    })->orderBy('title', 'ASC')->paginate(10);
                    $maxim_count = $maxims->count();
                    $selected_category = [];
                    $selected_category['category'] = $request->category;
                    return response(['maxims' => $maxims, 'maxim_count' => $maxim_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                } else {
                    $maxims = Maxim::orderBy('title', 'ASC')->paginate(10);
                    $maxim_count = Maxim::count();
                    $selected_category = [];
                    $selected_category['category'] = '';
                    return response(['maxims' => $maxims, 'maxim_count' => $maxim_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->maxim_feature) {
                        // $categories = Category::orderBy('category', 'ASC')->paginate(10);
                        $categories = Package::where('id', Auth::user()->package_id)->first();
                        if ($request->has('fetch_category')) {
                            $maxims = Maxim::where(function ($query) use ($request) {
                                return $request->category ? $query->from('maxims')->where('category', $request->category) : '';
                            })->orderBy('title', 'ASC')->paginate(10);
                            $maxim_count = $maxims->count();
                            $selected_category = [];
                            $selected_category['category'] = $request->category;
                            return response(['maxims' => $maxims, 'maxim_count' => $maxim_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                        } else {
                            $maxims = Maxim::orderBy('title', 'ASC')->paginate(10);
                            $maxim_count = Maxim::count();
                            $selected_category = [];
                            $selected_category['category'] = '';
                            return response(['maxims' => $maxims, 'maxim_count' => $maxim_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                        }
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allMaxim()
    {
        $allMaxim = Maxim::get();
        return response(['allMaxim' => $allMaxim]);
    }

    ///////////////////////////////////Foreign resources///////////////////////////////////
    public function resource(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $categories = Category::orderBy('category', 'ASC')->paginate(10);
                if ($request->has('fetch_category')) {
                    $resources = Resource::where(function ($query) use ($request) {
                        return $request->category ? $query->from('resources')->where('category', $request->category) : '';
                    })->orderBy('title', 'ASC')->paginate(10);
                    $resource_count = $resources->count();
                    $selected_category = [];
                    $selected_category['category'] = $request->category;
                    return response(['resources' => $resources, 'resource_count' => $resource_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                } else {
                    $resources = Resource::OrderBy('title', 'ASC')->paginate(10);
                    $resource_count = Resource::count();
                    $selected_category = [];
                    $selected_category['category'] = '';
                    return response(['resources' => $resources, 'resource_count' => $resource_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                }
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->resource_feature) {
                        // $categories = Category::orderBy('category', 'ASC')->paginate(10);
                        $categories = Package::where('id', Auth::user()->package_id)->first();
                        if ($request->has('fetch_category')) {
                            $resources = Resource::where(function ($query) use ($request) {
                                return $request->category ? $query->from('resources')->where('category', $request->category) : '';
                            })->orderBy('title', 'ASC')->paginate(10);
                            $resource_count = $resources->count();
                            $selected_category = [];
                            $selected_category['category'] = $request->category;
                            return response(['resources' => $resources, 'resource_count' => $resource_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                        } else {
                            $resources = Resource::OrderBy('title', 'ASC')->paginate(10);
                            $resource_count = Resource::count();
                            $selected_category = [];
                            $selected_category['category'] = '';
                            return response(['resources' => $resources, 'resource_count' => $resource_count, 'categories' => $categories, 'selected_category' => $selected_category]);
                        }
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allForeignResources() {
        $all_foreign_resources = Resource::get();
        return response(['all_foreign_resources' => $all_foreign_resources]);
    }

    ////////////////////////////// featured content //////////////////////////////////////
    public function featuredContent()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            DB::statement("SET SQL_MODE=''");
            $featured_teams = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->groupBy('reference_id')->paginate(10);
            $featured_users = FeaturedContent::where('type', 'user')->where('review_type', 'rating')->groupBy('reference_id')->paginate(10);
            $featured_articles = FeaturedContent::where('type', 'article')->where('review_type', 'rating')->groupBy('reference_id')->paginate(10);
            $featured_forms = FeaturedContent::where('type', 'form')->where('review_type', 'rating')->groupBy('reference_id')->paginate(10);
            $featured_notes = FeaturedContent::where('type', 'note')->where('review_type', 'rating')->groupBy('reference_id')->paginate(10);
            return response([
                'featured_teams' => $featured_teams,
                'featured_users' => $featured_users,
                'featured_articles' => $featured_articles,
                'featured_forms' => $featured_forms,
                'featured_notes' => $featured_notes,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    ///////////////////////////////////subscription package///////////////////////////////
    public function subscription()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $packages = Package::orderBy('name', 'ASC')->paginate(10);
                $area_of_laws = AreaOfLaw::orderBy('area_of_law', 'asc')->paginate(10);
                $categories = Category::orderBy('category', 'asc')->paginate(10);
                $courts = Court::orderBy('court', 'ASC')->paginate(10);
                $states = State::orderBy('name', 'ASC')->paginate(10);
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->paginate(10);
                return response(['packages' => $packages, 'area_of_laws' => $area_of_laws, 'categories' => $categories, 'courts' => $courts, 'states' => $states, 'rule_categories' => $rule_categories]);
            }
            return redirect('admin/dashboard');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    ////////////////////////////////////discount//////////////////////////////////////////
    public function discount()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $discounts = Discount::orderBy('name', 'asc')->paginate(10);
                $packages = Package::orderBy('name', 'asc')->paginate(10);
                $discount_code = $this->generateRandomString(6);
                return response(['discounts' => $discounts, 'packages' => $packages, 'discount_code' => $discount_code]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'admin/dashboard']);
    }

    public function generateRandomString($length = 20)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return redirect('/login')->withErrors('You have been logged out by another user');
        };

        try {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return response(['randomString' => $randomString]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function useDiscount(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
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
                return response(['Please enter a valid coupon']);
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
                                return response(['new_price' => $new_price, 'package' => $package]);
                            } elseif ($discount->used < $discount->usage) {
                                $data = 1 + $discount->used;
                                $discount->used = $data;
                                $discount->save();
                                $discounted_price = ($package->price * $discount->percentage) / 100;
                                $new_price = $package->price - $discounted_price;
                                Session::flash('success1', 'Discount applied');
                                return response(['new_price' => $new_price, 'package' => $package]);
                            }
                            return response(['error' => 'Coupon already used']);
                        }
                        return response(['error' => 'Coupon has expired']);
                    }
                    return response(['error' => 'Invalid coupon']);
                }
                return response(['error' => 'Invalid coupon']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['error' => 'Invalid coupon']);
    }

    /////////////////////////////////////transactions///////////////////////////////////////
    public function transaction(Request $request)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            if (Auth::user()->role->name == 'Admin') {
                $packages = Package::orderBy('name', 'ASC')->paginate(10);
                if ($request->has('fetch_transaction')) {
                    $transaction = Transaction::query();
                    if ($request->filled('end_date')) {
                        $start_date = Carbon::parse($request->start_date)->toDateTimeString();
                        $end_date = Carbon::parse($request->end_date)->toDateTimeString();
                        $transactions = $transaction->whereBetween('created_at', [$start_date, $end_date])->orderBy('created_at', 'DESC')->paginate(10);
                    }
                    if ($request->filled('status')) {
                        $transactions = $transaction->where('status', $request->status)->orderBy('created_at', 'DESC')->paginate(10);
                    }
                    if ($request->filled('package')) {
                        $transactions = $transaction->where('package', $request->package)->orderBy('created_at', 'DESC')->paginate(10);
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
                    return response(['transactions' => $transactions, 'transaction_count' => $transaction_count, 'gross_amount' => $gross_amount, 'net_amount' => $net_amount, 'bought_package' => $bought_package, 'packages' => $packages, 'selected_status' => $selected_status, 'selected_package' => $selected_package, 'discounted_sum' => $discounted_sum]);
                }
                $transactions = Transaction::orderBy('created_at', 'DESC')->paginate(10);
                $transaction_count = $transactions->count();
                $gross_amount =  $transactions->sum('amount');
                $discounted_sum =  $transactions->sum('discounted_price');
                $net_amount =  $transactions->where('status', 'paid')->sum('amount') - $discounted_sum;
                $bought_package =  $transactions->where('status', 'paid')->count();
                $selected_status = [];
                $selected_status['status'] = '';
                $selected_package = [];
                $selected_package['package'] = '';
                return response(['transactions' => $transactions, 'transaction_count' => $transaction_count, 'gross_amount' => $gross_amount, 'net_amount' => $net_amount, 'bought_package' => $bought_package, 'packages' => $packages, 'selected_status' => $selected_status, 'selected_package' => $selected_package, 'discounted_sum' => $discounted_sum]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'admin/dashboard']);
    }

    //////////////////////////////////////Teams/////////////////////////////////////////////
    public function team()
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            $teams = Team::get();
            $my_teams = Team::where('user_id', Auth::user()->id)->paginate(10);
            return response(['teams' => $teams, 'my_teams' => $my_teams]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showTeam(Request $request, $id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            $team = Team::findOrFail($id);
            $user = Auth::user()->id;
            $users = User::select("*")->whereNotNull('last_seen')->orderBy('last_seen', 'DESC')->paginate(10);
            $send_request = UserTeam::where('user_id', Auth::user()->id)->where('team_id', $team->id)->first();
            $approved_members = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->paginate(10);
            $some_approved_members = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->limit(4)->paginate(10);
            $approved_member = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->first();
            $approved_member_count = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->count();
            $comment = Comment::with('comment_replies')->where('team_id', $team->id)->where('pinned_post', 1)->first(); // pinned post
            $shared_files = Comment::where('team_id', $team->id)->orderBy('created_at', 'DESC')->limit(4)->paginate(10);
            $shared_resources = Comment::where('team_id', $team->id)->orderBy('created_at', 'DESC')->paginate(10);
            $saved_posts = SavedPost::where('team_id', $team->id)->where('user_id', Auth::user()->id)->where('status', 1)->orderBy('created_at', 'DESC')->paginate(10);

            $team_member = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->where('user_id', Auth::user()->id)->first();
            $rating_count = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->count();
            $rating = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->max('rating');
            $reviews = FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->orderBy('created_at', 'DESC')->paginate(10);

            if (isset($request->search_post) && !empty($request->search_post)) {
                $search = $request->search_post;
                $query_comment = Comment::query();
                $comments = $query_comment->with('comment_replies')
                    ->where('team_id', $team->id)
                    ->where('comment_body', 'LIKE', '%' . $search . '%')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);
                return response(['team' => $team, 'users' => $users, 'send_request' => $send_request, 'approved_members' => $approved_members, 'some_approved_members' => $some_approved_members, 'approved_member' => $approved_member, 'approved_member_count' => $approved_member_count, 'comments' => $comments, 'shared_files' => $shared_files, 'shared_resources' => $shared_resources, 'comment' => $comment, 'saved_posts' => $saved_posts, 'rating_count' => $rating_count, 'rating' => $rating, 'reviews' => $reviews, 'team_member' => $team_member]);
            }
            $comments = Comment::with('comment_replies')->where('team_id', $team->id)->where('id', '<>', @$comment->id)->orderBy('created_at', 'DESC')->paginate(10);
            // return view('admin.teams.show', compact('team', 'users', 'send_request', 'approved_members', 'some_approved_members', 'approved_member', 'approved_member_count', 'comments', 'shared_files', 'shared_resources', 'comment', 'saved_posts', 'rating_count', 'rating', 'reviews', 'team_member'));
            return response(['team' => $team, 'users' => $users, 'send_request' => $send_request, 'approved_members' => $approved_members, 'some_approved_members' => $some_approved_members, 'approved_member' => $approved_member, 'approved_member_count' => $approved_member_count, 'comments' => $comments, 'saved_posts' => $saved_posts, 'rating_count' => $rating_count, 'rating' => $rating, 'reviews' => $reviews, 'team_member' => $team_member]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function joinTeam($id)
    {
        if (checkUser() == false) {
            Session::flash('error', 'You have been logged out by another user');
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            $team = Team::findOrFail($id);
            $user = Auth::user()->id;
            $users = User::select("*")->whereNotNull('last_seen')->orderBy('last_seen', 'DESC')->paginate(10);
            $send_request = UserTeam::where('user_id', Auth::user()->id)->where('team_id', $team->id)->first();
            $approved_members = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->paginate(10);
            $some_approved_members = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->limit(4)->paginate(10);
            $approved_member = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->first();
            $approved_member_count = UserTeam::where('approve_request', 1)->where('team_id', $team->id)->count();
            $comments = Comment::with('comment_replies')->where('team_id', $team->id)->orderBy('created_at', 'DESC')->paginate(10);
            $shared_files = Comment::where('team_id', $team->id)->orderBy('created_at', 'DESC')->limit(4)->paginate(10);
            $shared_resources = Comment::where('team_id', $team->id)->orderBy('created_at', 'DESC')->paginate(10);
            return response(['team' => $team, 'users' => $users, 'send_request' => $send_request, 'approved_members' => $approved_members, 'some_approved_members' => $some_approved_members, 'approved_member' => $approved_member, 'approved_member_count' => $approved_member_count, 'comments' => $comments, 'shared_files' => $shared_files, 'shared_resources' => $shared_resources]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
            return response(['error' => 'You have been logged out by another user']);
        };

        try {
            if ($request->input('search')) {
                $search = $request->input('search');
                $first_search = $request->input('search');
                $second_search = '';



                /////////////// Judgement search //////////////////////

                $query_case['table'] = 'ratio';
                $query_case['search'] = SummaryRatio::query()->where('heading', 'LIKE', '%' . $search . '%')
                    ->orWhere('body', 'LIKE', '%' . $search . '%')->with('suit_no')
                    // ->orderBy('heading', 'ASC')
                    ->orderByRaw('CHAR_LENGTH(heading)')
                    ->simplePaginate(15)
                    ->withQueryString();
                // ->paginate(10);


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
                        ->with('court')
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
                // $judgement_summary = [];
                // $court = [];
                if($query_case['table'] == 'ratio'){
                    foreach($query_case['search'] as $case){
                        $judgement_summary1 = JudgementSummary::where('suit_no', $case->suit_no)->first();
                        // dd($judgement_summary);
                        $court1 = Court::where('id', $judgement_summary1 ? $judgement_summary1->court_id : '')->first();
                        // array_push($judgement_summary);
                    }
                }

                /////////////// Law of Federation search //////////////////////

                $query_law['table'] = 'lfn';
                $query_law['search'] = LawOfFederation::query()
                    ->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('subsidiary_legislation', 'LIKE', '%' . $search . '%')
                    ->orderBy('law_date', 'DESC')
                    ->simplePaginate(5)
                    ->withQueryString();
                // ->paginate(10);

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
                    // ->paginate(10);
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
                    // ->paginate(10);
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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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

                return response(['query_case' => $query_case, 'judgement_summary1' => $judgement_summary1, 'court1' => $court1, 'search' => $search, 'selected_year' => $selected_year, 'first_search' => $first_search, 'second_search' => $second_search, 'query_law' => $query_law, 'query_case_count' => $query_case_count, 'query_law_count' => $query_law_count, 'query_rule' => $query_rule, 'query_rule_count' => $query_rule_count, 'query_form' => $query_form, 'query_form_count' => $query_form_count, 'query_article' => $query_article, 'query_article_count' => $query_article_count, 'query_note' => $query_note, 'query_note_count' => $query_note_count]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        try {
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
                // ->paginate(10);

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
                    // ->paginate(10);
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
                    // ->paginate(10);
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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

                $query_note_count = Annotation::query()
                    ->where('content', 'LIKE', '%' . $search . '%')
                    ->orWhere('comment', 'LIKE', '%' . $search . '%')
                    ->where('resource_type', '!=', 'admin-note')
                    ->where('display', 'public')
                    ->count();

                if ($request->filled('year')) {
                    $suitNumbers = JudgementSummary::query()->where('judgement_date', 'LIKE', '%' . $request->year . '%')->paginate(10)->pluck('suit_no');
                    $query_case['table'] = 'ratio';
                    $heading = SummaryRatio::whereIn('suit_no', $suitNumbers)->where('heading', 'LIKE', '%' . $search . '%')->orderByRaw('CHAR_LENGTH(heading)')->paginate(10);
                    $body = SummaryRatio::whereIn('suit_no', $suitNumbers)->where('body', 'LIKE', '%' . $search . '%')->orderByRaw('CHAR_LENGTH(heading)')->paginate(10);
                    $together = $heading->merge($body);
                    $query_case_count = $together->count();
                    $query_case['search'] =  $this->customPaginate($together)->withPath(url()->current())->withQueryString();
                    $selected_year = [];
                    $selected_year['judgement_date'] = $request->year;
                    return response(['query_case' => $query_case, 'search' => $search, 'selected_year' => $selected_year, 'first_search' => $first_search, 'second_search' => $second_search, 'query_law' => $query_law, 'query_case_count' => $query_case_count, 'query_law_count' => $query_law_count, 'query_rule' => $query_rule, 'query_rule_count' => $query_rule_count, 'query_form' => $query_form, 'query_form_count' => $query_form_count, 'query_article' => $query_article, 'query_article_count' => $query_article_count, 'query_note' => $query_note, 'query_note_count' => $query_note_count]);
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
                return response(['query_case' => $query_case, 'search' => $search, 'selected_year' => $selected_year, 'first_search' => $first_search, 'second_search' => $second_search, 'query_law' => $query_law, 'query_case_count' => $query_case_count, 'query_rule' => $query_rule, 'query_law_count' => $query_law_count, 'query_rule_count' => $query_rule_count, 'query_form' => $query_form, 'query_form_count' => $query_form_count, 'query_article' => $query_article, 'query_article_count' => $query_article_count, 'query_note' => $query_note, 'query_note_count' => $query_note_count]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        try {
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
                // ->paginate(10);


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
                    // ->paginate(10);
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
                // ->paginate(10);

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
                    // ->paginate(10);
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
                    // ->paginate(10);
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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

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
                    ->paginate(10)
                    ->withQueryString();
                // ->paginate(10);

                $query_note_count = Annotation::query()
                    ->where('content', 'LIKE', '%' . $search . '%')
                    ->orWhere('comment', 'LIKE', '%' . $search . '%')
                    ->where('display', 'public')
                    ->where('resource_type', '!=', 'admin-note')
                    ->count();

                $selected_year = [];
                $selected_year['judgement_date'] = '';

                return response(['query_case' => $query_case, 'selected_year' => $selected_year, 'search' => $search, 'first_search' => $first_search, 'second_search' => $second_search, 'query_law' => $query_law, 'query_case_count' => $query_case_count, 'query_law_count' => $query_law_count, 'query_rule' => $query_rule, 'query_rule_count' => $query_rule_count, 'query_form' => $query_form, 'query_form_count' => $query_form_count, 'query_article' => $query_article, 'query_article_count' => $query_article_count, 'query_note' => $query_note, 'query_note_count' => $query_note_count]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        /////////// for more year results////////////
        // if($request->filled('years')) {
        //     $suitNumbers = JudgementSummary::query()->where('judgement_date','LIKE', '%'.$request->year.'%')->paginate(10)->pluck('suit_no');

        //     $query_case['table'] = 'ratio';
        //     $heading = SummaryRatio::whereIn('suit_no', $suitNumbers)->where('heading', 'LIKE', '%'.$search.'%')->orderByRaw('CHAR_LENGTH(heading)')->paginate(10);
        //     $body = SummaryRatio::whereIn('suit_no', $suitNumbers)->where('body', 'LIKE', '%'.$search.'%')->orderByRaw('CHAR_LENGTH(heading)')->paginate(10);
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
        //         ->paginate(10));
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
        //         ->paginate(10));
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
}
