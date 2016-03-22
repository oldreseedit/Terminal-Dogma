var Root = function(argument, index)
{
	this.argument = argument || 0;
	this.index = index || 2;
	
	this.isFactorizable = function()
	{
		if(Math.pow(this.argument,1/this.index) % 1 === 0) return Math.pow(this.argument,1/this.index);
		
		var inPrimes = this.argument.inPrimes();
		
		console.log(inPrimes);
	}
	
	
}