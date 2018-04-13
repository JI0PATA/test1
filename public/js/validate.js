const qs = selector => document.querySelector(selector);
const qsa = selector => document.querySelectorAll(selector);
let countClasses = 0;


class Message {
    /**
     * Информация об ошибке
     */
    error(msg) {
        this.parentElement.classList.remove('success');
        this.parentElement.classList.add('error');
        this.errorElement.innerText = msg;
    }

    /**
     * Информация об успехе
     */
    success() {
        this.parentElement.classList.remove('error');
        this.parentElement.classList.add('success');
        this.errorElement.innerText = '';
    }
}

/**
 * Валидация поля
 */
class ValidateField extends Message {
    constructor(id, regexp, title, msgError, ownFunction) {
        super();
        this.el = qs(id);
        this.parentElement = this.el.parentNode;
        this.errorElement = this.el.nextElementSibling;
        this._regexp = new RegExp(regexp);
        this._title = title;
        this._ownMessageError = msgError;
        this._ownFunction = ownFunction;

        countClasses++;

        this.bindEvents();
    }

    /**
     * Бинд событий
     */
    bindEvents() {
        this.el.addEventListener('input', _ => {
            this.required();
        });
        if (this.el.getAttribute('type') === 'file') {
            this.el.addEventListener('change', _ => {
                this.required();
            })
        }
    }

    /**
     * Проверка на пустоту
     */
    required() {
        if (this.el.value.trim().length === 0) this.error(`Поле ${this._title} не может быть пустым!`);
        else this.regexp();
    }

    regexp() {
        if (!this._regexp.test(this.el.value.trim())) this.error(this._ownMessageError);
        else {
            if (this._ownFunction !== null) this._ownFunction();
            else this.success();
        }

        this.countFieldSuccess = qsa('.success').length;
    }
}

class ValidateFieldAndCount extends ValidateField {
    constructor(id, regexp, title, msgError, ownFunction = null) {
        super(id, regexp, title, msgError, ownFunction);

        this.el.addEventListener('change', _ => {
            this.calcSuccessField();
        });
    }

    calcSuccessField() {
        let button = qs('#button');

        if (this.countFieldSuccess === countClasses) {
            button.classList.remove('disabled');
            button.setAttribute('type', 'submit');
        } else {
            button.classList.add('disabled');
            button.setAttribute('type', 'button');
        }
    }
}

function getAge(selectDate) {
    let dateSplit = selectDate.split('/');

    let dateObjNow = new Date();
    let dayNow = dateObjNow.getDate();
    let monthNow = dateObjNow.getMonth() + 1;
    let yearNow = dateObjNow.getFullYear();

    let age = yearNow - dateSplit[2];

    if (parseInt(`${monthNow}${dayNow}`) < parseInt(`${dateSplit[1]}${dateSplit[0]}`)) age--;

    return age;
}
