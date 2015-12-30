main.filter('firstCapitalized',function(){
    return function(input){
        input = input || '';
        var output = input.charAt(0).toUpperCase() + input.substring(1,input.length);
        // console.log(output);
        
        return output;
    };
});