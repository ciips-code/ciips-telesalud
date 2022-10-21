@extends('main')
@section('title')
    {{ __('views.vc') }}
@endsection
@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            @if(!$vc->patient_attendance_date)
                <div class="container has-text-centered">
                    @include('videoconsultation.sections.logo')
                    <p class="title">
                        {{ __('views.welcome_set_attendance') }}
                    </p>
                    <div class="subtitle">
                        <button onclick="setPatientAttendance(this);" type="button" class="button is-warning is-center">{{ __('views.set_attendance') }}</button>
                    </div>
                </div>
            @else
                <div class="container has-text-centered">
                    @include('videoconsultation.sections.logo')
                    <p class="title">
                        {{ __('views.waiting_medic') }}
                    </p>
                    <p class="subtitle">
                        {{ __('views.medic_will_connect_soon') }}
                    </p>
                </div>
            @endif
        </div>
    </section>
    <script>
        @if(!$vc->patient_attendance_date)
            function setPatientAttendance(el) {
                el.classList.add('is-loading');
                el.disabled = true;
                axios.post('{{ route('setPatientAttendance') }}', {
                    vc: '{{ $vc->secret }}'
                })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function() {
                        location.reload();
                });
            }
        @else
        document.addEventListener("DOMContentLoaded", function(event) {
            setTimeout(function() {
                location.reload();
            },10000)
        });
        @endif

    </script>
@endsection
