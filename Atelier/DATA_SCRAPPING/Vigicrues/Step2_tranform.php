<?php

// setting the URL
$file = "http://www.vigicrues.gouv.fr/niveau3.php?CdStationHydro=U251201001&typegraphe=h&AffProfondeur=168&nbrstations=9&ong=2&Submit=Refaire+le+tableau+-+Valider+la+s%C3%A9lection";

// getting the URL
$content = file_get_contents($file);

// Create a dom Document object
$doc = new DOMDocument();

// Load content in the DOM
$doc->loadHTML($content);

// Finding first table
$table = $doc->getElementsByTagName('table')->item(0);
// Extract all rows in the table
$rows = $table->getElementsByTagName("tr");


$data = "";

foreach ($rows as $row) 
	{
	
		// for each row (TR) get all cells (TD)
		$cells = $row->getElementsByTagName('td');

		// First line include table header and there is no TD on it
		// So if there is no cells, we skip the line using continue
		if($cells->length == 0) { continue; }

		// For each cell get the values
		foreach ($cells as $cell) 
			{
				// Getting cell Value
				$cellValue = $cell->nodeValue;

				// If the cell value size match the size of a date
				if(strlen($cell->nodeValue) == 16) 
					{
						// We create a MySQL date format with the date 
						// ie. 2016-06-20 18:00 / YYYY-MM-DD HH:MM

						// Thanks to PHP we can get a date from a string
						$dateObject = date_create_from_format('d/m/Y H:i',$cellValue);

						// We use the date with our wanted format
						$cellValue = date_format($dateObject,'Y-m-d H:i:s');						

					}
				
				// adding the value to data and separate the value with a TAB (\t)
				$data .=  $cellValue."\t";
			}
			
		// remove the last unneeded TAB (\t)
		$data = rtrim($data,"\t");
		 
		// Adding a semicolon and a carriage return at the end of line 
		$data .= ";\n";
		
	}


echo $data;

?>