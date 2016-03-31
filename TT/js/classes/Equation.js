function Equation(left,right)
{
	this.left = left;
	this.right = right || new mSum(new mNumber(0));
}

$.extend(Equation.prototype, MathObject.prototype);

Equation.prototype.exists = function()
{
	return this.left.exists() && this.right.exists();
}

Equation.prototype.simplify = function()
{
	this.left = this.left.simplify();
	this.right = this.right.simplify();
	return this;
}

Equation.prototype.plus = function(f, explicit)
{
	this.left = this.left.plus(f);
	this.right = this.right.plus(f);
	if(!explicit)
	{
		this.left = this.left.simplify();
		this.right = this.right.simplify();
	}
}

Equation.prototype.dot = function(f, explicit)
{
	this.left = this.left.dot(f);
	this.right = this.right.dot(f);
	if(!explicit)
	{
		this.left = this.left.simplify();
		this.right = this.right.simplify();
	}
}

Equation.prototype.over = function(f,explicit)
{
	this.left = this.left.over(f,explicit);
	this.right = this.right.over(f,explicit);
}

Equation.prototype.getTerms = function(side, degree)
{
	var side = (side === 'left' ? this.left : this.right);
	var terms = new Array();
	if(degree.isZero())
	{
		for(var i=0; i<side.terms.length; i++)
		{
			if(!(side.terms[i] instanceof Monomial))
			{
				terms.push(i);
			}
		}
		return terms;
	}
	else
	{
		for(var i=0; i<side.terms.length; i++)
		{
			if(side.terms[i] instanceof Monomial && side.terms[i].degree().equals(degree))
			{
				terms.push(i);
			}
		}
		return terms;
	}
}

Equation.prototype.toLeft = function(i)
{
	var opposite = this.right.terms[i].clone().opposite();
	this.left.plus(opposite);
	this.right.remove(i);
}

Equation.prototype.allToLeft = function()
{
	var k = this.right.terms.length;
	for(var i=0;i<k; i++)
	{
		this.toLeft(0);
	}
}

Equation.prototype.toRight = function(i)
{
	var opposite = this.left.terms[i].clone().opposite();
	this.right.plus(opposite);
	this.left.remove(i);
}

Equation.prototype.allToRight = function()
{
	var k = this.left.terms.length;
	for(var i=0;i<k; i++)
	{
		this.toRight(0);
	}
}

Equation.prototype.toTex = function()
{
	return this.left.toTex() + '=' + this.right.toTex();
}

