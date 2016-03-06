<div id="faqPage" ng-controller="privacyController as privacy">
	<div class="container">
		<div class="faqStep text-center">
            <div class="container">
                <div class="faqIntroduction"><h2>Privacy policy</h2></div>
            </div>
        </div>
        <div class="faqStep" ng-repeat="faqItem in privacy.faqList" ng-init="index=$index">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                            <div class="middle fa fa-3x fa-leaf" ng-class="privacy.getColours(index)"></div>
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