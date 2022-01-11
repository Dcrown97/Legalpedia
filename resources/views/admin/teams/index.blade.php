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
                        <h6 class="header-pretitle">
                        </h6>
                        <h1 class="header-title">
                            Teams
                        </h1>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="fe fe-plus"></i> Create Team
                        </a>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-51">
        <div class="header-body mb-4 mt-n5 mt-md-n6">
          <div class="row align-items-center">
            <div class="col">
                <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="team-tab" data-toggle="tab" href="#team" role="tab" aria-controls="team" aria-selected="true">
                            My Teams
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="all-team-tab" data-toggle="tab" href="#all-teams" role="tab" aria-controls="all-teams" aria-selected="false">
                            All Teams
                        </a>
                    </li>
                </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="wizardSteps">
                    <div class="tab-pane fade show active" id="team" role="tabpanel" aria-labelledby="team-tab">
                        <div class="row listAlias">
                            @if(count($my_teams) > 0)
                                @foreach($my_teams as $my_team)
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="card">
                                            <a href="{{route('show.team', $my_team->id)}}">
                                                <img src="{{$my_team->photo ? $my_team->photo : ''}}" alt="..." class="card-img-top">
                                            </a>
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-2 name">
                                                            <a href="{{route('show.team', $my_team->id)}}">{{$my_team->name}}</a>
                                                        </h4>
                                                        <p class="card-text small text-muted">
                                                            Created {{\Carbon\Carbon::parse($my_team->created_at)->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a style="cursor: pointer" data-bs-toggle="modal" onclick="showEditTeamModal('{{$my_team->name}}', '{{$my_team->id}}', '{{$my_team->description}}', '{{$my_team->photo}}', '{{$my_team->user_id}}', '{{$my_team->team_owner}}')" class="dropdown-item">
                                                                    <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                </a>
                                                                <form action="/admin/teams/{{$my_team->id}}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                                        <i class="fe fe-trash mr-2"></i>Delete
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer card-footer-boxed">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="row align-items-center g-0">
                                                            <div class="col-auto">
                                                                <?php $my_team_member_count = App\Models\UserTeam::where('approve_request', 1)->where('team_id', $my_team->id)->count(); ?>
                                                                <div class="small me-2">{{$my_team_member_count}} Members</div>
                                                            </div>
                                                            <div class="col text-center">
                                                                <div class="me-2 text-color"><a href="" class="text-green-0"><i class="fas fa-check-circle text-success"></i> Joined</a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="avatar-group">
                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Ab Hadley">
                                                                <img src="{{asset('assets/images/user-avatar.jpg')}}" alt="..." class="avatar-img rounded-circle">
                                                            </a>
                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Adolfo Hess">
                                                                <img src="{{asset('assets/images/user-avatar.jpg')}}" alt="..." class="avatar-img rounded-circle">
                                                            </a>
                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Daniela Dewitt">
                                                                <img src="{{asset('assets/images/user-avatar.jpg')}}" alt="..." class="avatar-img rounded-circle">
                                                            </a>
                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Miyah Myles">
                                                                <img src="{{asset('assets/images/user-avatar.jpg')}}" alt="..." class="avatar-img rounded-circle">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="text-center mt-8">
                                    <h3 class="text-muted"><i class="fe fe-users"></i> You don't own a team</h3>
                                    <div class="col-auto mt-2">
                                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                            <i class="fe fe-plus"></i> Create Team
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="all-teams" role="tabpanel" aria-labelledby="all-team-tab">
                        <div data-list='{"valueNames": ["name"]}'>
                            <div class="" data-list='{"valueNames": ["name"], "listClass": "listAlias"}'>
                                <div class="row mb-4">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-lg input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="text" placeholder="Search Teams" style="height: 50px">
                                                <div class="input-group-text">
                                                    <span class="fe fe-search"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto">
                                        <div class="nav btn-group" role="tablist">
                                            <button class="btn btn-lg btn-white active mr-2" data-bs-toggle="tab" data-bs-target="#tabPaneOne" role="tab" aria-controls="tabPaneOne" aria-selected="true">
                                                <span class="fe fe-grid"></span>
                                            </button>
                                            <button class="btn btn-lg btn-white" data-bs-toggle="tab" data-bs-target="#tabPaneTwo" role="tab" aria-controls="tabPaneTwo" aria-selected="false">
                                                <span class="fe fe-list"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="tabPaneOne" role="tabpanel">
                                        <div class="row listAlias">
                                            @if(count($teams) > 0)
                                                @foreach($teams as $team)
                                                    <div class="col-12 col-md-6 col-xl-4">
                                                        <div class="card">
                                                            <a href="{{route('show.team', $team->id)}}">
                                                                <img src="{{$team->photo}}" alt="{{$team->name}}" class="card-img-top">
                                                            </a>
                                                            <div class="card-body">
                                                                <div class="row align-items-center">
                                                                    <div class="col">
                                                                        <h4 class="mb-2 name">
                                                                            <a href="{{route('show.team', $team->id)}}">{{$team->name}}</a>
                                                                        </h4>
                                                                        <p class="card-text small text-muted">
                                                                            Created {{\Carbon\Carbon::parse($team->created_at)->toFormattedDateString()}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer card-footer-boxed">
                                                                <div class="row align-items-center">
                                                                    <div class="col">
                                                                        <div class="row align-items-center g-0">
                                                                            <div class="col-auto">
                                                                                <?php $all_team_member_count = App\Models\UserTeam::where('approve_request', 1)->where('team_id', $team->id)->count(); ?>
                                                                                <div class="small me-2">{{$all_team_member_count}} Members</div>
                                                                            </div>
                                                                            <div class="col text-center">
                                                                                <?php $approved_member = App\Models\UserTeam::where('user_id', Auth::user()->id)->where('approve_request', 1)->where('team_id', $team->id)->first(); ?>
                                                                                @if($approved_member)
                                                                                    @if(Auth::user()->id == $team->user_id || $approved_member->approve_request == 1)
                                                                                        <div class="me-2 text-color"><span class="text-green-0"><i class="fas fa-check-circle text-success"></i> Joined</span></div>
                                                                                        @else
                                                                                        <div class="me-2 text-color"><a href="{{route('show.team', $team->id)}}" class="text-color"><i class="mdi mdi-plus"></i> Join Team</a></div>
                                                                                    @endif
                                                                                    @else
                                                                                    <div class="me-2 text-color"><a href="{{route('show.team', $team->id)}}" class="text-color"><i class="mdi mdi-plus"></i> Join Team</a></div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <div class="avatar-group">
                                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Ab Hadley">
                                                                            <img src="{{asset('assets/images/user-avatar.jpg')}}" alt="..." class="avatar-img rounded-circle">
                                                                            </a>
                                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Adolfo Hess">
                                                                            <img src="{{asset('assets/images/user-avatar.jpg')}}" alt="..." class="avatar-img rounded-circle">
                                                                            </a>
                                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Daniela Dewitt">
                                                                            <img src="{{asset('assets/images/user-avatar.jpg')}}" alt="..." class="avatar-img rounded-circle">
                                                                            </a>
                                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Miyah Myles">
                                                                            <img src="{{asset('assets/images/user-avatar.jpg')}}" alt="..." class="avatar-img rounded-circle">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @else
                                                <div class="text-center mt-8">
                                                    <h3 class="text-muted"><i class="fe fe-users"></i> There are currently no teams</h3>
                                                    <div class="col-auto mt-2">
                                                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                                            <i class="fe fe-plus"></i> Create Team
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tabPaneTwo" role="tabpanel">
                                        <div class="row list">
                                            @if(count($teams) > 0)
                                                @foreach ($teams as $team)
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <a href="{{route('show.team', $team->id)}}" class="avatar avatar-lg avatar-4by3">
                                                                            <img src="{{$team->photo}}" alt="{{$team->name}}" class="avatar-img rounded">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col ms-n2">
                                                                        <h4 class="mb-1 name">
                                                                            <a href="{{route('show.team', $team->id)}}">{{$team->name}}</a>
                                                                        </h4>
                                                                        <p class="card-text small text-muted">
                                                                            Created {{\Carbon\Carbon::parse($team->created_at)->toFormattedDateString()}}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <div class="avatar-group d-none d-md-inline-flex">
                                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Ab Hadley">
                                                                            <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="...">
                                                                            </a>
                                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Adolfo Hess">
                                                                            <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="...">
                                                                            </a>
                                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Daniela Dewitt">
                                                                            <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="...">
                                                                            </a>
                                                                            <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Miyah Myles">
                                                                            <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="...">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @else
                                                <div class="text-center mt-8 mb-8">
                                                    <h3 class="text-muted"><i class="fe fe-users"></i> There are currently no teams</h3>
                                                    <div class="col-auto mt-2">
                                                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                                            <i class="fe fe-plus"></i> Create Team
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen p-9">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Create New Team</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('store.team')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">
                                        Team name
                                    </label>
                                    <input type="hidden" name="user_id" class="form-control" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="team_owner" class="form-control" value="{{Auth::user()->name}}">
                                    <input type="hidden" name="team_id" class="form-control">
                                    <input type="hidden" name="send_request" class="form-control" value="1">
                                    <input type="hidden" name="approve_request" class="form-control" value="1">
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Team description
                                    </label>
                                    <small class="form-text text-muted">
                                        This is what others will see about your team
                                    </small>
                                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Enter description"></textarea>
                                </div>
                                <hr class="mt-4 mb-5">
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Team Cover Image
                                    </label>
                                    <small class="form-text text-muted">
                                        Please use an image no larger than 1200px * 600px.
                                    </small>
                                    <div class="form-group">
                                        <label for="actual-btn" style="cursor: pointer" class="w-100 p-6 w-full text-center px-4 py-6 bg-white rounded-md border border-blue cursor-pointer hover:bg-purple-600 dark:bg-gray-700 hover:text-white text-gray-600 dark:text-gray-200 ease-linear transition-all duration-150">
                                            <i class="mdi mdi-cloud-upload icon-size"></i>
                                            <span class="mt-2 text-base text-lg leading-normal">Select an image (1200 x 600p)</span>
                                            <input type="file" name="photo" id="actual-btn" class="hidden"><br>
                                            <h2 class="text-lg" id="file-chosen">No file chosen</h2>
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Create team</span>
                                </button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTeamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen p-9">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Edit Team</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.team')}}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <label class="form-label">
                                        Team name
                                    </label>
                                    <input type="hidden" name="team_id" id="team_id" class="form-control">
                                    <input type="hidden" name="user_id" id="user_id" class="form-control">
                                    <input type="hidden" name="team_owner" id="team_owner" class="form-control">
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Team description
                                    </label>
                                    <small class="form-text text-muted">
                                        This is what others will see about your team
                                    </small>
                                    <textarea class="textarea-1 form-control" name="description" id="descr" rows="5"></textarea>
                                </div>
                                <hr class="mt-4 mb-5">
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Team Cover Image
                                    </label>
                                    <small class="form-text text-muted">
                                        Please use an image no larger than 1200px * 600px.
                                    </small>
                                    <div class="form-group">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save team</span>
                                </button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const actualBtn = document.getElementById('actual-btn');

        const fileChosen = document.getElementById('file-chosen');

        actualBtn.addEventListener('change', function(){
            fileChosen.textContent = this.files[0].name
        })
        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this Team?"))
            event.preventDefault();
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

        function showEditTeamModal(name, team_id, description, photo, user_id, team_owner){
            // var myContent = tinymce.get("textarea-1").getContent({ format: "text" });
            document.getElementById("name").value = name;
            document.getElementById("team_id").value = team_id;
            document.getElementById("descr").value = description;
            $('#imagePreview').css('background-image', 'url('+ photo +')');
            // document.getElementById("imagePreview").style.background = 'url(' + photo + ')';
            document.getElementById("user_id").value = user_id;
            document.getElementById("team_owner").value = team_owner;
            $('#editTeamModal').modal('show')

            tinymce.init({
                selector: '#descr',
                setup: function (editor) {
                    editor.on('init', function (e) {
                        editor.setContent('<p>'+ description +'</p>');
                    });
                }
            });
        }
    </script>
@endsection
