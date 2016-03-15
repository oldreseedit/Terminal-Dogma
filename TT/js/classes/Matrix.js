var Matrix = function()
{	
	this.matrix = [[0]];
	this.nRows = 1;
	this.nCols = 1;
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
		if(this.nCols !== 1 && row.length !== this.nCols) this.error('Numero di colonne diverso dal pre-esistente');
		else
		{
			this.matrix.push(row);
			this.nRows++;
			this.nCols = row.length;	
		}		
	};
	
	this.pushCol = function(col)
	{
		if(this.nRows !== 1 && col.length !== this.nRows) this.error('Numero di righe diverso dal pre-esistente');
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
	
	this.display = function(mode)
	{
		var tex;
		
		tex = (mode === 'inline' ? '\\(' : '\\[');
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
		tex += (mode === 'inline' ? '\\)' : '\\]');
		return tex;
	};
	
	
	
};