var Fraction = function(n,d)
{
	this.numerator = 1;
	this.denominator = 1;
	
	if(typeof n === 'number' && typeof d === 'number' )
	{
		var gcd = n.gcd(d);
		
		this.numerator = Math.abs(n/gcd);
		this.denominator = Math.abs(d/gcd);
		this.sign = !n.concordant(d) ? -1 : 1;
	}
	if(n instanceof Root && d instanceof Root)
	{
		this.numerator = n.abs();
		this.denominator = d.abs();
		this.sign = (n.outer).concordant(d.outer) ? 1 : -1;
	}
	if(n instanceof Root && typeof d === 'number' )
	{
		this.numerator = n.abs();
		this.denominator = d.abs();
		this.sign = (n.outer).concordant(d) ? 1 : -1;
	}
	if(typeof n === 'number' && d instanceof Root)
	{
		this.numerator = n.abs();
		this.denominator = d.abs();
		this.sign = n.concordant(d.outer) ? 1 : -1;
	}
	
	this.mode = 'withoutSign'; // default
	
	// Check denominator != 0
	
	this.changeSign = function()
	{
		var f = new Fraction(this.numerator, this.denominator)
		f.sign = f.sign.changeSign();
		return f;
	}
	
	this.tex = function(mode)
	{
		if(this.denominator === 1) return this.numerator;
		if(this.denominator === -1) return -this.numerator;
		
		this.mode = mode || this.mode;
		if(this.mode === 'withSign') return (this.sign===-1 ? '-' : '+') + '\\dfrac{' + this.numerator + '}{' + this.denominator + '}';
		else return (this.sign===-1 ? '-' : '') + '\\dfrac{' + this.numerator.tex() + '}{' + this.denominator.tex() + '}';
		
	}
	
	this.plusTex = function()
	{
		return this.tex('withSign');
	}
	
	this.dotTex = function()
	{
		return this.tex();
	}
	
}