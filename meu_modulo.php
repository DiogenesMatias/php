<?php
/*
Plugin Name: Meu Modulo
Description: Um modulo simples para cadastro de nome e email.
Version: 1.0
Author: Diógenes Carvalho Matias 2024-1
*/

// Criação da tabela no banco de dados
function criar_tabela() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'meu_modulo';

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nome varchar(50) NOT NULL,
        email varchar(50) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

/////////Adicionando as novas tabelas////////////


///Fim das tabelas


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
//Novas tabelas
//Fim das novas tabelas

}

register_activation_hook(__FILE__, 'criar_tabela');

// Adicionando o menu do modulo no painel administrativo
function adicionar_menu() {
    add_menu_page('Meu Modulo', 'Meu Modulo', 'manage_options', 'meu_modulo', 'mostrar_conteudo');

//Novas tabelas

//fim das tabelas 

}

add_action('admin_menu', 'adicionar_menu');

// Conteúdo do modulo
function mostrar_conteudo() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'meu_modulo';

    // Atualizar dados no banco de dados
    if (isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['email'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        $wpdb->update(
            $table_name,
            array(
                'nome' => $nome,
                'email' => $email
            ),
            array('id' => $id)
        );
    }
    // Inserir dados no banco de dados
    elseif (isset($_POST['nome']) && isset($_POST['email'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        $wpdb->insert(
            $table_name,
            array(
                'nome' => $nome,
                'email' => $email
            )
        );
    }

    // Excluir dados do banco de dados
    if (isset($_POST['id_excluir'])) {
        $id = $_POST['id_excluir'];

        $wpdb->delete(
            $table_name,
            array('id' => $id)
        );
    }

// mostrar tabela no post´s

function mostrar_tabela() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'meu_modulo';

    // Exibir dados do banco de dados
    $resultados = $wpdb->get_results("SELECT * FROM $table_name");

    $output = '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';

    $output .= '<table class="w3-table w3-bordered w3-striped">';
    $output .= '<tr><th>Nome</th><th>Email</th></tr>';
    foreach ($resultados as $resultado) {
        $output .= '<tr>';
        $output .= '<td>' . $resultado->nome . '</td>';
        $output .= '<td>' . $resultado->email . '</td>';
        $output .= '</tr>';
    }
    $output .= '</table>';

    return $output;
}
add_shortcode('mostrar_tabela', 'mostrar_tabela');


    // Exibir dados do banco de dados
    $resultados = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';

    echo '<form method="post" class="w3-container">';
    echo '<div class="w3-container w3-center"><label><h3>Cadastro inicial</h3></label></div>';
    echo '<br>';
    echo '<label>Nome</label>';
    echo '<input class="w3-input" type="text" name="nome">';
    echo '<label>Email</label>';
    echo '<input class="w3-input" type="text" name="email">';
    echo '<br>';
    echo '<input class="w3-button w3-blue" type="submit" value="Cadastrar">';
    echo '</form>';

    echo '<table class="w3-table w3-bordered w3-striped">';
    echo '<tr><th>Nome</th><th>Email</th><th>Ações</th></tr>';
    foreach ($resultados as $resultado) {
        echo '<tr>';
        echo '<td>' . $resultado->nome . '</td>';
        echo '<td>' . $resultado->email . '</td>';
        echo '<td>';
        echo '<button class="w3-button w3-yellow" onclick="document.getElementById(\'modal' . $resultado->id . '\').style.display=\'block\'">Editar</button>';
        echo '<form method="post" style="display:inline">';
        echo '<input type="hidden" name="id_excluir" value="' . $resultado->id . '">';
        echo '<input class="w3-button w3-red" type="submit" value="Excluir">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';

        echo '<div id="modal' . $resultado->id . '" class="w3-modal">';
        echo '<div class="w3-modal-content">';
        echo '<div class="w3-container">';
        echo '<span onclick="document.getElementById(\'modal' . $resultado->id . '\').style.display=\'none\'" class="w3-button w3-display-topright">×</span>';
        echo '<form method="post">';
        echo '<input type="hidden" name="id" value="' . $resultado->id . '">';
        echo '<label>Nome</label>';
        echo '<input class="w3-input" type="text" name="nome" value="' . $resultado->nome . '">';
        echo '<label>Email</label>';
        echo '<input class="w3-input" type="text" name="email" value="' . $resultado->email . '">';
	echo '<br>';
        echo '<input class="w3-btn w3-round-xlarge w3-blue" type="submit" value="Atualizar">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</table>';
}

//Adicionando menu no plugin ###########################################

// Adiciona o menu do módulo no painel administrativo


//finalizando o menu #######################################3

?>
