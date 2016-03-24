var Fraction = function(n,d)
{
	this.numerator = n || new mNumber(1);
	this.denominator = d || new mNumber(1);	
}

Fraction.prototype = Object.create(MathObject.prototype);

Fraction.prototype.exists = function()
{
	return !this.denominator.isZero();
}

Fraction.prototype.isZero = function()
{
	return this.numerator.isZero();
}

Fraction.prototype.isOne = function()
{
	return (this.numerator.isEqual(this.denominator) && this.isPositive());
}

Fraction.prototype.isPositive = function()
{
	return this.numerator.concordant(this.denominator);
}

Fraction.prototype.opposite = function()
{
	var f = new Fraction(this.numerator.opposite(), this.denominator)
	return f;
}

Fraction.prototype.inverse = function()
{
	var f = new Fraction(this.denominator, this.numerator);
	if(f.exists()) return f;
	else return Number.Nan;
}

Fraction.prototype.equals = function(f)
{
	var g = f.simplify();
	var h = this.simplify();
	return (  h.numerator.equals(g.numerator) && g.denominator.equals(g.denominator)  );
}

Fraction.prototype.simplify = function()
{
	var gcd = this.numerator.gcd(this.denominator);
	var num = this.numerator.over(gcd);
	var den = this.denominator.over(gcd);
	if(den.isOne()) return num;
	return new Fraction(this.numerator.over(gcd), this.denominator.over(gcd));
}

Fraction.prototype.abs = function()
{
	return new Fraction(this.numerator.abs(), this.denominator.abs());
}

Fraction.prototype.plus = function(f)
{
	var mcm = this.denominator.mcm(f.denominator);
	var num1 = this.numerator.dot(mcm.over(this.denominator));
	var num2 = f.numerator.dot(mcm.over(f.denominator));
	var num = num1.plus(num2);
	return new Fraction(num, mcm);
}

Fraction.prototype.minus= function(f)
{
	return this.plus(f.opposite());
}

Fraction.prototype.dot = function(f)
{
	return new Fraction(this.numerator.dot(f.numerator), this.denominator.dot(f.denominator));
}

Fraction.prototype.over = function(f)
{
	return this.dot(f.inverse());
}

Fraction.prototype.gcd = function(f)
{
	// TODO
}

Fraction.prototype.mcm = function(f)
{
	// TODO
}

Fraction.prototype.toTex = function()
{
	if(this.denominator.isOne()) return this.numerator.toTex();
	if(this.denominator.opposite().isOne()) return this.numerator.opposite().toTex();
	
	return (!this.isPositive() ? '-' : '') + '\\dfrac{' + this.numerator.toTex() + '}{' + this.denominator.toTex() + '}';
}