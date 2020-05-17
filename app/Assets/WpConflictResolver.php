<?php namespace App\Assets;

class WpConflictResolver {
  public function __construct() {
    add_action('wp', [$this, 'remove_sumome']);
    add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_default_template_stylesheet' ], 999 );
  }

  public function dequeue_default_template_stylesheet() {

    if ( get_theme_support( 'onepager' ) ) {
      return;
    }

    if ( ! onepager()->content()->isOnepage() ) {
      return;
    }

    global $wp_styles;
    
    
    if( method_exists($wp_styles, 'remove') )
    {
      $wp_styles->remove( get_default_template_stylesheet_handle() );
      if(onepager()->content()->isOnepageDefault()){
        $wp_styles->add('theme-default-stylesheet', get_stylesheet_uri() );
        $wp_styles->enqueue(array('theme-default-stylesheet'));
      }
    }
  }

  public function remove_sumome(){
    if ( onepager()->content()->isBuildMode() ||  onepager()->content()->isPreview()) {     
      global $wp_plugin_sumome;
      remove_action('wp_head', [$wp_plugin_sumome, 'append_script_code']);
    }
  }
}
