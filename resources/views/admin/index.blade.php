@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row list">

            @foreach($data as $item)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <div class="caption">
                            <h3>{{ $item->title }}</h3>
                            <p>
                                {{ date('d/m/Y', $item->date_at) }}
                            </p>
                            <p>{{ $item->description }}</p>
                            <p>
                                <a class="btn btn-danger" onclick="showForm('{{ route('deleteEvent', ['id' => $item->id]) }}')" role="button">Удалить</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection