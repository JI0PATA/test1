class Autocomplit {
    constructor() {
        this.el = qs('#search');

        this.tips = qs('#tips');

        this.bindEvents();
    }

    bindEvents() {
        this.el.addEventListener('input', _ => {
            if (this.el.value.trim().length !== 0) this.searchOccur();
            else this.dropData();
        })
    }

    /**
     * Поиск вхождений
     */
    searchOccur() {
        $.ajax({
            url: 'autocomplit',
            type: 'get',
            data: {
                's': this.el.value.trim(),
            },
            success: data => {
                this._tips_arr = data;
                this.fillData();
            }
        });
    }

    /**
     * Заполнение данными
     */
    fillData() {
        let tips = '';

        this._tips_arr.forEach(item => {
            tips += `
                <a href="?s=${item['title']}">${item['title'].toLowerCase().replace(this.el.value.trim().toLowerCase(), `<span class="tips_highlight">${this.el.value.trim().toLowerCase()}</span>`)}</a>
            `;
        });

        this.tips.innerHTML = tips;
    }

    dropData() {
        this.tips.innerHTML = '';
    }
}

let autocomplit = new Autocomplit();