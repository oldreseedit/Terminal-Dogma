var Step = function(step)
{
	this.formula = new Formula();
	this.description = '';
	
	this.setFormula = function(formula)
	{
		this.formula = formula;
	}
	
	this.setDescription = function(description)
	{
		this.description = description;
	}

}