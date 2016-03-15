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
		if(this.nRows < m)
		{
			for(var i=0; i<m-this.nRows; i++)
			{
				this.matrix.push([]);
			}
			this.nRows = m;
		}
		
		if(this.nRows > m)
		{
			this.matrix.splice(m,this.nRows-m);
			this.nRows = m;
		}
		
		for(var i=0; i<m; i++)
		{
			if(this.nCols < n)
			{
				for(var j=0; j<n-this.nCols; j++)
				{
					this.matrix[j].push([]);
				}
				this.nCols = n;
			}
			
			if(this.nCols > n)
			{
				this.matrix[i].splice(n,this.nCols-n);
				this.nCols = n;
			}
			
			for(var j=0; j<n; j++)
			{
				this.matrix[i][j] = 0;
			}
		}		
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
	
	this.display = function(mode)
	{
		if(this.nRows === this.nCols === 0) return '';
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