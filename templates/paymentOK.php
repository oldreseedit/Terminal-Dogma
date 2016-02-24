<div id="faqPage">
    <div class="container">
        <div class="faqStep text-center">
            <div class="container">
            
                <div class="faqIntroduction">Risultato pagamento:</div>
                <div class="stepContent">
                    <div class="container">
						<h2>
							<span class="fa-stack fa-lg leaf">
							  <i class="fa fa-circle fa-stack-2x"></i>
							  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
							</span>
							Il pagamento è andato a buon fine
						</h2>
						<h2>Troverai i corsi a cui ti sei iscritto <a ng-href="/profile/{{username}}">nel tuo profilo</a>.</h2>
                    </div>
                </div>
                
                <p>Ti consigliamo di ricopiare o stampare i dettagli di seguito riportati per futuro riferimento.
                Potrebbero tornarti utili come promemoria o per comunicarci gli estremi della tua iscrizione.
                Conservali con cura.</p>
                <h3>Dettagli pagamento:</h3>
                
                <table class="table table-striped text-center">
                	<tr>
                		<td><strong>Codice transazione</strong></td>
						<td ng-bind="payment.paymentID"></td>
                	</tr>
                	<tr>
                		<td><strong>Importo</strong></td>
						<td ng-bind="payment.amount"></td>
                	</tr>
                	<tr>
                		<td><strong>Modalità di pagamento</strong></td>
						<td ng-bind="payment.paymentCycle"></td>
                	</tr>
                	<tr>
                		<td><strong>Pagamento effettuato con</strong></td>
						<td ng-bind="payment.paymentMedia"></td>
                	</tr>
                	<tr ng-if="payment.wireTransferCode">
                		<td><strong>IBAN</strong></td>
						<td ng-bind="payment.wireTransferCode"></td>
                	</tr>
                	<tr ng-if="payment.wireTransferCode">
                		<td><strong>Causale</strong></td>
						<td ng-bind="payment.reason"></td>
                	</tr>
                </table>
            </div>
        </div>
    </div>
</div>