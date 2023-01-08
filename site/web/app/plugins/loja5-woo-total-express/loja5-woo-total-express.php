<?php
/*
  Plugin Name: Transportadora Total Express - Loja5
  Description: Integração a transportadora Total Express
  Version: 1.0
  Author: Loja5.com.br
  Author URI: http://www.loja5.com.br
  Copyright: © 2009-2017 Loja5.com.br.
  License: Comercial
*/

if ( ! class_exists( ' WC_Loja5_Total_Express' ) ) {
    
class WC_Loja5_Total_Express {
    
    protected static $instance = null;
    
    private function __construct() {
        $this->init();
        add_filter( 'woocommerce_shipping_methods', array( $this, 'include_methods' ) );
    }
	
	public function init() {
        if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.6.0', '>=' ) ) {
            include_once(dirname(__FILE__).'/classes/class.loja5.php');
			include_once(dirname(__FILE__).'/classes/config-total-express.php');
            include_once(dirname(__FILE__).'/classes/abstract-total-express.php');
            include_once(dirname(__FILE__).'/classes/metodos-total-express.php');
        }else{
            add_action( 'admin_notices', array( $this, 'alerta_versao' ) );
        }
	}
    
    public function alerta_versao(){
        echo '<div class="error">';
        echo '<p><strong>M&oacute;dulo Transportadora Total Express:</strong> Requer vers&atilde;o Woo 2.6.x ou superior, atualize seu Woo para vers&atilde;o compativel!</p>';
        echo '</div>';
    }
	
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
	
	public function include_methods( $methods ) {        
        if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.6.0', '>=' ) ) {
            $methods['total-express-legacy'] = 'Loja5_Shipping_Total_Express_Legacy';
            $methods['total-express-esp'] = 'Loja5_Shipping_Total_Express_ESP';
            $methods['total-express-exp'] = 'Loja5_Shipping_Total_Express_EXP';
            $methods['total-express-std'] = 'Loja5_Shipping_Total_Express_STD';
            $methods['total-express-prm'] = 'Loja5_Shipping_Total_Express_PRM';
        }
		return $methods;
	}
}

add_action( 'plugins_loaded', array( 'WC_Loja5_Total_Express', 'get_instance' ) );

}
?>