function tex (obj, mode)
{
	var t = '';
	
	if( mode.operation === 'plus' && obj.isPositive()) t+= '+';
	
	if( mode.isCoefficient && obj.opposite().isOne() ) t+= '-';
	
	if( ( mode.isCoefficient && !obj.isOne() && !obj.opposite().isOne() ) || !mode.isCoefficient ) t += obj.toTex();
	
	return t;
}