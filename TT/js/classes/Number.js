var mNumber = function(n)
{
	this.number = n.valueOf();
}

mNumber.prototype = Object.create(MathObject.prototype);

mNumber.prototype.valueOf = function()
{
	return this.number;
}

mNumber.prototype.numerator = function()
{
	return this.valueOf();
}

mNumber.prototype.denominator = function()
{
	return 1;
}

mNumber.prototype.inverse = function()
{
	if(this.isZero()) return Number.Nan;
	return new Fraction(new mNumber(1),this);
}

mNumber.prototype.concordant = function(f)
{
	return (f.isPositive() && this.isPositive()) || (f.opposite().isPositive() && this.opposite().isPositive())
}

mNumber.prototype.tex = function(mode)
{
	return tex(this,mode);
}

mNumber.prototype.plusTex = function(isCoefficient)
{
	return tex(this,{isCoefficient : isCoefficient || false, mode : 'plus'});
}

mNumber.prototype.dotTex = function(isCoefficient)
{
	return tex(this,{isCoefficient : isCoefficient || false, mode : 'dot'});
}

mNumber.prototype.exists = function()
{
	return true;
}

mNumber.prototype.isZero = function()
{
	return this.valueOf() === 0;
}

mNumber.prototype.isOne = function()
{
	return this.valueOf() === 1;
}

mNumber.prototype.isPositive = function()
{
	return this.valueOf() > 0;
}

mNumber.prototype.opposite = function()
{
	return new mNumber (-this.valueOf());
}

mNumber.prototype.equals = function(f)
{
	var g = f.simplify();
	if( f instanceof mNumber ) return (this.valueOf() === g.valueOf() );
	else return false;
}

mNumber.prototype.greaterThan = function(f)
{
	if(f instanceof mNumber) return (this.valueOf() > f.valueOf()); 
}

mNumber.prototype.simplify = function()
{
	return new mNumber(this.valueOf());
}

mNumber.prototype.abs = function()
{
	return new mNumber(Math.abs(this.valueOf()));
}

mNumber.prototype.gcd = function(b){
    return new mNumber(this.bezout(b.valueOf()).gcd);
    // TODO better
}

mNumber.prototype.mcm = function(b)
{
	var c;
	if(b instanceof mNumber)	c = b;
	
	var primesA = this.inPrimes();
	var primesB = c.inPrimes();
	var primesC = new Array();
	
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
			primesC = primesC.join(primesB.slice(i,primesB.length));
			i = primesB.length;
		}
		else
		{
			if(primesB[i].base.greaterThan(primesA[j].base))
			{
				primesC.push(primesA[j]);
				j++;
			}
			if(primesB[i].base.equals(primesA[j].base))
			{
				primesC.push({base: primesB[i].base, exponent: primesB[i].exponent.max(primesA[j].exponent)});
				i++;
				j++;
			}
			if(primesA[i].base.greaterThan(primesB[j].base))
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

mNumber.prototype.max = function(f)
{
	if(f instanceof mNumber) return new mNumber(Math.max(this.valueOf(), f.valueOf()));
	
	// TODO
}

mNumber.prototype.plus = function(f)
{
	if(!(f instanceof mNumber) && !(f instanceof Fraction)) return mNumber.NaN;
	if(f instanceof mNumber) return new mNumber(this.valueOf() + f.valueOf());
	return new Fraction(this).plus(new Fraction(f)).simplify();
}

mNumber.prototype.minus = function(f)
{
	return this.plus(f.opposite());
}

mNumber.prototype.dot = function(f)
{
	if(f instanceof mNumber) return new mNumber(this.valueOf()*f.valueOf());
	if(f instanceof Fraction) return new Fraction(this.dot(f.numerator),f.denominator,f.index);
	if(f instanceof Root) return new Root(f.argument,this.dot(f.outer),f.index);
//	if(f instanceof Sin) return new Sin(f.argument,this.dot(f.outer));
//	if(f instanceof Cos) return new Cos(f.argument,this.dot(f.outer));
	if(f instanceof Power) return new Power(f.base,this.dot(f.exponent));
//	if(f instanceof Log) return new Log(f.argument,this.dot(f.outer));
}

mNumber.prototype.over = function(f)
{
	if(f instanceof mNumber) return new mNumber(this.valueOf()/f.valueOf())
	return this.dot(f.inverse()).simplify();
}

mNumber.prototype.pow = function(f)
{
	if(f instanceof mNumber) return new mNumber(Math.pow(this.valueOf(),f.valueOf()));
	
	// TODO
}

mNumber.prototype.toTex = function()
{
	return this.valueOf();
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
	var primes = new Array();
	var n = this.valueOf();
	var d = 2;

	if(n<0)
	{
		primes.push({base: new mNumber(-1), exponent : new mNumber(1)});
		n *= -1;
	}
	
	while(n !== 1 && d<=n)
	{
		var factor = {base : new mNumber(d), exponent : new mNumber(0)};
		while(n%d === 0)
		{
			factor.exponent = factor.exponent.plus(new mNumber(1));
			n = n/d;
		}
		if(!factor.exponent.isZero()) primes.push(factor);
		d++;
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

