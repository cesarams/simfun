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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AdminSimfunController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->className = 'Simfun';
        $this->lang    = false;
        $this->token = Tools::getAdminTokenLite('AdminSimfun');
        $this->context = Context::getContext();
        $this->table = 'simfun';
        $this->deleted = false;
        $this->explicitSelect = true;
        $this->_defaultOrderBy = 'date';
        $this->allow_export = true;
		$this->can_import	= false;
		
        $this->fields_list = array(
            'id_simfun' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'identificacion' => array(
                'title' => $this->l('Identificación'),
				'class' => 'fixed-width-xs'
            ),
            'nombre' => array(
                'title' => $this->l('Nombre'),
                'orderby' => false
            ),
            'telefono' => array(
                'title' => $this->l('Teléfono'),
                'align' => 'center',
				'class' => 'fixed-width-xs'
            ),
            'celular' => array(
                'title' => $this->l('Celular'),
                'class' => 'fixed-width-xs',
                'align' => 'center',
            ),
			'email' => array(
                'title' => $this->l('Email'),
                'class' => 'fixed-width-xs',
                'align' => 'center',
            ),
			'value' => array(
                'title' => $this->l('Valor a financiar'),
                'class' => 'fixed-width-xs',
				'type' => 'price',
                'align' => 'center',
            ),
			'quota' => array(
                'title' => $this->l('Cuotas'),
                'class' => 'fixed-width-xs',
                'align' => 'center',
            ),
			'cuota' => array(
                'title' => $this->l('Valor cuota'),
                'class' => 'fixed-width-xs',
				'type' => 'price',
                'align' => 'center',
            ),
			'date' => array(
                'title' => $this->l('-'),
                'align' => 'center',
            )
        );

        $this->bulk_actions = array();
        $this->specificConfirmDelete = false;
		$this->list_no_link = true;			
		
		parent::__construct();
    }
	
	protected function l($string, $class = null, $addslashes = false, $htmlentities = true)
    {
        if ( _PS_VERSION_ >= '1.7') {
            return Context::getContext()->getTranslator()->trans($string);
        } else {
            return parent::l($string, $class, $addslashes, $htmlentities);
        }
    }

    public function init()
    {
		if (Tools::isSubmit('exportsimfun')) {
			unset($this->fields_list);
			$this->fields_list['id_simfun'] = array ('title' => $this->l('ID'));
			$this->fields_list['nombre'] = array ('title' => $this->l('NOMBRES Y APELLIDOS'));
			$this->fields_list['identificacion'] = array ('title' => $this->l('CC/NIT'));
			$this->fields_list['telefono'] = array ('title' => $this->l('TELEFONO'));
			$this->fields_list['celular'] = array ('title' => $this->l('CELULAR'));
			$this->fields_list['direccion'] = array ('title' => $this->l('DIRECCION'));
			$this->fields_list['departamento'] = array ('title' => $this->l('DEPARTAMENTO'));
			$this->fields_list['ciudad'] = array ('title' => $this->l('CIUDAD'));
			$this->fields_list['barrio'] = array ('title' => $this->l('BARRIO'));
			$this->fields_list['email'] = array ('title' => $this->l('E-MAIL'));
			$this->fields_list['vivienda'] = array ('title' => $this->l('TIPO DE VIVIENDA'));
			$this->fields_list['personas_cargo'] = array ('title' => $this->l('PERSONAS A CARGO'));
			$this->fields_list['hijos'] = array ('title' => $this->l('NRO DE HIJOS'));
			$this->fields_list['estrato'] = array ('title' => $this->l('ESTRATO'));
			$this->fields_list['empresa'] = array ('title' => $this->l('EMPRESA:'));
			$this->fields_list['direccion_empresa'] = array ('title' => $this->l('DIRECCION'));
			$this->fields_list['cargo'] = array ('title' => $this->l('CARGO'));
			$this->fields_list['eps'] = array ('title' => $this->l('EPS'));
			$this->fields_list['fondo'] = array ('title' => $this->l('FONDO DE PENSION'));
			$this->fields_list['actividad'] = array ('title' => $this->l('ACTIVIDAD ECONOMICA'));
			$this->fields_list['contrato'] = array ('title' => $this->l('CONTRATO'));
			$this->fields_list['fecha_vinculacion'] = array ('title' => $this->l('FECHA DE VINCULACION'));
			$this->fields_list['ingresos'] = array ('title' => $this->l('INGRESOS'));
			$this->fields_list['egresos'] = array ('title' => $this->l('EGRESOS'));
			$this->fields_list['placa_vehiculo'] = array ('title' => $this->l('PLACA DEL VEHICULO'));
			$this->fields_list['telefono_empresa'] = array ('title' => $this->l('TELEFONO'));
			$this->fields_list['conyuge_nombre'] = array ('title' => $this->l('CONYUGE NOMBRES Y APELLIDOS'));
			$this->fields_list['conyuge_identificacion'] = array ('title' => $this->l('CONYUGE CEDULA NUMERO'));
			$this->fields_list['conyuge_actividad'] = array ('title' => $this->l('CONYUGE ACTIVIDAD ECONOMICA'));
			$this->fields_list['conyuge_ingresos'] = array ('title' => $this->l('CONYUGE INGRESOS'));
			$this->fields_list['conyuge_telefono'] = array ('title' => $this->l('CONYUGE TELEFONO'));
			$this->fields_list['referencia_familiar_nombre'] = array ('title' => $this->l('REFERENCIA FAMILIAR NOMBRE'));
			$this->fields_list['referencia_familiar_telefono'] = array ('title' => $this->l('REFERENCIA FAMILIAR TELEFONO'));
			$this->fields_list['referencia_familiar_celular'] = array ('title' => $this->l('REFERENCIA FAMILIAR CELULAR'));
			$this->fields_list['referencia_personal_nombre'] = array ('title' => $this->l('REFERENCIA PERSONAL NOMBRE'));
			$this->fields_list['referencia_personal_telefono'] = array ('title' => $this->l('REFERENCIA PERSONAL TELEFONO'));
			$this->fields_list['referencia_personal_celular'] = array ('title' => $this->l('REFERENCIA PERSONAL CELULAR'));
			$this->fields_list['value'] = array ('title' => $this->l('VALOR SOLICITADO'));
			$this->fields_list['quota'] = array ('title' => $this->l('NRO CUOTAS'));
			$this->fields_list['tasa'] = array ('title' => $this->l('TASA CALCULO'));
			$this->fields_list['cuota'] = array ('title' => $this->l('CUOTA CALCULADA'));
			$this->fields_list['date'] = array ('title' => $this->l('FECHA REGISTRO'));
		}
        parent::init();
    }

	public function initToolbar()
    {
        parent::initToolbar();
		unset($this->toolbar_btn['new']);
    }
	
	public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_product'] = array(
                    'href' => self::$currentIndex.'&exportsimfun&token='.$this->token,
                    'desc' => $this->l('Export', null, null, false),
                    'icon' => 'process-icon-export'
                );
        }
		parent::initPageHeaderToolbar();
	}
    public function initContent()
    {
        parent::initContent();
    }
	
    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS(_PS_MODULE_DIR_.$this->module->name.'/css/simfun.css');
    }
}
