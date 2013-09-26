<?php
// Dê um Find Replace (CASE SENSITIVE!) em video pelo nome do seu post type 

class video
{
    const NAME = 'videos';
    const MENU_NAME = 'video';

    /**
     * alug do post type: deve conter somente minúscula 
     * @var string
     */
    protected static $post_type;

    static function init()
    {
        // o slug do post type
        self::$post_type = strtolower(__CLASS__);

        add_action('init', array(self::$post_type, 'register'), 0);

        add_action( 'init', array(__CLASS__, 'register_taxonomies') ,10);
        //add_filter('menu_order', array(self::$post_type, 'change_menu_label'));
        //add_filter('custom_menu_order', array(self::$post_type, 'custom_menu_order'));
        //add_action('save_post',array(__CLASS__, 'on_save'));
    }

    static function register()
    {
        register_post_type(self::$post_type, array(
            'labels' => array(
                'name' => _x(self::NAME, 'post type general name', 'SLUG'),
                'singular_name' => _x('video', 'post type singular name', 'SLUG'),
                'add_new' => _x('Adicionar Novo', 'image', 'SLUG'),
                'add_new_item' => __('Adicionar novo video', 'SLUG'),
                'edit_item' => __('Editar video', 'SLUG'),
                'new_item' => __('Novo video', 'SLUG'),
                'view_item' => __('Ver video', 'SLUG'),
                'search_items' => __('Search videos', 'SLUG'),
                'not_found' => __('Nenhum video Encontrado', 'SLUG'),
                'not_found_in_trash' => __('Nenhum video na Lixeira', 'SLUG'),
                'parent_item_colon' => ''
            ),
            'public' => true,
            'rewrite' => array('slug' => 'video'),
            'capability_type' => 'post',
            'hierarchical' => true,
            'map_meta_cap ' => true,
            'menu_position' => 6,
            'has_archive' => true, //se precisar de arquivo
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                //'page-attributes'
            ),
            'taxonomies' => array('cidade', 'estado', 'data', 'post_tag')
            )
        );
    }

    static function register_taxonomies()
    {
        // se for usar, descomentar //'taxonomies' => array('taxonomia') do post type (logo acima)

        $labels = array(
            'name' => _x('Cidades', 'taxonomy general name', 'SLUG'),
            'singular_name' => _x('Cidade', 'taxonomy singular name', 'SLUG'),
            'search_items' => __('Buscar cidade', 'SLUG'),
            'all_items' => __('Todas as cidades', 'SLUG'),
            'parent_item' => __('Cidade mãe', 'SLUG'),
            'parent_item_colon' => __('Cidade mãe:', 'SLUG'),
            'edit_item' => __('Editar cidade', 'SLUG'),
            'update_item' => __('Atualizar cidade', 'SLUG'),
            'add_new_item' => __('Adiciona nova cidade', 'SLUG'),
            'new_item_name' => __('Nome da nova cidade', 'SLUG'),
        );

        register_taxonomy('cidade', self::$post_type, array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            )
        );
        
        $labels = array(
            'name' => _x('Estados', 'taxonomy general name', 'SLUG'),
            'singular_name' => _x('Estado', 'taxonomy singular name', 'SLUG'),
            'search_items' => __('Buscar estado', 'SLUG'),
            'all_items' => __('Todos os estados', 'SLUG'),
            'parent_item' => __('Estado pai', 'SLUG'),
            'parent_item_colon' => __('Estado pai:', 'SLUG'),
            'edit_item' => __('Editar estado', 'SLUG'),
            'update_item' => __('Atualizar estado', 'SLUG'),
            'add_new_item' => __('Adiciona novo estado', 'SLUG'),
            'new_item_name' => __('Nome do novo estado', 'SLUG'),
        );

        register_taxonomy('estado', self::$post_type, array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            )
        );
        
        $labels = array(
            'name' => _x('Datas', 'taxonomy general name', 'SLUG'),
            'singular_name' => _x('Data', 'taxonomy singular name', 'SLUG'),
            'search_items' => __('Buscar data', 'SLUG'),
            'all_items' => __('Todos as datas', 'SLUG'),
            'parent_item' => __('Data pai', 'SLUG'),
            'parent_item_colon' => __('Data pai:', 'SLUG'),
            'edit_item' => __('Editar data', 'SLUG'),
            'update_item' => __('Atualizar data', 'SLUG'),
            'add_new_item' => __('Adiciona nova data', 'SLUG'),
            'new_item_name' => __('Nome do nova data', 'SLUG'),
        );

        register_taxonomy('data', self::$post_type, array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            )
        );
        
        
        
    }

    static function change_menu_label($stuff)
    {
        global $menu, $submenu;
        foreach ($menu as $i => $mi) {
            if ($mi[0] == self::NAME) {
                $menu[$i][0] = self::MENU_NAME;
            }
        }
        return $stuff;
    }

    static function custom_menu_order()
    {
        return true;
    }

    /**
     * Chamado pelo hook save_post
     * @param int $post_id
     * @param object $post
     */
    static function on_save($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        global $post;

        if ($post->post_type == self::$post_type) {
            // faça algo com o post 
        }
    }

}
video::init();
