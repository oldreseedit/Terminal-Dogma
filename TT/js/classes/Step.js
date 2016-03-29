function Step (step)
{
	this.formula = new Formula();
	this.description = '';
}

$.extend(Step.prototype, MathObject.prototype);
	
Step.prototype.setFormula = function(formula)
{
	this.formula = formula;
}

Step.prototype.setDescription = function(description)
{
	this.description = description;
}

Step.prototype.getFormula = function()
{
	return this.formula;
}

Step.prototype.getDescription = function()
{
	return this.description;
}