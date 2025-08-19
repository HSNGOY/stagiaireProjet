<?php
// menu.php - Menu de navigation réutilisable
function renderMenu($active = '') {
    $items = [
        'dashboard'    => 'Dashboard',
        'offres'       => 'Offres de stage',
        'demandes'     => 'Demandes de lettres',
        'etudiants'    => 'Etudiants',
        'statistiques' => 'Statistiques',
        'parametres'   => 'Paramètres'
    ];
    echo '<nav><ul>';
    foreach ($items as $url => $label) {
        $class = ($active === $url) ? ' class="active"' : '';
        echo "<li><a href='/StagiaireGestion-master/index.php?url={$url}'{$class}>{$label}</a></li>";
    }
    echo '</ul></nav>';
}
?>
