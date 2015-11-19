<div id="faqPage" ng-controller="faqController as faq">
    <div class="container">
        <div class="faqStep text-center">
            <div class="container">
                <div class="faqIntroduction">FAQ</div>
                <div class="stepContent">
                    <div class="container">
                        <span>Tutto ciò che avete sempre desiderato sapere ma non avete mai avuto il coraggio di chiedere!</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="faqStep" ng-repeat="faqItem in faq.faqList" ng-init="index=$index">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                        <div class="stepIcon fa-stack fa-3x">
                            <span class="fa-stack-2x fa fa-question-circle" ng-class="faq.getColours(index)"></span>
                        </div>
                        <span class="middler"></span><span class="stepTitle middle" ng-bind="faqItem.question"></span>
                    </div>
                </div>
                <div class="stepContent">
                    <div class="container">
                        <span ng-bind="faqItem.answer"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>