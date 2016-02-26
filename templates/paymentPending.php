<div id="faqPage">
    <div class="container">
        <div class="faqStep text-center">
            <div class="container">
            
                <div class="faqIntroduction">Risultato pagamento:</div>
                <div class="stepContent">
                    <div class="container">
						<h3>
							<span class="fa-stack fa-lg light-olive">
							  <i class="fa fa-circle fa-stack-2x"></i>
							  <i class="fa fa-exclamation fa-stack-1x fa-inverse"></i>
							</span>
							<strong>Pending</strong>
						</h3>
						<p>
						Abbiamo registrato la tua richiesta di iscrizione.
						Per completare la tua iscrizione, completa la procedura come riportato di seguito.
						</p>
                    </div>
                </div>
                
                <div style="height: 20vh;"></div>
                
                <div class="faqIntroduction">Cosa fare per risultare iscritto:</div>
                <div>
                	<div ng-if="payment.paymentMedia === 'contanti'">
	                    
	                    <macro-list number="1" class="green"><span class="step-title">Partecipa alla prima lezione del corso e porta con te i contanti necessari (<span ng-bind="payment.amount"></span>€).</span></macro-list>
	                    <macro-list number="2" class="water"><span class="step-title">Una volta che il pagamento risulterà effettuato, penseremo noi a completare la tua registrazione.</span></macro-list>
	                    
                	</div>
                	<div ng-if="payment.paymentMedia === 'bonifico'">
	                	
	                	<div class="container">
	                        <div class="stepIcon fa-stack fa-3x green">
	                            <span class="fa-stack-2x fa fa-circle-thin"></span>
	                            <span class="fa-stack-1x">1</span>
	                        </div>
	                        <span class="stepTitle middle">Effettua un bonifico con l'importo necessario sul conto corrente con IBAN:</span>
	                        <h4 ng-bind="payment.wireTransferCode"></h4>
	                        <span class="stepTitle middle">con la seguente causale,</span>
	                		<h4 ng-bind="payment.reason"></h4>
	                		<span class="stepTitle middle">il seguente importo</span>
	                		<h4><span ng-bind="payment.amount"></span> €</h4>
	                		<span class="stepTitle middle">e il seguente intestatario</span>
	                		<h4 ng-bind="payment.holder"></h4>
	                    </div>
	                    
	                    <div class="container">
	                        <div class="stepIcon fa-stack fa-3x water">
	                            <span class="fa-stack-2x fa fa-circle-thin"></span>
	                            <span class="fa-stack-1x">2</span>
	                        </div>
	                        <span class="stepTitle middle">Una volta che il pagamento risulterà effettuato, penseremo noi a completare la tua registrazione.</span>
	                    </div>
                	</div>
                	<div ng-if="payment.paymentMedia === 'paypal'">
                		<div class="container">
	                        <div class="stepIcon fa-stack fa-3x green">
	                            <span class="fa-stack-2x fa fa-circle-thin"></span>
	                            <span class="fa-stack-1x">1</span>
	                        </div>
	                        <span class="stepTitle middle">Per qualche motivo Paypal ha ritardato il trasferimento del denaro sul nostro conto Paypal.
                		Aspetta qualche giorno.</span>
	                    </div>
                	
                		<div class="container">
	                        <div class="stepIcon fa-stack fa-3x water">
	                            <span class="fa-stack-2x fa fa-circle-thin"></span>
	                            <span class="fa-stack-1x">2</span>
	                        </div>
	                        <span class="stepTitle middle">Una volta che il pagamento risulterà effettuato, penseremo noi a completare la tua registrazione.</span>
	                    </div>
	                    
                	</div>
                </div>
                
                <p class="faq-advice">Ti consigliamo di ricopiare o stampare i dettagli di seguito riportati per futuro riferimento.
                Potrebbero tornarti utili come promemoria o per comunicarci gli estremi della tua iscrizione.
                Conservali con cura.</p>
                <p>Ti abbiamo anche mandato una mail con le stesse informazioni.</p>
                <h3>Dettagli pagamento:</h3>
                
                <table class="table table-striped text-center">
                	<tr>
                		<td><strong>Codice transazione</strong></td>
						<td ng-bind="payment.paymentID"></td>
                	</tr>
                	<tr>
                		<td><strong>Importo</strong></td>
						<td><span ng-bind="payment.amount"></span> €</td>
                	</tr>
                	<tr>
                		<td><strong>Modalità di pagamento</strong></td>
						<td ng-bind="payment.paymentCycle"></td>
                	</tr>
                	
                	<tr>
                		<td><strong>Pagamento da effettuarsi con</strong></td>
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
                	<tr ng-if="payment.wireTransferCode">
                		<td><strong>Intestatario</strong></td>
						<td ng-bind="payment.holder"></td>
                	</tr>
                </table>
            </div>
        </div>
    </div>
</div>