var Matrix = function()
{	
	this.matrix = [];
	this.nRows = 0;
	this.nCols = 0;
	this.errors = [];
	
	this.error = function(errorString)
	{
		this.errors.push(errorString);
	};
	
	this.ok = function()
	{
		return (this.errors.length === 0);
	};
	
	this.setSize= function(m,n)
	{
		if(!m || !n) return;
		
		if(this.nRows < m && m>0)
		{
			for(var i=0; i<m-this.nRows; i++)
			{
				this.matrix.push([]);
			}
		}
		
		if(this.nRows > m && m>0)
		{
			this.matrix.splice(m,this.nRows-m);
		}
		
		for(var i=0; i<m; i++)
		{
			if(this.nCols < n && n>0)
			{
				for(var j=0; j<n-this.nCols; j++)
				{
					this.matrix[i].push([]);
				}
			}
			
			if(this.nCols > n && n>0)
			{
				this.matrix[i].splice(n,this.nCols-n);
			}
			
			for(var j=0; j<n; j++)
			{
				if(i>=this.nRows || j >= this.nCols) this.matrix[i][j] = 0;
			}
		}		
		
		this.nRows = m;
		this.nCols = n;
		
	}
	
	this.pushRow = function(row)
	{
		if(this.nCols !== 0 && row.length !== this.nCols) this.error('Numero di colonne diverso dal pre-esistente');
		else
		{
			this.matrix.push(row);
			this.nRows++;
			this.nCols = row.length;	
		}		
	};
	
	this.pushCol = function(col)
	{
		if(this.nRows !== 0 && col.length !== this.nRows) this.error('Numero di righe diverso dal pre-esistente');
		else
		{
			for(var i=0; i<col.length; i++)
			{
				if(this.nRows === 0) this.matrix.push([]);
				this.matrix[i].push(col[i]);
			}
			this.nRows = col.length;
			this.nCols++;	
		}		
	};
	
	this.determinant = function()
	{
		if(this.nRows !== this.nCols) this.error('La matrice non è quadrata');
		else
		{
			var a = [];
			for(var i=0; i<this.nRows; i++)
			{
				a.push(i);
			}
			var perms = a.listOfPermutations();
			var nPerms = perms.length;
			
			var sum = 0;
			var product = 1;
			for(var i=0; i<nPerms; i++)
			{
				product = 1;
				for(var j=0; j<this.nRows; j++)
				{
					product *= this.matrix[j][perms[i][j]];
				}
				sum += ( i%2===0 ? 1 : -1)*product;
			}
			return sum;
		}
	}
	
	this.plus = function(m)
	{
		if(!m.hasOwnProperty('matrix')) this.error('L\'argomento non è una matrice');
		else if(m.nRows !== this.nRows || m.nCols !== this.nCols) this.error('Le due matrici hanno dimensioni differenti');
		else
		{
			var C = new Matrix();
			for(var i=0; i<this.nRows; i++)
			{
				var c = [];
				for(var j=0; j<this.nCols; j++)
				{
					c.push(this.matrix[i][j] + m.matrix[i][j]);
				}
				C.pushRow(c);
			}
			return C;
		}
	}
	
	this.times = function(m)
	{
		if(!m.hasOwnProperty('matrix')) this.error('L\'argomento non è una matrice');
		else if(m.nRows !== this.nCols || m.nCols !== this.nCols) this.error('Le due matrici sono incompatibili per il prodotto');
		else
		{
			var C = new Matrix();
			for(var i=0; i<this.nRows; i++)
			{
				var c = [];
				for(var j=0; j<this.nCols; j++)
				{
					var somma = 0;
					for(var k=0; k<this.nCols; k++)
					{
						somma += this.matrix[i][k]*m.matrix[k][j];
					}
					c.push(somma);
				}
				C.pushRow(c);
			}
			return C;
		}
	}
	
	this.tex = function(mode)
	{
		var tex = '';
		
		if(mode === 'inline') tex += '\\(';
		if(mode === 'standalone') tex += '\\[';
		tex += ' \\begin{pmatrix} ';
		
		for(var i=0; i<this.nRows; i++)
		{
			for(var j=0; j<this.nCols; j++)
			{
				tex += this.matrix[i][j];
				if(j < this.nCols -1) tex +=' & '; 
			}
			if(i < this.nRows - 1) tex += ' \\\\ ';
		}

		tex += ' \\end{pmatrix} ';
		if(mode === 'inline') tex += '\\)';
		if(mode === 'standalone') tex += '\\]';
		
		return tex;
	};
	
	
	
};