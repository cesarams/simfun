<?php
/**
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @author    PrestaShop SA    <contact@prestashop.com>
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class simfun extends Module
{
	public $tabs = array(
				array(
						'name' => 'Crédito Online', // One name for all langs
						'class_name' => 'AdminSimfun',
						'visible' => true,
						'parent_class_name' => 'SELL',
			));
    public function __construct()
    {
        $this->name = 'simfun';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Fábricas Unidas';
		$this->secure_key = Tools::encrypt($this->name);
		parent::__construct();
        $this->displayName = $this->l('Simulador de credito');
        $this->description = $this->l('Instalador de componentes para formulario web crédito online');
        $this->_module = $this->name;
        $this->bootstrap = true;
        $this->confirmUninstall = $this->l('Esta seguro que desea desinstalar este modulo?');
        $this->_error = array();
        $this->_success = null;
    }
	
	protected function validatePost() 
	{
		if(!Validate::isUnsignedFloat(Tools::getValue($this->name.'_tasa'))) {
			$this->_error[] = Module::displayError($this->l('Ingrese una tasa de interes válida'));
		}
		
		if(Tools::getValue($this->name.'_cuotasdefault')) {
			if(!Validate::isInt(Tools::getValue($this->name.'_cuotasdefault'))) {
				$this->_error[] = Module::displayError($this->l('Ingrese una cuota por defecto válida'));
			}
		}
			
		if(!Tools::getValue($this->name.'_cuotas')) {
			$this->_error[] = Module::displayError($this->l('Ingrese un numero de cuotas válido'));	
		} else {
			$tasas = array_unique(array_filter(explode(',',Tools::getValue($this->name.'_cuotas'))));
			foreach($tasas as $tasa) {
				if(!Validate::isUnsignedInt($tasa)) {
					$this->_error[] = Module::displayError(sprintf($this->l('La tasa de interés %s no es válida'),$tasa));		
				}
			}
		}
	}
	
    protected function postProcess()
    {
		if(Tools::isSubmit($this->name.'_saveConfig')) {
			$this->validatePost();
			if(sizeof($this->_error) == 0) {
				$_POST[$this->name.'_cuotas'] = array_unique(array_filter(explode(',',Tools::getValue($this->name.'_cuotas'))));
				asort($_POST[$this->name.'_cuotas']);
				$_POST[$this->name.'_cuotas'] = implode(',',$_POST[$this->name.'_cuotas']);
				foreach ($_POST as $k => $v) {
					if (strstr($k, $this->name)) {
						Configuration::updateValue(
							Tools::strtoupper('ps_configuration_'.$k),
							$v ,
							in_array($k, array($this->name.'_message',$this->name.'_term')) ? true : false,
							Shop::getContextShopGroupID(true),
							Shop::getContextShopID(true)
						);
						$this->_success = Module::displayConfirmation($this->l('Actualización exitosa'));
					}
				}
			}
		}
    }
	
    public function getContent()
    {
        $this->postProcess();
        $helper = new HelperForm();
        $helper->shopLinkType = '';
        $helper->submit_action = '';
        $helper->simple_header = false;
        $helper->show_toolbar = false;
        $helper->currentIndex = AdminController::$currentIndex.'&configure=';
        $helper->currentIndex .= $this->name.'&token='.Tools::getAdminTokenLite('AdminModules');
        $this->fields_form[0]['form'] = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Configuración Formulario Web Crédito Online'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Tasa de interes:'),
                    'name' => $this->name.'_tasa',
                    'desc' => $this->l("Ingrese la tasa de interes ejemplo 1.98 evite el signo porcentual.")
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Cuotas:'),
					'desc' => $this->l("Ingrese en forma ascendente las cuotas permitidas separadas por comas (,) ejemplo 6,12,18,24... no es necesario espacio entre estas."),
                    'name' => $this->name.'_cuotas',
                ),
				array(
                    'type' => 'text',
                    'label' => $this->l('Cuotas por defecto:'),
					'desc' => $this->l("Ingrese el numero de cuotas por defecto, esta será usado para calcular el valor de cuota en la página del producto, deje en blanco para desactivar la funcionalidad"),
                    'name' => $this->name.'_cuotasdefault',
                ),
				array(
                    'type' => 'text',
                    'label' => $this->l('Tipo vivienda:'),
					'desc' => $this->l("Ingrese los valores permitidos separados por (,). no es necesario espacio entre estos"),
                    'name' => $this->name.'_tipo_vivienda',
                ),
				array(
                    'type' => 'text',
                    'label' => $this->l('Estrato:'),
					'desc' => $this->l("Ingrese los valores permitidos separados por (,). no es necesario espacio entre estos"),
                    'name' => $this->name.'_estrato',
                ),
				array(
                    'type' => 'text',
                    'label' => $this->l('Tipo de contrato:'),
					'desc' => $this->l("Ingrese los valores permitidos separados por (,). no es necesario espacio entre estos"),
                    'name' => $this->name.'_tipo_contrato',
                ),
				array(
					'type' => 'textarea',
                    'label' => $this->l('Mensaje de exito'),
                    'name' => $this->name.'_message',
                    'autoload_rte' => true,
                    'lang' => false,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}'
				),
				array(
					'type' => 'textarea',
                    'label' => $this->l('Terminos legales'),
                    'name' => $this->name.'_term',
                    'autoload_rte' => true,
                    'lang' => false,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}',
					'desc' => $this->l("Al ingresar este campo activará el campo de terminos legales en el formulario de solicitud de credito"),
				),
            ),
			'buttons' =>
                array(
                    array(
						'type' => 'submit',
                        'name' => $this->name.'_saveConfig',
                        'class' => 'btn btn-default pull-right',
                        'title' => $this->l('Guardar configuración'),
                        'icon'    => 'process-icon-save',
                    ),
                )
        );

        $helper->fields_value[$this->name.'_tasa'] = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_tasa'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
        $helper->fields_value[$this->name.'_cuotas'] = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_cuotas'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$helper->fields_value[$this->name.'_cuotasdefault'] = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_cuotasdefault'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$helper->fields_value[$this->name.'_tipo_vivienda'] = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_tipo_vivienda'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$helper->fields_value[$this->name.'_estrato'] = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_estrato'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$helper->fields_value[$this->name.'_tipo_contrato'] = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_tipo_contrato'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$helper->fields_value[$this->name.'_message'] = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_message'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		$helper->fields_value[$this->name.'_term'] = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_term'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		
        if (count($this->_error) > 0) {
            $errors = implode('', $this->_error);
        }
        return $this->_success.$errors.$helper->generateForm($this->fields_form);
    }
	
    public function install()
    {
		$sql = '
				CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'simfun` (
				`id_simfun` int(11) NOT NULL AUTO_INCREMENT,
				`id_shop` int(11) NOT NULL,
				`nombre` varchar(150) NOT NULL,
				`identificacion` varchar(30) NOT NULL,
				`telefono` varchar(30) NOT NULL,
				`celular` varchar(30) NOT NULL,
				`direccion` tinytext NOT NULL,
				`departamento` varchar(50) NOT NULL,
				`ciudad` varchar(50) NOT NULL,
				`barrio` varchar(50) NOT NULL,
				`email` varchar(100) NOT NULL,
				`vivienda` varchar(50) NOT NULL,
				`personas_cargo` int(2) NOT NULL,
				`hijos` int(2) NOT NULL,
				`estrato` int(1) NOT NULL,
				`empresa` varchar(100) NOT NULL,
				`direccion_empresa` tinytext NOT NULL,
				`cargo` varchar(100) NOT NULL,
				`eps` varchar(50) NOT NULL,
				`fondo` varchar(50) NOT NULL,
				`actividad` varchar(100) NOT NULL,
				`contrato` varchar(100) NOT NULL,
				`fecha_vinculacion` date NOT NULL,
				`ingresos` int(11) NOT NULL,
				`egresos` int(11) NOT NULL,
				`placa_vehiculo` varchar(10) NOT NULL,
				`telefono_empresa` varchar(30) NOT NULL,
				`conyuge_nombre` varchar(100) NOT NULL,
				`conyuge_identificacion` varchar(30) NOT NULL,
				`conyuge_actividad` varchar(100) NOT NULL,
				`conyuge_ingresos` int(11) NOT NULL,
				`conyuge_telefono` varchar(30) NOT NULL,
				`referencia_familiar_nombre` varchar(100) NOT NULL,
				`referencia_familiar_telefono` varchar(30) NOT NULL,
				`referencia_familiar_celular` varchar(30) NOT NULL,
				`referencia_personal_nombre` varchar(100) NOT NULL,
				`referencia_personal_telefono` varchar(30) NOT NULL,
				`referencia_personal_celular` varchar(30) NOT NULL,
				`value` decimal(20,6) NOT NULL,
				`quota` int(11) NOT NULL,
				`tasa` decimal(20,6) NOT NULL,
				`cuota` decimal(20,6) NOT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id_simfun`),
				KEY `id_shop` (`id_shop`)
				) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;		
		';    
        if (!parent::install() ||
		 	!$this->registerHook('displayBackOfficeHeader') ||
			!$this->registerHook('moduleRoutes') ||
			!$this->registerHook('displayProductPriceBlock') ||
			!$this->registerHook('header') ||
			!Db::getInstance()->Execute($sql)
        ) {
            return false;
        }
        return true;
    }
    public function uninstall()
    {
		$sql = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'simfun`;';
        if (!parent::uninstall() 
			|| !Db::getInstance()->Execute($sql)
			|| !Configuration::deleteByName('PS_CONFIGURATION_'.mb_strtoupper($this->name.'_cuotas'))
            || !Configuration::deleteByName('PS_CONFIGURATION_'.mb_strtoupper($this->name.'_tasa'))) {
            return false;
        }
        return true;
    }
    private function uninstallTabs($class_name)
    {
        try {
            $id_tab = (int)Tab::getIdFromClassName($class_name);
            if ($id_tab) {
                $tab = new Tab($id_tab);
                $tab->delete();
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    private function installTabs($class_name,$name,$parent = 3,$page = null,$title = null,$description = null,$url_rewrite = null) {
        try {
			$tab = new Tab();
			$tab->active = 1;
			$tab->class_name = $class_name;
			$tab->name = array();
			foreach (Language::getLanguages(true) as $lang)
				$tab->name[$lang['id_lang']] = $name;
			$tab->id_parent = $parent;//if exists
			$tab->position = 0;
			$tab->module = $this->name;
			$tab->add();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
	
	public function hookHeader() {
		$this->context->controller->registerStylesheet(
				'modules-simfuncss',
				'modules/'.$this->name.'/views/css/simfun.css'
		);
		$this->context->controller->registerJavascript(
				'modules-simfunjs',
				'modules/'.$this->name.'/views/js/simfun.js'
		);
		$this->context->controller->addJqueryPlugin(array('fancybox'));	
	}
	
	public function hookDisplayProductPriceBlock($params) {
		$nrocuotas = Configuration::get(
            'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_cuotasdefault'),
            null,
            Shop::getContextShopGroupID(true),
            Shop::getContextShopID(true)
        );
		if($params['type'] == 'price' && $params['product']['regular_price_amount'] && $nrocuotas) {
			require_once ('classes/Simfun.php');
			$simfun = new SimfunCore;
			
			$cuotas = explode(',',Configuration::get(
				'PS_CONFIGURATION_'.mb_strtoupper($this->name.'_cuotas'),
				null,
				Shop::getContextShopGroupID(true),
				Shop::getContextShopID(true)
			));
			$simulate = array();
			foreach($cuotas as $cuota) {
				$sumulate[$cuota] = $simfun->getQuota($params['product']['regular_price_amount'],$cuota);
				$sumulate[$cuota]['value'] =Tools::jsonEncode($sumulate[$cuota]);
				$sumulate[$cuota]['valuenoparse'] =Tools::jsonEncode($simfun->getQuota($params['product']['regular_price_amount'],$cuota,true));
				$sumulate[$cuota]['selected'] = false;
				if($cuota == $nrocuotas) {
					$sumulate[$cuota]['selected'] =true;
					$selected = $sumulate[$cuota]['valuenoparse'];
				}
			}
			$calcule = $simfun->getQuota($params['product']['regular_price_amount'],$nrocuotas); 
			$this->context->smarty->assign(array(
				'type' => $params['type'],
				'quota' => $calcule['quote'],
				'quotas' => $nrocuotas,
				'simulate' => $sumulate,
				'link' => $this->context->link->getModuleLink($this->name,'simulador'),
				'selected' => $selected,
			));
			return $this->display(__FILE__, 'hookDisplayProductPriceBlock.tpl');
		}
	}

	public function hookModuleRoutes() {
		return array(
			'module-'.$this->name.'-simulador' => array( 
				'controller' => 'simulador', 
				'rule' => 'simulador-credito', 
				'keywords' => array(),
				'params' => array(
					'fc' => 'module',
					'module' => $this->name, 
				)
			),
		);
	}	
	
    public function hookDisplayBackOfficeHeader() {
		 $this->context->controller->addCSS($this->_path.'views/css/simfun.css');
    }
}
