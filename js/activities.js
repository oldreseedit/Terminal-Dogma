main.controller('activitiesController',['utilities',function(utilities){
    var self = this;
    
    self.tiles = [
        {
            title: 'Siti web',
            iconName: '',
            contentFlipped: 'Creiamo il sito perfetto per le tue esigenze e quelle dei tuoi clienti, presente sui motori di ricerca e progettato secondo le corrette regole di user experience.',
            url: 'websites'
        },
        {
            title: 'Advergaming',
            iconName: '',
            contentFlipped: 'Progettiamo assieme a te e realizziamo il videogioco perfetto per pubblicizzare il tuo prodotto su piattaforme Android, iOS, social e web.',
            url: 'advergaming'
        },
        {
            title: 'Ripetizioni',
            iconName: '',
            contentFlipped: 'Ripetizioni professionali e assistenza allo studio a domicilio per universitari e studenti delle scuole superiori in Matematica, Fisica, Informatica e molto altro.',
            url: 'reps'
        },
    ];
    
    var numOfCol = imOnResponsive ? 3 : (self.tiles.length > 6 ? 6 : self.tiles.length);
        
    self.sizesTiles = utilities.sizesWithSpacer(0.75,numOfCol);
    
    self.spacedTiles = function(index){
        if(index % numOfCol === 0) return {
            'width': self.sizesTiles.elementsWidth*100 + '%',
            'padding-bottom' : self.tilesActivitiesWidth*self.sizesTiles.spacerWidth/100 + 'px',
        };
        else return {
            'width': self.sizesTiles.elementsWidth*100 + '%',
            'margin-left': self.sizesTiles.spacerWidth + '%',
            'padding-bottom' : self.tilesActivitiesWidth*self.sizesTiles.spacerWidth/100 + 'px',
        };
    };
    
    self.getIconClass = function(tile){
        return 'icon-' + tile.iconName;
    };
    
    self.getStyle = function(index,flipped){
        if(flipped) return ['bg-' + utilities.getColours(index), 'darker-grey'];
        else return ['bg-darker-grey',utilities.getColours(index)];
    };
    
    self.getTileWidth = function(){
        return self.tilesActivitiesWidth*self.sizesTiles.elementsWidth;
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
        return utilities.getColours(i);
    };
    
}]);