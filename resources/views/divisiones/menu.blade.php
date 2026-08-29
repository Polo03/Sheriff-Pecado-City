@extends('layout.app')

@section('title', 'Divisiones')

@section('content')

<div style="
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
">

    <h1>
        🏢 Divisiones
    </h1>

    <p style="color:#666;">
        Selecciona una de tus divisiones para consultar su información.
    </p>


    @foreach($divisiones as $division)

        <a
            href="{{ route('divisiones.show', $division->id) }}"
            style="
                display:block;
                margin-bottom:12px;
                padding:16px 20px;
                border-radius:8px;
                background:white;
                color:#222;
                text-decoration:none;
                box-shadow:0 3px 12px rgba(0,0,0,.08);
            "
        >

            🏢

            <strong>
                {{ $division->nombre }}
            </strong>

            @if($division->rango_division)

                <span style="
                    float:right;
                    color:#777;
                    font-size:13px;
                ">
                    {{ $division->rango_division }}
                </span>

            @endif

        </a>

    @endforeach


    @foreach($postulaciones as $postulacion)

        <a
            href="{{ route('divisiones.show', $postulacion->division_id) }}"
            style="
                display:block;
                margin-bottom:12px;
                padding:16px 20px;
                border-radius:8px;
                background:white;
                color:#222;
                text-decoration:none;
                box-shadow:0 3px 12px rgba(0,0,0,.08);
            "
        >

            📋

            <strong>
                {{ $postulacion->nombre }}
            </strong>

            <span style="
                float:right;
                color:#777;
                font-size:13px;
            ">
                Postulación pendiente
            </span>

        </a>

    @endforeach

</div>

@endsection