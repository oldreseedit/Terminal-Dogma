function tex (obj, mode)
{
	var t = '';
	
	if( mode.operation === 'plus' && obj.isPositive()) t+= '+';

	if( mode.operation === 'pm') t += '\\pm';
	else if( mode.isCoefficient && obj.isMinusOne() ) t+= '-';
	
	
	if( ( mode.isCoefficient && !obj.isOne() && !obj.isMinusOne() ) || !mode.isCoefficient ) t += obj.toTex();
	
	return t;
}