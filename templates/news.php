<div id="news-events" ng-controller="newsController as news" spinner="news.getAjax">
	<spinner-place class="fa-5x"></spinner-place>
	<spinner-final>
		<div ng-repeat="row in news.newsByRow" class="black">
			<div class="news" ng-repeat="event in row" ng-init="index=$index"  ng-class="presentation.spacedTabs($first)">
				<div  class="bg-leaf">
					<div class="container">
						<div class="news-icon" centered><i class="fa white" ng-class="news.getIconClass(event)"></i></div>
						<div class="news-title text-left" centered>
							<h4><b  class="white" ng-bind-html="event.title"></b></h4>
						</div>
					</div>
					<p ng-if="event.type==='event'" class="darker-grey">
						<small>
							<b class="white">Quando: </b><span class="black" ng-bind-html="news.getDate(event)"></span>
						</small><br />
						<small>
							<b class="white">Dove: </b><span class="black" ng-bind-html="event.place"></span>
						</small>
					</p>
				</div>
				<div class="news-description bg-dark-leaf">
					<p class="black"><span ng-bind-html="event.description"></span></p>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</spinner-final>
</div>