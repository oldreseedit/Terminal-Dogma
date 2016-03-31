function PM(argument)
{
	this.argument = argument || new mNumber(0);
}

$.extend(PM.prototype, MathObject.prototype);

PM.prototype.toTex = function()
{
	return '\\pm' + this.argument.toTex(); 
}