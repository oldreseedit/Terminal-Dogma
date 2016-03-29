function mSum (terms)
{
	this.terms = new Array();
	
	if(terms instanceof Array)
	{
		this.terms = terms;
	}
	if(terms instanceof MathObject)
	{
		this.terms.push(terms);
	}	
	
}

$.extend(mSum.prototype, MathObject.prototype);

mSum.prototype.valueOf = function()
{
	var sum = 0;
	for(var i=0; i<this.terms.length; i++)
	{
		sum += this.terms[i].valueOf();
	}
	return sum;
}

mSum.prototype.exists = function()
{
	for(var i=0; i<this.terms.length; i++)
	{
		if(!this.terms[i].exists()) return false;
	}
	return true;
}

mSum.prototype.opposite = function()
{
	return new mProduct(this).opposite();
}

mSum.prototype.oppositeInline = function()
{
	for(var i=0; i<this.terms.length; i++)
	{
		this.terms[i].opposite();
	}
	return this;
}

mSum.prototype.simplify = function()
{
	var terms = new Array({argument: this.terms[0], mClass: this.terms[0].constructor.name});
	
	for(var i=1; i<this.terms.length; i++)
	{
		var found = false;
		for(var j=0; j<terms.length; j++)
		{
			if(this.terms[i].constructor.name === terms[j].mClass)
			{
				terms[j].argument = terms[j].argument.plus(this.terms[i]);
				found = true;
			}
		}
		if(!found) terms.push({argument: this.terms[i], mClass: this.terms[i].constructor.name});
	}
	
	this.terms = new Array();
	
	for(var i=0; i<terms.length; i++)
	{
		this.terms.push(terms[i].argument);
	}
	
	// Remove zeros
	if(this.terms.length > 0)
	{
		for(var i=0; i<this.terms.length; i++)
		{
			if(this.terms[i].isZero()) this.terms.splice(i,1);
		}		
	}
	
	// Add a zero if the Sum is void
	if(this.terms.length === 0) this.terms[0] = new mNumber(0);
	
	for(var i=0; i<this.terms.length; i++)
	{
		this.terms[i] = this.terms[i].simplify();
	}
	
	return this;
}

mSum.prototype.gcd = function(f)
{
	var gcd = this.terms[0];
	for(var i=1; i<this.terms.length; i++)
	{
		gcd = gcd.gcd(this.terms[i]);
	}
	return gcd.gcd(f);
}

mSum.prototype.mcm = function(f)
{
	var mcm = this.terms[0];
	for(var i=1; i<this.terms.length; i++)
	{
		mcm = mcm.mcm(this.terms[i]);
	}
	return mcm.mcm(f);
}

mSum.prototype.plus = function(f)
{
	this.terms.push(f);
	return this;
}

mSum.prototype.dot = function(f)
{
	return new mProduct([this,f]);
}

mSum.prototype.over = function(f,explicit)
{
	if(!explicit)
	{
		for(var i=0; i<this.terms.length; i++)
		{
			this.terms[i] = this.terms[i].over(f,explicit);
		}
		return this;
	}
	else return new Fraction(this,f);
}

mSum.prototype.pow = function(f)
{
	return new Power(this,f);
}

mSum.prototype.toTex = function()
{
	var t = this.terms[0].toTex();
	for(var i=1; i<this.terms.length; i++)
	{
		t += this.terms[i].plusTex(); 
	}
	return t;
}



