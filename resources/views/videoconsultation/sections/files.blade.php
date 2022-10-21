<div id="modal_file" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">{{ __('views.upload_file') }}</p>
            <button class="delete" aria-label="close" onclick="cerrarPopupfiles()"></button>
        </header>
        <section class="modal-card-body">
            <div id="error_file" class="notification is-danger is-hidden">
                <button class="delete" onclick="document.getElementById('error_file').classList.add('is-hidden');"></button>
                <span id="span_error_file"></span>
            </div>
            <div class="field">
                <label class="label">{{ __('views.description') }}</label>
                <div class="control">
                    <input id="description_file" class="input" type="text" placeholder="{{ __('views.last_medical_exams') }}">
                </div>
                <p class="help">{{ __('views.file_description_help') }}</p>
            </div>

            <div class="field">
                <label class="label">{{ __('views.file') }}</label>
                <div class="file has-name">
                    <label class="file-label">
                        <input id="file" class="file-input" type="file" name="file">
                        <span class="file-cta">
                            <span class="file-label">{{ __('views.browse') }}</span>
                        </span>
                        <span id="file_name" class="file-name"></span>
                    </label>
                </div>
                <p class="help">{{ __('views.supported_formats', ['formats' => 'bmp, doc, docx, jpg, jpeg, pdf, png']) }}</p>
            </div>
        </section>
        <footer class="modal-card-foot">
            <button id="btnCargarfile" class="button is-primary" onclick="cargarfile()">{{ __('views.upload') }}</button>
            <button class="button" onclick="cerrarPopupfiles()">{{ __('views.cancel') }}</button>
        </footer>
    </div>
</div>


<div class="panel">
    <p class="panel-heading">
        {{ __('views.files') }}
    </p>
    <div id="files">
    </div>
    <div class="panel-block is-justify-content-center">
        <button class="button is-primary" onclick="openPopupfiles()" type="button">{{ __('views.upload_file') }}</button>
    </div>
</div>

<script>

    function actualizarListafiles() {
        let data = {
            medic: {
                name: "medico",
                files: [
                    {
                        description: "Receta",
                        date_time: "18/10/2022 12:58",
                        url: "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                    }
                ]
            },
            paciente: {
                name: "paciente",
                files: [
                    {
                        description: "Estudios laboratorio",
                        date_time: "18/10/2022 13:00",
                        url: "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                    }
                ]
            }
        };
        let html = '';
        for(const type in data) {
            let persona = data[type];
            html += '<p class="panel-block has-background-primary-light has-text-primary has-text-weight-bold">' + persona.name + '</p>'
            if (persona.files.length > 0) {
                persona.files.forEach(function (e, i) {
                    html += '<a target="_blank" class="panel-block" href="' + e.url + '">' + e.description + '</a>';
                });
            } else {
                html += '<p class="panel-block">{{ __('views.no_files') }}</p>';
            }
        }
        document.getElementById('files').innerHTML = html;

    }

    function openPopupfiles() {
        document.getElementById('description_file').value = '';
        document.getElementById('file').value = '';
        document.getElementById('file_name').innerHTML = '';
        document.getElementById('modal_file').classList.add('is-active');
        document.getElementById('error_file').classList.add('is-hidden');
    }

    function cerrarPopupfiles() {
        document.getElementById('modal_file').classList.remove('is-active');
    }

    function cargarfile() {
        //TODO: send file
    }


    const inputfile = document.querySelector('#file');
    inputfile.onchange = () => {
        if (inputfile.files.length > 0) {
            const fileName = document.querySelector('#file_name');
            fileName.textContent = inputfile.files[0].name;
        }
    }
    actualizarListafiles();
</script>
