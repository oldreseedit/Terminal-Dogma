main.controller('bookmarkController',function(){
	
	var self = this;
	
    self.selected = -2;
    self.oldSelected = -1;
    
    self.toggleSelection = function(i)
    {
		if(self.selected !== -2) self.oldSelected = self.selected;
		self.selected = (self.selected === i) ? -1 : i;
    }
    
});