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
	
	this.left.simplify();
	this.left.order();
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
	console.log(a,b,c, b2, delta);

	this.left = new X(new mNumber(1));
	this.right = new Fraction( new mSum( [ b.opposite(), new PM( new Root(delta) ) ] ) , new mProduct([new mNumber(2), a]) );
	this.addStep('Applico la formula risolutiva dell\'equazione di secondo grado');
	
	this.simplify();
	this.addStep('Svolgo i calcoli al secondo membro');
	
//	
//	step = new Step();
//	step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + (-this.coefficients[1]) + '\\pm \\sqrt{ ' + Math.pow(this.coefficients[1],2) + (-4*this.coefficients[2]*this.coefficients[0]).plusTex() + ' }  } { ' + 2*this.coefficients[2] + ' }'  ));
//	
//	this.solution.addStep(step);
//	
//	step = new Step();
//	step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + (-this.coefficients[1]) + '\\pm \\sqrt{ ' + (Math.pow(this.coefficients[1],2) + (-4*this.coefficients[2]*this.coefficients[0])) + ' }  } { ' + 2*this.coefficients[2] + ' }'  ));
//	
//	this.solution.addStep(step);
//	
//	var sqrt = new Root( Math.pow(this.coefficients[1],2) + (-4*this.coefficients[2]*this.coefficients[0]) );
//	sqrt.factorize();
//	var sqrtDescr;
//	
//	if(sqrt.outer !== 1) sqrtDescr = 'Fattorizzo la radice';
//	if(sqrt.argument=== 1) sqrtDescr = 'Risolvo la radice';
//	
//	if(sqrt.outer !== 1 || sqrt.argument === 1)
//	{
//		step = new Step();
//		step.setDescription(sqrtDescr);
//		step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + (-this.coefficients[1]) + '\\pm ' + sqrt.tex() + ' } { ' + 2*this.coefficients[2] + ' }'  ));
//		
//		this.solution.addStep(step);			
//	}
//	
//	var gcd = Math.abs(sqrt.outer.gcd(this.coefficients[1]).gcd(2*this.coefficients[2]));
//	
//	sqrt.outer /= gcd;
//	
//	newB = -this.coefficients[1]/gcd;
//	newC = 2*this.coefficients[2]/gcd;
//		
//	if(gcd !== 1)
//	{
//		step = new Step();		
//		step.setDescription('Semplifico la frazione');
//		if(newC === 1) step.setFormula(new Formula( 'x_{1,2} = ' + newB + '\\pm ' + sqrt.tex() ));
//		else step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + newB + '\\pm ' + sqrt.tex() + ' } { ' + newC + '}'  )); 
//		
//		this.solution.addStep(step);
//	}
//	
//	step = new Step();
//	
//	step.setDescription('<b>Soluzione</b>');
//	
//	if(newC === 1)
//	{
//		if(sqrt.argument === 1) step.setFormula(new Formula( ['x_1 = ' + (newB + sqrt.outer), 'x_2 = ' + (newB - sqrt.outer)]));
//		else step.setFormula(new Formula( ['x_1 = ' + newB + sqrt.plusTex(), 'x_2 = ' + newB + sqrt.changeSign().plusTex()]));
//	}
//	else
//	{
//		if(sqrt.argument === 1) step.setFormula(new Formula( ['x_1 = ' + new Fraction(newB + sqrt.outer, newC).tex(), 'x_2 = ' + new Fraction(newB - sqrt.outer, newC).tex() ] )); 
//		else step.setFormula(new Formula( ['x_1 = \\dfrac{ ' + newB + sqrt.plusTex() + ' } { ' + newC + '}', 'x_2 = \\dfrac{ ' + newB + sqrt.changeSign().plusTex() + ' } { ' + newC + '}'  ] )); 
//	}
//	
//	this.solution.addStep(step);
	
	
}
