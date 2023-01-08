<?php
class Loja5_Shipping_Total_Express_ESP extends Loja5_Shipping_Total_Express {
    
    public $code = 'ESP';
    
    public function __construct( $instance_id = 0 ) {
        $this->id           = 'total-express-esp';
        $this->method_title = __( 'Total Express - Especial', 'loja5-woo-total-express' );
        $this->more_link    = 'https://www.totalexpress.com.br/';
        parent::__construct( $instance_id );
    }
    
}

class Loja5_Shipping_Total_Express_EXP extends Loja5_Shipping_Total_Express {
    
    public $code = 'EXP';
    
    public function __construct( $instance_id = 0 ) {
        $this->id           = 'total-express-exp';
        $this->method_title = __( 'Total Express - Expresso', 'loja5-woo-total-express' );
        $this->more_link    = 'https://www.totalexpress.com.br/';
        parent::__construct( $instance_id );
    }
    
}

class Loja5_Shipping_Total_Express_STD extends Loja5_Shipping_Total_Express {
    
    public $code = 'STD';
    
    public function __construct( $instance_id = 0 ) {
        $this->id           = 'total-express-std';
        $this->method_title = __( 'Total Express - Standard', 'loja5-woo-total-express' );
        $this->more_link    = 'https://www.totalexpress.com.br/';
        parent::__construct( $instance_id );
    }
    
}

class Loja5_Shipping_Total_Express_PRM extends Loja5_Shipping_Total_Express {
    
    public $code = 'PRM';
    
    public function __construct( $instance_id = 0 ) {
        $this->id           = 'total-express-prm';
        $this->method_title = __( 'Total Express - Premium', 'loja5-woo-total-express' );
        $this->more_link    = 'https://www.totalexpress.com.br/';
        parent::__construct( $instance_id );
    }
    
}