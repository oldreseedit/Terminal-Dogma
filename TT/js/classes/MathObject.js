var MathObject = function(){}

MathObject.prototype.inverse = function()
{
	if(this.isZero()) return Number.Nan;
	return new Fraction( new mNumber(1),this);
}

MathObject.prototype.concordant = function(f)
{
	return (f.isPositive() && this.isPositive()) || (f.opposite().isPositive() && this.opposite().isPositive())
}

MathObject.prototype.tex = function(mode)
{
	return tex(this,mode);
}

MathObject.prototype.plusTex = function(isCoefficient)
{
	return tex(this,{isCoefficient : isCoefficient || false, mode : 'plus'});
}

MathObject.prototype.dotTex = function(isCoefficient)
{
	return tex(this,{isCoefficient : isCoefficient || false, mode : 'dot'});
}