<div id="payment" ng-controller="paymentController as payment" ng-init="payment.coursesPaid()">
    <div class="container">
        <div id="paymentFirstStep" class="paymentStep">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                        <div class="stepIcon fa-stack fa-3x">
                            <span class="fa-stack-2x fa fa-circle-thin"></span>
                            <span class="fa-stack-1x">1</span>
                        </div>
                        <span class="middler"></span><span class="stepTitle middle">Che corsi vuoi seguire?</span>
                    </div>
                </div>
                <div class="stepContent" ng-if="payment.ready">
                    <div class="container">
                        <div class="checkbox checkbox-success noselect">
                            <input type="checkbox" id="gameDesign" ng-model="payment.gameDesign" ng-click="payment.checkStep1()" ng-disabled="payment.alreadyPaid('gameDesign')"><label for="gameDesign">Game Design</label>
                        </div>
                        <div class="checkbox checkbox-success noselect">
                            <input type="checkbox" id="gameMaker" ng-model="payment.gameMaker" ng-click="payment.checkStep1()" ng-disabled="payment.alreadyPaid('gameMaker')"><label for="gameMaker">Game Maker</label>
                        </div>
                        <div class="checkbox checkbox-success noselect">
                            <input type="checkbox" id="3DStudioMax" ng-model="payment.studioMax" ng-click="payment.checkStep1()" ng-disabled="payment.alreadyPaid('studioMax')"><label for="3DStudioMax">3D Studio Max</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="paymentSecondStep" class="paymentStep" ng-if="payment.step1">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                        <div class="stepIcon fa-stack fa-3x">
                            <span class="fa-stack-2x fa fa-circle-thin"></span>
                            <span class="fa-stack-1x">2</span>
                        </div>
                        <span class="middler"></span><span class="stepTitle middle">Intendi pagare a rate o <i>one shot</i>?</span>
                    </div>
                </div>
                <div class="stepContent">
                    <div class="container">
                        <div class="radio">
                            <input type="radio" name="rateOptions" id="rate" value="rate" ng-model="payment.rate" ng-click="payment.checkStep2()"><label for="rate">A rate</label>
                        </div>
                        <div class="radio">
                            <input type="radio" name="rateOptions" id="oneShot" value="oneShot" ng-model="payment.rate" ng-click="payment.checkStep2()"><label for="oneShot">One Shot</label>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div id="paymentThirdStep" class="paymentStep" ng-if="payment.step2">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                        <div class="stepIcon fa-stack fa-3x">
                            <span class="fa-stack-2x fa fa-circle-thin"></span>
                            <span class="fa-stack-1x">3</span>
                        </div>
                        <span class="middler"></span><span class="stepTitle middle">Che metodo di pagamento preferisci?</span>
                    </div>
                </div>
                <div class="stepContent">
                    <div class="container">
                        <div class="radio">
                            <input type="radio" name="paymentOptions" id="contanti" value="contanti" ng-model="payment.paymentChoice" ng-click="payment.checkStep3()"><label for="contanti">Contanti</label>
                        </div>
                        <div class="radio">
                            <input type="radio" name="paymentOptions" id="bonifico" value="bonifico" ng-model="payment.paymentChoice" ng-click="payment.checkStep3()"><label for="bonifico">Bonifico bancario</label>
                        </div>
                        <div class="radio">
                            <input type="radio" name="paymentOptions" id="paypal" value="paypal" ng-model="payment.paymentChoice" ng-click="payment.checkStep3()"><label for="paypal">Paypal / Carta di credito</label>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div id="paymentFinalStep" class="paymentStep" ng-if="payment.step3">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                        <div class="stepIcon fa-stack fa-3x">
                            <span class="fa-stack-2x fa fa-circle-thin"></span>
                            <span class="fa-stack-1x fa fa-check"></span>
                        </div>
                        <span class="middler"></span><span class="stepTitle middle">Ecco le informazioni che cerchi!</span>
                    </div>
                </div>
                <div class="stepContent">
                    <div class="container">
                        <div ng-bind-html="payment.content"></div>
                        <div id="subscriptionButton" ng-if="payment.paymentChoice==='paypal'" ng-bind-html="payment.button" ng-click="payment.setPendingPayment()"></div>
                        <div id="subscriptionButton" ng-if="payment.paymentChoice!=='paypal'" ng-bind-html="payment.button" ng-click="payment.setPendingPayment(); payment.openDisclaimer()"></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>