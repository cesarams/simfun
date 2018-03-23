<div class="hookDisplayProductPriceBlock"> <a href="#" id="product-simulate">{l s='Simula tu crédito' d='Modules.simfun'}</a>
  <p> {$quotas} cuotas de {$quota} </p>
  <div class="simfun-modal">
    <div class="simfun-modal-content">
      <h3>{l s='Simulador de crédito' d='Modules.simfun'}</h3>
      <p>{l s='Quiero pagar en' d='Modules.simfun'}</p>
      <select id="simfun-modal-cuotes">
      {foreach from=$simulate item=quotes}
        <option {if $quotes.selected} selected {/if} value="{$quotes.value}" data-value="{$quotes.valuenoparse}">{$quotes.quotes} {l s='Cuotas' d='Modules.simfun'}</option>
      {/foreach}
      </select>
      <div id="simfun-quota">
        <p>{l s='De' d='Modules.simfun'}</p>
        <price>{$quota}</price> </div>
      <div class="submit text-sm-center">
        <button type="submit" id="gotosimulator" data-link="{$link}" data-value="{$selected}" name="calculate" class="button btn btn-primary button-medium"><span>{l s='Solicitar crédito' d='Modules.simfun'}<i class="icon-chevron-right right"></i></span></button>
      </div>
    </div>
  </div>
</div>
