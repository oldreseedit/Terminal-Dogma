<div id="faqPage" ng-controller="privacyController as privacy">
	<div class="container">
		<div class="faqStep text-center">
            <div class="container">
                <div class="faqIntroduction">Privacy policy</div>
            </div>
        </div>
        <div class="faqStep" ng-repeat="faqItem in privacy.faqList" ng-init="index=$index">
            <div class="container">
                <div class="stepLine">
                    <div class="container">
                            <div class="middle fa fa-lg fa-leaf" ng-class="privacy.getColours(index)"></div>
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