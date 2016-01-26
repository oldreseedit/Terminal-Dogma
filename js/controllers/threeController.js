main.controller('threeController',['$element',function($element){
	var self = this;
	
	var scene = new THREE.Scene();
	
	var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000 );
	camera.position.z = 200;
	
	var loader = new THREE.OBJMTLLoader();

	var renderer = new THREE.WebGLRenderer({
		precision: 'highp',
		antialias: true
	});
	renderer.setSize( 500, 500);
	renderer.pixelRatio
	
//	var light = new THREE.AmbientLight( 0xDBDBDB ); // soft white light
//	scene.add( light );
	
	var directionalLight = new THREE.DirectionalLight( 0xffffff, 1.5 );
	directionalLight.position.set( -1, -1, 1 );
	scene.add( directionalLight );
	
	loader.load('imgs/3D/withTexture.obj', 'imgs/3D/withTexture.mtl',
		// Function when resource is loaded
		function ( object ) {
			console.log(object);
			self.alien = object;
			self.alien.position.z = 80;
			self.alien.position.y = 40;
			scene.add( object );
			
			function render() {
				self.alien.rotation.y += 0.01;
				requestAnimationFrame( render );
				renderer.render( scene, camera );
			}
			render();			
		}
	);
	
	$element[0].appendChild(renderer.domElement);
	
	
//	console.log(renderer);
//	console.log(scene);
//	console.log(camera);
	
}]);