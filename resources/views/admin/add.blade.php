@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-lg-12" method="POST" action="{{ route('addEvent') }}">

                {{ csrf_field() }}

                <div class="form-group">
                    <label>Количество мест</label>
                    <input type="number" class="form-control" id="a_seats" name="a_seats"
                           placeholder="Количество доступных мест">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Наименование</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Наименование">
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <textarea id="description" name="description" class="form-control" cols="30"
                              rows="3"></textarea>
                    <div class="text-error"></div>
                </div>
                <div class="form-group">
                    <label>Дата</label>
                    <input type="text" class="form-control" id="date_at" name="date_at" placeholder="Дата">
                    <div class="text-error"></div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>Возраст от</label>
                        <input type="number" class="form-control" id="age_start" name="age_start" placeholder="От">
                        <div class="text-error"></div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Возраст до</label>
                        <input type="number" class="form-control" id="age_end" name="age_end" placeholder="До">
                        <div class="text-error"></div>
                    </div>
                </div>
                <button type="button" id="button" class="btn btn-success disabled">Добавить</button>
                <a href="{{ route('addXML') }}" class="btn btn-primary">Добавить XML</a>
            </form>


        </div>
    </div>

    <script>
        (function () {
            let a_seats = new ValidateFieldAndCount('#a_seats', '^[1-9][0-9]*$', 'Количество мест', 'Неверный формат записи!');
            let title = new ValidateFieldAndCount('#title', '', 'Наименование', '');
            let description = new ValidateFieldAndCount('#description', '', 'Описание', '');

            $('#date_at').datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '1950:2018',
                minDate: '0d',
                onSelect: _ => {
                    date_at.required();
                }
            });
            let date_at = new ValidateFieldAndCount('#date_at', '^[0-9]{2}/[0-9]{2}/[0-9]{4}$', 'Дата', 'Неверный формат даты!');
            let age_start = new ValidateFieldAndCount('#age_start', '^[1-9][0-9]+$', 'Возраст от', 'Значение должно быть не менее 16', function () {

                if (this.el.value.trim() < 16) this.error('Значение должно быть не менее 16');
                else if (age_end.el.value.trim().length !== 0) {
                    if (this.el.value.trim() > age_end.el.value.trim()) {
                        this.error('Значение Возраст от не может быть больше значения Возраст до');
                        age_end.error('Значение Возраст от не может быть больше значения Возраст до');
                    } else {
                        this.success();
                        age_end.success();
                    }
                }
                else this.success();
            });
            let age_end = new ValidateFieldAndCount('#age_end', '^[1-9][0-9]+$', 'Возраст до', 'Значение должно быть не меннее 16', function () {

                if (this.el.value.trim() < 16) this.error('Значение должно быть не менее 16');
                else if (age_start.el.value.trim().length !== 0) {
                    if (this.el.value.trim() < age_start.el.value.trim()) {
                        this.error('Значение Возраст до не может быть меньше значения Возраст от');
                        age_start.error('Значение Возраст до не может быть меньше значения Возраст от');
                    } else {
                        this.success();
                        age_start.success();
                    }
                }
                else this.success();
            });

        })();
    </script>
@endsection