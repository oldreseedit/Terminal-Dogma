function mFunction (argument) {
	this.argument = argument;
}

$.extend(mFunction.prototype,MathObject.prototype);

mFunction.prototype.toTex = function()
{
	return this.argument.toTex();
}