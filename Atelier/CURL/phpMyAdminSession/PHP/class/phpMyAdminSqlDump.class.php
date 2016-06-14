<?php

	class phpMyAdminSqlDump {
	
		function __construct()
			{
			
				// object settings
				$this->Settings['database'] = "julieng";
				$this->Settings['username'] = "julieng";
				$this->Settings['password'] = "XXXXXXXXXXX";

				$this->Settings['PMA_URL'] = "http://julieng.student.codeur.online/phpmyadmin/";
				$this->Settings['DB_EXPORT_SETTINGS'] = "";
				$this->Settings['COOKIE_FOLDER'] = "/tmp/";
			
			}

		/**
		 * Function name getDump
		 *
		 * Process the requests to create a session on
		 * phpmyadmin and execute the export with given 
		 * option and credentials
		 *
		 * @param string URL of the request
		 * @param array curl option key / value
		 * @param array curl request result info needed
		 * @return (array)
		 */			
		 

		public function getDump()
			{
			
				// create first request to retreive session cookie
				$url = $this->Settings['PMA_URL'];
				$this->cookieFile = $this->Settings['COOKIE_FOLDER']."cookie_".md5(microtime()).".txt";

				$options[CURLOPT_COOKIEJAR] = $this->cookieFile;
				$result = $this->curlRequest($url,$options);




				unset($options);
				
				// 2nd request to authenticate the user with cookie and credentials
				// End retrieve the session token

				
				// Setting the credential in the POST data
				$postdata = "pma_username=".$this->Settings['username']."&pma_password=".$this->Settings['password']."&server=1&target=index.php";

			 	$ch = curl_init(); 

				$options[CURLOPT_COOKIEJAR] = $this->cookieFile;
				$options[CURLOPT_COOKIEFILE] = $this->cookieFile;
				$options[CURLOPT_POSTFIELDS] = $postdata;

				$response[CURLINFO_REDIRECT_URL] = 'CURLINFO_REDIRECT_URL';

				$result = $this->curlRequest($url,$options,$response);
				$token = $this->getTokenFromUrl($result['CURLINFO_REDIRECT_URL']);
				
				
				// 3rd request, getting the dump using option , token and cookie
				$url .= "export.php";
				$postdata = 'token='.$token.'&export_type=server&export_method=quick&quick_or_custom=quick&db_select%5B%5D='.$this->Settings['database'].'&output_format=sendit&filename_template=%40SERVER%40&remember_template=on&charset_of_file=utf-8&compression=none&maxsize=&what=sql&ods_null=NULL&ods_structure_or_data=data&yaml_structure_or_data=data&htmlword_structure_or_data=structure_and_data&htmlword_null=NULL&pdf_report_title=&pdf_structure_or_data=data&latex_caption=something&latex_structure_or_data=structure_and_data&latex_structure_caption=Structure+of+table+%40TABLE%40&latex_structure_continued_caption=Structure+of+table+%40TABLE%40+%28continued%29&latex_structure_label=tab%3A%40TABLE%40-structure&latex_relation=something&latex_comments=something&latex_mime=something&latex_columns=something&latex_data_caption=Content+of+table+%40TABLE%40&latex_data_continued_caption=Content+of+table+%40TABLE%40+%28continued%29&latex_data_label=tab%3A%40TABLE%40-data&latex_null=%5Ctextit%7BNULL%7D&csv_separator=%2C&csv_enclosed=%22&csv_escaped=%22&csv_terminated=AUTO&csv_null=NULL&csv_structure_or_data=data&sql_include_comments=something&sql_header_comment=&sql_compatibility=NONE&sql_structure_or_data=structure_and_data&sql_create_table=something&sql_create_view=something&sql_procedure_function=something&sql_create_trigger=something&sql_create_table_statements=something&sql_if_not_exists=something&sql_auto_increment=something&sql_backquotes=something&sql_type=INSERT&sql_insert_syntax=both&sql_max_query_size=50000&sql_hex_for_binary=something&sql_utc_time=something&excel_null=NULL&excel_edition=win&excel_structure_or_data=data&mediawiki_structure_or_data=data&mediawiki_caption=something&mediawiki_headers=something&texytext_structure_or_data=structure_and_data&texytext_null=NULL&json_structure_or_data=data&phparray_structure_or_data=data&odt_structure_or_data=structure_and_data&odt_relation=something&odt_comments=something&odt_mime=something&odt_columns=something&odt_null=NULL&codegen_structure_or_data=data&codegen_format=0';

				unset($options);
				
				$ch = curl_init(); 

				$options[CURLOPT_COOKIEJAR] = $this->cookieFile;
				$options[CURLOPT_COOKIEFILE] = $this->cookieFile;
				$options[CURLOPT_POSTFIELDS] = $postdata;

				$result = $this->curlRequest($url,$options);

				return $result['body'];
			
			}

		/**
		 * Function name curlRequest
		 *
		 * Process a CURL request using an option array
		 * and return request result and header 
		 *
		 * @param string URL of the request
		 * @param array curl option key / value
		 * @param array curl request result info needed
		 * @return (array)
		 */			
		 
		private function curlRequest($url,$options=false,$response=false)
			{
			
				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL, $url);
				
				if($options)
					{
						
						for($i=0; $i < sizeof($options); $i++)
							{
								
								$curK = key($options);
								$curV = current($options);
								
								curl_setopt($ch, $curK, $curV); 
								
								next($options);
							
							}
					
					}
				 
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			    curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);

			    $result = curl_exec($ch); 

			    
			    if($response)
					{

						for($i=0; $i < sizeof($response); $i++)
							{
								
								$curK = key($response);
								$curV = current($response);
								
								$data[$curV] = curl_getinfo($ch, $curK);
								
								next($response);
							
							}
			    
			    	}
			  	$data["HEADER_OUT"] = curl_getinfo($ch, CURLINFO_HEADER_OUT);	
			    	
			    $data['body'] = $result;	

			    curl_close($ch); 

				return $data;			
			}	
		
		
		
		/**
		 * Function name getTokenFromUrl
		 *
		 * Get the token from a redirect URL
		 *
		 * @param string URL of redirect
		 * @return string
		 */			
		 	
		private function getTokenFromUrl($url)
			{
				$token = substr($url,strlen($url)-32);
				return $token;
			
			}	
			
	}
	

?>