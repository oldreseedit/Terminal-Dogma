<div id="news-events" ng-controller="newsController as news" spinner="news.getAjax">
	<spinner-place class="fa-5x"></spinner-place>
	<spinner-final>
		<div class="black" style="width: 60%; margin-left: auto; margin-right: auto;">
			<div class="news">
				<div  class="bg-leaf">
					<div class="container">
						<div class="news-icon" centered><i class="fa white" ng-class="news.getIconClass(news.topEvent)" fittext fittext-exclusive="width"></i></div>
						<div class="news-title" centered>
							<h1><b class="white"ng-bind-html="news.topEvent.title"></b></h1>
						</div>
					</div>
<!-- 					<p class="darker-grey"> -->
							<h2 class="text-left"><b class="white">Quando: </b><span class="black" ng-bind="news.getDate(news.topEvent)"></span></h2>
							<h2 class="text-left"><b class="white">Dove: </b><span class="black" ng-bind-html="news.topEvent.place"></span></h2>
<!-- 					</p> -->
				</div>
				<div class="news-description bg-dark-leaf">
					<h5 ng-bind-html="news.topEvent.description"></h5>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</spinner-final>
</div>