// The constructor needs an input array filled with coefficients in ascending order, e.g. [a_0, a_1, ... ] so that the formal equation is a_0 + a_1x^1 + a_2x^2 + ...

var Polynomial = function(coefficients)
{
	this.coefficients = [];
	this.errors = new MathError();
	this.solution = new Solution();
	
	this.generate = function(degree)
	{
		if(degree === 1) this.generateLinear();
		if(degree === 2) this.generateQuadratic();
	}
	
	this.generateQuadratic = function()
	{
		for(var i=0; i<3; i++)
		{
			this.coefficients[i] = Math.floor((Math.random() * 10) + 1);
			this.coefficients[i] *= Math.random() < 0.5 ? -1 : 1;
		}
	}
	
	if(coefficients)
	{
		if(Array.isArray(coefficients))
		{
			this.coefficients = coefficients;
		}
		else
		{
			this.errors.add('L\'input non è un oggetto/array.');
		}
	}
	else this.generate(2);
	

	
	this.degree = function()
	{
		return this.coefficients.length -1;
	}
	
	this.tex= function()
	{
		var t = '';
		for(var i=0; i<this.coefficients.length; i++)
		{
			var k = this.coefficients.length-i-1;
			
			if(this.coefficients[k] !== 0)
			{
				if(this.coefficients[k] !== 1 && k === this.coefficients.length-1) t += this.coefficients[k];
				if(this.coefficients[k] !== 1 && this.coefficients[k] != -1 && k !== this.coefficients.length-1) t += this.coefficients[k].plusTex();
				if(this.coefficients[k] === -1 && k !== this.coefficients.length-1) t+= '-';
				
				if(k !== 0)
				{
					t += 'x';
					if(k!== 1) t+= '^' + k;
				}
			}			
		}
		return t;
	};
	
	this.solve = function()
	{
		if(this.degree() === 1) this.solveLinear();
		if(this.degree() === 2) this.solveQuadratic();
		else this.errors.add('Equazione di grado troppo alto');
	}
	
	this.solveLinear = function()
	{
		var step = new Step();
		
		step.setDescription('Porto il termine noto al secondo membro');
		step.setFormula(new Formula(this.coefficients[1] + 'x = ' + (-this.coefficients[0]) ));
		this.solution.addStep(step);
		
		step = new Step();
		
		step.setDescription('Divido tutto per ' + this.coefficients[1]);
		var fraction = new Fraction(-this.coefficients[0], this.coefficients[1]);
		step.setFormula(new Formula( 'x = ' + fraction.tex() ));
		this.solution.addStep(step);
	}
	
	this.solveQuadratic = function()
	{
		var step = new Step();
		
		// If can be solved through simple decompositions
		
		// Else normal formula
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
		
		if(gcd !== 1)
		{
			sqrt.outer = sqrt.outer/gcd;
			
			step = new Step();
			
			step.setDescription('Semplifico la frazione');
			
			if( 2*this.coefficients[2]/gcd === 1 )
			{
				step.setFormula(new Formula( 'x_{1,2} = ' + (-this.coefficients[1]/gcd) + '\\pm ' + sqrt.tex() ));
			}
			else
			{
				step.setFormula(new Formula(  'x_{1,2} = \\dfrac{ ' + (-this.coefficients[1]/gcd) + '\\pm ' + sqrt.tex() + ' } { ' + 2*this.coefficients[2]/gcd + '}'  )); 
			}
			
			this.solution.addStep(step);	
		}		
	}
	
	this.ok = function()
	{
		return this.errors.ok();
	}

};