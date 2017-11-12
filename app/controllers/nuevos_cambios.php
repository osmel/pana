modelo
	 public function record_personal($data){

	$this->db->select("( CASE WHEN SUBSTR(AES_DECRYPT(r.ticket,'{$this->key_hash}'),1,4 ) = 'fac-' THEN 100 ELSE 0 END ) AS ptoface", FALSE);

views
   	record
			<p class="datos"><span class="textosdatos">TICKETS REGISTRADOS: </span><span><?php echo $record->cantidad- ($record->ptoface==100); ?></span></p>
			
			<p class="datos"><span class="textosdatos">PUNTOS TOTALES: </span><span><?php echo $record->total-100; ?></span></p>
			<p class="datos"><span class="textosdatos">Ptos facebook: </span><span><?php echo $record->ptoface; ?>	