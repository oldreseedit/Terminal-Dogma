var MathError = function()
{
	this.errors= [];
	
	this.add = function(error)
	{
		this.errors.push(error);
	}
	
	this.ok = function()
	{
		if(this.errors.length === 0) return true;
		else return false;
	}
};