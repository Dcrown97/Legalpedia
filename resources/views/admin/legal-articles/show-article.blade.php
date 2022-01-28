@extends('layouts.admin.legal-articles')

@section('title')
    <title>{{$article->title}} - Legalpedia</title>
@endsection

@section('content')
    <style>
        .article-image {
            height: 300px !important;
            object-fit: cover !important;
        }

        .modal-content {
            width: 100% !important;
            height: auto !important;
        }
    </style>
    <link href="{{asset('assets/css/recogito.min.css')}}" rel="stylesheet">
    <div class="header">
        <img src="{{$article ? $article->photo : ''}}" class="header-img-top" alt="{{$article->title}}">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/legal-articles')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title text-center" style="color: #990033">
                            {{$article->title}}
                        </h1>
                    </div>
                    @if(Auth::user()->id == $article->user_id)
                        <div class="col-auto">
                            <a href="{{route('edit.article', $article->id)}}" class="btn btn-primary text-white">
                                <i class="mdi mdi-pencil"></i> Edit Article
                            </a>
                        </div>
                        @elseif($article->article_type == 'legalpedia' && Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="{{route('edit.article', $article->id)}}" class="btn btn-primary text-white">
                                <i class="mdi mdi-pencil"></i> Edit Article
                            </a>
                        </div>
                    @endif
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="header-title"><a href="{{route('user.profile', Auth::user()->id)}}"> By {{$article->authur}}</a></h3>
                        <small class="text-muted">
                            Posted: <span class="text-color">{{\Carbon\Carbon::parse($article->created_at)->toFormattedDateString()}}</span>
                        </small>
                        <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-share-variant"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a data-bs-toggle="modal" data-bs-target="#share_articles" id="kt_toolbar_primary_button" class="cursor dropdown-item">
                                        <i class="fe fe-users mr-2"></i> Share to teams
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text={{route('articles', $article->id)}}" target="_blank" class="dropdown-item">
                                        <i class="mdi mdi-whatsapp mr-2"></i> Share to Whatsapp
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{route('articles', $article->id)}}" target="_blank" class="dropdown-item">
                                        <i class="mdi mdi-facebook mr-2"></i> Share to Facebook
                                    </a>
                                    <a class="dropdown-item d-flex">
                                        <i class="fe fe-paperclip mr-2"></i><input type="button" class="custom-button dropdown-item" id="hide-copy" value="Copy Link" onclick="Copy();" style="margin-left: -20px; margin-top: -8px;">
                                        <span class="text-color" id="show-status" style="display: none;">Link copied!</span>
                                    </a>
                                    <span><input type="text" style="position: absolute; opacity: 0;" id="paste-box"></span>
                                    @if(Auth::user()->id == $article->user_id)
                                        <form action="/admin/legal-articles/{{$article->id}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                <i class="fe fe-trash mr-2"></i>Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        <h3 class="text-muted">Category</h3>
                        <p class="card-text mb-1">{!! $article->category !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">Area(s) of Law</h3>
                        <p class="card-text mb-1">{!! $article->area_of_law !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">Description</h3>
                        <p class="card-text mb-1">{!! $article->description !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">Content</h3>
                        <p class="card-text mb-1" id="my-content">{!! $article->content !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">References</h3>
                        <p class="card-text mb-1">{!! $article->references !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">Link</h3>
                        <p class="card-text mb-1">
                            <a href="{{$article->link}}" target="_blank" class="text-color">{{ $article->link}}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="share_articles" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title" id="exampleModalCenterTitle">
                            Share Article to teams
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('share.article', $article->id)}}" method="POST">
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
                                <input type="hidden" name="team_id">
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
                                                    <input type="hidden" name="article_id" value="{{$article->id}}">
                                                    <?php $link = route('show.article', $article->id);
                                                        $article_data = [$article->title, $article->description, $link] ;
                                                    ?>
                                                    <input type="hidden" name="comment_body" value="{{ json_encode([$article->title, $article->description, $link]) }}">
                                                    <input type="hidden" name="file" value="{{substr($article->photo, 31)}}">
                                                    <input type="hidden" name="file_type" value="image">
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
    <script src="{{asset('assets/js/recogito.min.js')}}"></script>
    <script>
        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this article?"))
            event.preventDefault();
        }
        function Copy()
        {
            var Url = document.getElementById("paste-box");
            // Url.value = window.location.href;
            Url.value = "{{route('articles', $article->id)}}";
            Url.focus();
            Url.select();
            document.execCommand("Copy");

            document.getElementById('hide-copy').style.display = 'none';
            document.getElementById('show-status').style.display = 'block';
        }

        (function() {
        var r = Recogito.init({
            content: document.getElementById('my-content') // ID or DOM element
        });

        // Add an event handler
        r.on('createAnnotation', function(annotation) { /** **/ });
        })();
    </script>
@endsection
