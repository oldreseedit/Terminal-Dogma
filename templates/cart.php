<div id="cart">

<div class="container">
        <div class="no-gridster-item bg-light-grey">
        	<div class="container">
            	<div class="panel-title bg-lawn">
                	<h4>I corsi da te inseriti nel carrello</h4>
				</div>
                <div class="scrollbar-wrapper">
	        		<div class="panel-content">
	                	<div class="container">
	                		<div ng-if="cart.getCoursesToPay().length == 0">Non ci sono corsi nel tuo carrello.</div>
		                	
		                	<div ng-if="cart.getCoursesToPay().length > 0">
			                	<table class="table table-striped text-center">
									<tr ng-repeat="item in cart.getCoursesToPay()">
										<td align="left">
											<div>
											<strong>Corso</strong>: <span ng-bind="item.courseName"></span>
											<span class="cart-item-price"><span ng-bind="item.price"></span> €</span>
											</div>
											<div ng-if="item.simulation">
												<input type="checkbox" ng-checked="item.paySimulation" ng-click="cart.toggleSimulation(item)">
												<span class="cart-subitem">Simulazione</span>
												<span class="cart-item-price" ng-class="{'price-cancelled': !item.paySimulation}"><span ng-bind="item.simulationPrice"></span> €</span>
											</div>
											<div ng-if="!item.simulation">
												<span class="cart-subitem">Questo corso non prevede simulazione.</span>
											</div>
										</td>
										<td width="30px;">
											<span title="Rimuovi questo articolo dal carrello" class="fa fa-2x fa-times-circle text-danger clickable" ng-click="cart.remove(item)"></span>
										</td>
									</tr>
								</table>
	
								<div class="choice-text" ng-if="cart.paymentOptions.seedon.length > 1">
									<strong>Seedon: </strong>
									<select ng-model="cart.getCart().options.seedOnChosen" ng-click="cart.applySeedon(cart.getCart().options.seedOnChosen)">
										<option ng-repeat="seedon in cart.paymentOptions.seedon" value="{{seedon.seedonID}}" title="{{seedon.description}}">{{seedon.longDescription}}</option>
									</select>
								</div>
								
								<div class="choice-text">
									<strong>Modalità di pagamento: </strong>
									<select ng-model="cart.getCart().options.paymentMediaChosen" ng-click="cart.applyPaymentMedia()">
										<option ng-repeat="option in cart.paymentOptions.paymentMediaOptions" value="{{option.value}}" title="{{option.description}}">{{option.label}}</option>
									</select>
								</div>
								
								<div class="choice-text">
									<strong>Rateizzazione: </strong>
									<select ng-model="cart.getCart().options.paymentCycleChosen" ng-click="cart.applyPaymentCycle()">
										<option ng-repeat="option in cart.paymentOptions.paymentCycleOptions" value="{{option.value}}" title="{{option.description}}">{{option.label}}</option>
									</select>
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
									<button class="btn btn-danger empty-button" ng-class="{disabled: cart.getCoursesToPay() <= 0}" ng-click="cart.emptyCart()">Svuota il carrello</button>
									<button class="btn btn-success pay-button" ng-class="{disabled: cart.getCoursesToPay() <= 0 || cart.getCart().options.paymentCycleChosen == null || cart.getCart().options.paymentMediaChosen == null}" ng-click="cart.pay()">Paga</button>
								</div>
							</div>
							
	       				</div>
	                </div>
				</div>
			</div>
        </div>
</div>

</div>