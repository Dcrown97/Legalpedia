@extends('layouts.admin.rules-of-court')

@section('title')
    @if($order)
        <title>{{$order->title}} - Legalpedia</title>
        @elseif($schedule)
        <title>{{$schedule->title}} - Legalpedia</title>
        @elseif($part)
        <title>{{$part->title}} - Legalpedia</title>
        @elseif($form)
        <title>{{$form->title}} - Legalpedia</title>
        @elseif($probate_form)
        <title>{{$probate_form->title}} - Legalpedia</title>
        @elseif($civil_form)
        <title>{{$civil_form->title}} - Legalpedia</title>
        @elseif($appendix)
        <title>{{$appendix->title}} - Legalpedia</title>
    @endif
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/rules-of-court')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            @if($order)
                                {{$order->title}}
                                @elseif($schedule)
                                {{$schedule->title}}
                                @elseif($part)
                                {{$part->title}}
                                @elseif($form)
                                {{$form->title}}
                                @elseif($probate_form)
                                {{$probate_form->title}}
                                @elseif($civil_form)
                                {{$civil_form->title}}
                                @elseif($appendix)
                                {{$appendix->title}}
                            @endif
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
                        <h3>
                            @if($order)
                                {{$order->title}}
                                @elseif($schedule)
                                {{$schedule->title}}
                                @elseif($part)
                                {{$part->title}}
                                @elseif($form)
                                {{$form->title}}
                                @elseif($probate_form)
                                {{$probate_form->title}}
                                @elseif($civil_form)
                                {{$civil_form->title}}
                                @elseif($appendix)
                                {{$appendix->title}}
                            @endif
                        </h3>
                        @if($order)
                            {!! $order->content !!}
                            @elseif($schedule)
                            {!! $schedule->content !!}
                            @elseif($part)
                            {!! $part->content !!}
                            @elseif($form)
                            {!! $form->content !!}
                            @elseif($probate_form)
                            {!! $probate_form->content !!}
                            @elseif($civil_form)
                            {!! $civil_form->content !!}
                            @elseif($appendix)
                            {!! $appendix->content !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
      </div>
@endsection
