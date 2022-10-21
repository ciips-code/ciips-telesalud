@extends('main')
@section('title')
    {{ __('views.vc') }}
@endsection
@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                @include('videoconsultation.sections.logo')
                <p class="title">
                    {{ $titulo ?? '' }}
                </p>
                <p class="subtitle">
                    {{ $subtitulo ?? '' }}
                </p>
            </div>
        </div>
    </section>
@endsection
