function mProduct (terms)
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
$.extend(mProduct.prototype, MathObject.prototype);

mProduct.prototype.clone = function()
{
	return new mProduct(this.terms);
}

mProduct.prototype.valueOf = function()
{
	var product = 1;
	for(var i=0; i<this.terms.length; i++)
	{
		product *= this.terms[i].valueOf();
	}
	return product;
}

mProduct.prototype.exists = function()
{
	for(var i=0; i<this.terms.length; i++)
	{
		if(!this.terms[i].exists()) return false;
	}
	return true;
}

mProduct.prototype.opposite = function()
{
	if(this.terms[0] instanceof mNumber)
	{
		this.terms[0] = this.terms[0].opposite();
	}
	return this;
}

mProduct.prototype.simplify = function()
{
	var terms = new Array({argument: this.terms[0], mClass: this.terms[0].constructor.name});
	
	for(var i=1; i<this.terms.length; i++)
	{
		var found = false;
		for(var j=0; j<terms.length; j++)
		{
			if(this.terms[i].constructor.name === terms[j].mClass)
			{
				terms[j].argument = terms[j].argument.dot(this.terms[i],true);
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
	
	for(var i=0; i<this.terms.length; i++)
	{
		this.terms[i] = this.terms[i].simplify();
	}
	
	if(this.terms.length === 1) return this.terms[0];
	
	return this;
}

mProduct.prototype.gcd = function(f)
{
	var gcd = this.terms[0];
	for(var i=1; i<this.terms.length; i++)
	{
		gcd = gcd.gcd(this.terms[i]);
	}
	return gcd.gcd(f);
}

mProduct.prototype.mcm = function(f)
{
	var mcm = this.terms[0];
	for(var i=1; i<this.terms.length; i++)
	{
		mcm = mcm.mcm(this.terms[i]);
	}
	return mcm.mcm(f);
}

mProduct.prototype.plus = function(f)
{
	return new mSum([this,f]);
}

mProduct.prototype.dot = function(f)
{
	this.terms.push(f);
	return this;
}

mProduct.prototype.pow = function(f)
{
	return new Power(this,f);
}

mProduct.prototype.toTex = function()
{
	var t = this.terms[0].dotTex(true);
	for(var i=1; i<this.terms.length; i++)
	{
		if(this.terms[i-1].constructor.name === this.terms[i].constructor.name) t += '\\cdot';
		t += this.terms[i].dotTex();
	}
	return t;
}