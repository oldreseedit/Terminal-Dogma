main.controller('mediaController',['utilities','$timeout',function(utilities,$timeout){
    var self = this;
    
    self.tabs = [
        {
            id : 'media-events',
            name : 'Eventi',
            // url : 
            selected : true
        },
        {
            id : 'media-courses',
            name : 'Corsi',
            // url : 
            selected : false
        },
        {
            id : 'media-students',
            name : 'Studenti',
            // url : 
            selected : false
        }
    ];
    
    self.sizes = utilities.spacedSizes(self.tabs.length);
    self.actuallySelected = 0;
    
    self.spaced = function($first){
        if($first) return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.outerWidth;
        else return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.spacerWidth;
    };
    
    self.select = function(index){
        self.tabs[self.actuallySelected].selected = false;
        if(self.actuallySelected !== index) self.actuallySelected = index;
        self.tabs[index].selected = true;
    };
    
    self.getHeight = function(){
        $timeout(function(){self.heightReady = true;});
        return {
            'height' : self.lolloSpiegaHeight
        };
    };
    
    self.videoID = 'dQw4w9WgXcQ';
    self.playerVars = {
        autohide : 1,
        controls : 2,
        rel : 0,
        showinfo: 0,
        modestbranding: 0
    };
    
}]);