<div id="home">
    <div class="container">
    	<div id="school-courses" ng-controller="schoolCoursesController as schoolCoursesC">
	    	<div class="container">    
				<h3>Corsi per le scuole</h3>
				<p>I corsi reSeed per le scuole trattano temi tecnologici attuali e utili in ambito lavorativo, e mirano a insegnare agli studenti abilità pratiche, spesso a partire dalle conoscenze apprese grazie a 
materie curricolari. Le proposte si articolano in un percorso intracurricolare ed extracurricolare per, rispettivamente, introdurre e approfondire concetti e pratiche insegnati.</p>
				<div id="tiles-courses">
					<div class="container">
						<div id="tiles-courses-left" equal-height>
							<div class="container">
								<div class="gain-icon" centered>
									<i class="fa fa-arrow-circle-down white"></i>
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">Corsi intracurricolari</h4>
									<p><b>Durata:</b> 12 ore</p>
									<p><b>Costo:</b> 2€ l'ora per ogni studente</p>
									<p><b>Gratuità:</b></p>
									<ul>
										<li>Studenti portatori di handicap</li>
										<li>Fratelli/sorelle di studenti già partecipanti</li>
									</ul>
								</div>
							</div>			
						</div>
						<div id="tiles-courses-right" equal-height>
							<div class="container">
								<div class="experience-content text-left">
									<h4 class="white strong">Corsi extracurricolari</h4>
									<p><b>Durata:</b> 36 ore</p>
									<p><b>Costo:</b> 12€ l'ora per studente</p>
									<p><b>Classe minima:</b> 5 studenti</p>
								</div>
								<div class="unlock-icon" centered>
									<i class="fa fa-arrow-circle-up white"></i>
								</div>
							</div>			
						</div>
					</div>
				</div>
		
				<h3>Come funziona</h3>
				<p>Organizzare un corso reSeed nella vostra scuola è estremamente semplice grazie anche alla flessibilità su giorni, orari, etc.</p>
				<div id="tiles-course-presentation">
					<div class="container">
						<div ng-repeat="tab in schoolCoursesC.tabs" id="{{tab.id}}" class="tab bg-lawn" equal-height ng-class="schoolCoursesC.getStyleTabs($first)">
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
			</div>
		</div>
	</div>
</div>