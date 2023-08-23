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
        <div class="col-lg-6">
            <h3 style="color: #D93C3D;">{{$result_title}}</h3>
        </div>
        <div class="col-lg-6">
            <a class="btn" href="mailto:{{Auth()->user()->email}}?body={{$summary}}">
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