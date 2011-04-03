<?php

	/* Warning - this file is taken from some quick prototyping work
	 * and is meant for inspirational use only. Don't throw this on
	 * prod, as you might break something.
	 */

	
	// Include the Search Core file.
	include_once ( 'search.php' );
	
	// Declare the Search Core Class.
	$CSearch = new CSearch();

	// Simple check to see if there was a q param.
	if ( !isset($_GET['q'] ) ) {
		// Output the default 
		?>
		<form action='/' method='get'>
		
			<input name='q' type='textbox' value='search' size='20' />
			<input type='submit' name='po_qls' value='search' />
			
		</form>
		<? 
	}
	
	// Check to see if the executed search worked and print the result.
	if ( $CSearch->LoadSearch($_GET['q'],$_GET['start'],$_GET['num'],$_GET['sort']) ) {
		$Output = $CSearch->ExecuteSearch();
		print_r($Output);
	}
	else {
		// There was an error
		echo "There was an internal search error.";
	}
?>