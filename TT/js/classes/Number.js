Number.prototype.factorial = function()
{
	var fact = function(n)
	{
		if(n%1 !== 0) return -1;
		else
		{
			if(n===0) return 1;
			else return n*fact(n-1);
		}
	};
	
	return fact(this);
}