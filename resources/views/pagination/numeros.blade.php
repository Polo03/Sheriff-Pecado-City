@if ($paginator->hasPages())
    <nav aria-label="Paginación">
        @if ($paginator->onFirstPage())
            <span aria-disabled="true">Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a>
        @endif

        @php
            $primeraPagina = max(1, $paginator->currentPage() - 5);
            $ultimaPagina = min($paginator->lastPage(), $paginator->currentPage() + 5);
        @endphp

        @for ($pagina = $primeraPagina; $pagina <= $ultimaPagina; $pagina++)
            @if ($pagina == $paginator->currentPage())
                <span aria-current="page">{{ $pagina }}</span>
            @else
                <a href="{{ $paginator->url($pagina) }}">{{ $pagina }}</a>
            @endif
        @endfor

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a>
        @else
            <span aria-disabled="true">Siguiente</span>
        @endif
    </nav>
@endif
