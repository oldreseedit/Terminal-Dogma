<div id="faqPage" ng-controller="faqController as faq">
    <div class="container">
        <div class="faqStep text-center">
            <div class="container">
                <div class="faqIntroduction"><h2>DOMANDE FREQUENTI (F.A.Q.)</h2></div>
                <div class="stepContent">
                    <div class="container">
                        <p><span>Tutto ciò che avete sempre desiderato sapere ma non avete mai avuto il coraggio di chiedere!</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="faqStep" ng-repeat="faqItem in faq.faqList" ng-init="index=$index">
            <div class="container">
                <macro-list ng-class="faq.getColours(index)" number="?"><h3 class="inline"><span class="step-title" ng-bind-html="faqItem.question"></span></h3></macro-list>
                <macro-list-inverse ng-class="faq.getColours(index)" number="!"><p class="inline"><span class="answer" ng-bind-html="faqItem.answer"></span></p></macro-list-inverse>
<!--                 <div class="stepContent"> -->
<!--                     <div class="container"> -->
<!--                         <span ng-bind-html="faqItem.answer"></span> -->
<!--                     </div> -->
<!--                 </div> -->
            </div>
        </div>
    </div>
</div>