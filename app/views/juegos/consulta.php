//echo 'Tickets registrados: '.$tarjeta.'<br/>';	
			//echo 'Tickets registrados: '.$juego.'<br/>';	

			/*



				SELECT 
						SUBSTR(AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ), 1, 
						LOCATE(  '+', AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) )-1
						) as fig1,

						SUBSTR(AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ), 
						LOCATE(  '+', AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) )+1,
						LOCATE(  '+', AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) )-1
						) as seleccion

						
						FROM calimax_registro_participantes
			

					SELECT 
						SUBSTR(AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ), 1, 
						LOCATE(  '+', AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) )-1
						) as fig1,

						SUBSTR(AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ), 
						LOCATE(  '+', AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) )+1,
						LOCATE(  '+', AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) )-1
						) as seleccion,

						SUBSTR(AES_DECRYPT( tarjeta,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ), 
						LOCATE(  '+', AES_DECRYPT( tarjeta,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) )+1,
						LOCATE(  '-;', AES_DECRYPT( tarjeta,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) )-3
						) as estre,

						SUBSTRING_INDEX
						(							SUBSTRING_INDEX(AES_DECRYPT( tarjeta,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ),'-;',1),'+',-1

						) aaa,

						
						SUBSTRING_INDEX
						 (
						SUBSTRING_INDEX(AES_DECRYPT( tarjeta,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ),'+',-1)
						,'-;',1

						) aa22,

						LOCATE(  '+', AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) ) AS fig, 
						LOCATE(  '-', AES_DECRYPT( juego,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) ) AS sel, 
						AES_DECRYPT( juego, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) AS juego, 
						AES_DECRYPT( tarjeta,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ) AS tarjeta
						FROM calimax_registro_participantes
			








					SUBSTRING_INDEX
						(							SUBSTRING_INDEX(AES_DECRYPT( tarjeta,  
						SUBSTRING_INDEX(AES_DECRYPT( tarjeta,  'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5' ),'+',-1)
						,'-;',1

						) 
						  aqui1,
			
			$matriz = explode( ";",substr($tarjeta, 0, -1));
			
			$suma =0;
			$cant=0;
			//$ma5=date_create($ma3[0]);
			foreach ($matriz as $key => $value) {
				$ma1=explode( "+",$value);
				$ma2=explode( "-",$ma1[1]);
				
				$ma3=explode( "-",$ma2[1]);
				if ($ma1[0]==$ma2[0]) {
					$cant++;
				}
				
				$suma = ($suma==0) ? (strtotime($ma3[0])) : $suma+strtotime($ma3[0]) ; 

				


					
			} 
			echo 'Respuestas acertadas: '.$cant.'<br/>';
			echo date("i:s", $suma). "seg<br />"; //H:i:s//01:57:48
			echo "Tu resultado:<br />"; //H:i:s//01:57:48
	
			
			
			echo '<img src="'.base_url().$this->session->userdata("i".$c1).'" >';
			echo '<img src="'.base_url().$this->session->userdata("i".$c2).'" >';
			echo '<img src="'.base_url().$this->session->userdata("i".$c3).'" >';
			*/
			