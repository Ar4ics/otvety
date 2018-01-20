@foreach ($results as $link)
    <a href="{{ '/get/' . $link }}">{{ $link }}</a>
@endforeach

