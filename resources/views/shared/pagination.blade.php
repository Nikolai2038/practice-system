@if ($paginator->hasPages())
    <div class="pagination">
        Отображено {{ $paginator->count() }} из {{ $paginator->total() }} результатов!<br/>
        Страницы:<br/>
        @if($paginator->onFirstPage() == false)
            <a href="{{ $paginator->previousPageUrl() }}">Назад</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                {{ $element }}
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{ $page }}
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Вперёд</a>
        @endif
    </div>
@endif
