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

Number.prototype.concordant = function(n)
{
	if(this*n > 0) return true;
	else return false;
}

Number.prototype.bezout = function(b,c){ // di modo che risulti c = k_1 * a + k_2 * b
    c = c || 1;
    
    var temp, q;
    var s=0, sold=1, t=1, told=0, r=b, rold=this;
    
    while(r != 0)
    {
        q = (rold - rold%r)/r;
        
        temp = r;
        r = rold - q*r;
        rold = temp;
        
        temp = s;
        s = sold - q*s;
        sold = temp;
        
        temp = t;
        t = told - q*t;
        told = temp;
    }
    
    /*  I coefficienti di Bezout sono sold e told, l'MCD è rold, n/MCD = t, n-1/MCD = s */
    /*  Questo vuol dire che l'identità di Bezout è rold = sold*n + told*(n-1), e per ottenere l'equazione voluta devo moltiplicare tutto per c/rold. */
    
    var k1 = sold*c/rold;
    var k2 = told*c/rold;
    
    return {
        k1 : k1,
        k2 : k2,
        gcd : rold
    };
}

// Restituisce l'MCD tra due numeri.
Number.prototype.gcd = function(b){
    return this.bezout(b).gcd;
}

Number.prototype.plusTex = function()
{
	return (this>0 ? '+' : '-') + this;
}

Number.prototype.dotTex = function()
{
	return '\\cdot ' + (this<0 ? '\\left( ' + this + ' \\right)' : this);
}

Number.prototype.inPrimes = function()
{
	var primes = [];
	var n = new Number(this);
	var d = 2;
	
	while(n !== 1 && d<=n)
	{
		var factor = {base : d, exponent : 0};
		while(n%d === 0)
		{
			factor.exponent++;
			n /= d;
		}
		if(factor.exponent !== 0) primes.push(factor);
		d++;
	}
	
	return primes;
	
}

