@extends('layouts.app')

{{ config('Регистрация') }}

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-lg-12" method="POST" enctype="multipart/form-data" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>ФИО</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="ФИО">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="Email">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Логин</label>
                    <input name="login" type="text" class="form-control" id="login" placeholder="Логин">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Пароль">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Подтверждение пароля</label>
                    <input type="password" class="form-control" id="confirm-password" placeholder="Подтверждение пароля">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Дата рождения</label>
                    <input name="birthdate" type="text" class="form-control" id="birthdate" placeholder="Дата рождения">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Аватар</label>
                    <input name="file" type="file" class="form-control" id="file" placeholder="Дата рождения">
                    <div class="text-error"></div>
                </div>
                <button id="button" type="button" class="btn btn-success disabled">Зарегистрироваться</button>
            </form>
        </div>
    </div>

    <script>
        (function () {
            let name = new ValidateFieldAndCount('#name', '^[А-Яа-я ]+$', 'ФИО', 'Поле должно содержать только кириллицу');
            let email = new ValidateFieldAndCount('#email', '^.+@.+[.].+$', 'E-mail', 'Должен быть E-mail адрес!');
            let login = new ValidateFieldAndCount('#login', '', 'Логин', '',
                function () {
                    $.ajax({
                        url: '/checkUser',
                        type: 'get',
                        async: false,
                        data: {
                            login: this.el.value.trim()
                        },
                        success: data => {
                            if (parseInt(data) === 1) this.error('Такой Логин уже занят!');
                            else this.success();
                        }
                    });
                });
            let password = new ValidateFieldAndCount('#password', '(?=.*[A-Z])(?=.*[a-z])', 'Пароль', 'Должен содержать символы верхнего и нижнего регистра английской раскладки',
                function () {
                    if (this.el.value.trim().length < 6) return this.error('Должно быть не менее 6 символов');

                    if (confirm_password.el.value.trim().length !== 0) {
                        if (confirm_password.el.value.trim() !== this.el.value.trim()) {
                            this.error('Пароли должны совпадать!');
                            confirm_password.error('Пароли должны совпадать!');
                        } else {
                            this.success();
                            confirm_password.success();
                        }
                    } else {
                        this.success();
                    }
                });
            let confirm_password = new ValidateFieldAndCount('#confirm-password', '(?=.*[A-Z])(?=.*[a-z])', 'Подтверждение пароля', 'Должен содержать символы верхнего и нижнего регистра английской раскладки',
                function () {
                    if (this.el.value.trim().length < 6) return this.error('Должно быть не менее 6 символов');

                    if (password.el.value.trim().length !== 0) {
                        if (password.el.value.trim() !== this.el.value.trim()) {
                            this.error('Пароли должны совпадать!');
                            password.error('Пароли должны совпадать!');
                        } else {
                            this.success();
                            password.success();
                        }
                    } else {
                        this.success();
                    }
                });
            let birthdate = new ValidateFieldAndCount('#birthdate', '^[0-9]{2}/[0-9]{2}/[0-9]{4}$', 'Дата рождения', 'Неверный формат даты!');
            $('#birthdate').datepicker({
                dateFormat: 'dd/mm/yy',
                changeYear: true,
                changeMonth: true,
                yearRange: '1950:2018',
                maxDate: '0d',
                onSelect: function () {
                    if (getAge(this.value.trim()) < 16) birthdate.error('Ваш возраст должен быть не меньше 16 лет!');
                    else birthdate.success();
                }
            });
            let avatar = new ValidateFieldAndCount('#file', '', 'Аватар', '', function () {
                let file = this.el.files[0];

                if (file.type !== 'image/jpeg' || file.size / 1024 / 1024 > 1) this.error('Аватар должен быть в формате JPG и размером меньше 1Мб');
                else this.success();
            });


        })();
    </script>
@endsection
