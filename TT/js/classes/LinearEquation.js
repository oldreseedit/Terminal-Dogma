function LinearEquation (left, right)
{
	Equation.call(this,left,right);
	Solvable.call(this);
}

$.extend(LinearEquation.prototype, Equation.prototype);
$.extend(LinearEquation.prototype, Solvable.prototype);

LinearEquation.prototype.getLeftZeroTerms = function()
{
	return this.getTerms('left',new mNumber(0));
}

LinearEquation.prototype.getRightOneTerms = function()
{
	return this.getTerms('right',new mNumber(1));
}

LinearEquation.prototype.solve = function()
{
	this.addStep();
	
	this.simplify();
	this.addStep('Svolgo i calcoli al primo e al secondo membro');
	
	var leftZeroTerms = this.getLeftZeroTerms();
	if(leftZeroTerms.length > 0)
	{		
		for(var i=0; i<leftZeroTerms.length; i++)
		{
			this.toRight(leftZeroTerms[i]);
		}
		this.addStep('Porto i' + (leftZeroTerms.length>1 ? '' : 'l') + ' termin' + (leftZeroTerms.length>1 ? 'i' : 'e') + ' not' + (leftZeroTerms.length>1 ? 'i' : 'o') + ' al secondo membro');
		
		this.simplify();
		this.addStep();
	}
	
	var rightOneTerms = this.getRightOneTerms();
	if(rightOneTerms.length > 0)
	{
		for(var i=0; i<rightOneTerms.length; i++)
		{
			this.toLeft(rightOneTerms[i]);
		}
		this.addStep('Porto i' + (rightOneTerms>1 ? '' : 'l') + ' termin' + (rightOneTerms>1 ? 'i' : 'e') + ' di primo grado al primo membro');
		
		this.simplify();
		this.addStep();
	}
	
	var divisor = new mNumber(this.left.terms[0]);
	this.over(divisor,true);	
	this.addStep('Divido tutto per \\(' + divisor + '\\)');
	
	this.simplify();
	this.addStep('<b> Soluzione </b>');
}
