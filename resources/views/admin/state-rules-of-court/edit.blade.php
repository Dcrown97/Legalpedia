@extends('layouts.admin.state-rules-of-court')

@section('title')
    @if($order)
        <title>{{$order->title}} - Legalpedia</title>
        @elseif($schedule)
        <title>{{$schedule->title}} - Legalpedia</title>
        @elseif($part)
        <title>{{$part->title}} - Legalpedia</title>
        @elseif($form)
        <title>{{$form->title}} - Legalpedia</title>
        @elseif($probate_form)
        <title>{{$probate_form->title}} - Legalpedia</title>
        @elseif($civil_form)
        <title>{{$civil_form->title}} - Legalpedia</title>
        @elseif($appendix)
        <title>{{$appendix->title}} - Legalpedia</title>
    @endif
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/state-rules-of-court')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            @if($order)
                                {{$order->title}}
                                @elseif($schedule)
                                {{$schedule->title}}
                                @elseif($part)
                                {{$part->title}}
                                @elseif($form)
                                {{$form->title}}
                                @elseif($probate_form)
                                {{$probate_form->title}}
                                @elseif($civil_form)
                                {{$civil_form->title}}
                                @elseif($appendix)
                                {{$appendix->title}}
                            @endif
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body p-5">
                        @if($order)
                            <form action="{{route('update.state-rule', $order->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                State
                                            </label>
                                            <select name="name" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$order->name}}" selected>{{$order->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{Str::upper($state->name)}}">{{Str::upper($state->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Section
                                            </label>
                                            <select name="section" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$order->section}}" selected>{{$order->section}}</option>
                                                <option value="ORDERS">ORDERS</option>
                                                <option value="PARTS">PARTS</option>
                                                <option value="SCHEDULES">SCHEDULES</option>
                                                <option value="FORMS">FORMS</option>
                                                <option value="PROBATE FORMS">PROBATE FORMS</option>
                                                <option value="CIVIL FORMS">CIVIL FORMS</option>
                                                <option value="APPENDIX">APPENDIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        State Rule Title
                                    </label>
                                    <input type="hidden" name="type" value="State">
                                    <input type="text" name="title" class="form-control" value="{{$order->title}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Version No.
                                    </label>
                                    <input type="text" name="version_no" class="form-control" value="{{$order->version_no}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" rows="5" class="form-control" placeholder="Enter description">{{$order->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                    </button>
                                </div>
                            </form>
                            @elseif($schedule)
                            <form action="{{route('update.state-rule', $schedule->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                State
                                            </label>
                                            <select name="name" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$schedule->name}}" selected>{{$schedule->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{Str::upper($state->name)}}">{{Str::upper($state->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Section
                                            </label>
                                            <select name="section" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$schedule->section}}" selected>{{$schedule->section}}</option>
                                                <option value="ORDERS">ORDERS</option>
                                                <option value="PARTS">PARTS</option>
                                                <option value="SCHEDULES">SCHEDULES</option>
                                                <option value="FORMS">FORMS</option>
                                                <option value="PROBATE FORMS">PROBATE FORMS</option>
                                                <option value="CIVIL FORMS">CIVIL FORMS</option>
                                                <option value="APPENDIX">APPENDIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        State Rule Title
                                    </label>
                                    <input type="hidden" name="type" value="State">
                                    <input type="text" name="title" class="form-control" value="{{$schedule->title}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Version No.
                                    </label>
                                    <input type="text" name="version_no" class="form-control" value="{{$schedule->version_no}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" rows="5" class="form-control" placeholder="Enter description">{{$schedule->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                    </button>
                                </div>
                            </form>
                            @elseif($form)
                            <form action="{{route('update.state-rule', $form->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                State
                                            </label>
                                            <select name="name" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$form->name}}" selected>{{$form->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{Str::upper($state->name)}}">{{Str::upper($state->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Section
                                            </label>
                                            <select name="section" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$form->section}}" selected>{{$form->section}}</option>
                                                <option value="ORDERS">ORDERS</option>
                                                <option value="PARTS">PARTS</option>
                                                <option value="SCHEDULES">SCHEDULES</option>
                                                <option value="FORMS">FORMS</option>
                                                <option value="PROBATE FORMS">PROBATE FORMS</option>
                                                <option value="CIVIL FORMS">CIVIL FORMS</option>
                                                <option value="APPENDIX">APPENDIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        State Rule Title
                                    </label>
                                    <input type="hidden" name="type" value="State">
                                    <input type="text" name="title" class="form-control" value="{{$form->title}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Version No.
                                    </label>
                                    <input type="text" name="version_no" class="form-control" value="{{$form->version_no}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" rows="5" class="form-control" placeholder="Enter description">{{$form->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                    </button>
                                </div>
                            </form>
                            @elseif($part)
                            <form action="{{route('update.state-rule', $part->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                State
                                            </label>
                                            <select name="name" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$part->name}}" selected>{{$part->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{Str::upper($state->name)}}">{{Str::upper($state->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Section
                                            </label>
                                            <select name="section" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$part->section}}" selected>{{$part->section}}</option>
                                                <option value="ORDERS">ORDERS</option>
                                                <option value="PARTS">PARTS</option>
                                                <option value="SCHEDULES">SCHEDULES</option>
                                                <option value="FORMS">FORMS</option>
                                                <option value="PROBATE FORMS">PROBATE FORMS</option>
                                                <option value="CIVIL FORMS">CIVIL FORMS</option>
                                                <option value="APPENDIX">APPENDIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        State Rule Title
                                    </label>
                                    <input type="hidden" name="type" value="State">
                                    <input type="text" name="title" class="form-control" value="{{$part->title}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Version No.
                                    </label>
                                    <input type="text" name="version_no" class="form-control" value="{{$part->version_no}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" rows="5" class="form-control" placeholder="Enter description">{{$part->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                    </button>
                                </div>
                            </form>
                            @elseif($probate_form)
                            <form action="{{route('update.state-rule', $probate_form->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                State
                                            </label>
                                            <select name="name" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$probate_form->name}}" selected>{{$probate_form->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{Str::upper($state->name)}}">{{Str::upper($state->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Section
                                            </label>
                                            <select name="section" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$probate_form->section}}" selected>{{$probate_form->section}}</option>
                                                <option value="ORDERS">ORDERS</option>
                                                <option value="PARTS">PARTS</option>
                                                <option value="SCHEDULES">SCHEDULES</option>
                                                <option value="FORMS">FORMS</option>
                                                <option value="PROBATE FORMS">PROBATE FORMS</option>
                                                <option value="CIVIL FORMS">CIVIL FORMS</option>
                                                <option value="APPENDIX">APPENDIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        State Rule Title
                                    </label>
                                    <input type="hidden" name="type" value="State">
                                    <input type="text" name="title" class="form-control" value="{{$probate_form->title}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Version No.
                                    </label>
                                    <input type="text" name="version_no" class="form-control" value="{{$probate_form->version_no}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" rows="5" class="form-control" placeholder="Enter description">{{$probate_form->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                    </button>
                                </div>
                            </form>
                            @elseif($civil_form)
                            <form action="{{route('update.state-rule', $civil_form->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                State
                                            </label>
                                            <select name="name" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$civil_form->name}}" selected>{{$civil_form->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{Str::upper($state->name)}}">{{Str::upper($state->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Section
                                            </label>
                                            <select name="section" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$civil_form->section}}" selected>{{$civil_form->section}}</option>
                                                <option value="ORDERS">ORDERS</option>
                                                <option value="PARTS">PARTS</option>
                                                <option value="SCHEDULES">SCHEDULES</option>
                                                <option value="FORMS">FORMS</option>
                                                <option value="PROBATE FORMS">PROBATE FORMS</option>
                                                <option value="CIVIL FORMS">CIVIL FORMS</option>
                                                <option value="APPENDIX">APPENDIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        State Rule Title
                                    </label>
                                    <input type="hidden" name="type" value="State">
                                    <input type="text" name="title" class="form-control" value="{{$civil_form->title}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Version No.
                                    </label>
                                    <input type="text" name="version_no" class="form-control" value="{{$civil_form->version_no}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" rows="5" class="form-control" placeholder="Enter description">{{$civil_form->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                    </button>
                                </div>
                            </form>
                            @elseif($appendix)
                            <form action="{{route('update.state-rule', $appendix->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                State
                                            </label>
                                            <select name="name" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$appendix->name}}" selected>{{$appendix->name}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{Str::upper($state->name)}}">{{Str::upper($state->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Section
                                            </label>
                                            <select name="section" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="{{$appendix->section}}" selected>{{$appendix->section}}</option>
                                                <option value="ORDERS">ORDERS</option>
                                                <option value="PARTS">PARTS</option>
                                                <option value="SCHEDULES">SCHEDULES</option>
                                                <option value="FORMS">FORMS</option>
                                                <option value="PROBATE FORMS">PROBATE FORMS</option>
                                                <option value="CIVIL FORMS">CIVIL FORMS</option>
                                                <option value="APPENDIX">APPENDIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        State Rule Title
                                    </label>
                                    <input type="hidden" name="type" value="State">
                                    <input type="text" name="title" class="form-control" value="{{$appendix->title}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Version No.
                                    </label>
                                    <input type="text" name="version_no" class="form-control" value="{{$appendix->version_no}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Content
                                    </label>
                                    <textarea name="content" rows="5" class="form-control" placeholder="Enter description">{{$appendix->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
      </div>
@endsection
