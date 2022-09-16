<?php
include './conexao.php';
include './estrutura/cabecalho.php';
?>
<p>
<form id="busca" action="pagina2.php" method="POST" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" autocomplete="off">
    <label for="busca">Procurar solicitação:</label><input id="busc" type="int" name="busca" maxlength="4" placeholder="Número do protocolo" id="busca">
    <br><input id="botao4" type="submit" value="Buscar"><br><br>
</form>
</p>
<section class="hero">
    <?php

    $ano = date("y");
    $dataCadastro = date("y-m-d h:m:s");
    $statuss = 1;
    $dados =  filter_input_array(INPUT_POST, FILTER_DEFAULT);
    

    /*verificando se os dados foram inseridos corretamente*/
    
    if (!empty($dados['botao'])) {
        $empty_input = false;
        $dados = array_map('trim', $dados);
        if (in_array("", $dados)) {
            $empty_input = true;
            echo "<p id='erro'>Erro: necessário preencher todos os campos!</p>";
        } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $empty_input = true;
            echo "<p id='erro'>Erro: Informe e-mail válido!</p>";
        }

        /*Inserindo os dados no banco de dados*/

        if (!$empty_input) {
            $sql = "INSERT INTO formulario (solicitante, descricao, email, ano, dataCadastro, statuss) VALUES (:solicitante,:descricao, :email, '$ano', '$dataCadastro', '$statuss')";
            $cad_usuario = $conn->prepare($sql);
            $cad_usuario->bindParam(':solicitante', $dados['solicitante']);
            $cad_usuario->bindParam(':descricao', $dados['descricao']);
            $cad_usuario->bindParam(':email', $dados['email']);
            $cad_usuario->execute();



            if ($cad_usuario->rowCount()) {
    ?>
                <div class="hero2">

                <?php


                echo "<p id='sucesso'>Solicitação enviada com sucesso!</p>";
                $registro = $conn->prepare("SELECT solicitante FROM formulario WHERE solicitante = :solicitante");
                $registro->bindValue(':solicitante', $dados['solicitante']);
                $registro->execute();
                $resultado = $registro->fetch(PDO::FETCH_ASSOC);
                foreach ($resultado as $key => $value) {
                    echo "Solicitante: " . $value . "<br>";
                }
                $registro = $conn->prepare("SELECT descricao FROM formulario WHERE descricao = :descricao");
                $registro->bindValue(':descricao', $dados['descricao']);
                $registro->execute();
                $resultado = $registro->fetch(PDO::FETCH_ASSOC);
                foreach ($resultado as $key => $value) {
                    echo "Descrição: " . $value . "<br>";
                }
                $registro = $conn->prepare("SELECT email FROM formulario WHERE email = :email");
                $registro->bindValue(':email', $dados['email']);
                $registro->execute();
                $resultado = $registro->fetch(PDO::FETCH_ASSOC);
                foreach ($resultado as $key => $value) {
                    echo "E-mail: " . $value . "<br>";
                }
                echo "Ano: " . $ano . "<br>";
                echo "Data do Cadastro: " . $dataCadastro . "<br>";
                if ($statuss = 1) {
                    echo "Status: " . $statuss . " - aguardando análise<br>";
                }
                unset($dados);
            } else {
                echo "<p id='erro'>Erro: Solicitação não enviada!</p>";
            }
                ?>
      
                    <p id="fim">Confirme para finalizar e imprimir sua solicitação!!</p>
                    <a href="index.php" id="botao2">Confirmar</a>
                    <a href="pagina4.php" id="botao2">Alterar</a>
                

                </div>


        <?php
        }
    }

        ?>

        <!-- formulário-->

        <form id="form" action="#" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" autocomplete="off">
            <h3>Preencha com os Dados da Solicitação</h3>
            <label for="solicitante">Solicitante:</label><input type="text" name="solicitante" maxlength="50" placeholder="Nome completo" id="solicitante" value="<?php
                                                                                                                                                                    if (isset($dados['solicitante'])) {
                                                                                                                                                                        echo $dados['solicitante'];
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><br><br>
            <label for="descricao">Descrição:</label><input type="text" name="descricao" maxlength="500" placeholder="Descrição do pedido" id="descricao" value="<?php
                                                                                                                                                                    if (isset($dados['descricao'])) {
                                                                                                                                                                        echo $dados['descricao'];
                                                                                                                                                                    }
                                                                                                                                                                    ?>"><br><br>
            <label for="email">E-mail:</label><input type="email" name="email" placeholder="Seu melhor e-mail" id="email" value="<?php
                                                                                                                                    if (isset($dados['email'])) {
                                                                                                                                        echo $dados['email'];
                                                                                                                                    }
                                                                                                                                    ?>"><br><br>
            <input id="botao" type="submit" value="Enviar" name="botao">

        </form>


</section>
<?php
include './estrutura/footer.php';
?>