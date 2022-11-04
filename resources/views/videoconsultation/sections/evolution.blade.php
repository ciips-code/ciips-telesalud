<div class="panel">
    <p class="panel-heading">
        {{ __('views.evolution') }}
    </p>
    <div class="panel-block">
        <div class="control">
            <textarea class="textarea" id="evolution">{{ $vc->evolution }}</textarea>
        </div>

    </div>
    <div class="panel-block is-justify-content-center">
        <button id="btnsaveEvolution" type="button" class="button is-primary" onclick="saveEvolution()">{{ __('views.save') }}</button>
    </div>
</div>
<script>
    function saveEvolution() {
        let evo = document.getElementById('evolution');
        let btnGuardar = document.getElementById('btnsaveEvolution');

        evo.disabled = true;
        btnGuardar.disabled = true;
        btnGuardar.classList.add('is-loading');

        axios.post('{{ route('saveEvolution') }}', {
            vc: '{{ $vc->secret }}',
            medic: '{{ $vc->medic_secret }}',
            evolution: evo.value,
        })
            .then(function(response) {

            })
            .catch(function (error) {
                alert('{{ __('views.error_saving_evolution') }}');
            })
            .then(function() {
                evo.disabled = false;
                btnGuardar.disabled = false;
                btnGuardar.classList.remove('is-loading');
            });
    }
</script>
