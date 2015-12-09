main.controller('activitiesController',['utilities',function(utilities){
    var self = this;
    
    self.tiles = [
        {
            title: 'Matematica 1',
            iconName: 'mat1',
            contentFlipped: 'No, no, seriamente; è fica.'
        },
    ];
    
    var numOfCol = imOnResponsive ? 3 : 6;
        
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