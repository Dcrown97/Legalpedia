@extends('layouts.admin')

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
                            {{$fed->Title}}
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
                        <h3>{{$fed->Title}}</h3>
                        <p class="card-text text-muted small mb-1">Law No. <span class="text-color">{{$fed->LawNo}}</span></p>
                        <p class="card-text text-muted small mb-1">Date: <span class="text-color">{{$fed->LawDate}}</span></p>
                        <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$fed->category}}</span></p>
                        <p class="card-text text-muted small mb-1">Area of Law: <span class="text-color">{{$fed->area_of_law}}</span></p>
                        <span>{!! $fed->Descr !!}</span>
                        <hr class="my-5">
                        <span>{!! $fed->SubsidiaryLegislation !!}</span>
                        <?php $fed_part = App\Models\LawOfFedPart::where('LawId', $fed->id)->first() ;
                            $fed_section = App\Models\LawOfFedSection::where('LawId', $fed->id)->first() ;
                        ?>
                        <p class="card-text text-muted small mb-1">Part: <span class="text-color">{{$fed_part->PartHeader}}</span></p>
                        <p class="card-text text-muted small mb-1">Section: <span class="text-color">{{$fed_section->SectionHeader}}</span></p>
                        <span>{!! $fed_section->SectionBody !!}</span>
                    </div>
                </div>
            </div>
        </div>
      </div>
@endsection
