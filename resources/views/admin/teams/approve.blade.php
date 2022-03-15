@extends('layouts.admin.teams')

@section('title')
    <title>Teams - Legalpedia</title>
@endsection

@section('content')
    <style>
        .nav.btn-group .btn-white.active {
            background-color: #EC6959 !important;
            border-color: #EC6959 !important;
        }
        .mt-51 {
            margin-top: 50px !important;
        }
        .text-green-0{
            color: #32E017 !important;
        }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/teams')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Approve new members
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div data-list='{"valueNames": ["name"]}'>
                    <div class="" data-list='{"valueNames": ["name"], "listClass": "listAlias"}'>
                        <div class="row mb-4">
                            <div class="col">
                                <form>
                                    <div class="input-group input-group-lg input-group-merge input-group-reverse">
                                        <input class="form-control list-search" type="text" placeholder="Search members" style="height: 50px">
                                        <div class="input-group-text">
                                            <span class="fe fe-search"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row listAlias">
                            <div class="col-12">
                                @if(count($new_members) > 0)
                                    @foreach ($new_members as $new_member)
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="avatar avatar-lg">
                                                        <?php $user = App\Models\User::where('id', $new_member->user_id)->first(); ?>
                                                        @if($user->photo)
                                                            <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                            @else
                                                            <div class="initials">
                                                                <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                                            </div>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col ms-n2">
                                                    <h4 class="mb-1 item-name">
                                                        <a href="{{route('user.profile', $new_member->user_id)}}">{{$user->name}}</a>
                                                    </h4>
                                                    <p class="card-text small text-muted">
                                                        Requested at {{\Carbon\Carbon::parse($new_member->created_at)->toFormattedDateString()}}
                                                    </p>
                                                </div>
                                                @if($new_member->approve_request == 0)
                                                    <div class="col-auto">
                                                        <form action="{{route('approve.request', $new_member->id)}}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH') }}
                                                            <input type="hidden" name="approve_request" value="1">
                                                            <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-success">
                                                                <span class="button__text"><i class="mdi mdi-check"></i> Approve</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @elseif($new_member->approve_request == 1)
                                                    <div class="col-auto">
                                                        <form action="{{route('decline.request', $new_member->id)}}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PATCH') }}
                                                            <input type="hidden" name="approve_request" value="0">
                                                            <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                                                <span class="button__text"><i class="mdi mdi-close"></i> Decline</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="text-center mt-8 mb-8">
                                        <h3 class="text-muted"><i class="fe fe-users"></i> There are no requests</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
