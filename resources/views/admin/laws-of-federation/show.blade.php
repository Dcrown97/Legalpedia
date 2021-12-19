@extends('layouts.admin.laws-of-federation')

@section('title')
    <title>{{$fed->title}} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/forms-and-precedences')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title text-center text-color">
                            {{$fed->title}}
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
                        <h3>{{$fed->title}}</h3>
                        <p class="card-text text-muted small mb-1">Law No. <span class="text-color">{{$fed->LawNo}}</span></p>
                        <p class="card-text text-muted small mb-1">Date: <span class="text-color">{{$fed->LawDate}}</span></p>
                        <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$fed->category}}</span></p>
                        <p class="card-text text-muted small mb-1">Area of Law: <span class="text-color">{{$fed->area_of_law}}</span></p>
                        <span>{!! $fed->description !!}</span>
                        <hr class="my-5">
                        <span>{!! $fed->subsidiary_legislation !!}</span>
                        <?php $fed_part = App\Models\LawOfFedPart::where('law_of_federation_id', $fed->id)->first() ;
                            $fed_section = App\Models\LawOfFedSection::where('law_of_federation_id', $fed->id)->first() ;
                        ?>
                        @if($fed_part)
                            <p class="card-text text-muted small mb-1">Part: <span class="text-color">{{$fed_part->part_header}}</span></p>
                        @endif
                        @if($fed_section)
                            <p class="card-text text-muted small mb-1">Section: <span class="text-color">{{$fed_section->section_header}}</span></p>
                            <span>{!! $fed_section->section_body !!}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
      </div>
@endsection
