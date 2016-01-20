<div id="news-events" ng-controller="newsController as news" spinner="news.getAjax">
	<spinner-place class="fa-5x"></spinner-place>
	<spinner-final>
		<div ng-repeat="event in news.news" class="equal-height" ng-init="index = $index">
			<div ng-class="presentation.getColour(index)">
				<div class="news-icon"><i class="fa white" ng-class="news.getIconClass(event)" fittext-multiple="0.8"></i></div>
				<div class="news-title">
					
				</div>
			</div>
			<div ng-class="presentation.getDarkColour(index)">
				<span ng-bind="event.description"></span>
			</div>
		</div>
	</spinner-final>
</div>