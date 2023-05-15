<?php 

    // Iniciando as variaveis
    $num1 = "";
    $num2 = "";

    // Tratamento do formato do número
    $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

    // Recebendo datas
    $inicio = date("m-d-Y", strtotime("-7 days"));
    $fim = date("m-d-Y");
    $data = date("d/m/Y");

    // URL da API
    $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

    $dados = json_decode(file_get_contents($url), true);
    $cotacao = $dados["value"][0]["cotacaoCompra"];

    // Verifica se o formulário foi submetido pelo POST
    if(isset($_POST['submit'])){
        $num1 = $_POST['num1'] ?? 0;
        $num2 = numfmt_format_currency($padrao, ($num1 / $cotacao), "USD");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Conversor de moeda</title>
    <script>
        // Função para exibir o popup
        function showPopup() {
            document.getElementById("popup").style.display = "block";
            document.getElementsByClassName("popup").style.display = "block";
        }

        // Função para fechar o popup
        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
</head>
<body>
    <div class="container">
        <div>
            <form class="card" action="index.php" method="POST">
                <h1>conversor</h1>
                <span class="span">real - dólar</span>
                <div class="input-container">
                    <input type="number" step="0.01" autocomplete="off" name="num1" class="text-input" placeholder="R$ 0,00"  value="<?php print $num1; ?>">
                    <label class="label">Reais</label>
                </div>
                <i class="fa-solid fa-right-left"></i><input type="submit" value="Converter" class="button-enviar" name="submit">
                <button type="button" class="button-abrir" onclick="showPopup()"><i class="fa-solid fa-plus"></i>Saiba mais</button>
                <div class="result">
                    <h5>Em dólar: <span><?php print $num2; ?></span></h5>
                </div>
            </form>
            <div id="popup" class="popup">
                <h2>Data atual: <?php print $data; ?></h2>
                <h4>Câmbio do dólar: <?php print $cotacao; ?></h4>
                <p>Dados de câmbio disponibilizados pelo Banco Central do Brasil.</p>
                <div><button type="button" class="button-fechar" onclick="closePopup()">Fechar</button></div>
            </div>
        </div>
        <svg id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 490" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(15, 173, 100, 1)" offset="0%"></stop><stop stop-color="rgba(2.734, 234.829, 26.484, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,441L120,432.8C240,425,480,408,720,334.8C960,261,1200,131,1440,114.3C1680,98,1920,196,2160,253.2C2400,310,2640,327,2880,302.2C3120,278,3360,212,3600,163.3C3840,114,4080,82,4320,65.3C4560,49,4800,49,5040,73.5C5280,98,5520,147,5760,212.3C6000,278,6240,359,6480,400.2C6720,441,6960,441,7200,400.2C7440,359,7680,278,7920,204.2C8160,131,8400,65,8640,57.2C8880,49,9120,98,9360,98C9600,98,9840,49,10080,24.5C10320,0,10560,0,10800,40.8C11040,82,11280,163,11520,212.3C11760,261,12000,278,12240,310.3C12480,343,12720,392,12960,343C13200,294,13440,147,13680,81.7C13920,16,14160,33,14400,81.7C14640,131,14880,212,15120,245C15360,278,15600,261,15840,212.3C16080,163,16320,82,16560,81.7C16800,82,17040,163,17160,204.2L17280,245L17280,490L17160,490C17040,490,16800,490,16560,490C16320,490,16080,490,15840,490C15600,490,15360,490,15120,490C14880,490,14640,490,14400,490C14160,490,13920,490,13680,490C13440,490,13200,490,12960,490C12720,490,12480,490,12240,490C12000,490,11760,490,11520,490C11280,490,11040,490,10800,490C10560,490,10320,490,10080,490C9840,490,9600,490,9360,490C9120,490,8880,490,8640,490C8400,490,8160,490,7920,490C7680,490,7440,490,7200,490C6960,490,6720,490,6480,490C6240,490,6000,490,5760,490C5520,490,5280,490,5040,490C4800,490,4560,490,4320,490C4080,490,3840,490,3600,490C3360,490,3120,490,2880,490C2640,490,2400,490,2160,490C1920,490,1680,490,1440,490C1200,490,960,490,720,490C480,490,240,490,120,490L0,490Z"></path></svg>
    </div>
</body>
</html>