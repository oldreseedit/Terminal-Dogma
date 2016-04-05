function Monomial (c,n)
{
	mProduct.call(this,[c,new Power(new X(),new mNumber(n))]);
}

$.extend(Monomial.prototype, mProduct.prototype);

Monomial.prototype.clone = function()
{
	return new Monomial(this.terms[0].clone(),this.terms[1].exponent.clone());
}

Monomial.prototype.degree = function()
{
	return this.terms[1].exponent;
}

Monomial.prototype.gcd = function(f)
{
	return this.terms[0].gcd(f);
}

Monomial.prototype.plus = function(f,implicit)
{	
	if(f instanceof Monomial && implicit)
	{
		if(f.degree().equals(this.degree())) return new Monomial(this.terms[0].plus(f.terms[0]),this.degree());
	}
	return new mSum(this,f);
}

Monomial.prototype.over = function(f,implicit)
{
	if(implicit) return new Monomial(this.terms[0].over(f,explicit), this.degree());
	else return new Fraction(this,f);
}