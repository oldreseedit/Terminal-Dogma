var Root = function(argument, outer, index)
{
	this.argument = 1;
	this.outer = outer || 1;
	this.index = index || 2;
	
	if(argument)
	{
		if(argument.isOne()) return outer;
		this.argument = argument;
	}
	
	if(index)
	{
		if(index.isOne()) return this.argument.dot(this.outer);
	}
	
	this.exists = function(real)
	{
		var real = real || false;
		if(!real) return true;
		else return this.isReal();
	}
	
	this.isZero = function()
	{
		return ( this.argument.isZero() || this.outer.isZero() )
	}
	
	this.isOne = function()
	{
		return ( this.argument.isOne() && this.outer.isOne() );
	}
	
	this.isReal = function()
	{
		return this.argument.isPositive();
	}
	
	this.isPositive = function()
	{
		if(!this.isReal()) return Number.NaN;
		else return this.outer.isPositive();
	}
	
	this.opposite = function()
	{
		 return new Root(this.argument, this.outer.opposite());
	}
	
	this.equals = function(f)
	{
		var a = this.simplify();
		var b = f.simplify();
		if(!(f instanceof Root)) return false;
		return (a.outer.equals(b.outer) && a.argument.equals(b.argument) && a.index.equals(b.index));
	}
	
	this.simplify = function()
	{
		if(Math.pow(this.argument,1/this.index) % 1 === 0)
		{
			return new Root(1,this.outer*Math.pow(this.argument/this.index));
		}
		else
		{
			var inPrimes = this.argument.inPrimes();
			
			var outer = 1;
			var inner = 1;
			var index = this.index;
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
			var againInner = inner.inPrimes();
			var gcd;
			for(var i=0; i<againInner.length-1; i++)
			{
				gcd = againInner[i].exponent.gcd(againInner[i+1].exponent);
			}
			if(gcd !== 1 && index.isDivisible(gcd))
			{
				index /= gcd;
			}
			
			return new Root(inner,outer,index);
		}
	}
	
	this.abs = function()
	{
		if(!this.isReal()) return Number.NaN;
		return new Root(this.argument,this.outer.abs(),this.index);
	}
	
	this.gcd = function(f)
	{
		if(typeof f === 'number') return f.gcd(this.outer);
		if(f instanceof Root)
		{
			var a = this.simplify();
			var b = f.simplify();
			var arguments=1;
			if(a.index.equals(b.index))
			{
				arguments.dot(a.argument.gcd(b.argument));
				return new Root(arguments,a.outer.dot(b.outer),a.index)
			}
			else return a.outer.dot(b.outer);
		}
		return 1;
	}

	this.plus = function(root)
	{
		if(!(root instanceof Root)) return Number.NaN;
		if(!root.index.equals(this.index) || !root.argument.equals(this.argument)) return Number.NaN;
		return new Root(this.argument, this.outer.plus(root.outer), this.index);		
	}
	
	this.minus = function(root)
	{
		return this.plus(root.opposite());
	}
	
	this.dot = function(f)
	{
		if( f instanceof Root)
		{
			var a = this.simplify();
			var b = f.simplify();
			var mcm = a.index.mcm(b.index);
			return new Root( ( a.argument.over(mcm).simplify() ).dot( b.argument.over(mcm).simplify() ), a.outer.dot(b.outer), mcm);
		}
		else return new Root(this.argument, this.outer.dot(f.outer), this.index);
	}
	
	this.over = function(f)
	{
		return this.dot(f.inverse());
	}
	
	this.toTex = function()
	{
		var t = '';
		if(this.argument === 1 && this.outer === 1) return new Number(1).coefficientTex();
		if(this.argument === 0) return new Number(0).coefficientTex();
		t += this.outer.tex();
		if(this.argument < 0) t+= 'i';
		if(this.argument !== 1) t+= '\\sqrt{' + Math.abs(this.argument) + '}';
		
		return t;
	}	
	
}

Root.prototype = Object.create(MathObject.prototype);