@extends('layouts.admin.ai')

@section('title')
<title>AI Assistant - Legalpedia</title>
@endsection

@section('content')
<style>
    @font-face {
    font-family: 'AI';
        src:
        url("{{asset('assets/fonts/FuturaBoldfont.ttf')}}") format('truetype');
        font-weight: bold;
        font-style: normal;
    }
    .overlay {
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255, 255, 255, 0.8) url("{{asset('assets/images/loading.gif')}}") center no-repeat;
    }

    /* Turn off scrollbar when body element has the loading class */
    body.loading {
        overflow: hidden;
    }

    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay {
        display: block;
    }

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
        border: 1px solid #000;
        border-radius: 5px;
    }

    .aiBtn3 {
        border-radius: 5px;
        background: rgb(254 0 0 / 100%);
        color: #fff;
        font-family: Helvetica;
        font-size: 14px;
        border: 1px solid #FFF;
        border-radius: 5px;
    }

    .btn-row {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        background-color: #FFF;
        padding: 20px;
    }
</style>

<div class="container-fluid" style="background-color: #fff;">
    <div class="overlay"></div>
    @include('elements.notifications')
    <form method="post" action="{{route('admin.aiSummary')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6 p-5" style="height:90vh; background-color: rgb(254 0 0 / 3%); font-family: AI">
                <h1 style="font-size: 48px; color: red; font-weight: 800; margin-top:10px; margin-bottom: 0px">Legalpedia<span style="color: #000;">Lens</span></h1>
                <p style="font-size: 20px; font-family: AI">AI Powered Document Assistant</p>
                <br>
                <br>
                <br>
                <br>
                

                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" style="font-family: AI">
                    <div class="carousel-item active">
                        <br>
                        <h1 style="font-size: 42px; font-weight: 800; font-family: AI">Analyze</h1>
                        <ol>
                            <li style="font-size: 31.5px;">Decided Cases</li>
                            <li style="font-size: 31.5px;">Laws</li>
                            <li style="font-size: 31.5px;">Legal Agreements</li>
                        </ol>
                    </div>
                    <div class="carousel-item">
                        <br>
                        <h1 style="font-size: 42px; font-weight: 800; font-family: AI">In 3 simple steps</h1>
                        <ol>
                            <li style="font-size: 31.5px;">Upload your document</li>
                            <li style="font-size: 31.5px;">Select the type of document</li>
                            <li style="font-size: 31.5px;">Let LegalpediaLens do its magic</li>
                        </ol>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                </div>
            </div>
            <div class="col-lg-6 p-0">
                <div class="py-5 mt-5 mx-auto" style="background-color: #FFF; height: 90vh;">
                    <div style="text-align:center">
                        <h4 style="font-weight: bold">Upload a Document </h4>
                        <p>Upload the document you need Legalpedia AI help you summarise and analyse</p>
                    </div>


                    <div class="mx-auto mt-5 row p-4" style="width: 80%; border: 1px dashed rgba(0, 0, 0, 0.25); background: #fff">
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

                    <div class="mx-auto row px-2 py-4">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <label for="">Select Type</label>
                            <select name="type" class="form-select">
                                <option value="judgement">Judgement</option>
                                <option value="lfn">Laws of Federation</option>
                                <option value="agreement">Agreement</option>
                            </select>
                        </div>
                    </div>

                    <hr style="margin-bottom: 0px;">
                    <div class="btn-row">
                        <button type="submit" id="sb" class="aiBtn3 p-2">
                            Analyse
                        </button>
                        <button class="aiBtn2 p-2" type="button">
                            Cancel
                        </button>
                        <!-- <button type="submit" id="sb" class="aiBtn2 p-2">
                            Save Document
                        </button> -->
                        
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script>
        function handleSelectFile() {
            $('#uploadedFile').click()
        }

        $(document).ready(function(){
            $('.carousel').carousel({
                interval: 5000
            })
        })
       

        $('#uploadedFile').change(function() {
            var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')
            $('#fileName').html(filename)
            console.log($('input[type=file]')[0].files)
        })

        $('#sb').click(function() {
            $("body").addClass("loading");
        })
    </script>
</div>


@endsection