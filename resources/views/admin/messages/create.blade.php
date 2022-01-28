@extends('layouts.admin.messages')

@section('title')
    <title>Create Messages - Legalpedia</title>
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
                            Create Messages
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
            <form action="{{route('store.message')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label mb-1">
                        What's the name of this message ?
                    </label>
                    <input type="text" name="name" class="form-control" placeholder="e.g Welcome message">
                </div>

                <div class="form-group">
                    <label class="form-label mb-1">
                        Type of Message
                    </label>
                    <select name="type" id="message_type" class="form-select" onchange="showDiv('normal', 'auto', this)">
                        <option value="">Select Type</option>
                        <option value="in-app">In-app Message</option>
                        <option value="normal">Email Message</option>
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
                        <input type="text" name="receipient" class="form-control" placeholder="e.g Customers with active Subscription">
                    </div>
                </div>
                <div id="auto" style="display: none">
                    <div class="form-group">
                        <label class="form-label mb-1">
                            Receipient
                        </label>
                        <select name="receipient_type" class="form-select">
                            <option value="">Select Receipient Type</option>
                            <option value="dob">Date of birth message</option>
                            <option value="ctb">Call to bar message</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label mb-1">
                        Subject of Message
                    </label>
                    <small class="form-text text-muted">
                        This is the subject of the message
                    </small>
                    <input type="text" name="subject" class="form-control" placeholder="e.g Welcome to Legalpedia">
                </div>
                <div class="form-group">
                    <label class="form-label mb-1">
                        Message Body
                    </label>
                    <small class="form-text text-muted">
                        This is the body or content of the message
                    </small>
                    <textarea name="body" rows="5" class="form-control" placeholder="e.g Hello Emmanuel, You can now access thousands of records of recent and old Judgments, Laws, Rules, Articles and so much more!"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                        <span class="button__text">
                            <i class="mdi mdi-message"></i> Create Message
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
