function Power (base, exponent)
{
	this.base = base || new mNumber(1);
	this.exponent = exponent || new mNumber(1);
}

$.extend(Power.prototype, MathObject.prototype);
	
Power.prototype.clone = function()
{
	return new Power(this.base,this.exponent);
}

Power.prototype.valueOf = function()
{
	return Math.pow(this.base.valueOf(), this.exponent.valueOf());
}
	
Power.prototype.exists = function()
{
	return (this.base > 0 || (this.base < 0 && this.exponent instanceof Fraction));
}

Power.prototype.inverseInline = function()
{
	this.exponent.opposite();
}

Power.prototype.simplify = function()
{
	this.base = this.base.simplify();
	this.exponent = this.exponent.simplify();
	return this;
}

Power.prototype.plus = function(f)
{
	if(f instanceof Power && f.base.equals(this.base) && f.exponent.equals(this.exponent)) return new Power(this.base,this.exponent);
	return new mSum([this,f]);
}

Power.prototype.dot = function(f)
{
	if(f instanceof Power)
	{
		if(f.base.equals(this.base)) return new Power(this.base, this.exponent.plus(f.exponent));
		if(f.exponent.equals(this.exponent)) return new Power(this.base.dot(f.base), this.exponent);
	}
	return new mProduct([this,f]);
}

Power.prototype.toTex = function()
{	
	var t = '';
	if(this.base instanceof mNumber) t += this.base.toTex();
	if(this.base instanceof mSum) t += '\\left(' + this.base.toTex() + '\\right)';
	t += '^{' + (this.exponent instanceof mNumber ? this.exponent.toTex() : '\\left(' + this.exponent.toTex() + '\\right)') + '}';
	
	return t;
}

