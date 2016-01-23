main.filter('experiencePointsFormatter',function(){
    return function(input){
        input = input || '';
        
        var n = parseInt(input);
        var i = 0;
        var units = ['', 'k', 'M', 'T'];
        while(n > 1000)
        {
        	n = n/1000;
        	i++;
        }
        
        return parseInt(Math.round(n*10), 10)/10 + units[i];
    };
});
