<p>I corsi di reSeed prevedono una parte di simulazione di On-The-Job Training, che ponga gli studenti di fronte a questioni e problemi che non vengono affrontati in altri corsi di formazione ma che sono all'ordine del giorno in un ambiente lavorativo.</p>
<div id="tiles-presentation">
	<div class="container">
		<div ng-repeat="tab in presentation.tabs" id="{{tab.id}}" class="tab bg-lawn" equal-height ng-class="presentation.getStyleTabs($first)">
			<div class="container">
				<div class="inside-tab">
					<i class="fa fa-5x white" ng-class="tab.faName"></i>
					<div class="title-wrapper">
						<div class="container">
							<span ng-bind="tab.title" class="title white"></span>
						</div>
					</div>
					<div class="tab-content">
						<p ng-bind="tab.content"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>