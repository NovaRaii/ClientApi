<?php
namespace App\Html;

use App\Html\AbstractPage;   

class PageCounties extends AbstractPage
{
    static function table(array $entities) {
        echo '<h1>Megyék</h1>';
        self::searchBar();
    
        if (isset($_GET['btn-search']) && !empty($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $entities = array_filter($entities, function($entity) use ($searchTerm) {
                if (is_array($entity) && isset($entity['id']) && isset($entity['name'])) {
                    return (stripos($entity['name'], $searchTerm) !== false) || 
                           (stripos((string)$entity['id'], $searchTerm) !== false);
                }
                return false;
            });
        }
        
        echo '<table id="counties-table">';
        self::tableHead();
        self::tableBody($entities);
        echo "</table>";
    }

    static function tableHead()
    {
        echo ' 
        <thead>
            <tr>
                <th class="id-col">#</th>
                <th>Megnevezés</th>
                <th style="float: right; display: flex">
                    Művelet&nbsp;
                    <button id="btn-add" title="Új">+</button>';

        echo'
                </th>
            </tr>
            <tr id="editor" class="hidden">';
            self::editor();
            echo '  
            </tr>
        </thead>';
    }

    static function editor() {
        $searchTerm = htmlspecialchars($_GET['search'] ?? '');
        echo '
            <th>&nbsp;</th>
            <th>
                <form name="county-editor" method="post" action="">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" name="search" value="' . $searchTerm . '">
                    <input type="search" id="name" name="name" placeholder="County Name" required>
                    <button type="submit" id="btn-save-county" name="btn-save-county" title="Save">
                        <i class="fa fa-save"></i>
                    </button>
                    <button type="button" id="btn-cancel-county" title="Cancel">
                        <i class="fa fa-times"></i>
                    </button>
                </form>
            </th>
            <th class="flex">&nbsp;</th>';
    }
    static function editForm($county) {
        echo "
        <h2>Megye szerkesztése</h2>
        <form method='post' action=''>
            <input type='hidden' name='id' value='{$county['id']}'>
            <input type='text' name='name' value='{$county['name']}' required>
            <button type='submit' name='btn-update-county'>Mentés</button>
            <button type='submit' name='btn-cancel'>Mégse</button>
        </form>";
    }

    static function tableBody(array $entities) {
        echo '<tbody>';
        if (empty($entities)) {
            echo '<tr><td colspan="3">Nincs találat.</td></tr>'; // No results found
        } else {
            $i = 0;
            foreach ($entities as $entity) {
                if (is_array($entity) && isset($entity['id']) && isset($entity['name'])) {
                    echo "
                    <tr class='" . (++$i % 2 ? "odd" : "even") . "'>
                        <td>{$entity['id']}</td>
                        <td>{$entity['name']}</td>
                        <td class='flex float-right'>
                            <div class='button-group'>
                                <form method='post' action='' class='inline-form'>
                                    <button type='submit'
                                        name='btn-edit-county'
                                        value='{$entity['id']}'
                                        title='Szerkesztés'>
                                        <i class='fa fa-edit'></i>
                                    </button>
                                </form>
                                <form method='post' action='' class='inline-form'>
                                    <button type='submit'
                                        id='btn-del-county-{$entity['id']}'
                                        name='btn-del-county'
                                        value='{$entity['id']}'
                                        title='Töröl'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>";
                }
            }
        }
        echo '</tbody>';
    }
}
?>