// The constructor needs an input array filled with coefficients in ascending order, e.g. [a_0, a_1, ... ] so that the formal equation is a_0 + a_1x^1 + a_2x^2 + ...

var Equation = function(coefficients)
{
	this.coefficients = [];
	this.errors = new Error();	
	
	if(coefficients)
	{
		if(typeof coefficients === 'object')
		{
			this.coefficients = coefficients;
		}
		else
		{
			this.errors.add('L\'input non è un oggetto/array.');
		}
	}
	
	this.tex= function()
	{
		var t = '';
		for(var i=0; i<this.coefficients.length; i++)
		{
			var k = this.coefficients.length-i-1;
			
			if(this.coefficients[k] !== 0)
			{
				// If coefficient is -1 then you have to add only symbol -, except it is the last one.
				if(this.coefficients[k] === -1 && k !== 0) t += '-'; 
				else
				{
					// If coefficient is 1 then you have to add nothing, just the 'x' part, except it is the last one, else just print the number.
					if(this.coefficients[k] === 1 && k===0) t += String(this.coefficients[k]);
					if(this.coefficients[k] !== 1 && k !== 0) t += String(this.coefficients[k]);
				}
				
				if(k !== 0)
				{
					t += 'x';
					if(k!== 1) t+= '^' + String(k);
					t += '+';
				}
			}			
		}
		return t;
	};
	
	this.ok = function()
	{
		return this.errors.ok();
	}

};