Array.prototype.listOfPermutations = function()
{
	var perms = [];
	
	var permute = function(n,w){
		if(n === 1)
		{
			var a = [];
			for(var j=0; j<w.length; j++)
			{
				a.push(w[j]);
			}
			perms.push(a);
		}
		else
		{
			for(var i=0; i<n-1; i++)
			{
				permute(n-1,w);
				if(n%2 === 0)
				{
					var a = w[i];
					w[i] = w[n-1];
					w[n-1] = a;
				}
				else
				{
					var a = w[0];
					w[0] = w[n-1];
					w[n-1] = a;	
				}
			}
			permute(n-1,w);
		}		
	};
	
	var w = [];
	for(var i=0; i<this.length; i++)
	{
		w.push(this[i]);
	}
	
	permute(w.length, w);

	return perms;	
	
}