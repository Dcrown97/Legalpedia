<?php

namespace App\Http\Controllers\v1\Paid;

use App\Http\Controllers\Controller;
use App\Models\Annotation;
use App\Models\AreaOfLaw;
use App\Models\Article;
use App\Models\Category;
use App\Models\Coram;
use App\Models\Court;
use App\Models\Dictionary;
use App\Models\FeaturedContent;
use App\Models\FormsPrecedence;
use App\Models\JudgementCoram;
use App\Models\JudgementPrinciple;
use App\Models\JudgementSummary;
use App\Models\LawOfFederation;
use App\Models\Maxim;
use App\Models\Package;
use App\Models\Principle;
use App\Models\Rule;
use App\Models\RuleCategory;
use App\Models\State;
use App\Models\SubjectMatterIndex;
use App\Models\UserTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaidApiController extends Controller
{
    //////////////////////////////////judgement//////////////////////////////////////
    // public function judgement(Request $request)
    // {
    //     try {

    //         $search_param = $request->search_param;
    //         $filterByYear = $request->filterByYear;
    //         $filterByNoSummary = $request->filterByNoSummary;
    //         $filterBySbjMatterIndex = "";
    //         $courtId = $request->filterByCourtId;
    //         $sbj = SubjectMatterIndex::where('subject_matter_index', $request->filterBySbjMatterIndex)->first();
    //         if ($sbj) {
    //             $principle = Principle::where('subject_matter_index_id', $sbj->id)->first();
    //             $judg_principle = JudgementPrinciple::where('principle_id', $principle ? $principle->id : '')->first();
    //             $filterBySbjMatterIndex = $judg_principle->suit_no;
    //         }

    //         if (Auth::user()->role->name == 'Admin') {

    //             $records = JudgementSummary::when($search_param, function ($query, $search_param) {
    //                 return $query->where('title', 'LIKE', '%' . $search_param . '%')
    //                     ->orWhere('suit_no', 'LIKE', '%' . $search_param . '%')
    //                     ->orWhere('judgement_date', 'LIKE', '%' . $search_param . '%')
    //                     ->orWhereRelation('court', 'court', 'LIKE', '%' . $search_param . '%');
    //             })->when($filterByYear, function ($query) use ($filterByYear) {
    //                 return $query->where('judgement_date', 'LIKE', '%' . $filterByYear . '%');
    //             })->when($filterBySbjMatterIndex, function ($query) use ($filterBySbjMatterIndex) {
    //                 return $query->where('suit_no', $filterBySbjMatterIndex);
    //             })->when($filterByNoSummary == "no_summarry", function ($query) {
    //                 return $query->where('summary_of_facts', NULL);
    //             })->when($courtId, function ($query) use ($courtId) {
    //                 return $query->where('court_id', $courtId);
    //             })->latest()
    //                 ->paginate(10);

    //             return response(['records' => $records]);
    //         } else {
    //             if (Auth::user()->subscribedUser()) {

    //                 $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

    //                 if ($subscribed_package->judgement_featureapi) {

    //                     $records = JudgementSummary::when($search_param, function ($query, $search_param) {
    //                         return $query->where('title', 'LIKE', '%' . $search_param . '%')
    //                             ->orWhere('suit_no', 'LIKE', '%' . $search_param . '%')
    //                             ->orWhere('judgement_date', 'LIKE', '%' . $search_param . '%')
    //                             ->orWhereRelation('court', 'court', 'LIKE', '%' . $search_param . '%');
    //                     })->when($filterByYear, function ($query) use ($filterByYear) {
    //                         return $query->where('judgement_date', 'LIKE', '%' . $filterByYear . '%');
    //                     })->when($filterBySbjMatterIndex, function ($query) use ($filterBySbjMatterIndex) {
    //                         return $query->where('suit_no', $filterBySbjMatterIndex);
    //                     })->when($filterByNoSummary == "no_summarry", function ($query) {
    //                         return $query->where('summary_of_facts', NULL);
    //                     })->when($courtId, function ($query) use ($courtId) {
    //                         return $query->where('court_id', $courtId);
    //                     })->latest()
    //                         ->paginate(10);

    //                     return response(['records' => $records]);
    //                 }

    //                 return response(['error' => 'You need to upgrade your package to get access']);
    //             }

    //             return response(['error' => 'You need to subscribe to a package to get access']);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function judgement(Request $request)
    {
        try {
            $queryParams = [];

            if ($request->search_param) {
                $queryParams['search_param'] = $request->search_param;
            }
            if ($request->filterByYear) {
                $queryParams['filterByYear'] = $request->filterByYear;
            }
            if ($request->filterByNoSummary == "no_summarry") {
                $queryParams['filterByNoSummary'] = $request->filterByNoSummary;
            }
            if ($request->filterByCourtId) {
                $queryParams['filterByCourtId'] = $request->filterByCourtId;
            }
            if ($request->filterBySbjMatterIndex) {
                $queryParams['filterBySbjMatterIndex'] = $request->filterBySbjMatterIndex;
            }

            $queryString = http_build_query($queryParams);
            $webUrl = url('/admin/judgements') . ($queryString ? '?' . $queryString : '');

            return response()->json(['link' => $webUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function court(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = Court::get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->judgement_featureapi) {

                        $records = Court::get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function subjectMatterIndex(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = SubjectMatterIndex::get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->judgement_featureapi) {

                        $records = SubjectMatterIndex::get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sbjMatter(Request $request)
    {
        try {

            $search_param = $request->search_param;
            $filterBy = $request->filterBy;

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
                    dd($sbj, $principle, $judg_principle);
                    $judge = $judgement_summary->where('suit_no', $judg_principle->suit_no);
                    $judgement_count = $judge->count();
                    $judgement_summaries = $judge->orderBy('judgement_date', 'DESC')->paginate(10)->withQueryString();
                    $selected_subject_matter = [];
                    $selected_subject_matter['subject_matter_index'] = $request->subject_matter_index;
                    return response(['judgement_summaries' => $judgement_summaries, 'courts' => $courts, 'years' => $years, 'judgement_count' => $judgement_count, 'categories' => $categories, 'area_of_laws' => $area_of_laws, 'subject_matter_indices' => $subject_matter_indices, 'selected_subject_matter' => $selected_subject_matter]);

                    $sbj = SubjectMatterIndex::where('subject_matter_index', $filterBy)->first();
                    $principle = Principle::where('subject_matter_index_id', $sbj->id)->first();
                    $judg_principle = JudgementPrinciple::where('principle_id', $principle ? $principle->id : '')->first();
                    $filter = $judg_principle;

                    $judgement_summary = JudgementSummary::when($search_param, function ($query, $search_param) {
                        return $query->where('title', 'LIKE', '%' . $search_param . '%')
                            ->orWhere('suit_no', 'LIKE', '%' . $search_param . '%')
                            ->orWhere('judgement_date', 'LIKE', '%' . $search_param . '%')
                            ->orWhereRelation('court', 'court', 'LIKE', '%' . $search_param . '%');
                    })->when($filter, function ($query) use ($filter) {
                        return $query->where('suit_no', $filter);
                    })->with('court')
                        ->latest()
                        ->paginate(10);

                    return response(['judgement_summaries' => $judgement_summary]);
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
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->judgement_featureapi) {
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
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function legalCitation(Request $request)
    {
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
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->judgement_featureapi) {
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
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function noSummary(Request $request)
    {
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
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->judgement_featureapi) {
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
                    return response(['error' => 'You need to subscribe to a package to get access']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'redirect to admin/judgements']);
    }

    public function showJudgement($id)
    {
        try {
            if (Auth::user()->role->name == 'Admin') {
                $records = JudgementSummary::where('id', $id)
                    ->with('court', 'holden', 'partyAName', 'partyAType', 'partyBName', 'partyBType', 'areaOfLaw', 'judgement', 'counsels', 'summaryRatio', 'judgCoramsForApi')
                    ->first();
                if (is_null($records)) {
                    return response()->json(['error' => 'Record Not Found'], 500);
                }
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->judgement_featureapi) {
                        $records = JudgementSummary::where('id', $id)
                            ->with('court', 'holden', 'partyAName', 'partyAType', 'partyBName', 'partyBType', 'areaOfLaw', 'judgement', 'counsels', 'summaryRatio', 'judgCoramsForApi')
                            ->first();
                        if (is_null($records)) {
                            return response()->json(['error' => 'Record Not Found'], 500);
                        }
                        return response(['records' => $records]);
                    }
                    return response(['error' => 'You need to subscribe to a package to get access']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //////////////////////////////////Laws Of Federation//////////////////////////////////////

    public function fed(Request $request)
    {
        try {
            $search_param = $request->search_param;
            $category = $request->filterByCategory;
            if (Auth::user()->role->name == 'Admin') {
                // $categories = Category::orderBy('category', 'asc')->get();

                $records = LawOfFederation::when($search_param, function ($query, $search_param) {
                    return $query->where('title', 'LIKE', '%' . $search_param . '%')
                        ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                })->when($category, function ($query) use ($category) {
                    return $query->where('category', $category);
                })->orderBy('title', 'ASC')
                    ->paginate(10);

                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->lfn_featureapi) {

                        $records = LawOfFederation::when($search_param, function ($query, $search_param) {
                            return $query->where('title', 'LIKE', '%' . $search_param . '%')
                                ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                        })->when($category, function ($query) use ($category) {
                            return $query->where('category', $category);
                        })->orderBy('title', 'ASC')
                            ->paginate(10);

                        return response(['records' => $records]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fedCategory(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = Category::get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->lfn_featureapi) {

                        $records = Category::get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showFed($id)
    {
        try {
            if (Auth::user()->role->name == 'Admin') {
                $record = LawOfFederation::where('id', $id)
                    ->with('law_of_fed_parts', 'law_of_fed_sections', 'Law_of_fed_sched')
                    ->first();
                if (is_null($record)) {
                    return response()->json(['error' => 'Record Not Found'], 500);
                }
                // $categories = Category::orderBy('category', 'asc')->get();

                return response(['record' => $record]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->lfn_featureapi) {
                        $record = LawOfFederation::where('id', $id)
                            ->with('law_of_fed_parts', 'law_of_fed_sections', 'Law_of_fed_sched')
                            ->first();
                        if (is_null($record)) {
                            return response()->json(['error' => 'Record Not Found'], 500);
                        }
                        // $categories = Category::orderBy('category', 'asc')->get();

                        return response(['record' => $record]);
                    }
                    return response(['error' => 'You need to subscribe to a package to get access']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    ////////////////////////rule of court/////////////////////////////////////////////////
    public function rules(Request $request)
    {
        try {

            $search_param = $request->search_param;
            $rulesCategory = $request->filterByRulesCategory;
            $sections = $request->filterBySections;

            if (Auth::user()->role->name == 'Admin') {

                $records = Rule::where('type', 'Other')
                    ->when($search_param, function ($query, $search_param) {
                        return $query->where('title', 'LIKE', '%' . $search_param . '%');
                    })->when($rulesCategory, function ($query) use ($rulesCategory) {
                        return $query->where('name', $rulesCategory);
                    })->when($sections, function ($query) use ($sections) {
                        return $query->where('section', $sections);
                    })->orderBy('title', 'ASC')
                    ->paginate(10);

                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->roc_featureapi) {

                        $records = Rule::when($search_param, function ($query, $search_param) {
                            return $query->where('title', 'LIKE', '%' . $search_param . '%');
                        })->when($rulesCategory, function ($query) use ($rulesCategory) {
                            return $query->where('name', $rulesCategory);
                        })->when($sections, function ($query) use ($sections) {
                            return $query->where('section', $sections);
                        })->orderBy('title', 'ASC')
                            ->paginate(10);

                        return response(['records' => $records]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ruleCategory(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = RuleCategory::orderBy('name', 'ASC')->get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->roc_featureapi) {

                        $records = RuleCategory::orderBy('name', 'ASC')->get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /////////////////////////////rule categories//////////////////////////////////////////
    public function ruleCat()
    {
        try {
            if (Auth::user()->role->name == 'Admin') {
                $rule_categories = RuleCategory::orderBy('name', 'ASC')->paginate(10);
                $rule_category_count = RuleCategory::count();
                return response(['rule_categories' => $rule_categories, 'rule_category_count' => $rule_category_count]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->roc_featureapi) {
                        $rule_categories = RuleCategory::orderBy('name', 'ASC')->paginate(10);
                        $rule_category_count = RuleCategory::count();
                        return response(['rule_categories' => $rule_categories, 'rule_category_count' => $rule_category_count]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response(['redirect' => 'admin/judgements']);
    }

    ///////////////////////////state rule of court////////////////////////////////////////
    public function stateRules(Request $request)
    {
        try {

            $search_param = $request->search_param;
            $rulesByState = $request->filterByState;
            $sections = $request->filterBySections;

            if (Auth::user()->role->name == 'Admin') {

                $records = Rule::where('type', 'State')
                    ->when($search_param, function ($query, $search_param) {
                        return $query->where('title', 'LIKE', '%' . $search_param . '%');
                    })->when($rulesByState, function ($query) use ($rulesByState) {
                        return $query->where('name', $rulesByState);
                    })->when($sections, function ($query) use ($sections) {
                        return $query->where('section', $sections);
                    })->orderBy('title', 'ASC')
                    ->paginate(10);

                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->sroc_featureapi) {
                        $records = Rule::where('type', 'State')
                            ->when($search_param, function ($query, $search_param) {
                                return $query->where('title', 'LIKE', '%' . $search_param . '%');
                            })->when($rulesByState, function ($query) use ($rulesByState) {
                                return $query->where('name', $rulesByState);
                            })->when($sections, function ($query) use ($sections) {
                                return $query->where('section', $sections);
                            })->orderBy('title', 'ASC')
                            ->paginate(10);

                        return response(['records' => $records]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function states(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = State::orderBy('name', 'ASC')->get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->sroc_featureapi) {

                        $records = State::orderBy('name', 'ASC')->get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showRule($id)
    {
        try {
            if (Auth::user()->role->name == 'Admin') {

                $record = Rule::where('id', $id)->first();

                if (is_null($record)) {
                    return response()->json(['error' => 'Record Not Found'], 500);
                }

                return response(['record' => $record]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->roc_featureapi || $subscribed_package->sroc_featureapi) {
                        $record = Rule::where('id', $id)->first();

                        if (is_null($record)) {
                            return response()->json(['error' => 'Record Not Found'], 500);
                        }

                        return response(['record' => $record]);
                    }
                    return response(['errorr' => 'You need to subscribe to a package to get access']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /////////////////////////////////////Forms and Precedents///////////////////////////////
    public function forms(Request $request)
    {
        try {
            $search_param = $request->search_param;
            $category = $request->filterByCategory;
            if (Auth::user()->role->name == 'Admin') {

                $records = FormsPrecedence::when($search_param, function ($query, $search_param) {
                    return $query->where('title', 'LIKE', '%' . $search_param . '%')
                        ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                })->when($category, function ($query) use ($category) {
                    return $query->where('category', $category);
                })->orderBy('title', 'ASC')
                    ->paginate(10);

                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->form_featureapi) {

                        $records = FormsPrecedence::when($search_param, function ($query, $search_param) {
                            return $query->where('title', 'LIKE', '%' . $search_param . '%')
                                ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                        })->when($category, function ($query) use ($category) {
                            return $query->where('category', $category);
                        })->orderBy('title', 'ASC')
                            ->paginate(10);

                        return response(['records' => $records]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function formCategory(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = Category::get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->form_featureapi) {

                        $records = Category::get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function showForm($id)
    {
        try {
            if (Auth::user()->role->name == 'Admin') {

                $record = FormsPrecedence::where('id', $id)->first();

                if (is_null($record)) {
                    return response()->json(['error' => 'Record Not Found'], 500);
                }

                return response(['record' => $record]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->form_featureapi) {
                        $record = FormsPrecedence::where('id', $id)->first();

                        if (is_null($record)) {
                            return response()->json(['error' => 'Record Not Found'], 500);
                        }

                        return response(['record' => $record]);
                    }
                    return response(['error' => 'You need to subscribe to a package to get access']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    ///////////////////////////////////////Legal Articles///////////////////////////////////
    public function articles(Request $request)
    {
        try {

            $search_param = $request->search_param;
            $category = $request->filterByCategory;

            if (Auth::user()->role->name == 'Admin') {

                $records = Article::when($search_param, function ($query, $search_param) {
                    return $query->where('title', 'LIKE', '%' . $search_param . '%')
                        ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                })->when($category, function ($query) use ($category) {
                    return $query->where('category', $category);
                })->orderBy('title', 'ASC')
                    ->paginate(10);

                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->article_featureapi) {

                        $records = Article::when($search_param, function ($query, $search_param) {
                            return $query->where('title', 'LIKE', '%' . $search_param . '%')
                                ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                        })->when($category, function ($query) use ($category) {
                            return $query->where('category', $category);
                        })->orderBy('title', 'ASC')
                            ->paginate(10);

                        return response(['records' => $records]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function articleCategory(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = Category::get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->article_featureapi) {

                        $records = Category::get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showArticle($id)
    {
        try {
            if (Auth::user()->role->name == 'Admin') {

                $record = Article::where('id', $id)->first();

                if (is_null($record)) {
                    return response()->json(['error' => 'Record Not Found'], 500);
                }

                return response(['record' => $record]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->article_featureapi) {

                        $record = Article::where('id', $id)->first();

                        if (is_null($record)) {
                            return response()->json(['error' => 'Record Not Found'], 500);
                        }

                        return response(['record' => $record]);
                    }
                    return response(['error' => 'You need to subscribe to a package to get access']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    ////////////////////////////////////Legal Dictionary////////////////////////////////////
    public function dictionary(Request $request)
    {
        try {

            $search_param = $request->search_param;
            $category = $request->filterByCategory;

            if (Auth::user()->role->name == 'Admin') {

                $records = Dictionary::when($search_param, function ($query, $search_param) {
                    return $query->where('title', 'LIKE', '%' . $search_param . '%')
                        ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                })->when($category, function ($query) use ($category) {
                    return $query->where('category', $category);
                })->orderBy('title', 'ASC')
                    ->paginate(10);

                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->dict_featureapi) {

                        $records = Dictionary::when($search_param, function ($query, $search_param) {
                            return $query->where('title', 'LIKE', '%' . $search_param . '%')
                                ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                        })->when($category, function ($query) use ($category) {
                            return $query->where('category', $category);
                        })->orderBy('title', 'ASC')
                            ->paginate(10);

                        return response(['records' => $records]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function dictionaryCategory(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = Category::get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->dict_featureapi) {

                        $records = Category::get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showDictionary($id)
    {
        try {
            if (Auth::user()->role->name == 'Admin') {

                $record = Dictionary::where('id', $id)->first();

                if (is_null($record)) {
                    return response()->json(['error' => 'Record Not Found'], 500);
                }

                return response(['record' => $record]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->dict_featureapi) {

                        $record = Dictionary::where('id', $id)->first();

                        if (is_null($record)) {
                            return response()->json(['error' => 'Record Not Found'], 500);
                        }

                        return response(['record' => $record]);
                    }
                    return response(['error' => 'You need to subscribe to a package to get access']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    ////////////////////////////////////Legal Maxims///////////////////////////////////////
    public function maxim(Request $request)
    {
        try {

            $search_param = $request->search_param;
            $category = $request->filterByCategory;

            if (Auth::user()->role->name == 'Admin') {

                $records = Maxim::when($search_param, function ($query, $search_param) {
                    return $query->where('title', 'LIKE', '%' . $search_param . '%')
                        ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                })->when($category, function ($query) use ($category) {
                    return $query->where('category', $category);
                })->orderBy('title', 'ASC')
                    ->paginate(10);

                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {
                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->maxim_featureapi) {

                        $records = Maxim::when($search_param, function ($query, $search_param) {
                            return $query->where('title', 'LIKE', '%' . $search_param . '%')
                                ->orWhere('category', 'LIKE', '%' . $search_param . '%');
                        })->when($category, function ($query) use ($category) {
                            return $query->where('category', $category);
                        })->orderBy('title', 'ASC')
                            ->paginate(10);

                        return response(['records' => $records]);
                    }
                    return response(['error' => 'You need to upgrade your package to get access']);
                }
                return response(['error' => 'You need to upgrade your package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function legalMaximCategory(Request $request)
    {
        try {

            if (Auth::user()->role->name == 'Admin') {

                $records = Category::get();
                return response(['records' => $records]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();

                    if ($subscribed_package->maxim_featureapi) {

                        $records = Category::get();
                        return response(['records' => $records]);
                    }

                    return response(['error' => 'You need to upgrade your package to get access']);
                }

                return response(['error' => 'You need to subscribe to a package to get access']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showLegalMaxim($id)
    {
        try {
            if (Auth::user()->role->name == 'Admin') {

                $record = Maxim::where('id', $id)->first();

                if (is_null($record)) {
                    return response()->json(['error' => 'Record Not Found'], 500);
                }

                return response(['record' => $record]);
            } else {
                if (Auth::user()->subscribedUser()) {

                    $subscribed_package = Package::where('id', Auth::user()->package_id)->first();
                    if ($subscribed_package->maxim_featureapi) {

                        $record = Maxim::where('id', $id)->first();

                        if (is_null($record)) {
                            return response()->json(['error' => 'Record Not Found'], 500);
                        }

                        return response(['record' => $record]);
                    }
                    return response(['error' => 'You need to subscribe to a package to get access']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
