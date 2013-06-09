  
<?php
if(file_exists($folder."ModSplitReport.xls"))
		$fh = fopen($folder."ModSplitReport.xls", "a+") or die("can't open file");
		
		
fwrite($fh, "Mode Split Model \n \n") ;
fwrite($fh, "Trip Characteristics \n") ;
fwrite($fh, "In-Vehicle TravelTime\t Walking Time \t Waiting Time \t Fare Charged \t Parking Cost \t Other parameter \n") ;


// Check for mode type & display the Trip Characteristics according to values

for ($i = 0; $i < $m_nmode;$i++) 
{
	if($m_ModeName[$i]== 1)
	{
		fwrite($fh,"Car \t");
	}
	else if($m_ModeName[$i] == 2)
	{
		fwrite($fh,"Two Wheeler \t");
	}
	else if($m_ModeName[$i] == 3)
	{
		fwrite($fh,"Bus \t");
	}
	else if($m_ModeName[$i] == 4)
	{
		fwrite($fh,"Train \t");
	}
	else if($m_ModeName[$i] == 5)
	{
		fwrite($fh,"Walk \t");
	}	
	else if($m_ModeName[$i] == 6)
	{
		fwrite($fh,"Para Transit \t");
	}
	fwrite($fh,$m_txtTV[$i]." \t");
	fwrite($fh,$m_txtTW[$i]." \t");
	fwrite($fh,$m_txtTT[$i]." \t");
	fwrite($fh,$m_txtFC[$i]." \t");
	fwrite($fh,$m_txtPC[$i]." \t");
	fwrite($fh,$m_txtOP[$i]." \t \n");
	
}
fwrite($fh,"Coefficients\t".$m_txtcoTV."\t".$m_txtcoTW."\t".$m_txtcoTT."\t".$m_txtcoFC."\t".$m_txtcoPC."\t".$m_txtcoOP."\t ");
fwrite($fh,"\n");
fwrite($fh,"\n");
fwrite($fh,"\n");
								

// <!-- Calculate the Cost of travel according to selected mode -->
fwrite($fh,"Calculations \n");
$m_sumexp=0;
for ($i = 0; $i < $m_nmode;$i++) 
{
	fwrite($fh,"Cost of travel by  ");
	if($m_ModeName[$i]== 1)
	{
		fwrite($fh,"Car ");
	}
	else if($m_ModeName[$i] == 2)
	{
		fwrite($fh,"Two Wheeler ");
	}
	else if($m_ModeName[$i] == 3)
	{
		fwrite($fh,"Bus ");
	}
	else if($m_ModeName[$i] == 4)
	{
		fwrite($fh,"Train ");
	}
	else if($m_ModeName[$i] == 5)
	{
		fwrite($fh,"Walk ");
	}	
	else if($m_ModeName[$i] == 6)
	{
		fwrite($fh,"Para Transit ");
	}
	fwrite($fh,$m_txtcoTV." * ".$m_txtTV[$i]." + ".$m_txtcoTW." * ".$m_txtTW[$i]." + ".$m_txtcoTT." * ".$m_txtTT[$i]." + ".$m_txtcoFC." * ".$m_txtFC[$i]." + ".$m_txtcoPC." * ".$m_txtPC[$i]." + ".$m_txtOP[$i]." * ".$m_txtcoOP);
//	echo "&nbsp".$m_txtcoTV." * ". $m_txtTV[$i]." + ".$m_txtcoTW." * ".$m_txtTW[$i]." + ".$m_txtcoTT." * ".$m_txtTT[$i]." + ".$m_txtcoFC." * ".$m_txtFC[$i]." + ".$m_txtcoPC." * ".$m_txtPC[$i]." + ".$m_txtOP[$i]." * ".$m_txtcoOP;
	
	$m_cost[$i] = $m_txtcoTV * $m_txtTV[$i] + $m_txtcoTW * $m_txtTW[$i] + $m_txtcoTT * $m_txtTT[$i] + $m_txtcoFC * $m_txtFC[$i] + $m_txtcoPC * $m_txtPC[$i] + $m_txtOP[$i] * $m_txtcoOP;
	fwrite($fh,$m_cost[$i]."\n \n \n");
	
	$m_exp[$i] = exp(-$m_cost[$i]);
	$m_sumexp = $m_sumexp + $m_exp[$i];
	
}


// <!-- Calculate the Probability of choosing mode according to selected mode -->


for ($i = 0; $i < $m_nmode;$i++) 
{
	fwrite($fh,"Probability of choosing mode ");
	if($m_ModeName[$i]== 1)
	{
		fwrite($fh,"Car = ");
	}
	else if($m_ModeName[$i] == 2)
	{
		fwrite($fh,"Two Wheeler = ");
	}
	else if($m_ModeName[$i] == 3)
	{
		fwrite($fh,"Bus = ");
	}
	else if($m_ModeName[$i] == 4)
	{
		fwrite($fh,"Train = ");
	}
	else if($m_ModeName[$i] == 5)
	{
		fwrite($fh,"Walk = ");
	}	
	else if($m_ModeName[$i] == 6)
	{
		fwrite($fh,"Para Transit = ");
	}
	$m_pij[$i]= $m_exp[$i]/$m_sumexp;
	fwrite($fh,$m_pij[$i]."\n");
}
fwrite($fh," \n \n");
	
// <!-- Calculate the Proportion of Trips according to selected mode -->


for ($i = 0; $i < $m_nmode;$i++) 
{	
	fwrite($fh,"Proportion of Trips by ");
	if($m_ModeName[$i]== 1)
	{
		fwrite($fh,"Car = ");
	}
	else if($m_ModeName[$i] == 2)
	{
		fwrite($fh,"Two Wheeler = ");
	}
	else if($m_ModeName[$i] == 3)
	{
		fwrite($fh,"Bus = ");
	}
	else if($m_ModeName[$i] == 4)
	{
		fwrite($fh,"Train = ");
	}
	else if($m_ModeName[$i] == 5)
	{
		fwrite($fh,"Walk = ");
	}	
	else if($m_ModeName[$i] == 6)
	{
		fwrite($fh,"Para Transit = ");
	}
	$m_proportion[$i] = $m_pij[$i]* $m_trip;
	fwrite($fh,$m_pij[$i]." * ".$m_trip." = ".$m_proportion[$i]."\n  \n  \n" );
}			
	
// <!-- Calculate the Fare Collected from selected mode -->


for ($i = 0; $i < $m_nmode;$i++) 
{	
	fwrite($fh,"Fare Collected from ");
	if($m_ModeName[$i]== 1)
	{
		fwrite($fh,"Car = ");
	}
	else if($m_ModeName[$i] == 2)
	{
		fwrite($fh,"Two Wheeler = ");
	}
	else if($m_ModeName[$i] == 3)
	{
		fwrite($fh,"Bus = ");
	}
	else if($m_ModeName[$i] == 4)
	{
		fwrite($fh,"Train = ");
	}
	else if($m_ModeName[$i] == 5)
	{
		fwrite($fh,"Walk = ");
	}	
	else if($m_ModeName[$i] == 6)
	{
		fwrite($fh,"Para Transit = ");
	}
	$m_fare[$i] = $m_proportion[$i]* $m_cost[$i];
	fwrite($fh,$m_proportion[$i]." * ".$m_cost[$i]." = ".$m_fare[$i]."\n \n \n");
	
}

//<!-- Calculation to display into table format -->

fwrite($fh, "Result \n") ;
fwrite($fh, "Trip Characteristics \n") ;
fwrite($fh, "\t In-Vehicle TravelTime\t Walking Time \t Waiting Time \t Fare Charged \t Parking Cost \t Other parameter \t Cost \t exp(-Cost) \t Probability of choosing mode \t No. of Trips \n") ;
for ($i = 0; $i < $m_nmode;$i++) 
{
	
	if($m_ModeName[$i]== 1)
	{
		fwrite($fh,"Car \t");
	}
	else if($m_ModeName[$i] == 2)
	{
		fwrite($fh,"Two Wheeler \t");
	}
	else if($m_ModeName[$i] == 3)
	{
		fwrite($fh,"Bus \t");
	}
	else if($m_ModeName[$i] == 4)
	{
		fwrite($fh,"Train \t");
	}
	else if($m_ModeName[$i] == 5)
	{
		fwrite($fh,"Walk \t");
	}	
	else if($m_ModeName[$i] == 6)
	{
		fwrite($fh,"Para Transit \t");
	}
	fwrite($fh,$m_txtTV[$i]." \t");
	fwrite($fh,$m_txtTW[$i]." \t");
	fwrite($fh,$m_txtTT[$i]." \t");
	fwrite($fh,$m_txtFC[$i]." \t");
	fwrite($fh,$m_txtPC[$i]." \t");
	fwrite($fh,$m_txtOP[$i]." \t");
	fwrite($fh,$m_cost[$i]." \t");
	fwrite($fh,$m_exp[$i]." \t");
	fwrite($fh,$m_pij[$i]." \t");
	fwrite($fh,$m_proportion[$i]." \n");
	
}
fwrite($fh,"Coefficients \t");
fwrite($fh,$m_txtcoTV." \t");
fwrite($fh,$m_txtcoTW." \t");
fwrite($fh,$m_txtcoTT." \t");
fwrite($fh,$m_txtcoFC." \t");
fwrite($fh,$m_txtcoPC." \t");
fwrite($fh,$m_txtcoOP." \t");
fwrite($fh,"- \t");
fwrite($fh,"- \t");
fwrite($fh,"- \t");
fwrite($fh,"- \t ");
fwrite($fh," \n \n \n");

fclose($fh);
?>        
