<?php 

session_start();

require_once("db.php");

header('Content-type: text/html; charset=iso-8859-1');

$acao = addslashes($_POST['api']);

switch($acao){

## INSERIR TEMPO DO CLIENTE NA TELA - ONLINE
case "online":

$etapa = addslashes($_POST["cliente"]);
		
 	    $time = time()+15;
		$ip = base64_encode($_SERVER['REMOTE_ADDR']);
		date_default_timezone_set('America/Sao_Paulo');
        $hora = date('H:i:s');
	    		
		function via(){
		if( !empty($_SERVER['HTTP_USER_AGENT']) ) {
		$agents = array('iPhone','iPad','Android','webOS','BlackBerry','iPod','Symbian','Windows Phone');
		foreach($agents as $thedetec)
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], $thedetec) !== false){
		 return $thedetec;
		}
		}	 
        }
		
		$acesso = via(); 

		if($acesso==NULL){
		$dispositivo = "computador";
		}else{
		$dispositivo = $acesso;
		}
		
		##==========================

        function detecIp($consulta){
		if($consulta=="::1" || $consulta=="127.0.0.1"){
		$cidade = "Localhost"; 
		$estado = "Localhost"; 
		return $cidade . "|" . $estado; 
		}else{
		$r = json_decode(file_get_contents("http://ip-api.com/json/$consulta")); 		
		
		if($r->status=="fail"){
		$cidade = "Nao localizado";
		$estado = "Nao localizado";
		  
		return $cidade . "|" . $estado; 
		}else{
		
		$cidade = $r->city; 
		$estado = $r->regionName; 
		
		return $cidade . "|" . $estado; 
		}
		}
		}
		
		$consulta = $_SERVER['REMOTE_ADDR'];
		
		
		$sqlx = mysqli_query($conn, "SELECT * from online WHERE ip='$ip'");
		if(mysqli_num_rows($sqlx) > 0){
			  	
		$sql = mysqli_query($conn, "SELECT * from online WHERE ip='$ip'");
		 while($row = mysqli_fetch_array($sql)){ 
		   	   $situacao = $row["situacao"];
		      }
			  
		if($situacao=="ativo"){
		$query = mysqli_query($conn, "UPDATE online SET etapa='$etapa', time='$time' WHERE ip='$ip'");
		echo "0";
		}
		else if($situacao=="desativo"){
		echo "1";
		}else{
		echo "1";
		}
				
		}else{
		
		$result = detecIp($consulta);
		$quebra = explode("|", $result);
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$query = mysqli_query($conn, "INSERT INTO online (ip, etapa, time, cidade, estado, dispositivo, hora, situacao) VALUES ('$ip', '$etapa', '$time', '".$quebra[0]."', '".$quebra[1]."', '$dispositivo', '$hora', 'ativo')");
        
		}
		
	    
 
break;

## PASSO 1 - INSERIR DADOS DO CLIENTE
case "checkout":

$nome = addslashes($_POST["nome"]);
$email = addslashes($_POST["email"]);
$cpf = addslashes($_POST["cpf"]);
$celular = addslashes($_POST["celular"]);
$ip = base64_encode($_SERVER['REMOTE_ADDR']);

$sql = mysqli_query($conn, "SELECT * from clientes WHERE ip='$ip'");
 if(mysqli_num_rows($sql) > 0){
 $query = mysqli_query($conn, "UPDATE clientes SET nome='$nome', email='$email', cpf='$cpf', celular='$celular' WHERE ip='$ip'");
 $session_checkout = time() + 1000;
 $_SESSION['session_checkout'] = $session_checkout;
 echo "ok";
 }else{
 $query = mysqli_query($conn, "INSERT INTO clientes (nome,email,cpf,celular,ip) VALUES ('$nome','$email','$cpf','$celular', '$ip')");
 $session_checkout = time() + 1000;
 $_SESSION['session_checkout'] = $session_checkout;
 echo "ok";
}

break;

## PASSO 2 - INSERIR DADOS DO ENDEREÇO DO CLIENTE
case "address":

$cep = addslashes($_POST["cep"]);
$endereco = addslashes($_POST["endereco"]);
$numero = addslashes($_POST["numero"]);
$bairro = addslashes($_POST["bairro"]);
$cidade = addslashes($_POST["cidade"]);
$complemento = addslashes($_POST["complemento"]);
$destinatario = addslashes($_POST["destinatario"]);
$ip = base64_encode($_SERVER['REMOTE_ADDR']);

 $query = mysqli_query($conn, "UPDATE clientes SET cep='$cep', endereco='$endereco', numero='$numero', bairro='$bairro', cidade='$cidade', complemento='$complemento', destinatario='$destinatario' WHERE ip='$ip'");
 if($query){
 $session_address = time() + 1000;
 $_SESSION['session_address'] = $session_address;
 echo "ok";
 }else{
 echo "error";
 }
 
break;

case "dadosUsuario":
$ip = base64_encode($_SERVER['REMOTE_ADDR']);

$sql = mysqli_query($conn, "SELECT * from clientes WHERE ip='$ip'");
		
		 while($row = mysqli_fetch_array($sql)){ 
		   	   $id = $row["id"];
		   	   $nome = $row["nome"];
		   	   $email = $row["email"];
		   	   $cpf = $row["cpf"];
		      }
 
         echo "$nome|$email|$cpf";

break;

case "dadosEndereco":
$ip = base64_encode($_SERVER['REMOTE_ADDR']);

$sql = mysqli_query($conn, "SELECT * from clientes WHERE ip='$ip'");
		
		 while($row = mysqli_fetch_array($sql)){ 
		   	   
			   $endereco = $row["endereco"];
			   $numero = $row["numero"];
			   $bairro = $row["bairro"];
			   $cidade = $row["cidade"];
		   	   $cep = $row["cep"];
		   	  
		      }
 
         echo "$endereco|$numero|$bairro|$cidade|$cep";

break;


case "pixgerado":
		
		$valor = addslashes($_POST["valor"]);
		$item = addslashes($_POST["idItem"]);
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$ip = $_SERVER['REMOTE_ADDR'];
		date_default_timezone_set('America/Sao_Paulo');
        $hora = date('H:i:s');
		$tempo = time()+30;
		$query = mysqli_query($conn, "INSERT INTO pixgerado (ip, useragent, valor, produto, hora, time) VALUES ('$ip', '$useragent', '$valor', '$item', '$hora', '$tempo')");
		
		break;

		
		
		
case "gerarpix": //###################################################################################################
$valores = addslashes($_POST["pFinal"]);
$quantia = addslashes($_POST["ptotal"]);
$codigo_produto = addslashes($_POST["codigo"] ?? '');
$nome_produto   = addslashes($_POST["nome_produto"] ?? 'Produto');
if(strlen($valores) > 7 ){
$Alterado1 = str_replace(".", "", $valores);
$valorAlterado = str_replace(",", ".", $Alterado1);
}else{
$valorAlterado = str_replace(",", ".", $valores);
}
     $sql = mysqli_query($conn, "SELECT * from pix WHERE id='1'");
	 if(mysqli_num_rows($sql) > 0){
     while($row = mysqli_fetch_array($sql)){ 
	 
			 $chave = $row["chave"];
			 $cidade = $row["cidade"];
			 $descricao = $row["descricao"];
			 $identificador = $row["identificador"];
			 $beneficiario = $row["beneficiario"];
			 $use_freepay = (int)($row["use_freepay"] ?? 0);
     }

	 // -------------------------------------------------------
	 // INTEGRACAO FREEPAY: Se ativa, gerar PIX via gateway
	 // -------------------------------------------------------
	 if ($use_freepay === 1) {
		 require_once("freepay.php");

		 // Recuperar dados do cliente pelo IP
		 $ip_cliente = base64_encode($_SERVER['REMOTE_ADDR']);
		 $sql_cli    = mysqli_query($conn, "SELECT * FROM clientes WHERE ip='$ip_cliente' ORDER BY id DESC LIMIT 1");
		 $dados_cli  = mysqli_fetch_assoc($sql_cli);

		 $customer_data = [
			 'nome'     => $dados_cli['nome']     ?? 'Cliente',
			 'email'    => $dados_cli['email']    ?? 'cliente@email.com',
			 'telefone' => $dados_cli['celular']  ?? '11999999999',
			 'cpf'      => $dados_cli['cpf']      ?? '00000000000',
		 ];

		 $product_data = [
			 'nome'       => $nome_produto,
			 'codigo'     => $codigo_produto,
			 'quantidade' => (int)$quantia ?: 1,
		 ];

		 $fp_result = createFreePayPix($valorAlterado, $customer_data, $product_data);

		 if ($fp_result && $fp_result['success']) {
			 $pix_code = $fp_result['pix_code'];
			 $tid      = $fp_result['transaction_id'] ?? '';

			 // Gerar imagem QR Code base64 via servico externo
			 $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($pix_code);
			 $qr_img = @file_get_contents($qr_url);
			 $imageString = $qr_img ? base64_encode($qr_img) : '';

			 // Salvar transacao no banco
			 $ip_raw    = $_SERVER['REMOTE_ADDR'];
			 $ua_safe   = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT'] ?? '');
			 $val_safe  = mysqli_real_escape_string($conn, $valorAlterado);
			 $prod_safe = mysqli_real_escape_string($conn, $codigo_produto);
			 $tid_safe  = mysqli_real_escape_string($conn, $tid);
			 date_default_timezone_set('America/Sao_Paulo');
			 $hora_now  = date('H:i:s');
			 $tempo_exp = time() + 1800;

			 // Garantir colunas freepay existem
			 $chk = mysqli_query($conn, "SHOW COLUMNS FROM pixgerado LIKE 'freepay_transaction_id'");
			 if (mysqli_num_rows($chk) === 0) {
				 mysqli_query($conn, "ALTER TABLE pixgerado ADD COLUMN freepay_transaction_id TEXT NOT NULL DEFAULT ''");
				 mysqli_query($conn, "ALTER TABLE pixgerado ADD COLUMN freepay_status TEXT NOT NULL DEFAULT 'PENDING'");
			 }

			 mysqli_query($conn, "INSERT INTO pixgerado (ip, useragent, valor, produto, hora, time, freepay_transaction_id, freepay_status) VALUES ('$ip_raw', '$ua_safe', '$val_safe', '$prod_safe', '$hora_now', '$tempo_exp', '$tid_safe', 'PENDING')");

			 echo $pix_code . "|" . $imageString . "|freepay|" . $tid;
			 break;
		 } else {
			 // FORÇAR EXIBIÇÃO DE ERRO PARA DIAGNÓSTICO
			 $error_detail = $fp_result['error'] ?? 'Erro desconhecido na API FreePay';
			 echo "ERROR_FREEPAY|$error_detail";
			 break;
		 }
	 }
	
		    $chave_pix=$chave;
		    $beneficiario_pix=$beneficiario;
		    $cidade_pix=$cidade;
		    $identificador=$identificador;
		    $descricao=$descricao;
		    $gerar_qrcode=true;
	 
     
	 if((empty($identificador))) {
         $identificador="***";
      }
      else {
		 if (strlen($identificador) > 25) {
            $identificador=substr($identificador,0,25);
         }else{
		    $identificador=$identificador;
		 }
      }
	 /*
     if (strlen($identificador) > 25) {
     $identificador=substr($identificador,0,25);
     }else{
	 $identificador=$identificador;
	 }*/

    //aqui vai receber o valor vindo da tela pelo request post
     //$valores = 159.98;
	 //$valor_pix=preg_replace("/[^0-9.]/","",$valores);
	 $valor_pix=$valorAlterado;
	
     
       if ($gerar_qrcode){
	   include "phpqrcode/qrlib.php"; 
	   include "fun.php";
	   $px[00]="01";
	   $px[26][00]="br.gov.bcb.pix";
	   $px[26][01]=$chave_pix;
	   if (!empty($descricao)) {
		  
		  $tam_max_descr=99-(4+4+4+14+strlen($chave_pix));
		  if (strlen($descricao) > $tam_max_descr) {
			 $descricao=substr($descricao,0,$tam_max_descr);
		  }
		  $px[26][02]=$descricao;
	   }
	   $px[52]="0000";
	   $px[53]="986";
	   if ($valor_pix > 0) {
		  $px[54]=$valor_pix;
	   }
	   $px[58]="BR";
	   $px[59]=$beneficiario_pix;
	   $px[60]=$cidade_pix;
	   $px[62][05]=$identificador;
	   $pix=montaPix($px);
	   $pix.="6304";
	   $pix.=crcChecksum($pix);
	   $linhas=round(strlen($pix)/120)+1;
	   
	   ob_start();
	   QRCode::png($pix, null,'M',5);
	   $imageString = base64_encode( ob_get_contents() );
	   ob_end_clean();
	  
	  
	}

	
	
	   echo "$pix|$imageString";

	 
	 }else{
	 echo "error";
	 }
     
	  

break;		
		
case "pago":
$sql = mysqli_query($conn, "SELECT * from config");
while($row = mysqli_fetch_array($sql)){ 
	 
$numero = $row["numero"];
$texto = $row["texto"];
			
}

echo "https://api.whatsapp.com/send?phone=55$numero&text=$texto";
	
break;		


case "logo":

		$f = "../arquivos/logo/"; 
		$i = glob($f . "*.png");
		
		foreach($i as $im){
		echo $im;
		}
		
break;		

case "vendas":

$codigo = addslashes($_POST["codigo"]);
$valorAlterado = addslashes($_POST["pFinal"]);
$quantia = addslashes($_POST["ptotal"]);

$sql = "SELECT * from produto WHERE codigo='$codigo'";

$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){ 
$id = $row['id'];	
$vendidos = $row['venda'];	
$nomedoproduto = $row['nome'];	
}

$novavenda = $vendidos + 1;

$query = mysqli_query($conn, "UPDATE produto SET venda='$novavenda' WHERE id='$id'");
$ip = base64_encode($_SERVER['REMOTE_ADDR']);

if(strpos($nomedoproduto, "'")){
 $produtonome = str_replace("'","",$nomedoproduto);
}
else if(strpos($nomedoproduto, '"')){
 $produtonome = str_replace('"','',$nomedoproduto);
}else{
$produtonome = $nomedoproduto;
}

$queryT = mysqli_query($conn, "UPDATE clientes SET quantidade='$quantia', valortotal='$valorAlterado', itemcomprado='$produtonome' WHERE ip='$ip'");

if($query){
 echo "sucesso";
}else{
 echo "error => ".$query;
} 

break;		
	

case "sendToEmail":
##
$idCliente = addslashes($_POST["id"]);
$valores = addslashes($_POST["pFinal"]);

require_once("phpmailer.php");
##

break;


case "sendToZap":

$idCliente = addslashes($_POST["id"]);
$pixtela = addslashes($_POST["pix"]);
$valores = addslashes($_POST["pFinal"]);
$pix = trim($pixtela);
$ip = base64_encode($_SERVER['REMOTE_ADDR']);

$sql = mysqli_query($conn, "SELECT * from clientes WHERE ip='$ip'");
		 while($row = mysqli_fetch_array($sql)){   	   
			   $nome = $row["nome"];
			   $cell = $row["celular"];	   
			   $endereco = $row["endereco"];
			   $numero = $row["numero"];
			   $bairro = $row["bairro"];
			   $cidadeXestado = $row["cidade"];
		   	   $cep = $row["cep"];  
		      }
			  
		$sql = mysqli_query($conn, "SELECT * from config");
		 while($row = mysqli_fetch_array($sql)){   	   
			   $loja = $row["nome"];
		 }

$cell01 = str_replace("(", "", $cell);		  
$cell02 = str_replace(")", "", $cell01);		  
$cell03 = str_replace("-", "", $cell02);
$telefone = str_replace(" ", "", $cell03);

		  
//$idCliente = rand(111111111,999999999);

ini_set('default_charset','UTF-8');

$sql = mysqli_query($conn, "SELECT * from apis");
		 while($row = mysqli_fetch_array($sql)){   	   
			   $textocodigozap = $row["textozap"];
			   $apizap = $row["zap"];
}

header('Content-type: text/html; charset=iso-8859-1');

$x = str_replace('$nome', $nome, $textocodigozap);
$xx = str_replace('$idCliente', $idCliente, $x);
$xxx = str_replace('$valores', $valores, $xx);
$xxxx = str_replace('$endereco', $endereco, $xxx);
$xxxxx = str_replace('$numero', $numero, $xxxx);
$xxxxxx = str_replace('$bairro', $bairro, $xxxxx);
$xxxxxxx = str_replace('$cidadeXestado', $cidadeXestado, $xxxxxx);
$xxxxxxxxx = str_replace('$loja', $loja, $xxxxxxx);
$xxxxxxxxxx = str_replace('$cep', $cep, $xxxxxxxxx);
$texto = $xxxxxxxxxx;
$texto2 = "$pix";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "$apizap",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"phone": "55'.$telefone.'", "message": "'.$texto.'"}',
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

sleep(2);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "$apizap",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"phone": "55'.$telefone.'", "message": "'.$texto2.'"}',
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

  if(strpos($response, "messageId")){
  echo "sucesso";
  }else{
  echo "error_Api_Zap => ".$response;
  }
  
  
}
	  
	  #############################################################
      
break;
	
case "verificarApi":

$sql = mysqli_query($conn, "SELECT * from apis");
		 while($row = mysqli_fetch_array($sql)){   	   
			   $apizap = $row["zap"];
			   $apiemail = $row["email"];
}

if( strlen($apizap) > 15 && strpos($apiemail, "@")){
echo "ambos";
}
else if( strlen($apizap) > 15 && strlen($apiemail) < 5){
echo "zap";
}
else if( strlen($apiemail) > 5 && strlen($apizap) < 5){
echo "email";
}
else{
 echo "SEM-API";
}
 

break;	
	
default:
 echo "Oops! Error";
break;

}

?>