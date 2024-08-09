@extends('layouts.admin.featured-content')

@section('title')
    <title>Featured Content - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
        }

        .modal-content {
            width: 100% !important;
            height: auto !important;
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
                            Featured Content
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-51">
        <div class="header-body mb-4 mt-n5 mt-md-n6">
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="team-tab" data-toggle="tab" href="#team" role="tab"
                                aria-controls="team" aria-selected="true">
                                Featured Teams
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="user-tab" data-toggle="tab" href="#user" role="tab"
                                aria-controls="user" aria-selected="false">
                                Featured Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="article-tab" data-toggle="tab" href="#article" role="tab"
                                aria-controls="article" aria-selected="false">
                                Featured Articles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab"
                                aria-controls="form" aria-selected="false">
                                Featured Forms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="note-tab" data-toggle="tab" href="#note" role="tab"
                                aria-controls="note" aria-selected="false">
                                Featured Notes
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
                    <div class="tab-pane fade show active" id="team" role="tabpanel" aria-labelledby="team-tab">
                        <div data-list='{"valueNames": ["name"]}'>
                            <div class="" data-list='{"valueNames": ["name"], "listClass": "listAlias"}'>
                                {{-- <div class="row mb-4">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-lg input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="text" placeholder="Search Teams" style="height: 50px">
                                                <div class="input-group-text">
                                                    <span class="fe fe-search"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                                <div class="row list">
                                    @if (count($featured_teams) > 0)
                                        @foreach ($featured_teams as $featured_team)
                                            <div class="col-12">
                                                @php
                                                    // $newTeams = App\Models\Team::orderBy('id', 'desc')->paginate(10);
                                                    $newTeam = App\Models\Team::where(
                                                        'id',
                                                        $featured_team->reference_id,
                                                    )->first();
                                                @endphp
                                                {{-- @foreach ($newTeams as $newTeam) --}}
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <a href="{{ route('show.team', $newTeam->id) }}"
                                                                    class="avatar avatar-lg avatar-4by3">
                                                                    <img src="{{ $newTeam->photo }}"
                                                                        alt="{{ $newTeam->name }}"
                                                                        class="avatar-img rounded">
                                                                </a>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h4 class="mb-1 name">
                                                                    <a
                                                                        href="{{ route('show.team', $newTeam->id) }}">{{ $newTeam->name }}</a>
                                                                </h4>
                                                                <p class="card-text small text-muted">
                                                                    Created
                                                                    {{ \Carbon\Carbon::parse($newTeam->created_at)->toFormattedDateString() }}
                                                                </p>
                                                                @php
                                                                    $rating_count = App\Models\FeaturedContent::where(
                                                                        'type',
                                                                        'team',
                                                                    )
                                                                        ->where('review_type', 'rating')
                                                                        ->where('reference_id', $newTeam->id)
                                                                        ->count();
                                                                    $rating = App\Models\FeaturedContent::where(
                                                                        'type',
                                                                        'team',
                                                                    )
                                                                        ->where('review_type', 'rating')
                                                                        ->where('reference_id', $newTeam->id)
                                                                        ->max('rating');
                                                                @endphp
                                                                @if ($rating_count > 0)
                                                                    <small>{{ number_format($rating_count) }} .
                                                                        {{ getRating($rating) }} </small>
                                                                @else
                                                                    <small class="text-muted">No rating</small>
                                                                @endif
                                                            </div>
                                                            <div class="col-auto">
                                                                @if ($featured_team->featured == 1)
                                                                    <form
                                                                        action="{{ route('admin.save-feature', $featured_team->reference_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="featured"
                                                                            value="0">
                                                                        <input type="hidden" name="type" value="team">
                                                                        <button type="submit" name="remove_featured"
                                                                            class="btn btn-custom"
                                                                            onclick="this.classList.toggle('button--loading')">
                                                                            <span class="button__text"><i
                                                                                    class="mdi mdi-close"></i>Remove
                                                                                Featured</span>
                                                                        </button>
                                                                    </form>
                                                                @elseif($featured_team->featured == 0)
                                                                    <form
                                                                        action="{{ route('admin.save-feature', $featured_team->reference_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="featured"
                                                                            value="1">
                                                                        <input type="hidden" name="type"
                                                                            value="team">
                                                                        <button type="submit" name="make_featured"
                                                                            class="btn btn-primary"
                                                                            onclick="this.classList.toggle('button--loading')">
                                                                            <span class="button__text"><i
                                                                                    class="mdi mdi-check"></i>Make
                                                                                Featured</span>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- @endforeach --}}
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center mt-8 mb-8">
                                            <h3 class="text-muted"><i class="fe fe-users"></i> There are no featured teams
                                            </h3>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card"
                                    data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'
                                    id="contactsLists">
                                    {{-- <div class="card-header">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search">
                                                <div class="input-group-text">
                                                    <span class="fe fe-search"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div> --}}
                                    <div class="card-body">
                                        @if (count($featured_users) > 0)
                                            <ul id="table_data"
                                                class="list-group table_data list-group-lg list-group-flush list my-n4">
                                                @foreach ($featured_users as $featured_user)
                                                    @php
                                                        // $users = App\Models\User::orderBy('id', 'desc')->paginate(10);
                                                        $user = App\Models\User::where(
                                                            'id',
                                                            $featured_user->reference_id,
                                                        )->first();
                                                    @endphp
                                                    {{-- @foreach ($users as $user) --}}
                                                    <li class="list-group-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <a href="{{ route('user.profile', $user->id) }}"
                                                                    class="avatar avatar-lg">
                                                                    @if ($user->photo)
                                                                        <img src="{{ $user->photo }}"
                                                                            class="avatar-img rounded-circle"
                                                                            alt="{{ $user->name }}">
                                                                    @else
                                                                        <div class="initials">
                                                                            <span>{{ Str::limit($user->name, 1, '') }}{{ Str::limit($user->surname, 1, '') }}</span>
                                                                        </div>
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h4 class="mb-1 item-name">
                                                                    <a
                                                                        href="{{ route('user.profile', $user->id) }}">{{ $user->name }}</a>
                                                                </h4>
                                                                <span class="mb-4">
                                                                    @php
                                                                        $rating_count = App\Models\FeaturedContent::where(
                                                                            'type',
                                                                            'user',
                                                                        )
                                                                            ->where('review_type', 'rating')
                                                                            ->where('reference_id', $user->id)
                                                                            ->count();
                                                                        $rating = App\Models\FeaturedContent::where(
                                                                            'type',
                                                                            'user',
                                                                        )
                                                                            ->where('review_type', 'rating')
                                                                            ->where('reference_id', $user->id)
                                                                            ->max('rating');
                                                                    @endphp
                                                                    @if ($rating_count > 0)
                                                                        <a href="#reviews"><small>{{ number_format($rating_count) }}
                                                                                . {{ getRating($rating) }} </small></a>
                                                                    @else
                                                                        <small class="text-muted">No rating</small>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="col-auto">
                                                                @if ($featured_user->featured == 1)
                                                                    <form
                                                                        action="{{ route('admin.save-feature', $featured_user->reference_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="featured"
                                                                            value="0">
                                                                        <input type="hidden" name="type"
                                                                            value="user">
                                                                        <button type="submit" name="remove_featured"
                                                                            class="btn btn-custom"
                                                                            onclick="this.classList.toggle('button--loading')">
                                                                            <span class="button__text"><i
                                                                                    class="mdi mdi-close"></i>Remove
                                                                                Featured</span>
                                                                        </button>
                                                                    </form>
                                                                @elseif($featured_user->featured == 0)
                                                                    <form
                                                                        action="{{ route('admin.save-feature', $featured_user->reference_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="featured"
                                                                            value="1">
                                                                        <input type="hidden" name="type"
                                                                            value="user">
                                                                        <button type="submit" name="make_featured"
                                                                            class="btn btn-primary"
                                                                            onclick="this.classList.toggle('button--loading')">
                                                                            <span class="button__text"><i
                                                                                    class="mdi mdi-check"></i>Make
                                                                                Featured</span>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                    {{-- @endforeach --}}
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="text-center mt-8 mb-8">
                                                <h3 class="text-muted"><i class="fe fe-users"></i> There are no featured
                                                    users</h3>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row g-0">
                                        <ul
                                            class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                            <li class="page-item">
                                                <a class="page-link" href="#">
                                                    <i class="fe fe-arrow-left me-1"></i> Prev
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="col list-pagination pagination pagination-tabs justify-content-center">
                                        </ul>
                                        <ul
                                            class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                            <li class="page-item">
                                                <a class="page-link" href="#">
                                                    Next <i class="fe fe-arrow-right ms-1"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="article" role="tabpanel" aria-labelledby="article-tab">
                        <div class="card"
                            data-list='{"valueNames": ["item-name1"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'
                            id="contactsList">
                            {{-- <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search titles">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div> --}}
                            <div class="card-body">
                                @if (count($featured_articles) > 0)
                                    <ul class="list-group table_data list-group-lg list-group-flush list my-n4">
                                        @foreach ($featured_articles as $featured_article)
                                            @php
                                                // $articles = App\Models\Article::orderBy('id', 'desc')->paginate(10);
                                                $article = App\Models\Article::where(
                                                    'id',
                                                    $featured_article->reference_id,
                                                )->first();
                                            @endphp
                                            {{-- @foreach ($articles as $article) --}}
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <a href="{{ route('show.article', $article->id) }}"
                                                            class="avatar avatar-lg avatar-4by3">
                                                            <img src="{{ $article->photo ? $article->photo : '/assets/images/article.jpg' }}"
                                                                alt="{{ $article->title }}" class="avatar-img rounded">

                                                        </a>
                                                    </div>
                                                    <div class="col ms-n2">
                                                        <h4 class="mb-1 item-name1">
                                                            <a
                                                                href="{{ route('show.article', $article->id) }}">{{ $article->title }}</a>
                                                        </h4>
                                                        <p class="card-text small text-color">
                                                            @if ($article->authur == 'Legalpedia')
                                                                <a href="{{ route('user.profile', $article->user_id) }}"
                                                                    class="text-color">By {{ $article->authur }}</a>
                                                            @else
                                                                <a href="/admin/user/profile/{{ $article->user_id }}"
                                                                    class="text-color">By {{ $article->authur }}</a>
                                                                {{-- <a href="{{ route('user.profile', $article->user_id) }}"
                                                                            class="text-color">By {{ $article->authur }}</a> --}}
                                                            @endif
                                                        </p>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where(
                                                                'type',
                                                                'article',
                                                            )
                                                                ->where('review_type', 'rating')
                                                                ->where('reference_id', $article->id)
                                                                ->count();
                                                            $rating = App\Models\FeaturedContent::where(
                                                                'type',
                                                                'article',
                                                            )
                                                                ->where('review_type', 'rating')
                                                                ->where('reference_id', $article->id)
                                                                ->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{ number_format($rating_count) }} .
                                                                {{ getRating($rating) }} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <div class="col-auto">
                                                        @if ($featured_article->featured == 1)
                                                            <form
                                                                action="{{ route('admin.save-feature', $featured_article->reference_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="featured" value="0">
                                                                <input type="hidden" name="type" value="article">
                                                                <button type="submit" name="remove_featured"
                                                                    class="btn btn-custom"
                                                                    onclick="this.classList.toggle('button--loading')">
                                                                    <span class="button__text"><i
                                                                            class="mdi mdi-close"></i>Remove
                                                                        Featured</span>
                                                                </button>
                                                            </form>
                                                        @elseif($featured_article->featured == 0)
                                                            <form
                                                                action="{{ route('admin.save-feature', $featured_article->reference_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="featured" value="1">
                                                                <input type="hidden" name="type" value="article">
                                                                <button type="submit" name="make_featured"
                                                                    class="btn btn-primary"
                                                                    onclick="this.classList.toggle('button--loading')">
                                                                    <span class="button__text"><i
                                                                            class="mdi mdi-check"></i>Make
                                                                        Featured</span>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                            {{-- @endforeach --}}
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> There are no featured articles
                                        </h3>
                                    </div>
                                @endif
                            </div>
                            <!-- Pagination -->
                            <div class="row g-0">
                                <!-- Pagination (prev) -->
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <!-- Pagination -->
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <!-- Pagination (next) -->
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
                        <div class="card"
                            data-list='{"valueNames": ["item-name2"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'
                            id="contactsListss">
                            {{-- <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($public_form_count)}} records</h4>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                @if (count($featured_forms) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach ($featured_forms as $featured_form)
                                            @php
                                                // $forms = App\Models\FormsPrecedence::orderBy('id', 'desc')->paginate(
                                                //     10,
                                                // );
                                                $form = App\Models\FormsPrecedence::where(
                                                    'id',
                                                    $featured_form->reference_id,
                                                )->first();
                                            @endphp
                                            {{-- @foreach ($forms as $form) --}}
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <a href="{{ route('show.form', $form->id) }}"
                                                            class="avatar text-color avatar-lg">
                                                            <i class="fe fe-file"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <a
                                                                href="{{ route('show.form', $form->id) }}">{{ $form->title }}</a>
                                                        </h4>
                                                        <p class="card-text text-muted small mb-1">Category: <span
                                                                class="text-color">{{ $form->category }}</span></p>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where(
                                                                'type',
                                                                'form',
                                                            )
                                                                ->where('review_type', 'rating')
                                                                ->where('reference_id', $form->id)
                                                                ->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'form')
                                                                ->where('review_type', 'rating')
                                                                ->where('reference_id', $form->id)
                                                                ->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{ number_format($rating_count) }} .
                                                                {{ getRating($rating) }} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <div class="col-auto">
                                                        @if ($featured_form->featured == 1)
                                                            <form
                                                                action="{{ route('admin.save-feature', $featured_form->reference_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="featured" value="0">
                                                                <input type="hidden" name="type" value="form">
                                                                <button type="submit" name="remove_featured"
                                                                    class="btn btn-custom"
                                                                    onclick="this.classList.toggle('button--loading')">
                                                                    <span class="button__text"><i
                                                                            class="mdi mdi-close"></i>Remove
                                                                        Featured</span>
                                                                </button>
                                                            </form>
                                                        @elseif($featured_form->featured == 0)
                                                            <form
                                                                action="{{ route('admin.save-feature', $featured_form->reference_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="featured" value="1">
                                                                <input type="hidden" name="type" value="form">
                                                                <button type="submit" name="make_featured"
                                                                    class="btn btn-primary"
                                                                    onclick="this.classList.toggle('button--loading')">
                                                                    <span class="button__text"><i
                                                                            class="mdi mdi-check"></i>Make
                                                                        Featured</span>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                            {{-- @endforeach --}}
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i>There are no featured forms</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="note" role="tabpanel" aria-labelledby="note-tab">
                        <div class="card"
                            data-list='{"valueNames": ["item-name3"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'
                            id="contactsLi">
                            {{-- <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div> --}}
                            <div class="card-body">
                                @if (count($featured_notes) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach ($featured_notes as $featured_note)
                                            @php
                                                // $notes = App\Models\Annotation::orderBy('id', 'desc')->paginate(10);
                                                $note = App\Models\Annotation::where(
                                                    'id',
                                                    $featured_note->reference_id,
                                                )->first();
                                            @endphp
                                            {{-- @foreach ($notes as $note) --}}
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <div
                                                                class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                <i class="fe fe-file"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h4 class="mb-1 item-name3">
                                                                    @php
                                                                        $judgement_summary = App\Models\JudgementSummary::where(
                                                                            'suit_no',
                                                                            'LIKE',
                                                                            '%' . $note->content_id . '%',
                                                                        )->first();
                                                                        $fed = App\Models\LawOfFederation::where(
                                                                            'id',
                                                                            $note->content_id,
                                                                        )->first();
                                                                        $rule = App\Models\Rule::where(
                                                                            'id',
                                                                            $note->content_id,
                                                                        )->first();
                                                                        $state_rule = App\Models\Rule::where(
                                                                            'id',
                                                                            $note->content_id,
                                                                        )->first();
                                                                        $form = App\Models\Rule::where(
                                                                            'id',
                                                                            $note->content_id,
                                                                        )->first();
                                                                        $article = App\Models\Rule::where(
                                                                            'id',
                                                                            $note->content_id,
                                                                        )->first();
                                                                    @endphp
                                                                    @if ($note->resource_type == 'judgement')
                                                                        <a
                                                                            href="{{ route('show.judgement', $judgement_summary ? $judgement_summary->id : '') }}">
                                                                            @php
                                                                                $note->comment = json_decode(
                                                                                    $note->comment,
                                                                                );
                                                                            @endphp
                                                                            @if ($note->comment)
                                                                                @foreach ($note->comment as $comment_type)
                                                                                    {{ ucwords(strtolower($comment_type->value)) }}
                                                                                @endforeach
                                                                            @endif
                                                                        </a>
                                                                    @elseif($note->resource_type == 'fed')
                                                                        <a
                                                                            href="{{ route('show.fed', $fed ? $fed->id : '') }}">
                                                                            @php
                                                                                $note->comment = json_decode(
                                                                                    $note->comment,
                                                                                );
                                                                            @endphp
                                                                            @if ($note->comment)
                                                                                @foreach ($note->comment as $comment_type)
                                                                                    {{ ucwords(strtolower($comment_type->value)) }}
                                                                                @endforeach
                                                                            @endif
                                                                        </a>
                                                                    @elseif($note->resource_type == 'rule')
                                                                        <a
                                                                            href="{{ route('show.rule', $rule ? $rule->id : '') }}">
                                                                            @php
                                                                                $note->comment = json_decode(
                                                                                    $note->comment,
                                                                                );
                                                                            @endphp
                                                                            @if ($note->comment)
                                                                                @foreach ($note->comment as $comment_type)
                                                                                    {{ ucwords(strtolower($comment_type->value)) }}
                                                                                @endforeach
                                                                            @endif
                                                                        </a>
                                                                    @elseif($note->resource_type == 'state-rule')
                                                                        <a
                                                                            href="{{ route('show.state-rule', $state_rule ? $state_rule->id : '') }}">
                                                                            @php
                                                                                $note->comment = json_decode(
                                                                                    $note->comment,
                                                                                );
                                                                            @endphp
                                                                            @if ($note->comment)
                                                                                @foreach ($note->comment as $comment_type)
                                                                                    {{ ucwords(strtolower($comment_type->value)) }}
                                                                                @endforeach
                                                                            @endif
                                                                        </a>
                                                                    @elseif($note->resource_type == 'form')
                                                                        <a
                                                                            href="{{ route('show.form', $form ? $form->id : '') }}">
                                                                            @php
                                                                                $note->comment = json_decode(
                                                                                    $note->comment,
                                                                                );
                                                                            @endphp
                                                                            @if ($note->comment)
                                                                                @foreach ($note->comment as $comment_type)
                                                                                    {{ ucwords(strtolower($comment_type->value)) }}
                                                                                @endforeach
                                                                            @endif
                                                                        </a>
                                                                    @elseif($note->resource_type == 'article')
                                                                        <a
                                                                            href="{{ route('show.article', $article ? $article->id : '') }}">
                                                                            @php
                                                                                $note->comment = json_decode(
                                                                                    $note->comment,
                                                                                );
                                                                            @endphp
                                                                            @if ($note->comment)
                                                                                @foreach ($note->comment as $comment_type)
                                                                                    {{ ucwords(strtolower($comment_type->value)) }}
                                                                                @endforeach
                                                                            @endif
                                                                        </a>
                                                                    @endif
                                                                </h4>
                                                            </div>
                                                            <div class="col-auto">
                                                                @if ($featured_note->featured == 1)
                                                                    <form
                                                                        action="{{ route('admin.save-feature', $featured_note->reference_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="featured"
                                                                            value="0">
                                                                        <input type="hidden" name="type"
                                                                            value="note">
                                                                        <button type="submit" name="remove_featured"
                                                                            class="btn btn-custom mb-4"
                                                                            onclick="this.classList.toggle('button--loading')">
                                                                            <span class="button__text"><i
                                                                                    class="mdi mdi-close"></i>Remove
                                                                                Featured</span>
                                                                        </button>
                                                                    </form>
                                                                @elseif($featured_note->featured == 0)
                                                                    <form
                                                                        action="{{ route('admin.save-feature', $featured_note->reference_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="featured"
                                                                            value="1">
                                                                        <input type="hidden" name="type"
                                                                            value="note">
                                                                        <button type="submit" name="make_featured"
                                                                            class="btn btn-primary mb-4"
                                                                            onclick="this.classList.toggle('button--loading')">
                                                                            <span class="button__text"><i
                                                                                    class="mdi mdi-check"></i>Make
                                                                                Featured</span>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @php
                                                            $note->content = json_decode($note->content);
                                                        @endphp
                                                        <p class="small text-gray-700 mb-2">

                                                            @if ($note->content)
                                                                {{ ucwords(strtolower(str_replace("\"", '', $note->content->selector[0]->exact))) }}
                                                            @endif
                                                        </p>
                                                        <p class="card-text small text-muted">
                                                            {{ $note->created_at->diffForHumans() }}
                                                        </p>
                                                        <p class="card-text small text-color">
                                                            @php
                                                                $note_user = App\Models\User::where(
                                                                    'id',
                                                                    $note->user_id,
                                                                )->first();
                                                            @endphp
                                                            By <a href="{{ route('user.profile', $note->user_id) }}"
                                                                class="text-color">{{ $note_user->name }}
                                                                {{ $note_user->surname }}</a>
                                                        </p>
                                                        <h4 class="mb-2 item-name">
                                                            @if ($note->resource_type == 'judgement')
                                                                <a href="{{ route('show.judgement', $judgement_summary ? $judgement_summary->id : '') }}"
                                                                    class="text-primary">
                                                                    {{ $judgement_summary ? $judgement_summary->title : '' }}
                                                                </a>
                                                            @elseif($note->resource_type == 'fed')
                                                                <a href="{{ route('show.fed', $fed ? $fed->id : '') }}"
                                                                    class="text-primary">
                                                                    {{ $fed ? $fed->title : '' }}
                                                                </a>
                                                            @elseif($note->resource_type == 'rule')
                                                                <a href="{{ route('show.rule', $rule ? $rule->id : '') }}"
                                                                    class="text-primary">
                                                                    {{ $rule ? $rule->title : '' }}
                                                                </a>
                                                            @elseif($note->resource_type == 'state-rule')
                                                                <a href="{{ route('show.state-rule', $state_rule ? $state_rule->id : '') }}"
                                                                    class="text-primary">
                                                                    {{ $state_rule ? $state_rule->title : '' }}
                                                                </a>
                                                            @elseif($note->resource_type == 'form')
                                                                <a href="{{ route('show.form', $form ? $form->id : '') }}"
                                                                    class="text-primary">
                                                                    {{ $form ? $form->title : '' }}
                                                                </a>
                                                            @elseif($note->resource_type == 'article')
                                                                <a href="{{ route('show.article', $article ? $article->id : '') }}"
                                                                    class="text-primary">
                                                                    {{ $article ? $article->title : '' }}
                                                                </a>
                                                            @endif
                                                        </h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where(
                                                                'type',
                                                                'note',
                                                            )
                                                                ->where('review_type', 'rating')
                                                                ->where('reference_id', $note->id)
                                                                ->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'note')
                                                                ->where('review_type', 'rating')
                                                                ->where('reference_id', $note->id)
                                                                ->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <a href="#reviews"><small>{{ number_format($rating_count) }}
                                                                    .
                                                                    {{ getRating($rating) }} </small></a>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                        <br>
                                                        @php
                                                            $like_count = App\Models\Like::where(
                                                                'annotation_id',
                                                                $note->id,
                                                            )
                                                                ->where('like', 1)
                                                                ->count();
                                                        @endphp
                                                        <span id="like-div{{ $note->id }}">
                                                            <small id="like-no{{ $note->id }}"
                                                                class="text-color">{{ $like_count }} </small>
                                                            @if ($like_count < 2)
                                                                like
                                                            @else
                                                                likes
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                            {{-- @endforeach --}}
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i>There are no featured notes</h3>
                                    </div>
                                @endif
                            </div>
                            <!-- Pagination -->
                            <div class="row g-0">
                                <!-- Pagination (prev) -->
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <!-- Pagination -->
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <!-- Pagination (next) -->
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showTeamModal(content, id) {
            document.getElementById("anote-content").value = content;
            document.getElementById("anote-id").value = id;
            $('#teamModal').modal('show')
        }

        function showNoteDisplay(id) {
            document.getElementById("note-id").value = id;
            $('#noteDisplay').modal('show')
        }

        function showNoteModal(comment, content, id) {
            document.getElementById("note-comment").value = comment;
            document.getElementById("note-content").value = content;
            document.getElementById("admin-note-id").value = id;
            $('#editNote').modal('show')

            tinymce.init({
                selector: '#note-content',
                setup: function(editor) {
                    editor.on('init', function(e) {
                        editor.setContent('<p>' + content + '</p>');
                    });
                }
            });
        }

        function deleteNoteFunction() {
            if (!confirm("Are you sure you want to delete this note?"))
                event.preventDefault();
        }
    </script>
@endsection
