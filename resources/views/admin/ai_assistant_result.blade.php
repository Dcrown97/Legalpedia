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
                <a href="{{ url('admin/judgements') }}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i>
                    Back</a>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-6">
            <h3 style="color: #D93C3D;">{{$result_title}}</h3>
        </div>
        <div class="col-lg-6">
            <button class="btn">
                <i class="fe fe-bookmark"></i> Save for Later
            </button>
            <button class="btn">
                <i class="fe fe-share"></i> Share via Email 
            </button>
            <button class="btn btn-primary bgRed text-white">
                <i class="fe fe-users"></i> Share with Team
            </button>
        </div>
    </div>
    </div>
    
    <div style="background-color: #FFF; padding: 20px">
        {{$summary}}
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
    </script>
</div>


@endsection