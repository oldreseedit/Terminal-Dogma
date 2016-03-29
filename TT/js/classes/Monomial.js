function Monomial (c,n)
{
	mProduct.call(this,[c,new X(n)]);
}

$.extend(Monomial.prototype, mProduct.prototype);

Monomial.prototype.clone = function()
{
	return new Monomial(this.terms[0].clone(),this.terms[1].degree.clone());
}

Monomial.prototype.degree = function()
{
	return this.terms[1].degree;
}

Monomial.prototype.gcd = function(f)
{
	return this.terms[0].gcd(f);
}

Monomial.prototype.plus = function(f)
{	
	if(f instanceof Monomial)
	{
		if(f.degree().equals(this.degree())) return new Monomial(this.terms[0].plus(f.terms[0]),this.degree());
	} 
}

Monomial.prototype.over = function(f,explicit)
{
	if(!explicit) return new Monomial(this.terms[0].over(f,explicit), this.degree());
	else return new Fraction(this,f);
}