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
                        <a href="{{url('admin/laws-of-federation')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title text-center" style="color: #990033">
                            {{$fed->title}}
                        </h1>
                        <h3 class="card-text text-center text-color mt-2 mb-2">{{$fed->law_no}}</h3>
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
                        {{-- <h3>{{$fed->title}}</h3>
                        <p class="card-text text-muted small mb-1">Law No. <span class="text-color">{{$fed->law_no}}</span></p>
                        <p class="card-text text-muted small mb-1">Date: <span class="text-color">{{$fed->law_date}}</span></p>
                        <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$fed->category}}</span></p>
                        <p class="card-text text-muted small mb-1">Area of Law: <span class="text-color">{{$fed->area_of_law}}</span></p>
                        <span>{!! $fed->description !!}</span>
                        <hr class="my-5">
                        <span>{!! $fed->subsidiary_legislation !!}</span> --}}
                        <?php $fed_part = App\Models\LawOfFedPart::where('law_of_federation_id', $fed->id)->first() ;
                            $fed_sections = App\Models\LawOfFedSection::where('law_of_federation_id', $fed->id)->orderBy('section_header', 'ASC')->get() ;
                        ?>
                        {{-- @if($fed_part)
                            <p class="card-text text-muted small mb-1">Part: <span class="text-color">{{$fed_part->part_header}}</span></p>
                        @endif --}}
                        @if($fed_sections)
                            <?php $fed_section_no = 1; ?>
                            @foreach($fed_sections as $fed_section)
                                <h3 class="text-muted">{{$fed_section_no}}. {{$fed_section->section_header}}</h3>
                                <?php $fed_section_no++; ?>
                                <p class="card-text mb-1">{!! $fed_section->section_body !!}</p>
                                <hr class="my-4">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
      </div>
@endsection
