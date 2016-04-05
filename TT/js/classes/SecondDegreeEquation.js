function SecondDegreeEquation (left, right)
{
	Equation.call(this,left,right);
	Solvable.call(this);
}

$.extend(SecondDegreeEquation.prototype, Equation.prototype);
$.extend(SecondDegreeEquation.prototype, Solvable.prototype);

SecondDegreeEquation.prototype.solve = function()
{
	this.addStep();
	
	this.allToLeft();
	this.addStep('Porto ogni termine al primo membro');
	
	this.left = this.left.simplify();
	this.left = this.left.order();
	this.addStep('Svolgo i calcoli al primo membro ed ordino i suoi termini');
	
	
//	if(notDecomposable)
//	{
//		var left = new Monomial(new mNumber(1),new mNumber(1));
//		var right = new Fraction(new mSum([this.left.terms]))
//	}
//	
	
	var a = this.left.terms[this.getTerms('left',new mNumber(2))[0]].terms[0].clone() || new mNumber(0);
	var b = this.left.terms[this.getTerms('left',new mNumber(1))[0]].terms[0].clone() || new mNumber(0);
	var c = this.left.terms[this.getTerms('left',new mNumber(0))[0]].clone() || new mNumber(0);
	var b2 = new Power(b,new mNumber(2));
	var delta = new mSum([b2, new mProduct([new mNumber(4), a, c])]);

	this.left = new X();
	this.right = new Fraction( new mSum( [ b.opposite(), new PM( new Root(delta) ) ] ) , new mProduct([new mNumber(2), a]) );
	this.addStep('Applico la formula risolutiva dell\'equazione di secondo grado');
	
	this.right.numerator.terms[1].argument.argument = this.right.numerator.terms[1].argument.argument.simplify();
	this.right.denominator.simplify();
	this.addStep('Svolgo i calcoli');
	
	while(this.right.numerator.terms[1].argument.argument !== this.right.numerator.terms[1].argument.argument.simplify())
	{
		this.right.numerator.terms[1].argument.argument = this.right.numerator.terms[1].argument.argument.simplify();
		this.addStep();		
	}
	
	var finalStep = new Step();
	
	if(this.right.numerator.terms[1].argument.isZero())
	{
		this.right.numerator.terms.splice(1,1);
		this.addStep();
		this.right.simplify();
		this.addStep('<b>Soluzione</b>');
	}
	else if(this.right.numerator.terms[1].argument.isNegative())
	{
		finalStep.description('<b>Non vi sono soluzioni reali</b>');
		this.solution.addStep(finalStep);
	}
	else
	{	
		this.right.numerator.terms[1].argument = this.right.numerator.terms[1].argument.simplify();
		this.addStep();		

		var finalEquations = new Array();
		finalEquations.push(new Equation(new X(), new Fraction(new mSum([b.opposite(), this.right.numerator.terms[1].argument]),this.right.denominator)));
		finalEquations.push(new Equation(new X(), new Fraction(new mSum([b.opposite(), this.right.numerator.terms[1].argument.opposite()]),this.right.denominator)));
		
		finalStep.setDescription('<b>Soluzioni</b>');
		finalStep.setFormula(new Formula([finalEquations[0].toTex(), finalEquations[1].toTex()]))
		this.solution.addStep(finalStep);
		
		finalEquations[0].right.numerator = finalEquations[0].right.numerator.simplify();
		finalEquations[1].right.numerator = finalEquations[1].right.numerator.simplify();
		
		finalStep = new Step();
		finalStep.setFormula(new Formula([finalEquations[0].toTex(), finalEquations[1].toTex()]))
		this.solution.addStep(finalStep);
		
		finalEquations[0].right = finalEquations[0].right.simplify();
		finalEquations[1].right = finalEquations[1].right.simplify();
		
		finalStep = new Step();
		finalStep.setFormula(new Formula([finalEquations[0].toTex(), finalEquations[1].toTex()]))
		this.solution.addStep(finalStep);
	}	
	
	
	
	
}
