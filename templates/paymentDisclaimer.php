<div class="container">
    <div id="payment-disclaimer-modal">
        <div class="container">
            <h2>Disclaimer</h2>
            <p>Cliccando su “Accetta” ti impegni ad effettuare quanto riportato nelle istruzioni finali secondo le modalità mostrate, corrispondendo l'intero importo indifferentemente dal metodo di pagamento.</p>
            <form id="paymentDisclaimerForm" name="paymentDisclaimerForm" ng-submit="paymentDisclaimer.submit()" novalidate>
                <input id="payment-disclaimer-submit" type="submit" value="Accetta" />
                <input id="payment-disclaimer-cancel" ng-click="$dismiss()" value="Annulla" readonly/>
            </form>
        </div>
    </div>
</div>