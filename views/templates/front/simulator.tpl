{capture name=path}{l s='Simulador de crédito' mod='simfun'}{/capture}

<div id="message"></div>
<div id="step1" class="col-md-12 simfun">
  <div class="row">
    <h1>Simulador de crédito</h1>
    <p>Ingresa el valor de la compra que deseas realizar y el plazo a cual deseas diferirla</p>
    <form data-action="{$action}" method="post" id="formsimulate" enctype="multipart/form-data">
      <p class="form-group">
        <label for="value">{l s='Valor de la compra' mod='simfun'}</label>
        <input class="form-control" maxlength="20" id="value" value="{$value}" name="value" placeholder="{l s='Valor a financiar' mod='simfun'}">
      </p>
      <p class="form-group">
        <label for="quotes">{l s='Número de cuotas' mod='simfun'}</label>
        <select name="quotes" id="quota" class="form-control">
          <option>{l s='Seleccione el número de cuotas' mod='simfun'}</option>
            {foreach from=$quotes item=quote}
                {if $quote == $quotaselected}
          		<option selected="selected" value="{$quote}">{$quote}</option>
                {else}
         	 	<option value="{$quote}">{$quote}</option>
                {/if}
            {/foreach}
        </select>
      </p>
      <div class="submit">
        <button type="submit" id="calculate" name="calculate" class="button btn btn-default button-medium"><span>{l s='Calcular' mod='simfun'}<i class="icon-chevron-right right"></i></span></button>
      </div>
    </form>
  </div>
  <div id="step2" class="row">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <th scope="col">{l s='Valor Crédito' mod='simfun'}</th>
        <th scope="col">{l s='Número de Cuotas' mod='simfun'}</th>
        <th scope="col">{l s='Valor Cuota' mod='simfun'}</th>
      </tr>
      <tr>
        <td id="capital"></td>
        <td id="quotes"></td>
        <td id="quote"></td>
      </tr>
    </table>
    <button type="button" id="request" name="request" class="button btn btn-default button-medium">
    <span>{l s='Solicitar Crédito' mod='simfun'}<i class="icon-chevron-right right"></i></span>
    </button>
  </div>
</div>
<div id="step3" class="row">

<form action="" method="post" name="get" id="get" enctype="multipart/form-data">
  <h2>{l s='Información Personal:'}</h2>
  <div class="form-group col-md-12">
    <label for="nombre" class="required">{l s='Nombres y apellidos' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="nombre" name="nombre" placeholder="{l s='Ingrese su nombre completo' mod='simfun'}">
  </div>
  <div class="form-group col-md-4">
    <label for="identificacion" class="required">{l s='CC/Nit' mod='simfun'}</label>
    <input class="form-control" maxlength="15" id="identificacion" name="identificacion">
  </div>
  <div class="form-group col-md-4">
    <label for="telefono" class="required">{l s='Teléfono fijo' mod='simfun'}</label>
    <input class="form-control" maxlength="15" id="telefono" name="telefono">
  </div>
  <div class="form-group col-md-4">
    <label for="celular" class="required">{l s='Celular' mod='simfun'}</label>
    <input class="form-control" maxlength="15" id="celular" name="celular">
  </div>
  <div class="form-group col-md-12">
    <label for="direccion" class="required">{l s='Direccion' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="direccion" name="direccion">
  </div>
  <div class="form-group col-md-4">
    <label for="departamento" class="required">{l s='Departamento' mod='simfun'}</label>
    <input class="form-control" maxlength="50" id="departamento" name="departamento">
  </div>
  <div class="form-group col-md-4">
    <label for="ciudad" class="required">{l s='Ciudad' mod='simfun'}</label>
    <input class="form-control" maxlength="50" id="ciudad" name="ciudad">
  </div>
  <div class="form-group col-md-4">
    <label for="barrio" class="required">{l s='Barrio' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="barrio" name="barrio">
  </div>
  <div class="form-group col-md-6">
    <label for="email" class="required">{l s='Email' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="email" name="email">
  </div>
  <div class="form-group col-md-6">
    <label for="vivienda" class="required">{l s='Tipo de vivienda' mod='simfun'}</label>
    <select class="form-control" id="vivienda" name="vivienda">
      
          {foreach from=$tipo_vivienda item=tipo}
         	
      <option value="{$tipo}">{$tipo}</option>
      
          {/foreach}
        
    </select>
  </div>
  <div class="form-group col-md-4">
    <label for="personas_cargo" class="required">{l s='Personas a cargo' mod='simfun'}</label>
    <input class="form-control" maxlength="2" id="personas_cargo" name="personas_cargo">
  </div>
  <div class="form-group col-md-4">
    <label for="hijos" class="required">{l s='Número de hijos' mod='simfun'}</label>
    <input class="form-control" maxlength="2" id="hijos" name="hijos">
  </div>
  <div class="form-group col-md-4">
    <label for="estrato" class="required">{l s='Estrato' mod='simfun'}</label>
    <select class="form-control" id="estrato" name="estrato">
      <option>-</option>
      
          {foreach from=$estrato item=est}
         	
      <option value="{$est}">{$est}</option>
      
          {/foreach}
        
    </select>
  </div>
  <div class="form-group col-md-4">
    <label for="empresa" class="required">{l s='Empresa' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="empresa" name="empresa">
  </div>
  <div class="form-group col-md-4">
    <label for="direccion_empresa" class="required">{l s='Dirección de la empresa' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="direccion_empresa" name="direccion_empresa">
  </div>
  <div class="form-group col-md-4">
    <label for="telefono_empresa" class="required">{l s='Teléfono de la empresa' mod='simfun'}</label>
    <input class="form-control" maxlength="15" id="telefono_empresa" name="telefono_empresa">
  </div>
  <div class="form-group col-md-6">
    <label for="cargo" class="required">{l s='Cargo' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="cargo" name="cargo">
  </div>
  <div class="form-group col-md-6">
    <label for="contrato" class="required">{l s='Contrato' mod='simfun'}</label>
    <select class="form-control" id="contrato" name="contrato">
      
          {foreach from=$tipo_contrato item=contrato}
         	
      <option value="{$contrato}">{$contrato}</option>
      
          {/foreach}
        
    </select>
  </div>  
  <div class="form-group col-md-4">
    <label for="eps">{l s='EPS' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="eps" name="eps">
  </div>
  <div class="form-group col-md-4">
    <label for="fondo">{l s='Fondo de pensión' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="fondo" name="fondo">
  </div>
  <div class="form-group col-md-4">
    <label for="actividad">{l s='Actividad económica' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="actividad" name="actividad">
  </div>
  <div class="form-group col-md-3">
    <label for="fecha_vinculacion" class="required">{l s='Fecha de vinculación' mod='simfun'}</label>
    <input class="form-control" maxlength="10" id="fecha_vinculacion" name="fecha_vinculacion">
  </div>
  <div class="form-group col-md-3">
    <label for="ingresos" class="required">{l s='Ingresos' mod='simfun'}</label>
    <input class="form-control" maxlength="15" id="ingresos" name="ingresos">
  </div>
  <div class="form-group col-md-3">
    <label for="egresos" class="required">{l s='Egresos' mod='simfun'}</label>
    <input class="form-control" maxlength="15" id="egresos" name="egresos">
  </div>
  <div class="form-group col-md-3">
    <label for="placa_vehiculo">{l s='Placa del vehiculo' mod='simfun'}</label>
    <input class="form-control" maxlength="10" id="placa_vehiculo" name="placa_vehiculo">
  </div>
  <h2>{l s='Información del conyuge:'}</h2>
  <div class="form-group col-md-6">
    <label for="conyuge_nombre">{l s='Nombres y apellidos' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="conyuge_nombre" name="conyuge_nombre" placeholder="{l s='Ingrese el nombre de su conyuge completo' mod='simfun'}">
  </div>
  <div class="form-group col-md-6">
    <label for="conyuge_identificacion">{l s='Cedula número' mod='simfun'}</label>
    <input class="form-control" maxlength="15" id="conyuge_identificacion" name="conyuge_identificacion" placeholder="{l s='Ingrese el teléfono de su conyuge' mod='simfun'}">
  </div>
  <div class="form-group col-md-4">
    <label for="conyuge_actividad">{l s='Actividad económica' mod='simfun'}</label>
    <input class="form-control" maxlength="100" id="conyuge_actividad" name="conyuge_actividad" placeholder="{l s='Ingrese la actividad económica de su conyuge' mod='simfun'}">
  </div>
  <div class="form-group col-md-4">
    <label for="conyuge_ingresos">{l s='Ingresos' mod='simfun'}</label>
    <input class="form-control" maxlength="10" id="conyuge_ingresos" name="conyuge_ingresos" placeholder="{l s='Ingrese los ingresos de su conyuge' mod='simfun'}">
  </div>
  <div class="form-group col-md-4">
    <label for="conyuge_telefono">{l s='Teléfono' mod='simfun'}</label>
    <input class="form-control" maxlength="15" id="conyuge_telefono" name="conyuge_telefono" placeholder="{l s='Ingrese el teléfono de su conyuge' mod='simfun'}">
  </div>
  <h2>{l s='Referencias:'}</h2>
  <div class="form-group col-md-6">
    <label for="referencia_familiar_nombre" maxlength="100" class="required">{l s='Referencia familiar' mod='simfun'}</label>
    <input class="form-control" id="referencia_familiar_nombre" name="referencia_familiar_nombre" placeholder="{l s='Ingrese su nombre de su referencia familiar' mod='simfun'}">
  </div>
  <div class="form-group col-md-6">
    <label for="referencia_personal_nombre" maxlength="100" class="required">{l s='Referencia Personal' mod='simfun'}</label>
    <input class="form-control" id="referencia_personal_nombre" name="referencia_personal_nombre" placeholder="{l s='Ingrese su nombre de su referencia personal' mod='simfun'}">
  </div>
  <div class="form-group col-md-6">
    <label for="referencia_familiar_telefono" maxlength="15" class="required">{l s='Télefono' mod='simfun'}</label>
    <input class="form-control" id="referencia_familiar_telefono" name="referencia_familiar_telefono" placeholder="{l s='Ingrese el teléfono de su referencia familiar' mod='simfun'}">
  </div>
  <div class="form-group col-md-6">

    <label for="referencia_personal_telefono" maxlength="15" class="required">{l s='Teléfono' mod='simfun'}</label>
    <input class="form-control" id="referencia_personal_telefono" name="referencia_personal_telefono" placeholder="{l s='Ingrese el teléfono de su referencia personal' mod='simfun'}">
  </div>
  <div class="form-group col-md-6">
    <label for="referencia_familiar_celular" maxlength="15" class="required">{l s='Celular' mod='simfun'}</label>
    <input class="form-control" id="referencia_familiar_celular" name="referencia_familiar_celular" placeholder="{l s='Ingrese el celular de su referencia familiar' mod='simfun'}">
  </div>
  <div class="form-group col-md-6">
    <label for="referencia_personal_celular" maxlength="15" class="required">{l s='Celular' mod='simfun'}</label>
    <input class="form-control" id="referencia_personal_celular" name="referencia_personal_celular" placeholder="{l s='Ingrese el celular de su referencia personal' mod='simfun'}">
  </div>
  {if $terminos}
  <div class="form-group col-md-12">
  	<div class="terminos"><input name="terminos" id="terminos" class="form-control" type="checkbox" value="1" style="float:left" /></div>{$terminos}
  </div>
  {/if}
  <div class="form-group col-md-12">
    <button type="button" id="register" name="register" class="button btn btn-default button-medium"> <span>{l s='Solicitar Crédito' mod='simfun'}<i class="icon-chevron-right right"></i></span> </button>
  </div>
</form>
</div>
