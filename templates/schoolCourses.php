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
				
				<table id="table-courses-table" class="bg-green">
					<tr class="bg-white">
						<td><h3>Corsi intracurriculari</h3></td>
						<td><h3>Corsi extracurriculari</h3></td>
					</tr>
					
					<!-- Android -->
					<tr>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/Android.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">Applicazioni Android</h4>
									<p>Il corso rivede le basi della programmazione Java e introduce i concetti e gli strumenti necessari allo sviluppo di un’applicazione nativa Android.</p>
								</div>
							</div>
						</td>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/Android.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">Applicazioni Android</h4>
									<p>Dopo aver rivisto i concetti insegnati nel corso base intracurricolare, il corso passa ad approfondire gli strumenti offerti da Google per sviluppare applicazioni native Android di ogni genere.</p>
								</div>
							</div>
						</td>
					</tr>
					
					<!-- ECDL -->
					<tr>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/ECDL.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">ECDL</h4>
									<p>
									Il corso è pensato non solo per dare un’alfabetizzazione informatica di base, ma per preparare gli studenti al sostenimento dell’esame per ottenere la pa-
tente europea del computer.
									</p>
								</div>
							</div>
						</td>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/ECDL.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">ECDL</h4>
									<p>
									Il corso è pensato non solo per dare un’alfabetizzazione informatica di base, ma per preparare gli studenti al sostenimento dell’esame per ottenere la patente europea del computer.
									</p>
								</div>
							</div>
						</td>
					</tr>
					
					<!-- HTML, CSS e JavaScript -->
					<tr>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/websites.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">HTML, CSS e JavaScript</h4>
									<p>
									Il corso tratta la creazione e lo styiling di una pagina web, partendo dalle basi fino a toccare lo scripting in JavaScript.									</p>
								</div>
							</div>
						</td>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/websites.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">HTML, CSS e JavaScript</h4>
									<p>
									Ripartendo dalla basi, il corso insegna gli strumenti necessari per realizzare un sito web completo. 
Il corso prevede anche un’introduzione ai concetti di usabilità e user experience.
									</p>
								</div>
							</div>
						</td>
					</tr>
					
					<!-- Game Maker -->
					<tr>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/Game Maker.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">Game Maker</h4>
									<p>
									Il corso rinfresca le basi della programmazione, introduce l’ambiente di sviluppo Game Maker e tratta i concetti base necessari alla creazione di un semplice videogioco.
									</p>
								</div>
							</div>
						</td>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/Game Maker.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">Game Maker</h4>
									<p>
									Il corso affronta rapidamente quanto visto nel corso intracurricolare per poi passare ad approfondire gli strumenti offerti da Game Maker e, più in generale, le tecniche di sviluppo videoludico.
									</p>
								</div>
							</div>
						</td>
					</tr>
					
					<!-- Grafica 3D -->
					<tr>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/3D Studio Max.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">Grafica 3D</h4>
									<p>
									Il corso introduce le basi della modellazione tridimensionale in 3D Studio Max, programma utilizzato per videogiochi ed effetti speciali di film.
									</p>
								</div>
							</div>
						</td>
						<td>
							<div class="container course-cell">
								<div>
									<img src="imgs/courses/all/3D Studio Max.png" class="course-icon">
								</div>
								<div class="experience-content text-left">
									<h4 class="white strong">Grafica 3D</h4>
									<p>
									Il corso, dopo aver rinfrescato quanto visto nel corso base intracurricolare, approfondisce le tecniche di modellazione e affronta concetti avanzati, quali l’illuminazione, l’uso di materiali virtuali e il rendering.
									</p>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>