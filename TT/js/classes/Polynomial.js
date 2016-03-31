// The constructor needs an input array filled with coefficients in ascending order, e.g. [a_n, a_{n-1}, ... ] so that the formal equation is a_n x^n + ... + a_0

function Polynomial (coefficients)
{
	var monomials = new Array();
	for(var i=0; i<coefficients.length-1; i++)
	{
		monomials.push(new Monomial(coefficients[i],coefficients.length-i));
	}
	monomials.push(new mNumber(coefficients[coefficients.length]));
	mSum.call(this,monomials);
	
	this.zeros = new Array();
}

$.extend(Polynomial.prototype, mSum.prototype);

Polynomial.prototype.degree = function()
{
	return this.coefficients.length -1;
}

Polynomial.prototype.solve = function()
{
	if(this.degree() === 1) this.solveLinear();
	if(this.degree() === 2) this.solveQuadratic();
	else this.decompose();
}

Polynomial.prototype.isBinomialSquare= function()
{
	if(this.degree() !== 2) return false;
	
	var sqrtA = new Root(this.coefficients[2]);
	var sqrtC = new Root(this.coefficients[0]);
	sqrtA.factorize();
	sqrtC.factorize();
	var sqrtB = sqrtA.dot(sqrtC);
	sqrtB.factorize();
	
	if(sqrtB.isInteger() && 2*sqrtB.outer === this.coefficients[1])
	{
		return new Power(new Polynomial([sqrtC.outer,sqrtA.outer]), 2 ); 
	}
	if(sqrtB.isInteger() && 2*sqrtB.outer === -this.coefficients[1])
	{
		return new Power(new Polynomial([-sqrtC.outer,sqrtA.outer]), 2 ); 
	}	
}

Polynomial.prototype.isSquareDifference = function()
{
	//TODO BETTER - It won't recognize polynomials of the form x^4 - x^2, x^6 - x^4, x^6 - x^2, etc.
	
	if(this.degree() % 2 === 1) return false;
	for(var i=1; i<this.degree(); i++)
	{
		if(this.coefficients[i] !== 0) return false;
	}
	if(this.coefficients[0].concordant(this.coefficients[this.degree()])) return false;

	var sqrtA = new Root(Math.abs(this.coefficients[this.degree()]));
	var sqrtC = new Root(Math.abs(this.coefficients[0]));
	sqrtA.factorize();
	sqrtC.factorize();
	
	if(this.coefficients[this.degree()]< 0)
	{
		var sqrtA2 = sqrtA.changeSign();
		var sqrtC2 = sqrtC;
	}
	if(this.coefficients[0] < 0)
	{
		var sqrtA2 = sqrtA;
		var sqrtC2 = sqrtC.changeSign();
	}
	
	var p = [sqrtC];
	var q = [sqrtC2];
	for(var i=1; i< this.degree()/2; i++)
	{
		p.push(0);
		q.push(0)
	}
	p.push(sqrtA);
	q.push(sqrtA2);
	
	return [new Polynomial(p), new Polynomial(q)];
}

Polynomial.prototype.isSumAndProduct = function()
{
	if(this.degree() !== 2) return false;
	if(this.coefficients[this.degree()] !== 1) return false;
	
	var divisors = this.coefficients[0].divisors();
	
	for(var i=0; i<divisors.length; i++)
	{
		for(var j=0; j<divisors.length; j++)
		{
			if(divisors[i]+divisors[j] === this.coefficients[1] && divisors[i]*divisors[j] === this.coefficients[0]) return [new Polynomial([divisors[i],1]), new Polynomial([divisors[j],1])]
		}
	}
	
	
}

Polynomial.prototype.decompose = function()
{
	var bs = this.isBinomialSquare();
	if(bs) return {result: bs, method: 'bs'};
	
	var sd = this.isSquareDifference();
	if(sd) return {p: sd[0], q: sd[1], method: 'sd'}
	
	var sap = this.isSumAndProduct();
	if(sap) return {p: sap[0], q: sap[1], method: 'sap'}
	
	return false;
}

Polynomial.prototype.solveQuadratic = function()
{
	var step = new Step();
	
	// If can be solved through simple decompositions TODO
	
	var decomposition = this.decompose();
	console.log(decomposition);
	if(decomposition)
	{
		if(decomposition.method === 'bs')
		{
			step.setDescription('Il polinomio può essere scomposto in quadrato di binomio');
			step.setFormula(new Formula(decomposition.result.tex() + '= 0'));
			this.solution.addStep(step);
			
			step = new Step();
			step.setDescription('Il quadrato di un numero è uguale a zero se e solo se il numero stesso è zero');
			step.setFormula(new Formula(decomposition.result.base.tex() + '= 0'));
			this.solution.addStep(step);
			
			decomposition.result.base.solve();
			
			this.solution.steps = this.solution.steps.concat(decomposition.result.base.solution.steps);
		}
		
		if(decomposition.method === 'sd')
		{
			step.setDescription('Il polinomio può essere scomposto in differenza di quadrati');
			step.setFormula(new Formula( '\\left( ' + decomposition.p.tex() + '\\right) \\left( ' + decomposition.q.tex() + ' \\right) = 0'));
			this.solution.addStep(step);
			
			decomposition.p.solve();
			decomposition.q.solve();
			
			for(var i=0; i<2; i++)
			{
				step = new Step();
				step.setDescription(decomposition.p.solution.steps[i].description + ' \\( \\qquad \\) ' + decomposition.q.solution.steps[i].description);
				step.setFormula(new Formula( [decomposition.p.solution.steps[i].formula.formulas[0], decomposition.q.solution.steps[i].formula.formulas[0]] ));
				
				this.solution.addStep(step);
			}
		}
		
		// TODO: Gestisci somma e prodotto!
	}
	else
	{
	
		step.setDescription('Applico la formula risolutiva dell\'equazione di secondo grado');
		step.setFormula(new Formula( 'x_{1,2} = \\dfrac{ ' + (-this.coefficients[1]) + '\\pm \\sqrt{ \\left( ' + this.coefficients[1] + ' \\right)^2 -4 ' + this.coefficients[2].dotTex() + this.coefficients[0].dotTex() + ' }  } { 2 ' + this.coefficients[2].dotTex() + ' }' ));
		
		this.solution.addStep(step);
		
		step = new Step();
		step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + (-this.coefficients[1]) + '\\pm \\sqrt{ ' + Math.pow(this.coefficients[1],2) + (-4*this.coefficients[2]*this.coefficients[0]).plusTex() + ' }  } { ' + 2*this.coefficients[2] + ' }'  ));
		
		this.solution.addStep(step);
		
		step = new Step();
		step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + (-this.coefficients[1]) + '\\pm \\sqrt{ ' + (Math.pow(this.coefficients[1],2) + (-4*this.coefficients[2]*this.coefficients[0])) + ' }  } { ' + 2*this.coefficients[2] + ' }'  ));
		
		this.solution.addStep(step);
		
		var sqrt = new Root( Math.pow(this.coefficients[1],2) + (-4*this.coefficients[2]*this.coefficients[0]) );
		sqrt.factorize();
		var sqrtDescr;
		
		if(sqrt.outer !== 1) sqrtDescr = 'Fattorizzo la radice';
		if(sqrt.argument=== 1) sqrtDescr = 'Risolvo la radice';
		
		if(sqrt.outer !== 1 || sqrt.argument === 1)
		{
			step = new Step();
			step.setDescription(sqrtDescr);
			step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + (-this.coefficients[1]) + '\\pm ' + sqrt.tex() + ' } { ' + 2*this.coefficients[2] + ' }'  ));
			
			this.solution.addStep(step);			
		}
		
		var gcd = Math.abs(sqrt.outer.gcd(this.coefficients[1]).gcd(2*this.coefficients[2]));
		
		sqrt.outer /= gcd;
		
		newB = -this.coefficients[1]/gcd;
		newC = 2*this.coefficients[2]/gcd;
			
		if(gcd !== 1)
		{
			step = new Step();		
			step.setDescription('Semplifico la frazione');
			if(newC === 1) step.setFormula(new Formula( 'x_{1,2} = ' + newB + '\\pm ' + sqrt.tex() ));
			else step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + newB + '\\pm ' + sqrt.tex() + ' } { ' + newC + '}'  )); 
			
			this.solution.addStep(step);
		}
		
		step = new Step();
		
		step.setDescription('<b>Soluzione</b>');
		
		if(newC === 1)
		{
			if(sqrt.argument === 1) step.setFormula(new Formula( ['x_1 = ' + (newB + sqrt.outer), 'x_2 = ' + (newB - sqrt.outer)]));
			else step.setFormula(new Formula( ['x_1 = ' + newB + sqrt.plusTex(), 'x_2 = ' + newB + sqrt.changeSign().plusTex()]));
		}
		else
		{
			if(sqrt.argument === 1) step.setFormula(new Formula( ['x_1 = ' + new Fraction(newB + sqrt.outer, newC).tex(), 'x_2 = ' + new Fraction(newB - sqrt.outer, newC).tex() ] )); 
			else step.setFormula(new Formula( ['x_1 = \\dfrac{ ' + newB + sqrt.plusTex() + ' } { ' + newC + '}', 'x_2 = \\dfrac{ ' + newB + sqrt.changeSign().plusTex() + ' } { ' + newC + '}'  ] )); 
		}
		
		this.solution.addStep(step);
	}
}