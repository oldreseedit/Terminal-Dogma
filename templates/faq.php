<div id="faqPage" ng-controller="faqController as faq">
    <div class="container">
        <div class="faqStep text-center">
            <div class="container">
                <div class="faqIntroduction">DOMANDE FREQUENTI (F.A.Q.)</div>
                <div class="stepContent">
                    <div class="container">
                        <span>Tutto ciò che avete sempre desiderato sapere ma non avete mai avuto il coraggio di chiedere!</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="faqStep" ng-repeat="faqItem in faq.faqList" ng-init="index=$index">
            <div class="container">
                <macro-list ng-class="faq.getColours(index)" number="?"><span class="step-title" ng-bind-html="faqItem.question"></span></macro-list>
                <macro-list-inverse ng-class="faq.getColours(index)" number="!"><span class="answer" ng-bind-html="faqItem.answer"></span></macro-list-inverse>
<!--                 <div class="stepContent"> -->
<!--                     <div class="container"> -->
<!--                         <span ng-bind-html="faqItem.answer"></span> -->
<!--                     </div> -->
<!--                 </div> -->
            </div>
        </div>
    </div>
</div>