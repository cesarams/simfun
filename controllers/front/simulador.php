<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 */

class SimfunSimuladorModuleFrontController extends ModuleFrontController
{
	public $name = 'simulador';
	public $quota;
	public $quotes;
	private $_tipo_vivienda; 
	private $_estrato;
	private $_tipo_contrato;
	private $_terminos;
	private $_email_notification;
	

	public function init()
    {
		
		global $smarty;
        parent::init();
		$this->quotes = Configuration::get('PS_CONFIGURATION_'.mb_strtoupper($this->module->name.'_cuotas'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$this->quotes = explode(',',$this->quotes);
		
		$this->_tipo_vivienda = Configuration::get('PS_CONFIGURATION_'.mb_strtoupper($this->module->name.'_tipo_vivienda'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$this->_tipo_vivienda = explode(',',$this->_tipo_vivienda);
		
		$this->_estrato = Configuration::get('PS_CONFIGURATION_'.mb_strtoupper($this->module->name.'_estrato'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$this->_estrato = explode(',',$this->_estrato);
		
		$this->_tipo_contrato = Configuration::get('PS_CONFIGURATION_'.mb_strtoupper($this->module->name.'_tipo_contrato'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$this->_tipo_contrato = explode(',',$this->_tipo_contrato);
		$this->_terminos  = Configuration::get('PS_CONFIGURATION_'.mb_strtoupper($this->module->name.'_term'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$this->_emailnotificacion = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->module->name.'_emailnotificacion'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		require_once dirname(__FILE__)."/../../classes/Simfun.php";		
		if(Tools::getValue('ajax')) {
			switch(Tools::getValue('ajax')) {
				case 'calculate':
					$simfun = new SimfunCore();
					
					if(!Tools::getValue('value') || !Validate::isUnsignedInt(Tools::getValue('value')))
						$this->errors[] = $this->trans('Ingrese el Valor de la compra');
						
					if(!Tools::getValue('quota') || !Validate::isUnsignedInt(Tools::getValue('quota')))
						$this->errors[] = $this->trans('Seleccione el Número de cuotas');	
					
					if(Tools::getValue('value') && Tools::getValue('quota'))
						$this->quota = $simfun->getQuota(Tools::getValue('value'),Tools::getValue('quota'));
					
					if(!count($this->errors)) {
						$response['haserror'] = false;
						$response['message'] = $this->quota;
					}
				break;
				case 'register':
					$simfun = new SimfunCore();
					$_POST = Tools::getValue('post'); 
					
					if(!Tools::getValue('nombre') || !Validate::isName(Tools::getValue('nombre')))
						$this->errors[] = $this->trans('Ingrese un nombre válido');
						
					if(!Tools::getValue('identificacion'))
						$this->errors[] = $this->trans('Ingrese su identificación');	
						
					if(!Tools::getValue('telefono') || !Validate::isPhoneNumber(Tools::getValue('telefono')))
						$this->errors[] = $this->trans('Ingrese un número de teléfono válido');		
					
					if(!Tools::getValue('celular') || !Validate::isPhoneNumber(Tools::getValue('celular')))
						$this->errors[] = $this->trans('Ingrese un número de celular válido');	
						
					if(!Tools::getValue('direccion') || !Validate::isAddress(Tools::getValue('direccion')))
						$this->errors[] = $this->trans('Ingrese una dirección válida');	
						
					if(!Tools::getValue('departamento') || !Validate::isCityName(Tools::getValue('departamento')))
						$this->errors[] = $this->trans('Ingrese un departamento válido');	
						
					if(!Tools::getValue('ciudad') || !Validate::isCityName(Tools::getValue('ciudad')))
						$this->errors[] = $this->trans('Ingrese una ciudad válida');
						
					if(!Tools::getValue('barrio') || !Validate::isCityName(Tools::getValue('barrio')))
						$this->errors[] = $this->trans('Ingrese una barrio válido');	
						
					if(!Tools::getValue('email') || !Validate::isEmail(Tools::getValue('email')))
						$this->errors[] = $this->trans('Ingrese un Email válido');	
						
					if(!Tools::getValue('vivienda'))
						$this->errors[] = $this->trans('Seleccione el tipo de vivienda');	
					
					if(!Validate::isInt(Tools::getValue('personas_cargo')))
						$this->errors[] = $this->trans('Ingrese un numero de personas a cargo válida');	
						
					if(!Validate::isInt(Tools::getValue('hijos')))
						$this->errors[] = $this->trans('Ingrese un numero de hijos válido');	
						
					if(!Validate::isInt(Tools::getValue('estrato')))
						$this->errors[] = $this->trans('Seleccione el estrato');		
						
					if(!Tools::getValue('empresa') || !Validate::isGenericName(Tools::getValue('empresa')))
						$this->errors[] = $this->trans('Ingrese la empresa');	
						
					if(!Tools::getValue('direccion_empresa') || !Validate::isAddress(Tools::getValue('direccion_empresa')))
						$this->errors[] = $this->trans('Ingrese una dirección de empresa válida');
						
					if(!Tools::getValue('telefono_empresa') || !Validate::isPhoneNumber(Tools::getValue('telefono_empresa')))
						$this->errors[] = $this->trans('Ingrese un teléfono de empresa válido');	
						
					if(!Validate::isGenericName(Tools::getValue('cargo')))
						$this->errors[] = $this->trans('Ingrese un cargo válido');														
					
					if(!Validate::isGenericName(Tools::getValue('cargo')))
						$this->errors[] = $this->trans('Ingrese un cargo válido');
						
					if(!Validate::isGenericName(Tools::getValue('eps')))
						$this->errors[] = $this->trans('Ingrese una EPS válida');
						
					if(!Validate::isGenericName(Tools::getValue('fondo')))
						$this->errors[] = $this->trans('Ingrese un fondo de pensión válido');
						
					if(!Validate::isGenericName(Tools::getValue('actividad')))
						$this->errors[] = $this->trans('Ingrese su actividad económica');
						
					if(!Tools::getValue('contrato'))
						$this->errors[] = $this->trans('Seleccione el tipo de contrato');	
						
					if(!Tools::getValue('fecha_vinculacion') || !Validate::isDate(Tools::getValue('fecha_vinculacion')))
						$this->errors[] = $this->trans('Ingrese una fecha de vinculación válida');	
						
					if(!Tools::getValue('ingresos') || !Validate::isInt(Tools::getValue('ingresos')))
						$this->errors[] = $this->trans('Ingrese un monto válido de ingresos');	
						
					if(!Tools::getValue('egresos') || !Validate::isInt(Tools::getValue('egresos')))
						$this->errors[] = $this->trans('Ingrese un monto válido de egresos');
						
					if(!Validate::isGenericName(Tools::getValue('placa_vehiculo')))
						$this->errors[] = $this->trans('Ingrese un egreso válido');	
					
					if(Tools::getValue('conyuge_nombre') 
						|| Tools::getValue('conyuge_identificacion')
						|| Tools::getValue('conyuge_actividad')
						|| Tools::getValue('conyuge_ingresos')
						|| Tools::getValue('conyuge_telefono')) 
					{
						
						if(!Validate::isName(Tools::getValue('conyuge_nombre')))
							$this->errors[] = $this->trans('Ingrese el nombre del conyuge');	
							
						if(!Tools::getValue('conyuge_identificacion'))
							$this->errors[] = $this->trans('Ingrese la identificación del conyuge');		
							
						if(!Validate::isGenericName(Tools::getValue('conyuge_actividad')))
							$this->errors[] = $this->trans('Ingrese la actividad económica dekl conyuge');
							
						if(!Validate::isInt(Tools::getValue('conyuge_ingresos')))
							$this->errors[] = $this->trans('Ingrese un monto válido de ingresos');
							
						if(!Validate::isPhoneNumber(Tools::getValue('conyuge_telefono')))
							$this->errors[] = $this->trans('Ingrese el teléfono del conyuge');	
					}
					
					if(!Tools::getValue('referencia_familiar_nombre')
						&& !Tools::getValue('referencia_familiar_telefono')
						&& !Tools::getValue('referencia_familiar_celular')) 
					{
						$this->errors[] = $this->trans('Ingrese la referencia familiar');
					} else {
											
						if(!Tools::getValue('referencia_familiar_nombre') || !Validate::isName(Tools::getValue('referencia_familiar_nombre')))
							$this->errors[] = $this->trans('Ingrese el nombre de la referencia familiar');
	
						if(!Tools::getValue('referencia_familiar_telefono') || !Validate::isPhoneNumber(Tools::getValue('referencia_familiar_telefono')))
							$this->errors[] = $this->trans('Ingrese un teléfono válido para de la referencia familiar');	
	
						if(!Tools::getValue('referencia_familiar_celular') || !Validate::isPhoneNumber(Tools::getValue('referencia_familiar_celular')))
							$this->errors[] = $this->trans('Ingrese un celular válido la para referencia familiar');	
					}
					
					if(!Tools::getValue('referencia_personal_nombre')
						&& !Tools::getValue('referencia_personal_telefono')
						&& !Tools::getValue('referencia_personal_celular')) 
					{
						$this->errors[] = $this->trans('Ingrese la referencia personal');
					} else {
						if(!Tools::getValue('referencia_personal_nombre') || !Validate::isName(Tools::getValue('referencia_personal_nombre')))
							$this->errors[] = $this->trans('Ingrese el nombre de la referencia personal');	
	
						if(!Tools::getValue('referencia_personal_telefono') || !Validate::isPhoneNumber(Tools::getValue('referencia_personal_telefono')))
							$this->errors[] = $this->trans('Ingrese un teléfono válido para la referencia personal');	
							
						if(!Tools::getValue('referencia_personal_celular') || !Validate::isPhoneNumber(Tools::getValue('referencia_personal_celular')))
							$this->errors[] = $this->trans('Ingrese un celular válido para la referencia personal');
					}

					if($this->_terminos) {
						if(Tools::getValue('terminos') == 'false')
							$this->errors[] = $this->trans('Acepte los términos y condiciones');
					}
					
					if(!count($this->errors)) {
						
						try {
							foreach($_POST as $k => &$v) {
								$simfun->$k = $v;
							}
							$simfun->id_shop = $this->context->shop->id;
							$simfun->date = date('Y-m-d H:i:s');
							$simfun->tasa = Configuration::get(
								'PS_CONFIGURATION_SIMFUN_TASA',
								null,
								Shop::getContextShopGroupID(true),
								Shop::getContextShopID(true)
							);
							$couta = $simfun->getQuota($simfun->value,$simfun->quota,true);
							$simfun->cuota = $couta['quote'];
							if($this->_emailnotificacion) {
								$emails = explode(',',$this->_emailnotificacion);
								foreach(explode(',',$this->_emailnotificacion) as &$email) {
									Mail::Send((int)(
										Configuration::get('PS_LANG_DEFAULT')), // idLang
										'simfun', // template
										$this->trans('Nueva solicitud de crédito'), // subject
										array( // templateVars
										  '{customer}' => $_POST['nombre'], // sender email address
										), 
										$email, // to
										'test', 
										Configuration::get('PS_SHOP_EMAIL') , //from 
										NULL,  // fromName 
										NULL, //fileAttachment
										NULL, //mode_smtp
										_MODULE_DIR_.$this->module->name.'/' // templatePath
									);
								}
							}
							$simfun->add();
							unset($_POST);
							$response['haserror'] = false;
							$response['message'] = Configuration::get(
													'PS_CONFIGURATION_'.mb_strtoupper($this->module->name.'_message'),
													null,
													Shop::getContextShopGroupID(true),
													Shop::getContextShopID(true)
												);
							
						} catch (Exception $e) {
							$this->errors[] = $e->getMessage();
						}
					}
				break;			
			}
			if(count($this->errors)) {
				$response['haserror'] = true;
				$response['message'] = $this->_printErrors();
			}
			die(Tools::jsonEncode($response));
			exit;
		}
	}
	
	private function _printErrors() {
		$html = '<div class="col-xs-12 alert alert-danger">
					<ul>
						<li>';
		$html.= implode('</li><li>',$this->errors);
		$html.= '		</li>
					</ul>
				</div>';
				
		return $html;
	}
	
	public function initContent()
	{
		parent::initContent();
		$original_path = _PS_MAIL_DIR_;		
		$this->context->smarty->assign(array(
			'quotes' => $this->quotes,
			'action' => $this->context->link->getModuleLink($this->module->name,$this->name),
			'errors' => $this->errors,
			'value' => Tools::getValue('value'),
			'quota' => $this->quota,
			'estrato' => $this->_estrato,
			'tipo_contrato' => $this->_tipo_contrato,
			'tipo_vivienda' => $this->_tipo_vivienda,
			'terminos'		=> $this->_terminos,
			'quotaselected' => Tools::getValue('quotes'),
		));
		$this->setTemplate('module:'.$this->module->name.'/views/templates/front/simulator.tpl');
	}
	public function setMedia() 
	{
		parent::setMedia();
		$this->addJqueryUI('ui.datepicker');
		$this->addJqueryPlugin(array('fancybox'));		
    }
}