<div id="news-events" ng-controller="newsController as news" spinner="news.getAjax" style="margin-bottom:2em">
	<spinner-place class="fa-5x"></spinner-place>
	<spinner-final>
		<div class="black" style="width: 60%; margin-left: auto; margin-right: auto;">
			<div class="news">
				<div  class="bg-leaf">
					<div class="container">
						<div class="spotlights-icon" centered><i class="fa white" ng-class="news.getIconClass(news.topEvent)"></i></div>
						<div class="news-title" centered>
							<h2><b class="white"ng-bind-html="news.topEvent.title"></b></h2>
						</div>
					</div>
<!-- 					<p class="darker-grey"> -->
							<h6 class="text-center"><b class="white">Quando: </b><span class="black" ng-bind="news.getDate(news.topEvent)"></span></h6>
							<h6 class="text-center"><b class="white">Dove: </b><span class="black" ng-bind-html="news.topEvent.place"></span></h6>
<!-- 					</p> -->
				</div>
				<div class="news-description bg-dark-leaf">
					<p ng-bind-html="news.topEvent.description" class="black"></p>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</spinner-final>
</div>