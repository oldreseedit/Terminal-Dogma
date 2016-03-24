function tex (obj, mode)
{
	var t = '';
	if(mode.operation === 'dot' && !obj.isPositive()) t+= ' \\left( ';
	
	if( mode.operation === 'plus' && obj.isPositive()) t+= ' + ';
	
	if( mode.isCoefficient && obj.opposite().isOne() ) t+= ' - ';
	if( ( mode.isCoefficient && !obj.isOne() && !obj.opposite().isOne() ) || !mode.isCoefficient ) t += obj.toTex();
	
	if(mode.operation === 'dot' && !obj.isPositive()) t+= ' \\left) ';
	return t;
}