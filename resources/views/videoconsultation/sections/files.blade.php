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
        axios.get('{{ route('listFiles', ['vc' => $vc->secret]) }}')
            .then(function(response) {
                let html = '';
                let data = response.data.data;
               for(const type in data) {
                   let persona = data[type];
                    html += '<p class="panel-block has-background-primary-light has-text-primary has-text-weight-bold">' + persona.name + '</p>'
                    if(persona.files.length > 0) {
                        persona.files.forEach(function(e, i) {
                            html+= '<a class="panel-block" target="_blank" href="' + e.url + '">' + e.description + '</a>';
                        });
                    } else {
                        html += '<p class="panel-block">{{ __('views.no_files') }}</p>';
                    }
                }

                document.getElementById('files').innerHTML = html;
            })
            .catch(function(error) {
                if(error.response && error.response.status == 409) {
                    location.reload();
                }
                console.log('Error fetching files')
                console.log(error);
            });
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
        let listaErrores = [];
        let valido = true;
        let description = document.getElementById('description_file').value;

        if(description == '') {
            valido = false;
            listaErrores.push('{{ __('views.validation_description') }}');
        }
        if(inputfile.value == '') {
            valido = false;
            listaErrores.push('{{ __('views.validation_file') }}');
        }

        if(!valido) {
            showErrores(listaErrores);
            return;
        }

        let btn = document.getElementById('btnCargarfile');

        btn.classList.add('is-loading');
        btn.disabled = true;

        formData = new FormData();
        formData.append('description', description);
        formData.append('vc', '{{ $vc->secret }}');
        @if($esMedico)
            formData.append('medic', '{{ $vc->medic_secret }}');
        @endif
        formData.append('file', inputfile.files[0]);

        axios.post('{{ route('addFile') }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        })
          .then((response) => {
            if(response.data.success) {
                cerrarPopupfiles();
                actualizarListafiles();
            }
          })
          .catch((error) => {
              if(error.response) {
                  let errores = [];
                  switch (error.response.status) {
                      case 400:
                          console.log(error);
                          for(e in error.response.data.data) {
                              error.response.data.data[e].forEach(function(r,i) {
                                  errores.push(e + ': ' + r);
                              })
                          }
                          break;
                      case 404:
                          errores.push('{{ __('views.controllers.vc_not_found') }}');
                          break;
                      case 413:
                          errores.push('{{ __('views.validation_file_size') }}');
                          break;
                      default:
                          errores.push('{{ __('views.unknown_error') }}');
                  }
                  showErrores(errores);
              } else if(error.request) {
                  console.log(error.request);
              } else {
                  console.log(error);
              }
          })
            .then(() => {
                btn.classList.remove('is-loading');
                btn.disabled = false;
            });
    }

    function showErrores(errores) {
        str = '<p>{{ __('views.file_upload_error') }}:</p>' +
            '<ul>';

        errores.forEach(function(e,i) {
            str += '<li>' + e + '</li>';
        });

        str += '</ul>';

        document.getElementById('span_error_file').innerHTML = str;
        document.getElementById('error_file').classList.remove('is-hidden');
    }

    const inputfile = document.querySelector('#file');
    inputfile.onchange = () => {
        if (inputfile.files.length > 0) {
            const fileName = document.querySelector('#file_name');
            fileName.textContent = inputfile.files[0].name;
        }
    }

    var filesInterval;

    document.addEventListener("DOMContentLoaded", function(event) {
        actualizarListafiles();
        filesInterval = setInterval(function() {
            actualizarListafiles();
        }, 15000);
    });
</script>
