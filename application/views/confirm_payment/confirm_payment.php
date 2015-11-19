<div class="in-main" ng-controller="paymentConfirmationController as confirmation">
    <div class="container">
        <h3 ng-bind="confirmation.message"></h3>
        <h5 ng-bind="confirmation.secondMessage"></h5>
        <p ng-if="!confirmation.paymentConfirmed && confirmation.username">Se invece ritieni che ci sia stato un errore, contattaci immediatamente su Facebook o a <a href="mailto:info@reseed.it">info@reseed.it</a></p>
    </div>
</div>