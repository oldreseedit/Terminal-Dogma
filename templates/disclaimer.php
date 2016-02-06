<div id="faqPage" ng-controller="disclaimerController as disclaimer">
	<div class="container">
		<div class="faqStep text-center">
            <div class="container">
                <div class="faqIntroduction">Termini d'uso</div>
            </div>
        </div>
        <div class="faqStep" ng-repeat="faqItem in disclaimer.faqList" ng-init="index=$index">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                            <div class="middle fa fa-3x fa-lightbulb-o" ng-class="disclaimer.getColours(index)"></div>
                        <span class="stepTitle middle" ng-bind="faqItem.title"></span>
                    </div>
                </div>
                <div class="stepContent">
                    <div class="container">
                        <span ng-bind-html="faqItem.content"></span>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>