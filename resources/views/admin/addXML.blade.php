@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-lg-12" method="POST" action="{{ route('addEventXML') }}" enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="form-group">
                    <label>XML файл</label>
                    <input type="file" class="form-control" id="file" name="file"
                           placeholder="XML файл">
                    <div class="text-error"></div>
                </div>
                <button type="button" id="button" class="btn btn-success disabled">Добавить</button>
                <a href="{{ route('addEvent') }}" class="btn btn-primary">Добавить(обычный)</a>
            </form>


        </div>
    </div>

    <script>
        (function () {
            let file = new ValidateFieldAndCount('#file', '', 'XML', '', function() {
                if (this.el.files[0].type !== 'text/xml') this.error('Файл должен быть XML');
                else this.success();
            });
        })();
    </script>
@endsection