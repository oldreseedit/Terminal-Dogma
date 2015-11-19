main.controller('activitiesController',['utilities',function(utilities){
    var self = this;
    
    self.tiles = [
        {
            title: 'Matematica 1',
            iconName: 'mat1',
            contentFlipped: 'No, no, seriamente; è fica.'
        },
        {
            title: 'Informatica 2',
            iconName: 'info3',
            contentFlipped: 'No, no, seriamente; è fica.'
        },
        {
            title: 'Matematica 3',
            iconName: 'mat3',
            contentFlipped: 'No, no, seriamente; è fica.'
        },
        {
            title: 'Informatica 4',
            iconName: 'info1',
            contentFlipped: 'No, no, seriamente; è fica.'
        },
        {
            title: 'Matematica 5',
            iconName: 'mat5',
            contentFlipped: 'No, no, seriamente; è fica.'
        },
        {
            title: 'Matematica 6',
            iconName: 'mat6',
            contentFlipped: 'No, no, seriamente; è fica.'
        },
        {
            title: 'Fisica 7',
            iconName: 'fis1',
            contentFlipped: 'No, no, seriamente; è fica.'
        }
    ];
    
    var numOfCol = imOnResponsive ? 3 : 6;
        
    self.sizesTiles = utilities.spacedSizes(numOfCol);
    
    self.spacedTiles = function($index){
        
        if($index % numOfCol == 0) return ["col-" + self.sizesTiles.elementsWidth, "offset-" + self.sizesTiles.outerWidth];
        else return ["col-" + self.sizesTiles.elementsWidth, "offset-" + self.sizesTiles.spacerWidth];
    };
    
    self.getIconClass = function(tile){
        return 'icon-' + tile.iconName;
    };
    
    self.getStyle = function(index,flipped){
        if(flipped) return ['bg-' + utilities.getColours(index), 'darker-grey'];
        else return ['bg-darker-grey',utilities.getColours(index)];
    };
    
    self.getTileWidth = function(){
        return self.activitiesWidth*self.sizesTiles.elementsWidth/100;
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