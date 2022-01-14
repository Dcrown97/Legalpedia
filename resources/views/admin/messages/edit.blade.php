@extends('layouts.admin.messages')

@section('title')
    <title>Edit Message - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
        }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/messages')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Edit Message
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
          <div class="col-12 col-lg-10 col-xl-8">
            <form action="{{route('update.message', $message->id)}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('patch') }}
                <div class="form-group">
                    <label class="form-label mb-1">
                        What's the name of this message ?
                    </label>
                    <input type="text" name="name" class="form-control" placeholder="e.g Welcome message" value="{{$message->name}}">
                </div>

                @if($message->type == 'normal')
                    <div class="form-group">
                        <label class="form-label mb-1">
                            Type of Message
                        </label>
                        <select name="type" id="message_type" class="form-select" onchange="showDiv('normal', 'auto', this)">
                            <option value="{{$message->type}}" selected>Normal Message</option>
                            <option value="in-app">In-app Message</option>
                            <option value="automated">Automated Message</option>
                        </select>
                    </div>
                    <div id="normal">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Receipient
                            </label>
                            <small class="form-text text-muted">
                                Who are the receipients of this message?
                            </small>
                            <input type="text" name="receipient" class="form-control" placeholder="e.g Customers with active Subscription" value="{{$message->receipient}}">
                        </div>
                    </div>
                    <div id="auto" style="display: none">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Receipient
                            </label>
                            <select name="receipient_type" class="form-select">
                                <option value="{{$message->receipient_type}}" selected>{{$message->receipient_type}}</option>
                                <option value="dob">Date of birth message</option>
                                <option value="ctb">Call to bar message</option>
                            </select>
                        </div>
                    </div>
                    @elseif($message->type == 'automated')
                    <div class="form-group">
                        <label class="form-label mb-1">
                            Type of Message
                        </label>
                        <select name="type" id="message_type" class="form-select" onchange="showDiv('normal', 'auto', this)">
                            <option value="{{$message->type}}" selected>Automated Message</option>
                            <option value="in-app">In-app Message</option>
                            <option value="normal">Normal Message</option>
                        </select>
                    </div>
                    <div id="normal" style="display: none">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Receipient
                            </label>
                            <small class="form-text text-muted">
                                Who are the receipients of this message?
                            </small>
                            <input type="text" name="receipient" class="form-control" placeholder="e.g Customers with active Subscription" value="{{$message->receipient}}">
                        </div>
                    </div>
                    <div id="auto">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Receipient
                            </label>
                            <select name="receipient_type" class="form-select">
                                <option value="{{$message->receipient_type}}" selected>{{$message->receipient_type}}</option>
                                <option value="dob">Date of birth message</option>
                                <option value="ctb">Call to bar message</option>
                            </select>
                        </div>
                    </div>
                    @elseif($message->type == 'in-app')
                    <div class="form-group">
                        <label class="form-label mb-1">
                            Type of Message
                        </label>
                        <select name="type" id="message_type" class="form-select" onchange="showDiv('normal', 'auto', this)">
                            <option value="{{$message->type}}" selected>In-app message</option>
                            <option value="normal">Normal Message</option>
                            <option value="automated">Automated Message</option>
                        </select>
                    </div>
                    <div id="normal" style="display: none">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Receipient
                            </label>
                            <small class="form-text text-muted">
                                Who are the receipients of this message?
                            </small>
                            <input type="text" name="receipient" class="form-control" placeholder="e.g Customers with active Subscription" value="{{$message->receipient}}">
                        </div>
                    </div>
                    <div id="auto">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Receipient
                            </label>
                            <select name="receipient_type" class="form-select">
                                <option value="{{$message->receipient_type}}" selected>{{$message->receipient_type}}</option>
                                <option value="dob">Date of birth message</option>
                                <option value="ctb">Call to bar message</option>
                            </select>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="form-label mb-1">
                        Subject of Message
                    </label>
                    <small class="form-text text-muted">
                        This is the subject of the message as it is in the email
                    </small>
                    <input type="text" name="subject" class="form-control" placeholder="e.g Welcome to Legalpedia" value="{{$message->subject}}">
                </div>
                <div class="form-group">
                    <label class="form-label mb-1">
                        Message Body
                    </label>
                    <small class="form-text text-muted">
                        This is the body or content of the message as it is in the email
                    </small>
                    <textarea name="body" rows="5" class="form-control" placeholder="e.g Hello Emmanuel, You can now access thousands of records of recent and old Judgments, Laws, Rules, Articles and so much more!">
                        {{$message->body}}
                    </textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                        <span class="button__text">
                            <i class="mdi mdi-check"></i> Save Message
                        </span>
                    </button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <script>
        function showDiv(normal, auto, element)
        {
            document.getElementById(normal).style.display = element.value == 'normal' ? 'block' : 'none';
            document.getElementById(auto).style.display = element.value == 'automated' ? 'block' : 'none';
        }
    </script>
@endsection
