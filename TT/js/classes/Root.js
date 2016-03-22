var Root = function(argument, index)
{
	this.argument = argument || 0;
	this.outer = 1;
	this.index = index || 2;
	
	this.factorize = function()
	{
		if(Math.pow(this.argument,1/this.index) % 1 === 0)
		{
			this.outer = Math.pow(this.argument,1/this.index);
			this.argument = 1;
		}
		else
		{
			var inPrimes = this.argument.inPrimes();
			
			var outer = 1;
			var inner = 1;

			for(var i=0; i< inPrimes.length; i++)
			{
				
				if(inPrimes[i].exponent >= this.index)
				{
					outer *= inPrimes[i].exponent%this.index !== 0 ? Math.pow(inPrimes[i].base, (inPrimes[i].exponent%this.index)/this.index ) : Math.pow(inPrimes[i].base, inPrimes[i].exponent/this.index);
					inner *= Math.pow(inPrimes[i].base, inPrimes[i].exponent%this.index);
				}
				else inner*=Math.pow(inPrimes[i].base, inPrimes[i].exponent);
			}
			if(inner<0 && this.index%2 === 1)
			{
				inner *= -1;
				outer *=-1;
			}
			
			this.outer = outer;
			this.argument = inner;
		}
	}
	
	this.tex = function()
	{
		var t = '';
		if(this.argument === 1 && this.outer === 1) return '1';
		if(this.argument === 0) return '0';
		if(this.outer !== 1) t += this.outer;
		if(this.argument < 0) t+= 'i';
		if(this.argument !== 1) t+= '\\sqrt{' + Math.abs(this.argument) + '}';
		
		return t;
	}
	
	
}