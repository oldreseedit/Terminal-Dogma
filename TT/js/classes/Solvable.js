function Solvable ()
{
	this.solution = new Solution();
}

Solvable.prototype.addStep = function(description)
{
	var step = new Step();
	step.setDescription(description);
	step.setFormula(new Formula(this.toTex()));
	this.solution.addStep(step);
}