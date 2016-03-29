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
	if(!explicit) this.simplify();
}

Equation.prototype.over = function(f,explicit)
{
	this.left = this.left.over(f,explicit);
	this.right = this.right.over(f,explicit);
}

Equation.prototype.toLeft = function(i,explicit)
{
	var opposite = this.right.terms[i].clone();
	opposite.opposite();
	this.plus(opposite,explicit);
}

Equation.prototype.toRight = function(i,explicit)
{
	var opposite = this.left.terms[i].clone();
	opposite.opposite();
	this.plus(opposite, explicit);
}

Equation.prototype.toTex = function()
{
	return this.left.toTex() + '=' + this.right.toTex();
}

