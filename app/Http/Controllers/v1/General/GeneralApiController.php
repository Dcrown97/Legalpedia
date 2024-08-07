<?php

namespace App\Http\Controllers\v1\General;

use App\Http\Controllers\Controller;
use App\Models\Annotation;
use App\Models\Category;
use App\Models\JudgementCoram;
use App\Models\JudgementSummary;
use App\Models\LawOfFederation;
use App\Models\LawOfFedPart;
use App\Models\LawOfFedSched;
use App\Models\LawOfFedSection;
use App\Models\Rule;
use App\Models\RuleCategory;
use App\Models\State;
use App\Models\SummaryRatio;
use App\Models\UserTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralApiController extends Controller
{
    public function showJudgement(Request $request)
    {
        try {
            $judgement_summary = JudgementSummary::with('court', 'holden', 'partyAName', 'partyAType', 'partyBName', 'partyBType', 'areaOfLaw', 'judgement', 'counsels')->paginate(500);
            if (is_null($judgement_summary)) {
                return response()->json(['error' => 'Record Not Found'], 500);
            }
            foreach ($judgement_summary as $item) {
                $item->judgement_coram = JudgementCoram::where('suit_no', $item->suit_no)->get();
                $item->ratios = SummaryRatio::where('suit_no', $item->suit_no)->get();
            }
            return response(['judgement_summary' => $judgement_summary]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showLawOfFed(Request $request)
    {
        try {
            $fed = LawOfFederation::paginate(500);
            if (is_null($fed)) {
                return response()->json(['error' => 'Record Not Found'], 500);
            }
            foreach ($fed as $item) {
                $item->fed_part = LawOfFedPart::where('law_of_federation_id', $item->id)->orderBy('id', 'ASC')->get();
                $item->fed_sections = LawOfFedSection::where('law_of_federation_id', $item->id)->orderBy('id', 'ASC')->get();
                $item->fed_schedules = LawOfFedSched::where('law_of_federation_id', $item->id)->orderBy('id', 'ASC')->get();
            }
            $categories = Category::orderBy('category', 'asc')->get();

            return response(['fed' => $fed, 'categories' => $categories]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showRuleOfCourt(Request $request)
    {
        try {
            $search_param = $request->search_param;
            $rulesCategory = $request->filterByRulesCategory;
            $sections = $request->filterBySections;
            $records = Rule::when($search_param, function ($query, $search_param) {
                return $query->where('title', 'LIKE', '%' . $search_param . '%');
            })->when($rulesCategory, function ($query) use ($rulesCategory) {
                return $query->where('name', $rulesCategory);
            })->when($sections, function ($query) use ($sections) {
                return $query->where('section', $sections);
            })->orderBy('title', 'ASC')
            ->paginate(500);
            return response(['records' => $records]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function showRuleOfCourt(Request $request)
    // {
    //     try {
    //         if ($request->section == 'ORDERS') {
    //             $orders = Rule::where('section', 'ORDERS')->paginate(500);
    //             foreach ($orders as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['orders' => $orders]);
    //         } elseif ($request->section == 'SCHEDULES') {
    //             $schedule = Rule::where('section', 'SCHEDULES')->paginate(500);
    //             foreach ($schedule as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['schedule' => $schedule]);
    //         } elseif ($request->section == 'APPENDIX') {
    //             $appendix = Rule::where('section', 'APPENDIX')->paginate(500);
    //             foreach ($appendix as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['appendix' => $appendix]);
    //         } elseif ($request->section == 'FORMS') {
    //             $form = Rule::where('section', 'FORMS')->paginate(500);
    //             foreach ($form as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['form' => $form]);
    //         } elseif ($request->section == 'CIVIL FORMS') {
    //             $civil_form = Rule::where('section', 'CIVIL FORMS')->paginate(500);
    //             foreach ($civil_form as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['civil_form' => $civil_form]);
    //         } elseif ($request->section == 'PROBATE FORMS') {
    //             $probate_form = Rule::where('section', 'PROBATE FORMS')->paginate(500);
    //             foreach ($probate_form as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['probate_form' => $probate_form]);
    //         } elseif ($request->section == 'PARTS') {
    //             $part = Rule::where('section', 'PARTS')->paginate(500);
    //             foreach ($part as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['part' => $part]);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
}
