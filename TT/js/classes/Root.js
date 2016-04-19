function Root (argument, index)
{
	this.argument = argument || new mNumber(1);
	this.index = index || new mNumber(2);
}

$.extend(Root.prototype, MathObject.prototype);
	
Root.prototype.clone = function()
{
	return new Root(this.argument,this.index);
}

Root.prototype.valueOf = function()
{
	return Math.pow(this.argument.valueOf(),1/this.index.valueOf());
}

Root.prototype.exists = function(complex)
{
	var complex = complex|| false;
	if(!complex) return true;
	else return this.isReal();
}

Root.prototype.isReal = function()
{
	return this.argument.isPositive();
}

Root.prototype.simplify = function()
{
	
	if(this.argument.pow(new mNumber(1).over(this.index)).valueOf() % 1 === 0)
	{
		return new mNumber(this.argument.pow(new mNumber(1).over(this.index)).valueOf());
	}
	else
	{
		var inPrimes = this.argument.inPrimes();
		
		var inner = new mNumber(1);
		var index = this.index;
		for(var i=0; i< inPrimes.length; i++)
		{
			if(inPrimes[i].exponent.greaterThan(index))
			{
				inner = inner.dot(inPrimes[i].base.pow( inPrimes[i].exponent.valueOf()%index.valueOf() ) );
			}
			else inner = inner.dot(inPrimes[i].base.pow( inPrimes[i].exponent) );
		}
		
		var againInner = inner.inPrimes();
		var gcd = againInner[0].exponent;
		for(var i=1; i<againInner.length; i++)
		{
			gcd = gcd.gcd(againInner[i+1].exponent);
		}
		if(!gcd.isOne() && index.isDivisible(gcd))
		{
			index = index.over(gcd);
		}

		this.argument = inner;
		this.index = index;
		
		return this;
	}
}

this.gcd = function(f)
{
	if(f instanceof Root)
	{
		var a = this.simplify();
		var b = f.simplify();
		var arguments=1;
		if(a.index.equals(b.index))
		{
			arguments.dot(a.argument.gcd(b.argument));
			return new Root(arguments,a.index)
		}
	}
	return new mNumber(1);
}

Root.prototype.plus = function(f, implicit)
{
	if(f instanceof Root && implicit)
	{
		if(!f.index.equals(this.index) || !f.argument.equals(this.argument)) return new mSum([this,f]);
		return new mProduct(new mNumber(2),this);		
	}
	 return new mSum([this,f]);
}

Root.prototype.dot = function(f, implicit)
{
	if( f instanceof Root && implicit)
	{
		var a = this;
		var b = f;
		var mcm = a.index.mcm(b.index);
		return new Root( ( a.argument.pow(a.index.over(mcm)).simplify() ).dot( b.argument.pow(a.index.over(mcm)).simplify() ), mcm);
	}
	else return new mProduct([this,f]);
}

Root.prototype.toTex = function()
{
	return '\\sqrt[\\leftroot{-2}\\uproot{2}' + (this.index.valueOf() !== 2 ? this.index.toTex() : '') + ']{' + this.argument.toTex() + '}';
}
