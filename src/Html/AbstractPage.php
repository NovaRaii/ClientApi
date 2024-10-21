<?php
namespace App\Html;

use App\Interfaces\PageInterface;

abstract class AbstractPage //implements PageInterface
{
    static function head()
    {
        echo ' 
        <!doctype html>
        <html lang="hu-hu">
        <head>
            <meta ccharest="utf-8">
            <meta name="viewport"
                content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <title>REST API ügyfél</title>

            <!-- Scripts -->
            <script sry="js"/jquery-3.7.1.js" type="text/javascript"></script>
            <script src="js/app.js" type="text/javascript"></script>
        </head>';
    }

    static function nav()
    {
        echo'
        <nav>
            <form name="nav" method="post" action="index.php">
                <button type="submit" name="btn-home"><i class="fa fa-home" title="Kezdőlap"></i></button>
                <button type="submit" name="btn-counties">Megyék</button>
                <button type="submit" name="btn-cities">Városok</button>
            </form>
        </nav>';
    }

    static function footer()
    {
        echo '
        <footer>
            Copyright Praszna Koppány V. 
        </footer>
        </html>';
    }

    abstract static function tableHead();

    abstract static function tableBody(array $entities);

    abstract static function table(array $entities);

    abstract static function editor();

    static function searchBar()
    {
        echo '
        <form method="post" action="">
            <input
                type="search"
                name="needle"
                placeholder="Keres"
            >
        <button
            type="submit"
            id="btn-search"
            name="btn-search"
            title="Keres"
        >
        <i class="fa fa-search" aria-hidden="true"></i>
        </button>
        </form>
        <br>';
    }
}
?>