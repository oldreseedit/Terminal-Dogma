// The constructor needs an input array filled with strings containing formulas in tex-format , or just a single string containing a formula in tex-format. 

var Formula = function(formulas)
{
	this.formulas = [];
	this.mode = 'equation'; // Default, it assumes also 'inline';
	this.errors = new MathError();
	
	if(formulas)
	{
		if(formulas instanceof Array) this.formulas = formulas;
		else if(typeof formulas === 'string') this.formulas.push(formulas);
		else this.errors.add('Input non compatibile.');
	}
	
	this.changeMode = function(mode)
	{
		if(mode !== 'inline' && mode !== 'equation') this.errors.add('Modalità inesistente');
		else this.mode = mode;
	}
	
	this.ok = function()
	{
		return this.errors.ok();
	}
	
	this.display = function()
	{
		var t = '';
		if(this.mode === 'equation') t+= '\\[';
		if(this.mode === 'inline') t+= '\\(';
		
		for(var i=0; i<this.formulas.length; i++)
		{
			t+= this.formulas[i];
			if(i!== this.formulas.length-1) t += ' \\qquad ';
		}
		
		if(this.mode === 'equation') t+= '\\]';
		if(this.mode === 'inline') t+= '\\)';
		
		return t;
	}

}