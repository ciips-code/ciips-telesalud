@extends('main')
@section('title')
    {{ __('views.vc') }}
@endsection

@section('content')
    <div class="p-4">
    @if($esMedico)
        <div class="columns">
            <div class="column is-three-quarters">
                @include('videoconsultation.sections.vc')
            </div>
            <div class="column">
                <div class="is-flex is-flex-direction-column">
                    <div class="is-flex is-justify-content-center mb-4">
                        @include('videoconsultation.sections.logo')
                    </div>
                    <div class="is-flex-grow-5">
                        @include('videoconsultation.sections.evolution')
                    </div>
                    <div class="is-flex-grow-3">
                        @include('videoconsultation.sections.files')
                    </div>
                    <div class="is-align-self-flex-end is-justify-content-center">
                        @include('videoconsultation.sections.finish')
                    </div>
                </div>

            </div>
        </div>
    @else
        <div class="columns">
            <div class="column is-three-quarters">
                @include('videoconsultation.sections.vc')
            </div>
            <div class="column">
                <div class="is-flex is-justify-content-center mb-4">
                    @include('videoconsultation.sections.logo')
                </div>
                @include('videoconsultation.sections.files')
            </div>
        </div>
    @endif
    </div>

@endsection
