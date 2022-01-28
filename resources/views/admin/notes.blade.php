@extends('layouts.admin.notes')

@section('title')
    <title>Notes - Legalpedia</title>
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
                            Notes
                        </h1>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#admin_note" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="fe fe-plus"></i> Add note
                        </a>
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
                        <a class="nav-link active" id="public-tab" data-toggle="tab" href="#public" role="tab" aria-controls="public" aria-selected="true">
                            Public Notes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="my-tab" data-toggle="tab" href="#my" role="tab" aria-controls="my" aria-selected="false">
                            My Notes
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
                    <div class="tab-pane fade show active" id="public" role="tabpanel" aria-labelledby="public-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Public Notes</h4>
                                <h4>{{$public_note_count}} records</h4>
                            </div>
                            <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                @if(count($public_notes) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($public_notes as $note)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                <i class="fe fe-file"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            @php
                                                                $judgement_summary = App\Models\JudgementSummary::where('suit_no', $note->content_id)->first();
                                                                $fed = App\Models\LawOfFederation::where('id', $note->content_id)->first();
                                                                $rule = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $state_rule = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $form = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $article = App\Models\Rule::where('id', $note->content_id)->first();
                                                            @endphp
                                                            @if($note->resource_type == 'judgement')
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'fed')
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'rule')
                                                                <a href="{{route('show.rule', $rule ? $rule->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'state-rule')
                                                                <a href="{{route('show.state-rule', $state_rule ? $state_rule->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'form')
                                                                <a href="{{route('show.form', $form ? $form->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'article')
                                                                <a href="{{route('show.article', $article ? $article->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                            @endif
                                                        </h4>
                                                        <p class="small text-gray-700 mb-2">
                                                            @php
                                                                $note->content = json_decode($note->content);
                                                            @endphp
                                                            @if($note->content)
                                                                {{ucwords(strtolower($note->content->selector[0]->exact))}}
                                                            @endif
                                                        </p>
                                                        {{-- <p class="small text-color mb-1">
                                                            @php
                                                                $user = App\Models\User::where('id', $note->user_id)->first();
                                                            @endphp
                                                            <a href="{{route('user.profile', $user->id)}}" class="text-color">By {{$user->name}}</a>
                                                        </p> --}}
                                                        <p class="card-text small text-muted">
                                                            {{$note->created_at->diffForHumans()}}
                                                        </p>
                                                        <h4 class="mb-2 item-name">
                                                            @if($note->resource_type == 'judgement')
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">
                                                                    {{$judgement_summary ? $judgement_summary->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'fed')
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-primary">
                                                                    {{$fed ? $fed->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'rule')
                                                                <a href="{{route('show.rule', $rule ? $rule->id : '')}}" class="text-primary">
                                                                    {{$rule ? $rule->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'state-rule')
                                                                <a href="{{route('show.state-rule', $state_rule ? $state_rule->id : '')}}" class="text-primary">
                                                                    {{$state_rule ? $state_rule->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'form')
                                                                <a href="{{route('show.form', $form ? $form->id : '')}}" class="text-primary">
                                                                    {{$form ? $form->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'article')
                                                                <a href="{{route('show.article', $article ? $article->id : '')}}" class="text-primary">
                                                                    {{$article ? $article->title : ''}}
                                                                </a>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            @if($note->resource_type !== 'admin-note')
                                                                <a data-bs-toggle="modal" onclick="showTeamModal('{{$note->content->selector[0]->exact}}', '{{$note->id}}')" class="dropdown-ellipses dropdown-toggle cursor">
                                                                    <i class="mdi mdi-share-variant"></i>
                                                                </a>
                                                                @else
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a data-bs-toggle="modal" onclick="showEditNote('{{$note->comment}}', '{{$note->content}}', '{{$note->id}}')" class="dropdown-item cursor">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/notes/{{$note->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deleteNoteFunction();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @elseif(count($public_notes) < 1)
                                    @foreach($admin_notes as $note)
                                        <div class="list-group-item">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-sm">
                                                        <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                            <i class="fe fe-file"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col ms-n2">
                                                    <h5 class="mb-1">
                                                        <a href="{{url('admin/notes')}}">
                                                            {{$note->comment}}
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-sm" style="visibility: hidden">
                                                        <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                            <i class="fe fe-file"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <p class="small text-gray-700 mb-0">
                                                        {!! $note->content !!}
                                                    </p>
                                                    <p class="card-text small text-muted">
                                                        {{$note->created_at->diffForHumans()}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
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
                    <div class="tab-pane fade" id="my" role="tabpanel" aria-labelledby="my-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLists">
                            <div class="card-header">
                                <h4 class="card-header-title">My Notes</h4>
                                <h4>{{number_format($note_count)}} records</h4>
                            </div>
                            <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                @if(count($notes) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($notes as $note)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                <i class="fe fe-file"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            @php
                                                                $judgement_summary = App\Models\JudgementSummary::where('suit_no', $note->content_id)->first();
                                                                $fed = App\Models\LawOfFederation::where('id', $note->content_id)->first();
                                                                $rule = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $state_rule = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $form = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $article = App\Models\Rule::where('id', $note->content_id)->first();
                                                            @endphp
                                                            @if($note->resource_type == 'judgement')
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'fed')
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'rule')
                                                                <a href="{{route('show.rule', $rule ? $rule->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'state-rule')
                                                                <a href="{{route('show.state-rule', $state_rule ? $state_rule->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'form')
                                                                <a href="{{route('show.form', $form ? $form->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'article')
                                                                <a href="{{route('show.article', $article ? $article->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                            @endif
                                                        </h4>
                                                        <p class="small text-gray-700 mb-2">
                                                            @php
                                                                $note->content = json_decode($note->content);
                                                            @endphp
                                                            @if($note->content)
                                                                {{ucwords(strtolower($note->content->selector[0]->exact))}}
                                                            @endif
                                                        </p>
                                                        {{-- <p class="small text-color mb-1">
                                                            @php
                                                                $user = App\Models\User::where('id', $note->user_id)->first();
                                                            @endphp
                                                            <a href="{{route('user.profile', $user->id)}}" class="text-color">By {{$user->name}}</a>
                                                        </p> --}}
                                                        <p class="card-text small text-muted">
                                                            {{$note->created_at->diffForHumans()}}
                                                        </p>
                                                        <h4 class="mb-2 item-name">
                                                            @if($note->resource_type == 'judgement')
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">
                                                                    {{$judgement_summary ? $judgement_summary->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'fed')
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-primary">
                                                                    {{$fed ? $fed->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'rule')
                                                                <a href="{{route('show.rule', $rule ? $rule->id : '')}}" class="text-primary">
                                                                    {{$rule ? $rule->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'state-rule')
                                                                <a href="{{route('show.state-rule', $state_rule ? $state_rule->id : '')}}" class="text-primary">
                                                                    {{$state_rule ? $state_rule->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'form')
                                                                <a href="{{route('show.form', $form ? $form->id : '')}}" class="text-primary">
                                                                    {{$form ? $form->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'article')
                                                                <a href="{{route('show.article', $article ? $article->id : '')}}" class="text-primary">
                                                                    {{$article ? $article->title : ''}}
                                                                </a>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                    {{-- <div class="col-auto">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="dropdown-item">
                                                                    <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @elseif(count($notes) < 1)
                                    @foreach($admin_notes as $note)
                                        <div class="list-group-item">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-sm">
                                                        <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                            <i class="fe fe-file"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col ms-n2">
                                                    <h5 class="mb-1">
                                                        <a href="{{url('admin/notes')}}">
                                                            {{$note->comment}}
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-sm" style="visibility: hidden">
                                                        <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                            <i class="fe fe-file"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <p class="small text-gray-700 mb-0">
                                                        {!! $note->content  !!}
                                                    </p>
                                                    <p class="card-text small text-muted">
                                                        {{$note->created_at->diffForHumans()}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
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
    <div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title" id="exampleModalCenterTitle">
                            Share Note to teams
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('share.anote')}}" method="POST">
                        @csrf
                        <div class="card-header">
                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                <input class="form-control list-search" type="search" placeholder="Search">
                                <div class="input-group-text">
                                <span class="fe fe-search"></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check mb-n2">
                                    <input class="form-check-input list-checkbox-all" name="checkBoxArray" id="ordersSelectAll" type="checkbox">
                                    <label class="form-check-label" for="ordersSelectAll">&nbsp;</label> All Teams
                                </div>
                            </div>
                            <div class="col-auto me-n3">
                                <input type="hidden" name="anote_id" id="anote-id">
                                <input type="hidden" name="comment_body" id="anote-content">
                                <button type="submit" name="share_all" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-share-variant-outline"></i> Share</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my-n3">
                                @if(count($teams) > 0)
                                    @foreach($teams as $team)
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-1">
                                                    <div class="form-check mb-n2">
                                                        <input class="form-check-input list-checkbox" type="checkbox" name="checkBoxArray[]" id="ordersSelectOne" value="{{$team->team_id}}">
                                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <?php $my_team = App\Models\Team::where('id', $team->team_id)->first(); ?>
                                                    <a href="{{route('show.team', $team->team_id)}}" class="avatar avatar-lg">
                                                        <img src="{{$my_team->photo}}" class="avatar-img rounded-circle w-2 h-2" alt="{{$my_team->name}}">
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="mb-1 name">
                                                        <a href="{{route('show.team', $team->team_id)}}">{{$my_team->name}}</a>
                                                    </h4>
                                                    <?php $team_member_count = App\Models\UserTeam::where('approve_request', 1)->where('team_id', $team->team_id)->count(); ?>
                                                    <small class="text-muted">
                                                        {{$team_member_count}} members
                                                    </small>
                                                </div>
                                                <div class="col-3">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                    <input type="hidden" name="team_id" value="{{$team->team_id}}">
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    @else
                                    <div class="text-center mt-8 mb-8">
                                        <h3 class="text-muted"><i class="fe fe-users"></i> You have no teams</h3>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kt_modal_create_project" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Make your notes public or private</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.anote')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <p class="mb-5 text-muted">Make notes searchable</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="display" class="form-select">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>
                                <input type="hidden" name="note_id" id="note-id">
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save Note</span>
                                </button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="admin_note" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Create a note</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('store.note')}}" method="POST">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <p class="mb-5 text-muted">Create a note to display for new customers</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Title
                                    </label>
                                    <input type="text" name="comment" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" class="form-control" rows="5" placeholder="Enter note"></textarea>
                                </div>
                                <input type="hidden" name="note_id" value="{{$admin_note_id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="display" value="public">
                                <input type="hidden" name="resource_type" value="admin-note">
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Add Note</span>
                                </button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editNote" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Edit note</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.note')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <p class="mb-5 text-muted">Edit note to display for new customers</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Title
                                    </label>
                                    <input type="text" name="comment" id="note-comment" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" id="note-content" class="form-control" rows="5" placeholder="Enter note"></textarea>
                                </div>
                                <input type="hidden" name="admin_note_id" id="admin-note-id">
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save Note</span>
                                </button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showTeamModal(content, id){
            document.getElementById("anote-content").value = content;
            document.getElementById("anote-id").value = id;
            $('#teamModal').modal('show')
        }

        function showNoteModal(comment, content, id){
            document.getElementById("note-comment").value = comment;
            document.getElementById("note-content").value = content;
            document.getElementById("admin-note-id").value = id;
            $('#editNote').modal('show')

            tinymce.init({
                selector: '#note-content',
                setup: function (editor) {
                    editor.on('init', function (e) {
                        editor.setContent('<p>'+ content +'</p>');
                    });
                }
            });
        }

        function deleteNoteFunction() {
            if(!confirm("Are you sure you want to delete this note?"))
            event.preventDefault();
        }
    </script>
@endsection
