// The constructor needs an input array filled with strings containing formulas in tex-format , or just a single string containing a formula in tex-format. 

function Formula (formulas)
{
	this.formulas = (formulas instanceof Array) ? formulas : (formulas ? new Array(formulas) : new Array());
	this.mode = 'equation'; // Default, it assumes also 'inline';
}
	
Formula.prototype.changeMode = function(mode)
{
	if(mode) this.mode = mode;
}

Formula.prototype.display = function(mode)
{
	if(mode) this.changeMode(mode);
	
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