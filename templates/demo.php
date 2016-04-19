<div id="demo">

	<div id="navbar-demo">
		
		<div class="tab">
			<h2><span class="clickable" ng-click="select = 'presentazione'">Presentazione del gioco</span></h2>
		</div>
		<div class="tab">
			<h2><span class="clickable" ng-click="select = 'gioca'">Gioca a Flappy Chicken</span></h2>
		</div>
		
	</div>
	
	<div id="container-demo">
		<div id="presentazione" ng-if="select == 'presentazione'">
			
			<img alt="Flappy Chicken" src="imgs/flappyChicken.jpeg" class="galleggiante">
			<p>
				Flappy Chicken è il gioco più fico della storia sia perché è stato creato in appena due ore, ma anche perché il pollo è una divinità sottovalutata agli occhi dei poveri mortali. Inoltre contiene le seguenti feature:
			</p>
			<ul>
				<li><p>Lorem</p></li>
				<li><p>ipsum</p></li>
				<li><p>dolor</p></li>
				<li><p>sit</p></li>
				<li><p>amet</p></li>
			</ul>
			<p>
				consectetur adipiscing elit. Maecenas volutpat nisl ut neque mollis facilisis. Integer eu ligula auctor, semper metus quis, mollis mi. Pellentesque gravida sit amet dui sed hendrerit. Fusce rutrum pulvinar leo vel ultrices. Proin arcu purus, feugiat quis ex a, fringilla scelerisque sapien. Aenean vel pretium augue, et ornare leo. Fusce dictum eleifend justo, ut iaculis enim pharetra eu. In hac habitasse platea dictumst.
			</p>
			<img alt="Flappy Chicken" src="imgs/flappyChicken.jpeg" class="galleggianteDestra">
			<p>
				Vestibulum ac elementum turpis. Phasellus scelerisque, lacus vel congue pellentesque, elit arcu pulvinar odio, viverra blandit sapien purus a nulla. Donec eleifend urna nunc, in aliquet urna lacinia a. Fusce ornare consequat neque, eu tincidunt dui imperdiet quis. Quisque porta interdum ipsum, ut volutpat enim viverra id. Etiam eget diam eget orci tempus sodales. Suspendisse molestie erat vel quam posuere eleifend. Sed aliquet id enim quis porta. Phasellus eu est in mi placerat pulvinar. Quisque dui justo, aliquet eget neque id, hendrerit sagittis purus. Ut in laoreet velit. Donec pharetra porta justo, quis maximus urna vehicula in. Nulla sit amet tellus sed ex vulputate blandit ut id sapien. Aliquam tincidunt purus eget tincidunt convallis. Curabitur a augue molestie, pellentesque felis in, pharetra odio.
			</p>
			
			
		</div>
		<div id="gioca" ng-if="select == 'gioca'">
		
				<div id="flappy-container">
					<img id="flappy" src="imgs/flappy.png">
				</div>
<!-- 			<div ng-include="'templates/admin.php'"></div> -->
		
		</div>
	</div>
	
</div>