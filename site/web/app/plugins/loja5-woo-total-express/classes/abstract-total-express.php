<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Loja5_Shipping_Total_Express extends WC_Shipping_Method {

	protected $code = '';
    protected $log = null;
    public $serial = '';
    public $uri = 'https://edi.totalexpress.com.br/webservice_calculo_frete.php?wsdl';

	public function __construct( $instance_id = 0 ) {
		$this->instance_id        = absint( $instance_id );
		$this->method_description = sprintf( __( '%s é um metodo transportadora Total Express', 'loja5-woo-total-express' ), $this->method_title );
		$this->supports           = array(
			'shipping-zones',
			'instance-settings',
		);

		$this->init_settings();
		$this->init_form_fields();

        $this->title              = $this->get_option( 'title' );
        $this->pagar              = $this->get_option( 'pagar' );
        $this->fator              = $this->get_option( 'fator' );
        $this->peso_calculo       = $this->get_option( 'peso_calculo' );
		$this->peso_minimo        = $this->get_option( 'peso_minimo' );
		$this->prazo              = $this->get_option( 'prazo' );
        $this->taxa               = $this->get_option( 'taxa' );
        $this->debug              = $this->get_option( 'debug' );
        
        $this->log = new WC_Logger();

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	protected function get_log_link() {
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.2', '>=' ) ) {
			return ' <a href="' . esc_url( admin_url( 'admin.php?page=wc-status&tab=logs&log_file=' . esc_attr( $this->id ) . '-' . sanitize_file_name( wp_hash( $this->id ) ) . '.log' ) ) . '">' . __( 'Ver logs.', 'loja5-woo-total-express' ) . '</a>';
		}
	}
    
	public function init_form_fields() {
        $this->instance_form_fields = array(
			'imagem' => array(
				'title' => "",
				'type' 			=> 'hidden',
				'description' => "<img src='".plugins_url()."/loja5-woo-total-express/banner.png'>",
				'default' => ''
			),
		    'title' => array(
				'title'       => __( 'Titulo', 'loja5-woo-total-express' ),
				'type'        => 'text',
				'description' => __( 'Nome a exibir do meio de entrega.', 'loja5-woo-total-express' ),
				'desc_tip'    => true,
				'default'     => $this->method_title,
			),
			'behavior_options' => array(
				'title'   => __( 'Configura&ccedil;&otilde;es '.$this->method_title.'', 'loja5-woo-total-express' ),
				'type'    => 'title',
				'default' => '',
			),
		    'prazo' => array(
				'title' => "Prazo Extra",
				'type' => 'text',
				'description' => "Prazo extra em dias a somar no prazo real.",
				'default' => '1'
		    ),
			'taxa' => array(
				'title' => "Taxa Extra",
				'type' => 'text',
				'description' => "Valor em R$ de uma Taxa extra caso queira cobrar.",
				'default' => '0.00'
		    ),
            'peso_minimo' => array(
				'title'       => __( 'Peso Minimo KG', 'loja5-woo-total-express' ),
				'type'        => 'text',
				'description' => __( 'Peso minimo de um pedido para uso do modulo.', 'loja5-woo-total-express' ),
				'desc_tip'    => true,
				'placeholder' => '0.00',
				'default'     => '0.00',
			),
            'peso_calculo'  => array(
				'title'           => "Peso do Produto a Usar",
				'type'            => 'select',
				'default'         => 'cubado',
				'options'         => array(
					'real' => 'Peso real dos produtos',
					'cubado' => 'Peso cubado dos produtos'
				),
				'description' => ''
			),
            'fator' => array(
				'title'       => __( 'Fator de Cubagem', 'loja5-woo-total-express' ),
				'type'        => 'text',
				'description' => __( 'Fator de cubagem para calculo do peso cubico.', 'loja5-woo-total-express' ),
				'desc_tip'    => true,
				'default'     => '300',
			),
            'testing' => array(
				'title'   => __( 'Debug', 'loja5-woo-total-express' ),
				'type'    => 'title',
				'default' => '',
			),
			'debug' => array(
				'title'       => __( 'Log', 'loja5-woo-total-express' ),
				'type'        => 'checkbox',
				'label'       => __( 'Ativar log', 'loja5-woo-total-express' ),
				'default'     => 'no',
				'description' => sprintf( __( 'Logs e eventos de %s.', 'loja5-woo-total-express' ), $this->method_title ) . $this->get_log_link(),
			),
		);
	}

	public function admin_options() 
    {
		global $woocommerce;
		?>
		<h3><?php echo $this->method_title;?></h3>
		<p><?php echo $this->method_description;?></p>
		<table class="form-table">
			<?php
			echo $this->get_admin_options_html();
			?>
		</table>
		<?php
	}
    
    public function is_available( $package ) {
		return true;
	}

	protected function get_cart_total() {
		if ( ! WC()->cart->prices_include_tax ) {
			return WC()->cart->cart_contents_total;
		}
		return WC()->cart->cart_contents_total + WC()->cart->tax_total;
	}
    
    private function calcular_pesos($package) {
        $config = new Loja5_Shipping_Total_Express_Legacy();
        $fator = $this->fator;
        if($fator <= 0){
            $fator = 300;
        }
		$peso_cubado = $peso_real = $volume = 0;
    	foreach ( $package['contents'] as $item_id => $values ) {
    		if( !$values['data']->needs_shipping() ){
    			continue;
    		}
            $product = $values['data'];
			$qty     = $values['quantity'];
            $volume++;
            $alt = $product->get_height()/100;
            $com = $product->get_length()/100;
            $lar = $product->get_width()/100;
			$peso = $product->get_weight();
			if($config->settings['peso_tipo']=='k'){
				$peso_real += $peso*$qty;
				$peso_cubado += (($alt*$lar*$com)*$qty)*$fator;
			}else{
				$peso_real += ($peso/1000)*$qty;
				$peso_cubado += ((($alt*$lar*$com)*$qty)*$fator)/1000;
			}
    	}
        return array('real'=>round($peso_real, 2),'cubado'=>round($peso_cubado, 2),'volume'=>$volume);
    }

	public function calculate_shipping( $package = array() ) {
		$config = new Loja5_Shipping_Total_Express_Legacy();
		
        if ( 'yes' !== $this->enabled ) {
            return;
        }
        
        if ( '' === $package['destination']['postcode'] || 'BR' !== $package['destination']['country'] ) {
			return;
		}
        
        $peso = $this->calcular_pesos($package);
        
        //pega o peso para uso 
        if($this->peso_calculo=='cubado'){
            if($peso['real'] > $peso['cubado']){
                $peso = $peso['real'];
            }else{
                $peso = $peso['cubado'];
            }
        }else{
            $peso = $peso['real'];
        }
		if($peso < 1.00){
			$peso = 1.00;
		}
        
        //regra peso minimo
        if($peso < $this->peso_minimo){
            return;
        }
        
        //calcula 
        $calculo = $this->calcular_frete($package,$peso);
        
        if(isset($calculo->ValorServico)){
            $calculo_total = (float)str_replace(',','.',str_replace('.','',$calculo->ValorServico));
			$calculo_total = number_format($calculo_total, 2, '.', '');
            if(isset($calculo->Prazo)){
                $prazo = 'em at&eacute; '.((int)$this->prazo+$calculo->Prazo).' dia(s)';
            }else{
				$prazo = '';
			}				
            if($calculo_total > 0){
                $calculo_total += (float)$this->taxa;
                $this->add_rate(array(
                    'code'	=> 'total-express',
                    'id' 	=> $this->id,
                    'label' => $this->title.' '.$prazo.'',
                    'cost' 	=> $calculo_total
                ));
            }else{
                return;
            }
        }else{
            return;
        }

	}
	
	public function calcular_frete($pack,$peso){
	    global $woocommerce;
        
        $config = new Loja5_Shipping_Total_Express_Legacy();
        
        $request = array();
		$request['TipoServico'] = strtoupper($this->code);
        $request['CepDestino'] = preg_replace('/\D/', '', $pack['destination']['postcode']);
        $request['Peso'] = number_format($peso, 2, '.', '');
        $request['ValorDeclarado'] = number_format($pack['contents_cost'], 2, '.', '');
		$request['TipoEntrega'] = 0;
		$request['ServicoCOD'] = (bool)$config->settings['pagar'];
        
        if ( 'yes' === $this->debug ) {
            $this->log->add( $this->id, 'Total express '.$this->title.' envio: ' . print_r($request,true) );
        }
        
        $soap_opt = array();
        $soap_opt['stream_context'] = stream_context_create(array('http' => array('protocol_version' => 1.0) ) );
        $soap_opt['encoding']    = 'UTF-8';
        $soap_opt['trace']           = true;
        $soap_opt['exceptions'] = true;
		$soap_opt['connection_timeout'] = 10;
        $soap_opt['login'] = html_entity_decode(trim($config->settings['login']), ENT_QUOTES, 'UTF-8');
        $soap_opt['password'] = html_entity_decode(trim($config->settings['senha']), ENT_QUOTES, 'UTF-8');

		$client = new SoapClient($this->uri,$soap_opt);
		try { 
			$info = $client->__call("calcularFrete", array($request));
            
            if ( 'yes' === $this->debug ) {
                $this->log->add( $this->id, 'Total Express '.$this->title.' resultado: ' . print_r($info,true) );
            }
                
            if(isset($info->CodigoProc)){
                if($info->CodigoProc==1){
                    return $info->DadosFrete;
                }else{
                    $erro = isset($info->ErroConsultaFrete)?$info->ErroConsultaFrete:'Verificar login/senha e ambiente!';
                    if(function_exists('wc_add_notice')){
                        wc_add_notice("Erro Total Express ".$this->title.": " . $erro);
                    }else{
                        $woocommerce->add_error("Erro Total Express ".$this->title.": " . $erro);
                    }
                    return false;
                }
            }else{
                return false;
            }
		} catch (SoapFault $fault) { 
            if ( 'yes' === $this->debug ) {
                $this->log->add( $this->id, 'Total Express '.$this->title.' fault: ' . print_r( $fault->faultstring, true ) );
            }
			if(function_exists('wc_add_notice')){
                wc_add_notice("Erro Total Express: ".$fault->faultstring."");
			}else{
                $woocommerce->add_error("Erro Total Express: ".$fault->faultstring."");
			}
			return false; 
		}
	}
}