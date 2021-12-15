@extends('layouts.admin')

@section('title')
    <title>Messages - Legalpedia</title>
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
                        <h6 class="header-pretitle">
                        </h6>
                        <h1 class="header-title">
                            Messages
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="header-body mb-4 mt-n5 mt-md-n6">
          <div class="row align-items-center">
            <div class="col">
                <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="send-message-tab" data-toggle="tab" href="#sendMessage" role="tab" aria-controls="sendMessage" aria-selected="true">
                            Send Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="auto-message-tab" data-toggle="tab" href="#autoMessage" role="tab" aria-controls="autoMessage" aria-selected="false">
                            Automated Messages
                        </a>
                    </li>
                </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
          <div class="col-12 col-lg-10 col-xl-8">
            <div class="tab-content" id="wizardSteps">
                <div class="tab-pane fade show active" id="sendMessage" role="tabpanel" aria-labelledby="send-message-tab">
                    <form action="">
                        <div class="form-group">
                            <label class="form-label">
                                Select Recipient's Category
                            </label>
                            <select class="form-select mb-3" data-choices='{"searchEnabled": false, "choices": [
                                {
                                "value": "Dianna Smiley",
                                "label": "Dianna Smiley",
                                "customProperties": {
                                    "avatarSrc": "../assets/img/avatars/profiles/avatar-1.jpg"
                                }
                                },
                                {
                                "value": "Ab Hadley",
                                "label": "Ab Hadley",
                                "customProperties": {
                                    "avatarSrc": "../assets/img/avatars/profiles/avatar-2.jpg"
                                }
                                },
                                {
                                "value": "Adolfo Hess",
                                "label": "Adolfo Hess",
                                "customProperties": {
                                    "avatarSrc": "../assets/img/avatars/profiles/avatar-3.jpg"
                                }
                                },
                                {
                                "value": "Daniela Dewitt",
                                "label": "Daniela Dewitt",
                                "customProperties": {
                                    "avatarSrc": "../assets/img/avatars/profiles/avatar-4.jpg"
                                }
                                }
                                ]}'>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Title of Message
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Message Body
                            </label>
                            <small class="form-text text-muted">
                            This is the full description of the message
                            </small>
                            <div data-quill></div>
                        </div>
                        <hr class="my-5">
                        <div class="col-auto">
                            <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                <i class="mdi mdi-message"></i> Send Message
                            </a>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="autoMessage" role="tabpanel" aria-labelledby="auto-message-tab">
                    <form action="">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Select Recipient's Category
                                    </label>
                                    <select class="form-select mb-3" data-choices='{"searchEnabled": false, "choices": [
                                        {
                                        "value": "Dianna Smiley",
                                        "label": "Dianna Smiley",
                                        "customProperties": {
                                            "avatarSrc": "../assets/img/avatars/profiles/avatar-1.jpg"
                                        }
                                        },
                                        {
                                        "value": "Ab Hadley",
                                        "label": "Ab Hadley",
                                        "customProperties": {
                                            "avatarSrc": "../assets/img/avatars/profiles/avatar-2.jpg"
                                        }
                                        },
                                        {
                                        "value": "Adolfo Hess",
                                        "label": "Adolfo Hess",
                                        "customProperties": {
                                            "avatarSrc": "../assets/img/avatars/profiles/avatar-3.jpg"
                                        }
                                        },
                                        {
                                        "value": "Daniela Dewitt",
                                        "label": "Daniela Dewitt",
                                        "customProperties": {
                                            "avatarSrc": "../assets/img/avatars/profiles/avatar-4.jpg"
                                        }
                                        }
                                        ]}'>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Select Date and Time to send
                                    </label>
                                    <input type="text" class="form-control" placeholder="20/11/2020" data-flatpickr>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Title of Message
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Message Body
                            </label>
                            <small class="form-text text-muted">
                            This is the full description of the message
                            </small>
                            <div data-quill></div>
                        </div>
                        <hr class="my-5">
                        <div class="col-auto">
                            <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                <i class="mdi mdi-message"></i> Send Message
                            </a>
                        </div>
                    </form>
                </div>
            </div>

          </div>
        </div>
      </div>

    <div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen p-9">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Create Project</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y m-5">
                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                        <div class="container">
                            <div class="stepper-nav justify-content-center py-2">
                                <!--begin::Step 1-->
                                <div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Project Type</h3>
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Project Settings</h3>
                                </div>
                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Budget</h3>
                                </div>
                                <!--end::Step 3-->
                                <!--begin::Step 4-->
                                <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Build A Team</h3>
                                </div>
                                <!--end::Step 4-->
                                <!--begin::Step 5-->
                                <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Set First Target</h3>
                                </div>
                                <!--end::Step 5-->
                                <!--begin::Step 6-->
                                <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Upload Files</h3>
                                </div>
                                <!--end::Step 6-->
                                <!--begin::Step 7-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Completed</h3>
                                </div>
                                <!--end::Step 7-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
