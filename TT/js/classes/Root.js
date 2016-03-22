var Root = function(argument, outer, index)
{
	this.argument = argument || 0;
	this.outer = outer || 1;
	this.index = index || 2;
	
	this.factorize = function()
	{
		if(Math.pow(this.argument,1/this.index) % 1 === 0)
		{
			this.outer *= Math.pow(this.argument,1/this.index);
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
					outer *= Math.pow(inPrimes[i].base, (inPrimes[i].exponent - inPrimes[i].exponent%this.index)/this.index );
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
	
	this.isInteger = function()
	{
		return (this.argument===1);
	}
	
	this.dot = function(root)
	{
		if(this.index === root.index)
		{
			var result = new Root(this.argument*root.argument);
			result.outer = this.outer*root.outer;
			return result;
		}
		else
		{
			
		}
	}
	
	this.changeSign = function()
	{
		var r = new Root(this.argument, this.outer.changeSign());
		return r;
	}
	
	this.abs = function()
	{
		var r = new Root(this.argument, this.outer.abs());
		return r;
	}
	
	this.tex = function()
	{
		var t = '';
		if(this.argument === 1 && this.outer === 1) return '1';
		if(this.argument === 0) return '0';
		if(this.outer === -1) t += '-';
		if(this.outer !== 1 && this.outer !== -1) t += this.outer.tex();
		if(this.argument < 0) t+= 'i';
		if(this.argument !== 1) t+= '\\sqrt{' + Math.abs(this.argument) + '}';
		
		return t;
	}
	
	this.plusTex = function()
	{
		var t = (this.outer < 0 ? '' : '+');
		t += this.tex();
		return t;
	}
	
	
}