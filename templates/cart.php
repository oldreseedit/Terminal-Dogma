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
		                	<table class="table table-striped text-center">
								<tr ng-repeat="item in cart.getCoursesToPay()">
									<td align="left">
										<span ng-bind="item.courseID"></span>
										<span class="cart-item-price"><span ng-bind="item.price"></span> €</span>
									</td>
								</tr>
							</table>
							
							<div class="cart-total">
								<strong>Totale: </strong>
								<strong><span ng-bind="cart.getTotalPrice()"></span> €</strong>
							</div>
							
							<div>
								<button class="btn btn-success pay-button" ng-class="{disabled: cart.getTotalPrice() <= 0}" ng-click="cart.pay()">Paga</button>
							</div>
	       				</div>
	                </div>
				</div>
			</div>
        </div>
</div>

</div>