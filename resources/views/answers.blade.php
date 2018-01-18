<HTML>
<HEAD>
    <TITLE>Тест по специальности 05.13.18 Раздел I. Математическое моделирование </TITLE>
    <META http-equiv=Content-Type content="text/html; charset=windows-1251">
</HEAD>
<BODY text=black bgColor=white leftMargin=0 background="../images/oboifon.jpg">

<H2>Тест по специальности 05.13.18</H2>

<H3>{{ $part }}. Математическое моделирование </H3>


<table>

    @foreach ($answers as $answer)
        <tr>
            <td>
                <b>{!! $answer->question !!}</b>
                <ol>
                    @foreach ($answer->answers as $variant)
                        @if ($loop->iteration === $answer->correct)
                            <li style="background-color: #2ab27b">{!! $variant !!}</li>
                        @else
                            <li>{!! $variant !!}</li>
                        @endif
                    @endforeach
                </ol>
                <b>Правильный ответ {{ $answer->correct }}</b>
            </td>
        </tr>
    @endforeach

</table>
</body>
</html>

