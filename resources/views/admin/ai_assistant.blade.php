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
</style>

<div class="container-fluid" style="background-color: #fff;">
    @include('elements.notifications')
    <form method="post" action="{{route('admin.aiSummary')}}" enctype="multipart/form-data">
        @csrf
        <div class="py-5 mt-5 mx-auto" style="background-color: #F8FAFF; border: 1px dashed #F3F7FF">
            <div style="text-align:center">
                <h4 style="font-weight: bold">Upload a Document </h4>
                <p>Upload the document you need Legalpedia AI help you summarise and analyse</p>
            </div>


            <div class="mx-auto mt-5 row p-4" style="width: 60%; border: 1px dashed rgba(0, 0, 0, 0.25); background: #fff">
                <input type="file" name="uploadedFile" id="uploadedFile" accept="application/pdf" style="display: none">
                <div class="col-lg-2">
                    <img src="{{asset('assets/images/upload.svg')}}" alt="upload" height="48px">
                </div>
                <div class="col-lg-7">
                    <h4>Select a file</h4>
                    <p style="color: rgba(0, 0, 0, 0.40);">PDF, file size no more than 10MB</p>
                    <p id="fileName"></p>
                </div>
                <div class="col-lg-3">
                    <button class="selectFile p-2" type="button" onclick="handleSelectFile()">
                        Select File
                    </button>
                </div>
            </div>
            <br>
            
            <div class="mx-auto row p-4">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <label for="">Type</label>
                    <select name="type" class="form-control">
                        <option value="judgement">Judgement</option>
                        <option value="lfn">Laws of Federation</option>
                        <option value="agreement">Agreement</option>
                    </select>
                </div> 
            </div>
            
            <hr style="margin-bottom: 0px;">
            <div class="btn-row">
                <button class="aiBtn2 p-2">
                    Cancel
                </button>
                <button type="submit" class="aiBtn2 p-2">
                    Save Document
                </button>
                <button type="submit" class="aiBtn2 p-2">
                    Analyse
                </button>
            </div>
        </div>
    </form>

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