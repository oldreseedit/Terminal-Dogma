// The constructor needs an input array filled with Steps classes or a single Step class

var Solution = function(steps)
{
	this.steps = [];
	this.errors = new MathError();
	
	if(steps)
	{
		if(Array.isArray(steps)) this.steps = steps;
		else this.addStep(steps);
	}
	
	this.addStep = function(step)
	{
		this.steps.push(step);
	}
	
	this.get = function()
	{
		return this.steps;
	}
	
	this.ok = function()
	{
		return this.errors.ok();
	}
	
	
};