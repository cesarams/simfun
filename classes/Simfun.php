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

class SimfunCore extends ObjectModel
{
	public $id;
	public $id_shop;
	public $nombre;
	public $identificacion;
	public $telefono;
	public $celular;
	public $direccion;
	public $departamento;
	public $ciudad;
	public $barrio;
	public $email;
	public $vivienda;
	public $personas_cargo;
	public $hijos;
	public $estrato;
	public $empresa;
	public $direccion_empresa;
	public $cargo;
	public $eps;
	public $fondo;
	public $actividad;
	public $contrato;
	public $fecha_vinculacion;
	public $ingresos;
	public $egresos;
	public $placa_vehiculo;
	public $telefono_empresa;
	public $conyuge_nombre;
	public $conyuge_identificacion;
	public $conyuge_actividad;
	public $conyuge_ingresos;
	public $conyuge_telefono;
	public $referencia_familiar_nombre;
	public $referencia_familiar_telefono;
	public $referencia_familiar_celular;
	public $referencia_personal_nombre;
	public $referencia_personal_telefono;
	public $referencia_personal_celular;
	public $value;
	public $quota;
	public $tasa;
	public $cuota;
	public $date;
	

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'simfun',
		'primary' => 'id',
		'multilang' => false,
		'multilang_shop' => false,
		'fields' => array(
			'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'nombre' => array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true),
			'identificacion' => array('type' => self::TYPE_STRING, 'required' => true),
			'telefono' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true),
			'celular' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true),
			'direccion' => array('type' => self::TYPE_STRING, 'validate' => 'isAddress', 'required' => true),
			'departamento' => array('type' => self::TYPE_STRING, 'validate' => 'isCityName', 'required' => true),
			'ciudad' => array('type' => self::TYPE_STRING, 'validate' => 'isCityName', 'required' => true),
			'barrio' => array('type' => self::TYPE_STRING, 'validate' => 'isCityName', 'required' => true),
			'email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true),
			'vivienda' => array('type' => self::TYPE_STRING, 'required' => true),
			'personas_cargo' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'hijos' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'estrato' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'empresa' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'direccion_empresa' => array('type' => self::TYPE_STRING, 'validate' => 'isAddress', 'required' => true),
			'cargo' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'eps' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
			'fondo' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
			'actividad' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
			'contrato' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'fecha_vinculacion' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
			'ingresos' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'egresos' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'placa_vehiculo' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
			'telefono_empresa' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true),
			'conyuge_nombre' => array('type' => self::TYPE_STRING, 'validate' => 'isName'),
			'conyuge_identificacion' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
			'conyuge_actividad' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
			'conyuge_ingresos' => array('type' => self::TYPE_STRING, 'validate' => 'isInt'),
			'conyuge_telefono' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber'),
			'referencia_familiar_nombre' => array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true),
			'referencia_familiar_telefono' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true),
			'referencia_familiar_celular' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true),
			'referencia_personal_nombre' => array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true),
			'referencia_personal_telefono' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true),
			'referencia_personal_celular' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true),
			'value' => array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
			'quota' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'tasa' => array('type' => self::TYPE_FLOAT, 'validate' => 'isPercentage'),
			'cuota' => array('type' => self::TYPE_INT, 'validate' => 'isPrice'),
			'date' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
		)
	);
 	
	public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
	}
	
	public function add($autodate = true, $null_values = false)
    {
		return parent::add($autodate, $null_values);
	}
	
	public function getQuota($c = null,$m = null,$noformat = false) {
		$im = Configuration::get(
			'PS_CONFIGURATION_SIMFUN_TASA',
			null,
			Shop::getContextShopGroupID(true),
			Shop::getContextShopID(true)
		);
		$ca = Configuration::get(
			'PS_CONFIGURATION_SIMFUN_CARGO_ADICIONAL',
			null,
			Shop::getContextShopGroupID(true),
			Shop::getContextShopID(true)
		);
		
		if(!$c || !$m || !$im)
			return;
		
		return array(
			'capital' => $noformat ? $c : Tools::displayPrice($c),
			'quotes' => $m,
			'quote'	=> ($noformat ? round((($im / 100) * $c) / (1 - pow(($im / 100) + 1,-$m))+$ca) : Tools::displayPrice(round((($im / 100) * $c) / (1 - pow(($im / 100) + 1,-$m))+$ca)))
		);
	}
}
