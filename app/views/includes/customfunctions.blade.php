<?php
############################ ConvertDateMySQLNorm #############################
Function ConvertDateMySQLNorm($date)
{
	$datetmp = explode('-', $date);
	$datenormal = $datetmp[1].'/'.substr ($datetmp[2],-2).'/'.$datetmp[0];

	return $datenormal;
}

############################ ConvertDateNormMySQL #############################
Function ConvertDateNormMySQL($date)
{
	$datetmp = explode('-', $date);
	$datemysql = $datetmp[2].'/'.$datetmp[0].'/'.$datetmp[1];

	return $datemysql;
}