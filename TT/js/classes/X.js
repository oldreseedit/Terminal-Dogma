function X (n)
{
	this.degree = n || new mNumber(1)
}

$.extend(X.prototype, MathObject.prototype);

X.prototype.valueOf = function()
{
	return 1;
}

X.prototype.isOne = function()
{
	return true;
}

X.prototype.isZero = function()
{
	return false;
}

X.prototype.toTex = function()
{
	return 'x' + (this.degree > 1 ? ('^{' + this.degree + '}') : '');
}