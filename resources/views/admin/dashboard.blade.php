@extends('layouts.admin')

@section('title')
    <title>Dashboard - Legalpedia</title>
@endsection

@section('content')
    <style>
        .alert-primary {
            background-color: #E3EDFF !important;
            border-color: #E3EDFF !important;
            color: #767676 !important;
        }
        .text-green-0{
            color: #32E017;
        }
        .text-4xl {
            font-size: 30px;
        }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <h6 class="header-pretitle">
                        </h6>
                        <h1 class="header-title">
                            @if(Auth::user()->role->name == 'Admin')
                                Hi, Admin
                                @else
                                Hi, {{Str::words(Auth::user()->name, 1, '')}}
                            @endif
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i class="mdi mdi-message mr-2 text-green-0"></i><strong>Welcome back {{Str::words(Auth::user()->name, 1, '')}}</strong> You can now access thousands of records of recent and old Judgments, Laws, Rules, Articles and so much more!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="row">
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/judgements')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Judgements
                                    </h6>
                                    <span class="h2 mb-0">
                                        <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt=" Latest Judgments">
                                        <span class="text-4xl">{{number_format($judgement_count)}}</span> <span class="text-muted">Cases</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/laws-of-federation')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                Laws
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Laws of Federation">
                                    <span class="text-4xl">{{number_format($fed_count)}}</span> <span class="text-muted">Laws</span>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/rules-of-court')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                    Rules
                                    </h6>
                                    <span class="h2 mb-0">
                                        <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="State Rules of Court">
                                        <span class="text-4xl">{{number_format($rule_count)}}</span> <span class="text-muted">Rules</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/forms-and-precedents')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Forms
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt="Forms & Precedences">
                                    <span class="text-4xl">{{number_format($form_count)}}</span> <span class="text-muted">Forms</span>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/judgements')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Legal Articles
                                    </h6>
                                    <span class="h2 mb-0">
                                        <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt="Legal Articles">
                                        <span class="text-4xl">{{number_format($article_count)}}</span> <span class="text-muted">Articles</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/laws-of-federation')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                Law Dictionary
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Law Dictionary">
                                    <span class="text-4xl">{{number_format($dict_count)}}</span> <span class="text-muted">Words</span>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/rules-of-court')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Legal Maxims
                                    </h6>
                                    <span class="h2 mb-0">
                                        <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Legal Maxims">
                                        <span class="text-4xl">{{number_format($maxim_count)}}</span> <span class="text-muted">Maxims</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/forms-and-precedents')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Resources
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt="Resources">
                                    <span class="text-4xl">{{number_format($resource_count)}}</span> <span class="text-muted">Resources</span>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <hr>
    </div>
    <div class="container-fluid mt-6">
        <div class="header-body mb-4 mt-n5 mt-md-n6">
          <div class="row align-items-center">
            <div class="col">
                <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="year-tab" data-toggle="tab" href="#year" role="tab" aria-controls="year" aria-selected="true">
                            LegalPedia Activities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="subject-tab" data-toggle="tab" href="#subject" role="tab" aria-controls="subject" aria-selected="false">
                            My Activities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="legal-tab" data-toggle="tab" href="#legal" role="tab" aria-controls="legal" aria-selected="false">
                            Team Activities
                        </a>
                    </li>
                </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="wizardSteps">
                    <div class="tab-pane fade show active" id="year" role="tabpanel" aria-labelledby="year-tab">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-group list-group-lg list-group-flush list my-n4">
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="#!" class="avatar text-color avatar-lg">
                                                    <i class="fe fe-file"></i>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <h4 class="mb-1 item-name">
                                                    <a href="">Some Content</a>
                                                </h4>
                                                <p class="card-text small text-muted">
                                                    26th, December 2021
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject-tab">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-group list-group-lg list-group-flush list my-n4">
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="#!" class="avatar text-color avatar-lg">
                                                    <i class="fe fe-file"></i>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <h4 class="mb-1 item-name">
                                                    <a href="">Some Content</a>
                                                </h4>
                                                <p class="card-text small text-muted">
                                                    26th, December 2021
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="legal" role="tabpanel" aria-labelledby="legal-tab">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-group list-group-lg list-group-flush list my-n4">
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="#!" class="avatar text-color avatar-lg">
                                                    <i class="fe fe-file"></i>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <h4 class="mb-1 item-name">
                                                    <a href="">Some Content</a>
                                                </h4>
                                                <p class="card-text small text-muted">
                                                    26th, December 2021
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
