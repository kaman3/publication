<div class = 'boxArticle'>
    <h3 class="headerCmenu">Поиск</h3>
    <form action = '/' method = 'get'>
       <input type = 'hidden' name = 'r' value="content">
       <input type = 'text' name = 'title_search' value="<?=$_GET['title_search'];?>">
       <input type = 'submit' value="Найти">
    </form>
</div>