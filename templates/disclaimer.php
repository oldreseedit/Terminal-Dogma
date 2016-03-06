<div id="faqPage" ng-controller="disclaimerController as disclaimer">
	<div class="container">
		<div class="faqStep text-center">
            <div class="container">
                <div class="faqIntroduction"><h3>Termini d'uso</h3></div>
            </div>
        </div>
        <div class="faqStep" ng-repeat="faqItem in disclaimer.faqList" ng-init="index=$index">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                            <i class="middle fa fa-3x fa-lightbulb-o" ng-class="disclaimer.getColours(index)"></i>
                        <span class="middler"></span><h3 class="inline middle"><span class="stepTitle" ng-bind="faqItem.title"></span></h3>
                    </div>
                </div>
                <div class="stepContent">
                    <div class="container">
                        <p><span ng-bind-html="faqItem.content"></span></p>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>