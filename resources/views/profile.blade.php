@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            @forelse($data as $item)
                @if ($item->date_at >= time() + 86400)
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
                            <h3>{{ $item->title }}</h3>
                            <p>
                                {{ date('d/m/Y', $item->date_at) }}
                            </p>
                            <p>{{ $item->description }}</p>
                            <div
                                    @if ($visible)
                                    onclick="showForm('{{ route('cancelEvent', ['id' => $item->id]) }}')"
                                    @endif
                                    class="btn btn-danger @if(!$visible) disabled @endif"

                                    role="button">Отмена записи
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>У вас ещё нет записей!</p>
            @endforelse
        </div>
    </div>
@endsection