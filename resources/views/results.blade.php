@if (!empty($results))
    @foreach ($results as $link)
        <p>
            <a href="{{ '/get/' . $link }}">{{ $link }}</a>
        </p>
    @endforeach
@else
    <p>Нет ответа</p>
@endif
