var Power = function(base, exponent)
{
	this.base = base || 1;
	this.exponent = exponent || 1;
	
	this.tex = function()
	{	
		if(exponent === 1) return base.tex();;
		
		var t = '';
		if(base instanceof Number) t += base;
		if(base instanceof Polynomial) t += '\\left(' + base.tex() + '\\right)';
		t += '^{';
		t+= exponent;
		t += '}';
		
		return t;
		
	}
	
}