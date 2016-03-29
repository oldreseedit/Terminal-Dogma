function MathObject (){}

MathObject.prototype.tex = function(mode)
{
	return tex(this,mode);
}

MathObject.prototype.plusTex = function(isCoefficient)
{
	return tex(this,{isCoefficient : isCoefficient || false, operation : 'plus'});
}

MathObject.prototype.dotTex = function(isCoefficient)
{
	return tex(this,{isCoefficient : isCoefficient || false, operation: 'dot'});
}

MathObject.prototype.equals = function(f)
{
	return (this.valueOf() === f.valueOf() );
}

MathObject.prototype.greaterThan = function(f)
{
	return (this.valueOf() > f.valueOf()); 
}

MathObject.prototype.greaterEqThan = function(f)
{
	return (this.valueOf() >= f.valueOf()); 
}

MathObject.prototype.lessThan = function(f)
{
	return (this.valueOf() < f.valueOf()); 
}

MathObject.prototype.lessEqThan = function(f)
{
	return (this.valueOf() <= f.valueOf()); 
}

MathObject.prototype.isZero = function()
{
	return this.valueOf() === 0;
}

MathObject.prototype.isOne = function()
{
	return this.valueOf() === 1;
}

MathObject.prototype.isMinusOne = function()
{
	return this.valueOf() === -1;
}

MathObject.prototype.isPositive = function()
{
	return this.valueOf() >= 0;
}

MathObject.prototype.isNegative = function()
{
	return this.valueOf() < 0;
}

MathObject.prototype.opposite = function()
{
	return new mProduct( new mNumber(-1), this);
}

MathObject.prototype.minus = function(f)
{
	return this.plus(f.opposite());
}

MathObject.prototype.inverse = function()
{
	return new mNumber(1).over(f);
}

MathObject.prototype.over = function(f)
{
	return new Fraction(this,f);
}

MathObject.prototype.max = function(f)
{
	if(this.valueOf() >= f.valueOf()) return this;
	else return f;	
}

MathObject.prototype.concordant = function(f)
{
	return (this.valueOf()*f.valueOf() > 0);
}

MathObject.prototype.simplify = function()
{
	return this;
}

