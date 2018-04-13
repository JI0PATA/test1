@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-lg-12" action="{{ route('login') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Логин</label>
                    <input type="text" name="login" class="form-control" id="login" placeholder="Логин">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
                    <div class="text-error"></div>
                </div>
                <button type="submit" class="btn btn-success">Войти</button>
            </form>

        </div>
    </div>

    <script>
        (function () {
            let login = new ValidateField('#login', '', 'Логин', '', null);
            let password = new ValidateField('#password', '(?=.*[A-Z])(?=.*[a-z])', 'Пароль', 'Пароль должен содержать символы английской раскладки верхнего и нижнего регистра', function () {
                if (this.el.value.trim().length < 6) this.error('Длина должна быть не меньше 6 символов!');
                else this.success();
            });
        })();
    </script>
@endsection
