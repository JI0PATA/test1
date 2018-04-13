/**
 * Кнопки в форме
 */
class Buttons {
    createButtons() {
        return `
        <div class="buttons">
            <div class="btn ok" onclick="location.href='${this._link}'">Ок</div>
            <div class="btn cancel" id="closeForm">Отмена</div>
        </div>
        `;
    }
}

/**
 * Генерация всплывающей формы
 */
class Form extends Buttons {
    constructor(link) {
        super();

        this._link = link;

        this.checkIssetForm();
    }

    /**
     * Создание формы
     */
    createForm() {
        this._form = document.createElement(`div`);
        this._form.setAttribute('id', 'formConfirm');
        this._form.innerHTML = `
        <div class="title">Вы хотите выполнить действие?</div>
        ${this.createButtons()}
        `;

        qs('body').appendChild(this._form);

        this.bindEvents();
    }

    bindEvents() {
        qs('#closeForm').addEventListener('click', _ => this.close()    )
    }

    /**
     * Закрытие формы
     */
    close() {
        let form = qs('#formConfirm');
        form.classList.add('closeForm');
        setTimeout(_ => {
            form.remove();
        }, 500);
    }

    checkIssetForm() {
        if (qs('#formConfirm') === null) this.createForm();
        else {
            this.close();
            setTimeout(_ => this.createForm(), 300);
        }
    }
}



let showForm = link => new Form(link);