var Power = function(base, exponent, outer)
{
	this.base = base || new mNumber(1);
	this.exponent = exponent || new mNumber(1);
	this.outer = outer || new mNumber(1);
}

Power.prototype = Object.create(MathObject.prototype);
	
Power.prototype.exists = function()
{
	return (this.base > 0 || (this.base < 0 && this.exponent instanceof Fraction));
}

Power.prototype.isZero = function()
{
	return (this.outer.isZero() || this.base.isZero());
}

Power.prototype.isOne = function()
{
	return ( (this.base.isOne() || this.exponent.isZero()) && this.outer.isOne() );
}

Power.prototype.isPositive = function()
{
	return (this.base.isPositive() && this.outer.isPositive());
}

Power.prototype.opposite = function()
{
	return new Power(this.base, this.exponent, this.outer.opposite());
}

Power.prototype.inverseInline = function()
{
	return new Power(this.base, this.exponent.opposite(), this.outer);
}

Power.prototype.equals = function(f)
{
	var a = new mNumber( this.outer.dot(this.base.pow(this.exponent)) );
	var b = f.simplify();
	
	if(b instanceof mNumber) return b.equals(a);
	if(b instanceof Power) return this.base.equals(b.base) && this.exponent.equals(b.exponent) && this.outer.equals(b.outer);
	
	// TODO better
}

Power.prototype.simplify = function()
{
	return new Power(this.base.simplify(),this.exponent.simplify(),this.outer.simplify());
}

Power.prototype.abs = function()
{
	return new Power(this.base.abs(),this.exponent,this.outer.abs());
}

Power.prototype.gcd = function(f)
{
	// TODO
}

Power.prototype.mcm = function(f)
{
	// TODO
}

Power.prototype.plus = function(f)
{
	if(f instanceof Power && f.base.equals(this.base) && f.exponent.equals(this.exponent)) return new Power(this.base,this.exponent,this.outer.plus(f.outer));
	
	// TODO crea polinomio
}

Power.prototype.minus = function(f)
{
	return this.plus(f.opposite());
}

Power.prototype.dot = function(f)
{
	if(f instanceof mNumber) return new Power(this.base,this.exponent, this.outer.dot(f));
	if(f instanceof Power)
	{
		if(f.base.equals(this.base)) return new Power(this.base, this.exponent.plus(f.exponent), this.outer.dot(f.outer));
		if(f.exponent.equals(this.exponent)) return new Power(this.base.dot(f.base), this.exponent, this.outer.dot(f.outer));
		
		// TODO crea produttoria
	}
}

Power.prototype.toTex = function()
{	
	if(this.exponent.isOne()) return this.base.tex();
	
	var t = '';
	if(this.base instanceof mNumber) t += this.base.tex();
	if(this.base instanceof Polynomial) t += '\\left(' + this.base.tex() + '\\right)';
	t += '^{';
	t+= this.exponent.tex();
	t += '}';
	
	return t;
}