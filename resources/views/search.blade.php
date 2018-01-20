<form method="post" action="/search">
    {{ csrf_field() }}
    <label for="question">Вопрос</label>
    <input id="question" name="question" type="text"/>
    <button type="submit">Найти</button>
</form>
