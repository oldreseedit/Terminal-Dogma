function Fraction (n,d)
{
	this.numerator = n || new mNumber(1);
	this.denominator = d || new mNumber(1);	
}

$.extend(Fraction.prototype, MathObject.prototype);

Fraction.prototype.valueOf = function()
{
	return this.numerator.valueOf()/this.denominator.valueOf();
}

Fraction.prototype.exists = function()
{
	return !this.denominator.isZero();
}

Fraction.prototype.opposite = function()
{
	this.numerator.opposite();
	return this;
}

Fraction.prototype.inverse = function()
{
	if(this.isZero()) return Number.Nan;
	var d = this.denominator;
	this.denominator = this.numerator;
	this.numerator = d;
	return this;
}

Fraction.prototype.simplify = function()
{
	var gcd = this.numerator.gcd(this.denominator);
	this.numerator = this.numerator.over(gcd);
	this.denominator = this.denominator.over(gcd);
	
	if(this.denominator.isOne()) return this.numerator;
	if(this.denominator.isMinusOne())
	{
		this.numerator.opposite();
		return this.numerator;
	}
	
	return this;
}

Fraction.prototype.plus = function(f)
{
	if(f instanceof Fraction)
	{
		var mcm = this.denominator.mcm(f.denominator);
		var num1 = this.numerator.dot(mcm.over(this.denominator));
		var num2 = f.numerator.dot(mcm.over(f.denominator));
		var num = num1.plus(num2);
		return new Fraction(num, mcm);		
	}
	return new mSum([this,f]);
}

Fraction.prototype.dot = function(f)
{
	if(f instanceof Fraction)	return new Fraction(this.numerator.dot(f.numerator), this.denominator.dot(f.denominator));
	return new mProduct([this,f]);
}

Fraction.prototype.toTex = function()
{	
	return '\\frac{' + this.numerator.toTex() + '}{' + this.denominator.toTex() + '}';
}

