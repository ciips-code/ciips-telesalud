<button title="Ayuda" class="helpdesk-button button is-primary" onclick="popupMesaAyuda()">?</button>
<div id="modal_mesa_ayuda" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">{{ __('views.contact_helpdesk_title') }}</p>
            <button class="delete" aria-label="close" onclick="cerrarPopupMesaAyuda()"></button>
        </header>
        <section class="modal-card-body">
            <p>{{ __('views.contact_helpdesk_body') }}</p>
            <div class="notification is-primary is-light">
                <p class="has-text-centered has-text-weight-bold is-size-4">{{ config('app.helpdesk_email') }}</p>
            </div>
        </section>
        <footer class="modal-card-foot">
            <a class="button is-primary" href="mailto:{{ config('app.helpdesk_email') }}">{{ __('views.send_email') }}</a>
            <button class="button" onclick="cerrarPopupMesaAyuda()">{{ __('views.cancel') }}</button>
        </footer>
    </div>
</div>
<script>
    function popupMesaAyuda() {
        document.getElementById('modal_mesa_ayuda').classList.add('is-active');
    }

    function cerrarPopupMesaAyuda() {
        document.getElementById('modal_mesa_ayuda').classList.remove('is-active');
    }
</script>
