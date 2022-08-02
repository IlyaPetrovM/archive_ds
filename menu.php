<a href='search.php' class="nav-link">Поиск</a> 
<a href='files.php' class="nav-link">Файлы</a> 
<a href='informants.php' class="nav-link">Информанты</a>
<?php if (check_auth()) { ?>
    <div>Привет, <?=htmlspecialchars($_SESSION['username'])?>!</div>
    <form method="post" action="do_logout.php">
           <button type="submit" class="btn btn-secondary">Выйти</button>
    </form>
<?php } else { ?>
   <form method="post" action="login.php">
        <button type="submit" class="btn btn-secondary">Войти</button>
    </form>
<?php } ?>
<!--<a href='marks.php'>Опись</a> |-->
<!--<a href='dictionary.php'>Словарь</a>-->