function Solution (steps)
{
	this.steps = steps || new Array();
}

$.extend(Solution.prototype, MathObject.prototype);

Solution.prototype.addStep = function(step)
{
	this.steps.push(step);
}

Solution.prototype.get = function()
{
	return this.steps;
}