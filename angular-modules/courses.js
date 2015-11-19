main.controller('coursesController',['utilities','$timeout','$location',function(utilities,$timeout,$location){
    var self = this;
    
    self.categories = [
        {
            name: 'Informatica',
            tiles: [
                {
                    title: 'Java',
                    iconName: 'java',
                    contentFlipped: 'Impara il linguaggio di programmazione che controlla più di 4 miliardi di dispositivi!',
                    url: 'java'
                },
                {
                    title: 'Mobile App',
                    iconName: 'android',
                    contentFlipped: 'Apprendi le basi per sviluppare un\'applicazione Android!',
                    url: 'mobileApp'
                }
            ]
        },
        {
            name: 'Web Development',
            tiles: [
                {
                    title: 'HTML + CSS + JS',
                    iconName: 'web',
                    contentFlipped: 'Un corso introduttivo ma completo sulle nozioni e funzionalità di base della programmazione web: HTML, CSS e Javascript',
                    url: 'HCJS'
                },
                {
                    title: 'MVC Development',
                    iconName: 'web2',
                    contentFlipped: 'Un corso completo sui framework più diffusi e potenti (AngularJS, jQuery e CodeIgniter) per lo sviluppo di applicazioni web.',
                    url:'MVCDevelopment'
                }
            ]
        },
        {
            name: 'Gaming',
            tiles: [
                {
                    title: 'Game Design',
                    iconName: 'gameDesign',
                    contentFlipped: 'Fondamenti di game design e progettazione di un videogioco da realizzare in collaborazione con altri corsi.',
                    url: 'gameDesign'
                },
                {
                    title: 'Game Maker',
                    iconName: 'gameMaker',
                    contentFlipped: 'Come creare un videogioco da zero utilizzando Game Maker Studio, e suo effettivo sviluppo in collaborazione con altri corsi.',
                    url: 'gameMaker'
                },
                {
                    title: 'Games for Dummies',
                    iconName: 'gamesForDummies',
                    contentFlipped: 'Corso per principianti mirato allo sviluppo di un videogioco senza alcuna conoscenza di linguaggi di programmazione.',
                    url: 'gamesForDummies'
                }
            ]
        },
        {
            name: 'Grafica',
            tiles: [
                {
                    title: '3D Studio Max',
                    iconName: '3DStudioMax',
                    contentFlipped: 'Modellazione, texturing, illuminazione e rendering in 3DS Max + V-Ray e realizzazione della grafica per un videogioco in collaborazione con altri corsi.',
                    url: '3DStudioMax'
                }
            ]
        }
    ];
        
    self.sizesCategories = utilities.sizesWithSpacer(0.75,self.categories.length);
    
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
        return utilities.getColours(i, self.categories.length);
    };
    
    self.route = function(url){
        $location.path('courses/'+url);
    };
    
}]);