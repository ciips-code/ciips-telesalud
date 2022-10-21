<div id="modal_finalizar" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">{{ __('views.confirm_finish_vc') }}</p>
            <button class="delete" aria-label="close" onclick="cerrarPopupFinalizar()"></button>
        </header>
        <section class="modal-card-body">
            <p>{{ __('views.finish_vc_effect') }}</p>
        </section>
        <footer class="modal-card-foot">
            <button id="btnFinalizarConsulta" class="button is-danger" onclick="finalizarConsulta()">{{ __('views.finish') }}</button>
            <button class="button" onclick="cerrarPopupFinalizar()">{{ __('views.cancel') }}</button>
        </footer>
    </div>
</div>

<button onclick="popupFinalizarConsulta();" type="button" class="button is-warning is-center">{{ __('views.finish_vc') }}</button>

<script>
    function popupFinalizarConsulta() {
        document.getElementById('modal_finalizar').classList.add('is-active');
    }

    function cerrarPopupFinalizar() {
        document.getElementById('modal_finalizar').classList.remove('is-active');
    }

    function finalizarConsulta() {
        document.getElementById('btnFinalizarConsulta').classList.add('is-loading');

        axios.post('{{ route('setFinish') }}', {
            vc: '{{ $vc->secret }}',
            medic: '{{ $vc->medic_secret }}',
        })
            .then(function(response) {
                location.reload();
            })

            .catch(function (error) {
                console.log(error);
            });
    }
</script>
