var Fraction = function(n,d)
{
	var gcd = n.gcd(d);
	
	this.numerator = Math.abs(n/gcd) || 1;
	this.denominator = Math.abs(d/gcd) || 1;
	this.sign = !n.concordant(d) ? -1 : 1;
	this.mode = 'withSign'; // default
	
	// Check denominator != 0
	
	this.tex = function(mode)
	{
		if(this.denominator === 1) return this.numerator;
		if(this.denominator === -1) return -this.numerator;
		
		this.mode = mode || this.mode;
		if(this.mode === 'withSign') return (this.sign===-1 ? '-' : '+') + '\\dfrac{' + this.numerator + '}{' + this.denominator + '}';
		else return (this.sign===-1 ? '-' : '') + '\\dfrac{' + this.numerator + '}{' + this.denominator + '}';
		
	}
	
	this.plusTex = function()
	{
		return this.tex();
	}
	
	this.dotTex = function()
	{
		return this.tex('withoutSign');
	}
	
}