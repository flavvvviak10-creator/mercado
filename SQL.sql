-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Abr-2026 às 11:00
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lojinha`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acesso`
--

CREATE TABLE `acesso` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `senha` text NOT NULL,
  `acesso` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `acesso`
--

INSERT INTO `acesso` (`id`, `login`, `senha`, `acesso`) VALUES
(1, 'thefake', '12345', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `apis`
--

CREATE TABLE `apis` (
  `id` int(11) NOT NULL,
  `zap` text NOT NULL,
  `email` text NOT NULL,
  `htmlemail` text NOT NULL,
  `texto1email` text NOT NULL,
  `textozap` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `apis`
--

INSERT INTO `apis` (`id`, `zap`, `email`, `htmlemail`, `texto1email`, `textozap`) VALUES
(1, '', '', '<html>\n<head></head>\n\n<body>\n<h4>Olá, $nome</h4> total a pagar $valores\n<h4>id:  $idCliente</h4>\n<h4>Endereço:  $endereco</h4>\n<h4>Bairro:  $bairro, $numero</h4>\n<h4>Cidade:  $cidadeXestado</h4>\n<h4>Cep: $cep</h4>\n<h4>Loja: $loja</h4>\n</body>\n</html>', 'Aguardando pagamento, para envio do produto.', 'Olá, *$nome*!\nSeu pedido foi confirmado agora estamos aguardando a confirmação do pagamento para prosseguir com o envio.\\r\n\nPedido N° $idCliente\\r\n\nSubtotal: R$ $valores\\r\nPrazo de Entrega: em até 5 dias úteis\\r\n\nTotal: R$ $valores\\r\n\nLogradouro: $endereco, $numero\\r\nBairro: $bairro\\r\nCidade/Estado: $cidadeXestado\\r\nCEP: $cep\\r\n\nCaso tenha alguma dúvida basta nos enviar uma mensagem que lhe ajudaremos o mais rápido possivel.\\r\n\nAtenciosamente SAC $loja.\\r\n\nApós copiar o código, abra seu aplicativo de pagamento onde você utiliza o Pix.\\r\nEscolha a opção Pix Copia e Cola e insira o código copiado\\r\n\nSegue o código pix:');

-- --------------------------------------------------------

--
-- Estrutura da tabela `bot`
--

CREATE TABLE `bot` (
  `id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `useragent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `cpf` text NOT NULL,
  `celular` text NOT NULL,
  `cep` text NOT NULL,
  `endereco` text NOT NULL,
  `numero` text NOT NULL,
  `bairro` text NOT NULL,
  `cidade` text NOT NULL,
  `complemento` text NOT NULL,
  `destinatario` text NOT NULL,
  `quantidade` text NOT NULL,
  `valortotal` text NOT NULL,
  `itemcomprado` text NOT NULL,
  `ip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `cor` text NOT NULL,
  `img` text NOT NULL,
  `numero` text NOT NULL,
  `texto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id`, `nome`, `cor`, `img`, `numero`, `texto`) VALUES
(1, 'TheStore', '#11ce17', 'logo-loja.png', '00000000000', 'Olá, efetuei o pagamento na loja!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `desktop`
--

CREATE TABLE `desktop` (
  `id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `useragent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mobile`
--

CREATE TABLE `mobile` (
  `id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `useragent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `online`
--

CREATE TABLE `online` (
  `id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `etapa` text NOT NULL,
  `time` text NOT NULL,
  `cidade` text NOT NULL,
  `estado` text NOT NULL,
  `dispositivo` text NOT NULL,
  `hora` text NOT NULL,
  `situacao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `online`
--

INSERT INTO `online` (`id`, `ip`, `etapa`, `time`, `cidade`, `estado`, `dispositivo`, `hora`, `situacao`) VALUES
(18, 'Ojox', 'pix', '1670461036', 'Localhost', 'Localhost', 'computador', '21:23:24', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pix`
--

CREATE TABLE `pix` (
  `id` int(11) NOT NULL,
  `chave` text NOT NULL,
  `cidade` text NOT NULL,
  `descricao` text NOT NULL,
  `identificador` text NOT NULL,
  `beneficiario` text NOT NULL,
  `freepay_public_key` text NOT NULL DEFAULT '',
  `freepay_secret_key` text NOT NULL DEFAULT '',
  `use_freepay` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pix`
--

INSERT INTO `pix` (`id`, `chave`, `cidade`, `descricao`, `identificador`, `beneficiario`, `freepay_public_key`, `freepay_secret_key`, `use_freepay`) VALUES
(1, '52605078-1cee-43ce-aaf7-f35b6cc4bd27', 'ITAPEVI', 'The Bar Comercio Eletronico LTDA', '', 'TheBar', '', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pixgerado`
--

CREATE TABLE `pixgerado` (
  `id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `useragent` text NOT NULL,
  `valor` text NOT NULL,
  `produto` text NOT NULL,
  `hora` text NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `codigo` text NOT NULL,
  `nome` text NOT NULL,
  `valor` text NOT NULL,
  `img` text NOT NULL,
  `oferta` text NOT NULL,
  `desconto` text NOT NULL,
  `descricao` text NOT NULL,
  `venda` text NOT NULL,
  `cliques` text NOT NULL,
  `img1` text,
  `img2` text,
  `img3` text,
  `img4` text,
  `img5` text,
  `img6` text,
  `caracteristicas` text,
  `reviews` longtext,
  `valor_original` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `codigo`, `nome`, `valor`, `img`, `oferta`, `desconto`, `descricao`, `venda`, `cliques`) VALUES
(13, '6388088338b4f1669859459', 'Johnnie Walker Gold Label 18 anos 750 ml', '59.99', '6388088338b4f1669859459.png', '1', '70', 'Johnnie Walker Gold Label 18 anos 750 ml. Foi substituído pelo Johnnie Walker Ultimate 18 anos. Foi criado em 1920 em comemoração aos 100 anos da fundação dos negócios de Johnnie Walker. Em sua formulação são usados os melhores Whiskys da Escócia, envelhecidos por, no mínimo, 18 anos. É suntuosamente luxuoso e suave, com uma textura cremosa que o torna único na categoria. A água utilizada em sua composição provém de um manancial de onde se extrai ouro, fazendo com que seu sabor seja único. Origem: Escócia. Categoria: Super Deluxe (18 anos). Graduação: 40% vol. Volume: 750 ml. É proibida a venda de bebidas para menores de 18 anos', '0', '0'),
(23, '8630860241670453118', 'Barril Chopp Brahma 5 Litros Pague 1 Leve 2', '29.89', '8630860241670453118.png', '1', '55', 'Seus momentos de lazer, descanso e festa merecem uma boa bebida para acompanhar e tornar tudo ainda mais especial. Se você está em dúvida entre qual escolher para comprar, uma excelente opção é a Cerveja Brahma Chopp Pilsen. A referência do sabor de cerveja no Brasil desde 1888, a Brahma Lager é uma cerveja saborosa e balanceada, com o sabor autêntico de cerveja brasileira, com espuma cremosa e persistente, amargor presente e ligeiramente encorpada. ', '2', '8'),
(25, '1378843141670455882', 'COMBO WHISKY BUCHANANS DeLuxe Aged 12 Anos 1l  6 unidades', '589.30', '1378843141670455882.png', '1', '89', 'O Whisky Buchanan\'s Deluxe é o reflexo da criação de James Buchanan\'s em 1884; um blend tão leve, suave e refinado que veio a consagrá-lo como fornecedor oficial de whisky do Parlamento Britânico.', '27', '4');

-- --------------------------------------------------------

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `acesso`
--
ALTER TABLE `acesso`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `apis`
--
ALTER TABLE `apis`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `desktop`
--
ALTER TABLE `desktop`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mobile`
--
ALTER TABLE `mobile`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pix`
--
ALTER TABLE `pix`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pixgerado`
--
ALTER TABLE `pixgerado`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acesso`
--
ALTER TABLE `acesso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `apis`
--
ALTER TABLE `apis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `desktop`
--
ALTER TABLE `desktop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de tabela `mobile`
--
ALTER TABLE `mobile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `online`
--
ALTER TABLE `online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `pix`
--
ALTER TABLE `pix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pixgerado`
--
ALTER TABLE `pixgerado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
