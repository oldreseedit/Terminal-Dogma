function PM(argument)
{
	this.argument = argument || new mNumber(0);
}

$.extend(PM.prototype, MathObject.prototype);

PM.prototype.simplify = function()
{
	console.log(this.argument);
	this.argument = this.argument.simplify();
	console.log(this.argument);
	return this;
}

PM.prototype.toTex = function()
{
	return '\\pm' + this.argument.toTex(); 
}