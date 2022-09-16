<?php
include './conexao.php';
include './estrutura/cabecalho.php';
?>
<div class="hero2">
    <?php
    $numero = $_POST['busca'];
    $query = "SELECT * FROM formulario WHERE numero LIKE :busca";
    $reg = $conn->prepare($query);
    $reg->bindParam(':busca', $numero);
    $result = $reg->execute();
    $result = $reg->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['busca']) && $result['numero'] ) {


        echo "Número: " . $result['numero'] . "<br>";
        echo "Solicitante: " . $result['solicitante'] . "<br>";
        echo "Descrição: " . $result['descricao'] . "<br>";
        echo "E-mail: " . $result['email'] . "<br>";
        echo "Ano: " . $result['ano'] . "<br>";
        echo "Status: " . $result['statuss'] . "<br>";
        echo "Data: " . $result['dataCadastro'] . "<br>";
    ?>
        <p id="fim">Consulta realizada com sucesso!!</p>
        <a href="index.php" id="botao2">Voltar</a>
    <?php
    } else {
        header("Location: pagina3.php");
        exit;
    }
    ?>
</div>
<?php
include './estrutura/footer.php';
?>