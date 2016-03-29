function LinearEquation (left, right)
{
	Equation.call(this,left,right);
	this.solution = new Solution();
}

$.extend(LinearEquation.prototype, Equation.prototype);


LinearEquation.prototype.getLeftZeroTerms = function()
{
	var leftZeroTerms = new Array();
	for(var i=0; i<this.left.terms.length; i++)
	{
		if(this.left.terms[i] instanceof mNumber)
		{
			leftZeroTerms.push(i);
		}
	}
	return leftZeroTerms;
}

LinearEquation.prototype.getRightOneTerms = function()
{
	var rightOneTerms = new Array();
	for(var i=0; i<this.right.terms.length; i++)
	{
		if(this.right.terms[i] instanceof Monomial)
		{
			rightOneTerms.push(i);
		}
	}	
	return rightOneTerms;
}

LinearEquation.prototype.solve = function()
{
	var step = new Step();
	
	step.setFormula(new Formula(this.toTex()));
	
	this.solution.addStep(step);
	
	step = new Step();
	
	step.setDescription('Svolgo i calcoli al primo e al secondo membro');
	
	this.simplify();
	
	step.setFormula(new Formula(this.toTex()));
	
	this.solution.addStep(step);
	
	var leftZeroTerms = this.getLeftZeroTerms();
	
	if(leftZeroTerms.length > 0)
	{
		step = new Step();
		
		for(var i=0; i<leftZeroTerms.length; i++)
		{
			this.toRight(leftZeroTerms[i],true);
		}
		
		step.setDescription('Porto i' + (leftZeroTerms.length>1 ? '' : 'l') + ' termin' + (leftZeroTerms.length>1 ? 'i' : 'e') + ' not' + (leftZeroTerms.length>1 ? 'i' : 'o') + ' al secondo membro');
		step.setFormula(new Formula(this.toTex()));
		
		this.solution.addStep(step);
		
		this.simplify();
		step = new Step();
		step.setFormula(new Formula(this.toTex()));
		this.solution.addStep(step);
	}
	
	var rightOneTerms = this.getRightOneTerms();
	
	if(rightOneTerms.length > 0)
	{
		step = new Step();		

		for(var i=0; i<rightOneTerms.length; i++)
		{
			this.toLeft(rightOneTerms[i],true);
		}

		step.setDescription('Porto i' + (rightOneTerms>1 ? '' : 'l') + ' termin' + (rightOneTerms>1 ? 'i' : 'e') + ' di primo grado al primo membro');
		step.setFormula(new Formula(this.toTex()));
		
		this.solution.addStep(step);
		
		this.simplify();
		step = new Step();
		step.setFormula(new Formula(this.toTex()));
		this.solution.addStep(step);
	}
	
	if(this.left.terms.length > 1 || this.right.terms.length > 1)
	{
		step = new Step();		
		
		this.simplify();
		
		step.setDescription('Svolgo i calcoli al primo e al secondo membro');
		step.setFormula(new Formula(this.toTex()));
		
		this.solution.addStep(step);	
	}
	
	step = new Step();
	step.setDescription('Divido tutto per \\(' + this.left.terms[0] + '\\)');
	
	var divisor = new mNumber(this.left.terms[0]);
	
	this.over(divisor,true);
	
	step.setFormula(new Formula(this.toTex()));
	this.solution.addStep(step);
	
	step = new Step();
	this.simplify();
	step.setDescription('<b> Soluzione </b>');
	step.setFormula(new Formula(this.toTex()));
	this.solution.addStep(step);
}
