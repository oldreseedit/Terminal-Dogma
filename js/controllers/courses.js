main.controller('coursesController',['utilities','$timeout','$location','$server','moment',function(utilities,$timeout,$location,$server,moment){
    var self = this;
    
//    self.categories = [
//        {
//            name: 'Informatica',
//            tiles: [
//                {
//                    title: 'Java',
//                    iconName: 'java',
//                    contentFlipped: 'Impara il linguaggio di programmazione che controlla più di 4 miliardi di dispositivi!',
//                    url: 'java2016'
//                },
//                {
//                    title: 'Mobile App',
//                    iconName: 'mobileApp',
//                    contentFlipped: 'Apprendi le basi per sviluppare un\'applicazione Android!',
//                    url: 'mobileApp2016'
//                }
//            ]
//        },
//        {
//            name: 'Web Development',
//            tiles: [
//                {
//                    title: 'HTML + CSS + JS',
//                    iconName: 'HCJS',
//                    contentFlipped: 'Un corso introduttivo ma completo sulle nozioni e funzionalità di base della programmazione web: HTML, CSS e Javascript',
//                    url: 'HCJS2016'
//                },
//                {
//                    title: 'MVC Development',
//                    iconName: 'MVCDevelopment',
//                    contentFlipped: 'Un corso completo sui framework più diffusi e potenti (AngularJS, jQuery e CodeIgniter) per lo sviluppo di applicazioni web.',
//                    url:'MVCDevelopment2016'
//                }
//            ]
//        },
//        {
//            name: 'Gaming',
//            tiles: [
//                {
//                    title: 'Game Design',
//                    iconName: 'gameDesign',
//                    contentFlipped: 'Fondamenti di game design e progettazione di un videogioco da realizzare in collaborazione con altri corsi.',
//                    url: 'gameDesign2016'
//                },
//                {
//                    title: 'Game Maker',
//                    iconName: 'gameMaker',
//                    contentFlipped: 'Come creare un videogioco da zero utilizzando Game Maker Studio, e suo effettivo sviluppo in collaborazione con altri corsi.',
//                    url: 'gameMaker2016'
//                },
//                {
//                    title: 'Games for Dummies',
//                    iconName: 'gamesForDummies',
//                    contentFlipped: 'Corso per principianti mirato allo sviluppo di un videogioco senza alcuna conoscenza di linguaggi di programmazione.',
//                    url: 'gamesForDummies2016'
//                }
//            ]
//        },
//        {
//            name: 'Grafica',
//            tiles: [
//                {
//                    title: '3D Studio Max',
//                    iconName: '3DStudioMax',
//                    contentFlipped: 'Modellazione, texturing, illuminazione e rendering in 3DS Max + V-Ray e realizzazione della grafica per un videogioco in collaborazione con altri corsi.',
//                    url: '3DStudioMax2016'
//                }
//            ]
//        }
//    ];

    self.categories = [{name: 'Informatica', tiles: []},
                       {name: 'Web Development', tiles: []},
                       {name: 'Gaming', tiles: []},
                       {name: 'Grafica', tiles: []}];
    
    self.coursesData = $server.post('courses/get_all').then(
    		function(response)
    		{
    			for(var i=0; i<response.data.length; i++)
    			{
    				var course = response.data[i];
    				
    				// Find the corresponding category
    				var category = null;
    				for(var j=0; j<self.categories.length; j++)
    				{
    					if(self.categories[j].name === course.category)
    					{
    						category = self.categories[j];
    					}
    				}
//    				if(category == null)
//    				{
//    					category = {
//    							'name': course.category,
//    							'tiles': []
//    					};
//    					self.categories.push(category);
//    				}
    				
    				// Find the corresponding tile
    				var tile = null;
    				for(var k=0;k<category.tiles.length;k++)
    				{
    					if(category.tiles[k].subject === course.subject)
    					{
    						tile = category.tiles[k];
    					}
    				}
    				if(tile == null)
    				{
    					tile = {
    							'subject': course.subject,
								'title': course.name,
								'iconName': course.icon,
								'contentFlipped': course.shortDescription,
								'startingDate': course.startingDate,
								'url': course.courseID
    					};
    					category.tiles.push(tile);}
    				
    				// Set the course-specific information
    				// (e.g., if the user is subscribed to a specific course or if the course is the
    				// latest one)
    				if(moment(course.startingDate).isAfter(moment(tile.startingDate)))
    				{
    					tile.url = course.courseID;
    				}
    			}
//    			self.categories.sort(function(a, b){return a.name >= b.name});
    			console.log("CATEGORIE:", self.categories);
    		}
        );
    
    self.sizesCategories = utilities.sizesWithSpacer(0.75, 4);
    
    self.spacedCategories = function($first){
        if($first) return {
            'width': self.sizesCategories.elementsWidth*100 + '%'
        };
        else return {
            'width': self.sizesCategories.elementsWidth*100 + '%',
            'margin-left': self.sizesCategories.spacerWidth + '%'
        };
    };
    
    self.getIconClass = function(tile){
        return 'icon-' + tile.iconName;
    };
    
    self.getStyle = function(index,flipped){
        if(!flipped) return ['bg-' + utilities.getColours(index, self.categories.length), 'darker-grey'];
        else return ['bg-darker-grey', utilities.getColours(index, self.categories.length)];
    };
    
    self.getVerticalOffset = function(){
        var style = {
            'padding-bottom' : self.tilesCoursesWidth*self.sizesCategories.spacerWidth/100 + 'px',
        };
        
        return style;
    };
    
    self.getVerticalOffsetForCategory = function(){
        var style = {
            'height' : self.getTileWidth()/3 + 'px',
            'margin-bottom' : self.tilesCoursesWidth*self.sizesCategories.spacerWidth/100 + 'px'
        };
        return style;
    };
    
    self.getTileWidth = function(){
        return self.tilesCoursesWidth*self.sizesCategories.elementsWidth;
    };
    
    self.getTileTitle = function(){
        return {
            'height' : self.getTileWidth()/4 + 'px'
        };
    };
    
    self.getTileContent = function(){
        return {
            'height' : self.getTileWidth()*3/4 + 'px'
        };
    };
    
    self.getColours = function(i){
        return utilities.getColours(i, 4);
    };
    
}]);