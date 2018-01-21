<form id="form" method="post" action="/search">
    {{ csrf_field() }}
    <label for="question">Вопрос</label>
    <input id="question" name="question" type="text"/>
</form>
<button onclick="submit()">Найти</button>
<script>
function submit() {
    let q = document.getElementById("question");
    q.select();
    document.execCommand("Copy");
    document.getElementById("form").submit();
    q.value = '';
}
</script>