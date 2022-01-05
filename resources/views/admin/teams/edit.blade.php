@section('title')
    <title>{{$team->name}} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/teams')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Edit Team
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body p-5">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
