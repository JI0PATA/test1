@extends('layouts.app')

@section('content')

    @if (Auth::check())
        <img src="{{ asset("storage/".Auth::user()->avatar) }}" alt="">
    @endif

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-right">
                <a href="{{ route('home') }}" class="btn btn-success" role="button">Активное</a>
                <a href="{{ route('home', ['filter' => 'passed']) }}" class="btn btn-primary" role="button">Прошло</a>
                <a href="{{ route('home', ['filter' => 'no_places']) }}" class="btn btn-danger" role="button">Нет
                    мест</a>
            </div>
        </div>

        <hr>
    </div>

    <div class="container">

        <div class="row list">
            @forelse($events as $item)
                @if (($item->age_start <= getAgeUser() && getAgeUser() <= $item->age_end))
                    @php
                        $visible = true;
                    @endphp
                @else
                    @php
                        $visible = false;
                    @endphp
                @endif
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <div class="caption">

                            <h3>{!! Request::get('s') ? str_replace(mb_strtolower(Request::get('s')), "<span class='tips_highlight'>".mb_strtolower(Request::get('s'))."</span>", mb_strtolower($item->title)) : $item->title !!}</h3>
                            <p>
                                {{ date('d/m/Y', $item->date_at) }}
                            </p>
                            <p>{{ $item->description }}</p>
                            @if (Auth::check())
                                <div
                                        @if ($visible)
                                        onclick="showForm('{{ route('joinEvent', ['id' => $item->id]) }}')"
                                        @endif
                                        class="btn btn-success @if(!$visible) disabled @endif"

                                        role="button">Записаться
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <h2>Нет результатов</h2>
            @endforelse

        </div>
        {{ $events->links() }}
    </div>
@endsection