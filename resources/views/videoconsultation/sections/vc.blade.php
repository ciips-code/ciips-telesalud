<div id="vc" style="min-height: 95vh" class="responsive-iframe-container"></div>
<script src="{{ $baseUrl }}external_api.js"></script>
@php
    $parsedUrl = parse_url($baseUrl);
@endphp

<script>
    var api = new JitsiMeetExternalAPI('{{ $parsedUrl['host'] . (isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '') }}', {
        roomName: '{{ $vc->secret }}',
        width: '100%',
        height: '100%',
        lang: '{{ config('app.locale') }}',
        parentNode: document.getElementById('vc'),
        @if($token)
            jwt: '{{ $token }}',
        @endif
        userInfo: {
            displayName: '{{ $name }}'
        }
    });

    @if($esMedico)

        api.addListener('incomingMessage', function(event) {
            notificarChat(event.message, false);
        });
        api.addListener('outgoingMessage', function(event) {
            notificarChat(event.message, true);
        });
        api.addListener('videoConferenceJoined', function(event) {


            api.addListener('videoConferenceLeft', function(event) {
                axios.post('{{ route('unsetMedicAttendance') }}', {
                    vc: '{{ $vc->secret }}',
                    medic: '{{ $vc->medic_secret }}',
                })

                    .catch(function (error) {
                        console.log(error);
                    });
            });

            api.addListener('participantJoined', function(event) {
                console.log('participantJoined');
                axios.post('{{ route('setStart') }}', {
                    vc: '{{ $vc->secret }}',
                    medic: '{{ $vc->medic_secret }}',
                })

                    .catch(function (error) {
                        console.log(error);
                    });
            });

            axios.post('{{ route('setMedicAttendance') }}', {
                vc: '{{ $vc->secret }}',
                medic: '{{ $vc->medic_secret }}',
            })

                .catch(function (error) {
                    console.log(error);
                });
        });

        function notificarChat(mensaje, medic) {
            axios.post('{{ route('addChat') }}', {
                vc: '{{ $vc->secret }}',
                medic: '{{ $vc->medic_secret }}',
                es_medic: medic,
                mensaje: mensaje
            })

                .catch(function (error) {
                    console.log(error);
                });
        }
    @else

    api.addListener('participantLeft', function(event) {
        setTimeout(function() {
            axios.post('{{ route('checkFinished') }}', {
                vc: '{{ $vc->secret }}',
            })
                .then(function(response) {
                    if(response.data.data.finished) {
                        location.reload();
                    }
                })

                .catch(function (error) {
                    console.log(error);
                });
        }, 1000);

    });
    @endif
</script>
