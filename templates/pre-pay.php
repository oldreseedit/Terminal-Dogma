<div id="cart">

<div class="container">
        <div class="no-gridster-item bg-light-grey">
        	<div spinner="cart.paypalAjax">
	        	<while-spinning>
	        		<div style="z-index: 1000; display: table; position:fixed; left:5vw; top:5vh; overflow: visible; background-color: white; border: 10px solid; width:90vw; height:90vh;">
		        		<div style="text-align: center; display: table-cell; vertical-align: middle;">
				    		<h1>Abbiamo inoltrato la richiesta di pagamento<span ng-if="cart.getCart().options.paymentMediaChosen === 'creditCard'"> a Paypal</span>...</h1>
				    		<h2 ng-if="cart.getCart().options.paymentMediaChosen === 'creditCard'">Verrai redirezionato alla pagina di pagamento dedicata di Paypal.</h2>
				    		<h2 ng-if="cart.getCart().options.paymentMediaChosen !== 'creditCard'">Stiamo effettuando dei controlli...</h2>
				    		<spinner-place class="fa-5x"></spinner-place>
				    	</div>
				    </div>
		    	</while-spinning>
        	</div>
        
        	<div class="container">
            	<div class="panel-title bg-lawn">
                	<h4>Rivedi il tuo pagamento</h4>
				</div>
                <div class="scrollbar-wrapper">
	        		<div class="panel-content">
	                	<div class="container">
	                		<div ng-if="cart.getCart().items.length == 0">Non ci sono corsi nel tuo carrello.</div>
		                	
		                	<div ng-if="cart.getCart().items.length > 0">
			                	<table class="table table-striped text-center">
									<tr ng-repeat="item in cart.getCart().items">
										<td align="left">
											<div>
											<strong>Corso</strong>: <span ng-bind="item.courseName"></span>
											</div>
											<div ng-if="item.payCourse">
												<span class="cart-subitem">Corso</span>
												<span class="cart-item-price"><span ng-bind="item.price"></span> €</span>
											</div>
											<div ng-if="item.paySimulation">
												<span class="cart-subitem">Simulazione</span>
												<span class="cart-item-price"><span ng-bind="item.simulationPrice"></span> €</span>
											</div>
										</td>
									</tr>
								</table>
	
								<div class="choice-text" ng-if="cart.getCart().options.seedOnChosen != null">
									<strong>Seedon: </strong>
									<span ng-repeat="seedon in cart.paymentOptions.seedon" ng-bind="seedon.longDescription" ng-if="seedon.seedonID === cart.getCart().options.seedOnChosen"></span>
								</div>
								
								<div class="choice-text">
									<strong>Modalità di pagamento: </strong>
									<span ng-repeat="option in cart.paymentOptions.paymentMediaOptions" ng-bind="option.label" ng-if="option.value === cart.getCart().options.paymentMediaChosen"></span>
								</div>
								
								<div class="choice-text">
									<strong>Rateizzazione: </strong>
									<span ng-repeat="option in cart.paymentOptions.paymentCycleOptions" ng-bind="option.label" ng-if="option.value === cart.getCart().options.paymentCycleChosen"></span>
								</div>
	
								<div title="Questo è il totale calcolato prima di applicare qualunque tipo di sconto." class="cart-total" ng-class="{'price-cancelled': cart.getCart().options.discount > 0 || cart.getCart().options.seedonDiscount > 0}">
									<strong>Totale: </strong>
									<strong><span ng-bind="cart.getTotalPrice()"></span> €</strong>
								</div>
								
								<div title="Hai questo sconto a vita perché sei cliente di reSeed e hai contribuito alla sua crescita." class="cart-total strong leaf">
									<strong>Sconto lifetime ottenuto grazie al tuo livello: </strong>
									<strong><span ng-bind="{{100*cart.getCart().options.discount}}"></span> % ({{cart.getTotalPrice()*cart.getCart().options.discount}} €)</strong>
								</div>
								
								<div title="Attento: questo sconto può essere usato solo una volta." class="cart-total strong leaf" ng-if="cart.getCart().options.seedonDiscount">
									<strong>Sconto applicato in base al seedon scelto: </strong>
									<strong><span ng-bind="{{100*cart.getCart().options.seedonDiscount}}"></span> % ({{cart.getTotalPrice()*cart.getCart().options.seedonDiscount}} €)</strong>
								</div>
								
								<div title="Questo è il totale vero, calcolato dopo l'applicazione dei vari sconti." class="cart-total cart-grand-total">
									<strong>Totale: </strong>
									<strong><span ng-bind="cart.getFinalPrice()"></span> €</strong>
									<span ng-if="cart.getCart().options.paymentCycleChosen === 'monthly'">/mese, per 3 mesi</span>
								</div>
								
								<div class="cart-buttons">
									<a href="/cart"><button class="btn btn-danger empty-button">Torna al carrello</button></a>
									<button class="btn btn-success pay-button" ng-click="cart.pay()">Paga</button>
								</div>
							</div>
							
	       				</div>
	                </div>
				</div>
			</div>
        </div>
</div>

</div>