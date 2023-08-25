@extends('layouts.admin.ai')

@section('title')
<title>AI Assistant - Legalpedia</title>
@endsection

@section('content')
<style>
    .selectFile {
        border-radius: 5px;
        border: 1px solid var(--legal-sec-red, #EC6959);
        background: #FBFDFE;
        color: var(--legal-sec-red, #EC6959);
    }

    .aiBtn2 {
        border-radius: 5px;
        background: #FFF;
        color: #000;
        font-family: Helvetica;
        font-size: 14px;
        border: 1px solid #FFF;
    }

    .btn-row {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        background-color: #F3F7FF;
        padding: 20px;
    }

    .bgRed{
        background-color: #D93C3D;
    }
</style>

<div class="container-fluid" style="background-color: #fff;">
    <div class="header-body">
        <div class="row align-items-end mb-4">
            <div class="col">
                <a href="{{ url('admin/ai-assistant') }}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i>
                    Back</a>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-7">
            <h1 style="color: #D93C3D; font-weight: 700; font-size: larger;">{{$result_title}}</h1>
        </div>
        <div class="col-lg-5">
            <a class="btn" href="mailto:{{Auth()->user()->email}}">
                <i class="fe fe-share"></i> Share via Email 
            </a>
            <button class="btn btn-primary bgRed text-white" data-bs-toggle="modal" data-bs-target="#popModal" id="kt_toolbar_primary_button">
                <i class="fe fe-users"></i> Share with Team
            </button>
        </div>
    </div>
    </div>
    
    <div style="background-color: #FFF; padding: 20px">
        {!! $summary !!}
    </div>

    <div class="modal fade" id="popModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div>
                    <div class="modal-card card">
                        <div class="card-body">
                            <h1 class="card-title">Share With Teams</h1>
                            <p class="mb-5">Share your AI Summarized document with your teams</p>
                            @foreach($teams as $team)
                                <div class="row mb-3">
                                    <div class="col-lg-8">
                                        <h4 class="mb-2 name">
                                            <a href="{{route('show.team', $team->id)}}">{{$team->name}}</a>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-primary bgRed text-white" onclick='sendToTeam({{$team->id}})'>
                                            <i class="fe fe-share"></i> Share with Team
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleSelectFile() {
            $('#uploadedFile').click()
        }

        $('#uploadedFile').change(function(){
            var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')
            $('#fileName').html(filename)
            console.log($('input[type=file]')[0].files)
        })

        function sendToTeam(team_id){
            var user_id = "{{Auth::user() ? Auth::user()->id : ''}}";
            var comment_body = $('#summaryText').html()
            $.ajax({
                type:'POST',
                url: "{{route('post.commentApi')}}",
                data:{
                    "_token": "{{ csrf_token() }}",
                    user_id:user_id,
                    team_id:team_id,
                    comment_body:comment_body,
                },
                success:function(data){
                    swal({
                        title: "Success!",
                        text: 'Shared with team successfully',
                        icon: "success",
                    });
                },
                error: function(error) {
                    swal({
                        title: "Error!",
                        text: 'Couldn\'t share with team at the moment, please try again later',
                        icon: "error",
                    });
                }
            });
        }
    </script>
</div>


@endsection