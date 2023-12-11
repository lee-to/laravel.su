import {Controller}   from '@hotwired/stimulus';
import TextareaEditor from 'textarea-editor';

export default class extends Controller {
    static targets = [
        'input',
    ];

    inputTargetConnected(input) {
        this.editor = new TextareaEditor(input);
    }

    format(e) {
        e.preventDefault();
        if (this.editor) {
            this.editor.toggle(e.params.format);
        }
    }

    chooseFiles() {
        const input = document.createElement('input');
        input.type = 'file';
        input.multiple = true;
        input.hidden = true;
        document.body.appendChild(input);
        input.addEventListener('change', () => {
            if (input.files) {
                Array.from(input.files).forEach((file) =>
                    this.uploadFile(file),
                );
            }
        });
        input.click();
        input.remove();
    }

    uploadFile(file) {
        const prefix = file.type.startsWith('image/') ? '!' : '';
        const placeholder = `${prefix}[Uploading ${file.name}]()\n`;
        let replacement = '';

        this.editor?.insert(placeholder);

        // Загрузить файл
        try {
            let url = 'https:://example.com'; //Адрес загрузки файла

            replacement = `${prefix}[${file.name}](${url})\n`;
        } catch (e) {
            alert("Загрузка файла не удалась");
        }

        const start = this.inputTarget.value.indexOf(placeholder);
        if (start === -1 || !this.editor) return;

        const delta = replacement.length - placeholder.length;
        const range = this.editor.range();
        this.editor
            .range([start, start + placeholder.length])
            .insert(replacement)
            .range([range[0] + delta, range[1] + delta]);
    }

}
