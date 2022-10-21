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
        
    }
</script>
