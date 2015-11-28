main.controller('headerController',function(){
    var self = this;
    
    self.getLogoStyle = function(){
        if(self.headerHeight - self.logoHeight <= 0) return;
        return {
            'margin-top' : (self.headerHeight - self.logoHeight)/2 + 'px'
        };
    };
    
    self.getSloganStyle = function(){
        if(self.headerHeight - self.sloganHeight <= 0) return;
        return {
            'margin-top': (self.headerHeight - self.sloganHeight)/2 + 'px'
        };
    };
});