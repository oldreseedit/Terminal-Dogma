function mNumber (n)
{
	this.number = n.valueOf();
}

$.extend(mNumber.prototype, MathObject.prototype);
	
mNumber.prototype.clone = function()
{
	return new mNumber(this.number);
}

mNumber.prototype.valueOf = function()
{
	return this.number;
}

mNumber.prototype.exists = function()
{
	return true;
}

mNumber.prototype.opposite = function()
{
	this.number = -this.number;
	return this;
}

mNumber.prototype.gcd = function(b){
    return new mNumber(this.bezout(b.valueOf()).gcd);
}

mNumber.prototype.mcm = function(b)
{
	
	var primesA = this.inPrimes();
	var primesB = b.inPrimes();
	var primesC = new Array();
	
//	console.log(primesA, primesB);
	
	var i = 0, j=0;
	
	while(i < primesB.length || j < primesA.length)
	{
		if(i === primesB.length)
		{
			primesC = primesC.concat(primesA.slice(j,primesA.length));
			j = primesA.length;
		}
		else if(j === primesA.length)
		{
			primesC = primesC.concat(primesB.slice(i,primesB.length));
			i = primesB.length;
		}
		else
		{
			if(primesB[i].base.greaterThan(primesA[j].base))
			{
				primesC.push(primesA[j]);
				j++;
			}
			else if(primesB[i].base.equals(primesA[j].base))
			{
				primesC.push({base: primesB[i].base, exponent: primesB[i].exponent.max(primesA[j].exponent)});
				i++;
				j++;
			}
			else if(primesA[i].base.greaterThan(primesB[j].base))
			{
				primesC.push(primesB[i]);
				i++;
			}
		}	
	}
	
	var result = new mNumber(1);
	for(var i=0; i<primesC.length; i++)
	{
		result = result.dot( primesC[i].base.pow(primesC[i].exponent) );
	}
	
	return result;
}

mNumber.prototype.plus = function(f)
{
	if(f instanceof mNumber) return new mNumber(this.valueOf() + f.valueOf());
	return new mSum([this,f]);
}

mNumber.prototype.dot = function(f)
{
	if(f instanceof mNumber) return new mNumber(this.valueOf()*f.valueOf());
	return new mProduct([this,f]);
}

mNumber.prototype.over = function(f, explicit)
{
	if(!explicit) return new mNumber(this.valueOf()/f.valueOf());
	else return new Fraction(this,f);
}

mNumber.prototype.pow = function(f)
{
	if(f instanceof mNumber) return new mNumber(Math.pow(this.valueOf(),f.valueOf()));
	else return new Power(this,f);
}

mNumber.prototype.factorial = function()
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
	
	return mNumber(fact(this.valueOf()));
}

mNumber.prototype.bezout = function(b,c){ // di modo che risulti c = k_1 * a + k_2 * b
    c = c || new mNumber(1);
    
    var temp, q;
    var s=0, sold=1, t=1, told=0, r=b.valueOf(), rold=this.valueOf();
    
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
        k1 : new mNumber(k1),
        k2 : new mNumber(k2),
        gcd : new mNumber(rold)
    };
}

mNumber.prototype.inPrimes = function()
{
	if(this.isOne()) return [{base: new mNumber(1), exponent: new mNumber(1)}];
	
	var primes = new Array();
	var n = this;
	var d = new mNumber(2);

	if(n.lessThan(0))
	{
		primes.push({base: new mNumber(-1), exponent : new mNumber(1)});
		n.dot(new mNumber(1));
	}
	
	while(!n.isOne() && n.greaterEqThan(d))
	{
		var factor = {base : new mNumber(d), exponent : new mNumber(0)};
		while(n.isDivisible(d))
		{
			factor.exponent = factor.exponent.plus(new mNumber(1));
			n = n.over(d);
		}
		if(!factor.exponent.isZero()) primes.push(factor);
		d = d.plus(new mNumber(1));
	}
	
	return primes;
}

mNumber.prototype.divisors = function()
{
	var divisors = [new mNumber(1), new mNumber(-1)];
	for(var i=2; i<=this.valueOf()/2; i++)
	{
		if(this.valueOf() % i === 0)
		{
			divisors.push( new mNumber(i) );
			divisors.push( new mNumber(-i) );
		}
	}
	divisors.push( this );
	divisors.push( this.opposite() );
	
	return divisors;
}

mNumber.prototype.isDivisible = function(f)
{
	return (this.valueOf() % f.valueOf() === 0);
}

mNumber.prototype.toTex = function(withoutSign)
{
	return withoutSign ? Math.abs(this.number) : this.number;
}
