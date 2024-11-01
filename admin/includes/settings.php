<?php
defined('ABSPATH') || exit;

// Ajouter une page de réglages pour le plugin
function customlogin_plugin_settings_page_content() {
    wp_enqueue_script('custom-login-preview', plugin_dir_url(__FILE__) . '../js/preview.js', array('jquery'), null, true);
    wp_localize_script('custom-login-preview', 'customLoginSettings', array(
        'nonce' => wp_create_nonce('custom_login_form_action')
    ));
    wp_enqueue_style('custom-login-styles', plugin_dir_url(__FILE__) . '../css/custom-login-styles.css');
    ?>
    <div class="wrap">
        <h2><?php esc_html_e('Custom Login Plugin Settings', 'simple-login-custom'); ?></h2>
        <h2 class="nav-tab-wrapper">
            <!--<a href="?page=custom-login-plugin-settings" class="nav-tab <?php echo (!isset($_GET['tab']) || $_GET['tab'] === 'login') ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Login', 'simple-login-custom'); ?></a>-->
            <a href="?page=custom-login-plugin-settings&tab=style" class="nav-tab <?php echo (!isset($_GET['tab']) || $_GET['tab'] === 'style') ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Style', 'simple-login-custom'); ?></a>
            <a href="?page=custom-login-plugin-settings&tab=control" class="nav-tab <?php echo (isset($_GET['tab']) && $_GET['tab'] === 'control') ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Simple Login Control', 'simple-login-custom'); ?></a>
        </h2>
        <?php
        $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field($_GET['tab']) : 'style';

        if( $active_tab == 'style' ) {
            $form_max_width = get_option('customlogin_form_max_width', '100%');
            $form_background_color = get_option('customlogin_form_background_color', '#0FF000');
            $form_text_color = get_option('customlogin_form_text_color', '#00FF00');
            $form_border_color = get_option('customlogin_form_border_color', '#00FF00');
            $form_border_width = get_option('customlogin_form_border_width', '3px');
            $form_border_style = get_option('customlogin_form_border_style', 'solid');
            $form_border_padding = get_option('customlogin_form_border_padding', '1em');
            $link_color = get_option('customlogin_link_color', '#00FF00');
            $link_underline_style = get_option('customlogin_link_underline_style', 'Aucun');
			$text_normal = get_option('customlogin_link_text_normal', 'Veuillez vous');
            $link_text = get_option('customlogin_link_text', 'identifier');
			$is_register = get_option('customlogin_show_buttons', 0);
            ?>
    <h3 style="display: flex; justify-content: space-between; align-items: center;">
    <?php esc_html_e('Style du formulaire de connexion', 'simple-login-custom'); ?>
    <label class="switch">
        <input type="checkbox" id="toggle-form-buttons" name="customlogin_show_buttons" value="1" <?php checked($is_register, 1); ?>>
        <span class="slider round"></span>
    </label>
</h3>
    <form method="post" action="options.php" id="custom-login-style-form">
        <?php settings_fields('custom-login-plugin-style-group'); ?>
        <div class="preview-container form-preview">
			<div class="form-navigation" style="display:none;">
        <button class="switch-form login-btn">Se connecter</button>
        <button class="switch-form register-btn">Créer un compte</button>
    		</div>
            <h3><?php esc_html_e('Aperçu du formulaire de connexion', 'simple-login-custom'); ?></h3>
			<div id="register-form-preview" class="login-form-preview" style="display: none;">
    <!-- Le contenu dynamique sera inséré ici via AJAX -->
			</div>
            <div id="login-form-preview" class="login-form-preview">
                <?php /*echo customlogin_form_shortcode();*/ ?>
            </div>
        </div>
        <table class="form-table" style="clear: unset; width: 50%;">
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Largeur du formulaire', 'simple-login-custom'); ?></th>
                <td><input type="text" name="customlogin_form_max_width" value="<?php echo esc_attr($form_max_width); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Couleur de fond du formulaire', 'simple-login-custom'); ?></th>
                <td><input type="text" name="customlogin_form_background_color" value="<?php echo esc_attr($form_background_color); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Couleur du texte du formulaire', 'simple-login-custom'); ?></th>
                <td><input type="text" name="customlogin_form_text_color" value="<?php echo esc_attr($form_text_color); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Couleur du contour du formulaire', 'simple-login-custom'); ?></th>
                <td><input type="text" name="customlogin_form_border_color" value="<?php echo esc_attr($form_border_color); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Style du contour du formulaire', 'simple-login-custom'); ?></th>
                <td><input type="text" name="customlogin_form_border_style" value="<?php echo esc_attr($form_border_style); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Epaisseur du contour du formulaire', 'simple-login-custom'); ?></th>
                <td><input type="text" name="customlogin_form_border_width" value="<?php echo esc_attr($form_border_width); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Décalage du contour du formulaire', 'simple-login-custom'); ?></th>
                <td><input type="text" name="customlogin_form_border_padding" value="<?php echo esc_attr($form_border_padding); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
    <hr />
    <h3><?php esc_html_e('Style du lien personnalisé', 'simple-login-custom'); ?></h3>
    <form method="post" action="options.php" id="custom-login-style-link">
        <?php settings_fields('custom-login-plugin-style-link-group'); ?>
        <div class="preview-container link-preview">
            <h3><?php esc_html_e('Aperçu du lien du formulaire de connexion', 'simple-login-custom'); ?></h3>
            <div id="login-link-preview" class="login-link-preview">
                <?php /*echo customlogin_link_shortcode();*/ ?>
            </div>
        </div>
        <table class="form-table" style="clear: unset; width: 50%;">
			<tr valign="top">
                 <th scope="row"><?php esc_html_e('Partie normale du texte du lien', 'simple-login-custom'); ?></th>
                 <td><input type="text" name="customlogin_link_text_normal" value="<?php echo esc_attr($text_normal); ?>" /></td>
            </tr>
            <tr valign="top">
                 <th scope="row"><?php esc_html_e('Texte du lien avec le lien', 'simple-login-custom'); ?></th>
                 <td><input type="text" name="customlogin_link_text" value="<?php echo esc_attr($link_text); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Couleur du lien', 'simple-login-custom'); ?></th>
                <td><input type="text" name="customlogin_link_color" value="<?php echo esc_attr($link_color); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Style de soulignement du lien', 'simple-login-custom'); ?></th>
                <td>
                    <select name="customlogin_link_underline_style">
                        <option value="none" <?php selected( $link_underline_style, 'none' ); ?>><?php esc_html_e('Aucun', 'simple-login-custom'); ?></option>
                        <option value="underline" <?php selected( $link_underline_style, 'underline' ); ?>><?php esc_html_e('Souligné', 'simple-login-custom'); ?></option>
                        <option value="overline" <?php selected( $link_underline_style, 'overline' ); ?>><?php esc_html_e('Sur la ligne', 'simple-login-custom'); ?></option>
                        <option value="line-through" <?php selected( $link_underline_style, 'line-through' ); ?>><?php esc_html_e('Traversé', 'simple-login-custom'); ?></option>
                    </select>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
		<h3><?php esc_html_e('Shortcode', 'simple-login-custom'); ?></h3>
        <p><?php esc_html_e('Utilisez le shortcode suivant pour afficher le formulaire de connexion personnalisé sur n\'importe quelle page :', 'simple-login-custom'); ?> <code>[customlogin_form]</code></p>
        <p><?php esc_html_e('Utilisez le shortcode suivant pour afficher le lien vers le formulaire personnalisé avec un texte personnalisé :', 'simple-login-custom'); ?> <code>[customlogin_link]</code> (<?php esc_html_e('possibilité d\'utiliser un scroll to id', 'simple-login-custom'); ?>)</p>
    <?php
        } elseif ( $active_tab == 'control' ) {
            // Contenu de la tabulation "Simple Login Control"
            ?>
		<style>
			.matrix-login-logs {
    background-color: #000;
    color: #00FF00;
    padding: 20px;
    border-radius: 10px;
    font-family: 'Courier New', monospace;
    overflow: hidden;
}

.login-logs-matrix {
    max-height: 400px;
    overflow-y: auto;
}

.login-logs-matrix div {
    animation: matrix-effect 7s infinite;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
}

@keyframes matrix-effect {
    0% { opacity: 0; transform: translateY(-10px); }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { opacity: 0; transform: translateY(10px); }
}
		</style>
		<script>
			jQuery(document).ready(function($) {
    function updateLogs() {
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_latest_logins'
        },
        success: function(response) {
            if (response.success && response.data.logins) {
                $('#login-logs-container').empty();
                $.each(response.data.logins, function(index, login) {
                    var $log = $('<div class="login-log">' + login.user + ' - ' + login.timestamp + ' - IP: ' + login.ip + '</div>');
                    $('#login-logs-container').append($log);
                    setTimeout(function() {
                        $log.css('opacity', 1); // Assure que l'animation CSS se déclenche
                    }, 100); // Petit délai pour s'assurer que le CSS s'applique correctement
                });
            } else {
                console.log("La réponse ne contient pas les logins attendus:", response);
                $('#login-logs-container').html('<div class="login-log error">Erreur lors de la récupération des logs</div>');
            }
        },
        error: function(xhr, status, error) {
            console.log("Erreur de l'AJAX request:", status, error);
            $('#login-logs-container').html('<div class="login-log error">Erreur lors de la récupération des logs</div>');
        }
    });
}

    // Initial update
    updateLogs();

    // Update every 60 seconds
    setInterval(updateLogs, 60000);
});
		</script>
            <div class="matrix-login-logs">
    <h2 style="color: #00FF00; text-shadow: 0 0 10px #00FF00;"><?php esc_html_e('Dernières Connexions', 'simple-login-custom'); ?></h2>
    <div id="login-logs-container" class="login-logs-matrix">
        <!-- Les logs seront insérés ici par JavaScript -->
    </div>
</div>
            <?php
        }?>

        <!-- Section pour afficher le shortcode -->
        <!--<h3><?php esc_html_e('Shortcode', 'simple-login-custom'); ?></h3>
        <p><?php esc_html_e('Utilisez le shortcode suivant pour afficher le formulaire de connexion personnalisé sur n\'importe quelle page :', 'simple-login-custom'); ?> <code>[customlogin_form]</code></p>
        <p><?php esc_html_e('Utilisez le shortcode suivant pour afficher le lien vers le formulaire personnalisé avec un texte personnalisé :', 'simple-login-custom'); ?> <code>[customlogin_link]</code> (<?php esc_html_e('possibilité d\'utiliser un scroll to id', 'simple-login-custom'); ?>)</p>-->
    </div>
    <?php
}

// Enregistrer les options de configuration du plugin
function customlogin_plugin_register_settings() {
    register_setting('custom-login-plugin-login-group', 'customlogin_domain');
    register_setting('custom-login-plugin-style-group', 'customlogin_form_style');
    register_setting('custom-login-plugin-control-group', 'customlogin_logo_text');
    register_setting('custom-login-plugin-login-group', 'customlogin_desc_id'); // Enregistrer l'ID du paragraphe de description
    register_setting('custom-login-plugin-style-link-group', 'customlogin_link_text_normal');
    register_setting('custom-login-plugin-style-link-group', 'customlogin_link_text'); // Enregistrer le texte du lien
    // Enregistrer les options de style
    register_setting('custom-login-plugin-style-group', 'customlogin_show_buttons');
    register_setting('custom-login-plugin-style-group', 'customlogin_form_max_width');
    register_setting('custom-login-plugin-style-group', 'customlogin_form_background_color');
    register_setting('custom-login-plugin-style-group', 'customlogin_form_text_color');
    register_setting('custom-login-plugin-style-group', 'customlogin_form_border_padding');
    register_setting('custom-login-plugin-style-group', 'customlogin_form_border_width');
    register_setting('custom-login-plugin-style-group', 'customlogin_form_border_style');
    register_setting('custom-login-plugin-style-group', 'customlogin_form_border_color');
    register_setting('custom-login-plugin-style-link-group', 'customlogin_link_color');
    register_setting('custom-login-plugin-style-link-group', 'customlogin_link_underline_style');
}
add_action('admin_init', 'customlogin_plugin_register_settings');