<!DOCTYPE HTML>
<html>
<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<?php
$protocolo = $ano_protocolo = "";
if ($_GET["protocolo"] != "") {
    $protocolo = $_GET["protocolo"];
}
if ($_POST["protocolo"] != "") {
    $protocolo = $_POST["protocolo"];
}
$servername = $_SG['servidor'];
$username = $_SG['usuario'];
$password = $_SG['senha'];
$dbname = $_SG['banco'];

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM documentos WHERE id=" . $protocolo;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $data_entrada_ex = explode("-", $row["data_entrada"]);
        $ano_protocolo = $data_entrada_ex[0];
        $numero_nic = $row["numero_nic"];
        $data_entrada = $row["data_entrada"];
        $cadaver_informacao = $row["cadaver_informacao"];
        $data_fato = $row["data_fato"];
        $procedencia_bairro = $row["procedencia_bairro"];
        $procedencia_cidade = $row["procedencia_cidade"];
        $procedencia_uf = $row["procedencia_uf"];
        $cadaver_situacao = $row["cadaver_situacao"];
        $numero_guia = $row["numero_guia"];
        $causa_morte = $row["causa_morte"];
        $destino_exame = $row["destino_exame"];
        $numero_sei = $row["numero_sei"];
        $status_coleta = $row["status_coleta"];
        $nome_completo = $row["nome_completo"];
        $nome_pai = $row["nome_pai"];
        $nome_mae = $row["nome_mae"];
        $naturalidade_cidade = $row["naturalidade_cidade"];
        $naturalidade_uf = $row["naturalidade_uf"];
        $data_nascimento = $row["data_nascimento"];
        $docuemnto_tipo = $row["docuemnto_tipo"];
        $docuemnto_numero = $row["docuemnto_numero"];
        $docuemnto_orgao = $row["docuemnto_orgao"];
        $docuemnto_uf = $row["docuemnto_uf"];
        $observacoes = $row["observacoes"];
    }
} else {
    // echo "0 results";
}

mysqli_close($conn);
?>
<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_nic = test_input($_POST["numero_nic"]);
    $data_entrada = test_input($_POST["data_entrada"]);
    $cadaver_informacao = test_input($_POST["cadaver_informacao"]);
    $data_fato = test_input($_POST["data_fato"]);
    $procedencia_bairro = test_input($_POST["procedencia_bairro"]);
    $procedencia_cidade = test_input($_POST["procedencia_cidade"]);
    $procedencia_uf = test_input($_POST["procedencia_uf"]);
    $cadaver_situacao = test_input($_POST["cadaver_situacao"]);
    $numero_guia = test_input($_POST["numero_guia"]);
    $causa_morte = test_input($_POST["causa_morte"]);
    $destino_exame = test_input($_POST["destino_exame"]);
    $numero_sei = test_input($_POST["numero_sei"]);
    $status_coleta = "";
    if ($_POST["status_coleta"] == "on") {
        $status_coleta = 1;
    } else {
        $status_coleta = 0;
    }
    $perito = test_input($_SESSION['usuarioNome']);
    $nome_completo = test_input($_POST['nome_completo']);
    $nome_pai = test_input($_POST["nome_pai"]);
    $nome_mae = test_input($_POST["nome_mae"]);
    $naturalidade_cidade = test_input($_POST["naturalidade_cidade"]);
    $naturalidade_uf = test_input($_POST["naturalidade_uf"]);
    if (test_input($_POST["data_nascimento"]) == "") {
        $data_nascimento = "2000-01-01";
    } else {
        $data_nascimento = test_input($_POST["data_nascimento"]);
    }
    $docuemnto_tipo = test_input($_POST["docuemnto_tipo"]);
    $docuemnto_numero = test_input($_POST["docuemnto_numero"]);
    $docuemnto_orgao = test_input($_POST["docuemnto_orgao"]);
    $docuemnto_uf = test_input($_POST["docuemnto_uf"]);
    $observacoes = test_input($_POST["observacoes"]);

    $servername = $_SG['servidor'];
    $username = $_SG['usuario'];
    $password = $_SG['senha'];
    $dbname = $_SG['banco'];

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE `documentos` SET `numero_nic`='" . $numero_nic . "',`data_entrada`='" . $data_entrada . "',`cadaver_informacao`='" . $cadaver_informacao . "',`data_fato`='" . $data_fato . "',`procedencia_bairro`='" . $procedencia_bairro . "',`procedencia_cidade`='" . $procedencia_cidade . "',`procedencia_uf`='" . $procedencia_uf . "',`cadaver_situacao`='" . $cadaver_situacao . "',`numero_guia`='" . $numero_guia . "',`causa_morte`='" . $causa_morte . "',`destino_exame`='" . $destino_exame . "',`numero_sei`='" . $numero_sei . "',`status_coleta`='" . $status_coleta . "',`perito`='" . $perito . "',`nome_completo`='" . $nome_completo . "', `nome_pai`='" . $nome_pai . "',`nome_mae`='" . $nome_mae . "', `naturalidade_cidade`='" . $naturalidade_cidade . "',`naturalidade_uf`='" . $naturalidade_uf . "', `data_nascimento`='" . $data_nascimento . "',`docuemnto_tipo`='" . $docuemnto_tipo . "', `docuemnto_numero`='" . $docuemnto_numero . "',`docuemnto_orgao`='" . $docuemnto_orgao . "', `docuemnto_uf`='" . $docuemnto_uf . "',`observacoes`='" . $observacoes . "',`data_formulario`='" . date("Y-m-d") . "' WHERE id=" . $protocolo . "";
}
?>
<?php include 'head.php'; ?>

<body>
    <div class="page-container">
        <div class="left-content">
            <div class="mother-grid-inner">
                <?php include 'nav.php'; ?>
                <!--inner block start here-->
                <div class="inner-block">
                    <div class="typography">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (mysqli_query($conn, $sql)) {
                                echo '<div class="alert alert-success alert-dismissable">';
                                echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
                                echo 'Sucesso! Editado documentação do <b>PROTOCOLO ' . str_pad($protocolo, 4, '0', STR_PAD_LEFT) . '/' . $ano_protocolo . '</b>.';
								echo '</div>';                               
                            } else {
                                echo '<div class="alert alert-danger alert-dismissable">';
                                echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                echo '</div>';
                            }
                            mysqli_close($conn);
                        }
                        ?>
                        <h2>Formulário de Registro</h2>
                        <form action="perfilDocumento.php" method="POST">
                            <div class="clearfix"> </div>
                            <div class="typo-buttons col-md-12 grid_4">
                                <input name="protocolo" value="<?php echo $protocolo; ?>" type="hidden">
                                <input name="perito" value="<?php echo $_SESSION['usuarioNome']; ?>" type="hidden">
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Protocolo Parecer </label>
                                    <input class="col-md-2" type="text" value="<?php echo str_pad($protocolo, 4, '0', STR_PAD_LEFT) . "/" . $ano_protocolo; ?>" disabled>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Nº NIC </label>
                                    <input name="numero_nic" class="col-md-4" type="text" value="<?php echo $numero_nic; ?>" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Data de Entrada </label>
                                    <input name="data_entrada" class="col-md-2" type="date" value="<?php echo $data_entrada; ?>" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Informações Cadáver </label>
                                    <input name="cadaver_informacao" class="col-md-8" type="text" value="<?php echo $cadaver_informacao; ?>" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Data do Fato </label>
                                    <input name="data_fato" class="col-md-2" type="date" value="<?php echo $data_fato; ?>" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Procedente </label>
                                    <input name="procedencia_bairro" class="col-md-4" type="text" value="<?php echo $procedencia_bairro; ?>" placeholder="Bairro ou Hospital" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                    <input name="procedencia_cidade" class="col-md-3" type="text" value="<?php echo $procedencia_cidade; ?>" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                    <input name="procedencia_uf" class="col-md-1" type="text" value="<?php echo $procedencia_uf; ?>" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Situação do Cadáver </label>
                                    <input name="cadaver_situacao" class="col-md-8" type="text" value="<?php echo $cadaver_situacao; ?>" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Nº da Guia de Solicitação </label>
                                    <input name="numero_guia" class="col-md-4" type="text" value="<?php echo $numero_guia; ?>" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Causa Morte </label>
                                    <input name="causa_morte" class="col-md-8" type="text" value="<?php echo $causa_morte; ?>" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Destino do Exame </label>
                                    <input name="destino_exame" class="col-md-8" type="text" value="<?php echo $destino_exame; ?>" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                <div class="col-md-12 well">
                                    <label class="col-md-4">Protocolo SEI </label>
                                    <input name="numero_sei" class="col-md-4" type="text" value="<?php echo $numero_sei; ?>" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
                                </div>
                                <div class="col-md-12 well">
                                    <input name="status_coleta" class="col-md-1" type="checkbox" <?php
                                                                                                    if ($status_coleta == 1) {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                    ?>>
                                    <label class="col-md-11">Não apresenta condições de coleta de Impressões Digitais</label>
                                </div>

                                <?php
                                if ($status_coleta == 0) {
                                    if ($nome_completo != "") {
                                        ?>
                                        <div class="col-md-12 well">
                                            <label class="col-md-4">Nome Completo </label>
                                            <input name="nome_completo" class="col-md-8" type="text" value="<?php echo $nome_completo; ?>" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                        </div>
                                        <div class="col-md-12 well">
                                            <label class="col-md-4">Nome do Pai </label>
                                            <input name="nome_pai" class="col-md-8" type="text" value="<?php echo $nome_pai; ?>" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                        </div>
                                        <div class="col-md-12 well">
                                            <label class="col-md-4">Nome da Mãe </label>
                                            <input name="nome_mae" class="col-md-8" type="text" value="<?php echo $nome_mae; ?>" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                        </div>
                                        <div class="col-md-12 well">
                                            <label class="col-md-4">Naturalidade </label>
                                            <input name="naturalidade_cidade" class="col-md-7" type="text" value="<?php echo $naturalidade_cidade; ?>" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                            <input name="naturalidade_uf" class="col-md-1" type="text" value="<?php echo $naturalidade_uf; ?>" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                        </div>
                                        <div class="col-md-12 well">
                                            <label class="col-md-4">Data de Nascimento </label>
                                            <input name="data_nascimento" class="col-md-2" type="date" value="<?php echo $data_nascimento; ?>" required>
                                        </div>
                                        <div class="col-md-12 well">
                                            <label class="col-md-4">Documento Apresentado </label>
                                            <select name="docuemnto_tipo" class="col-md-2" type="text">
                                                <?php
                                                if ($docuemnto_tipo == "RG") {
                                                    echo '<option value="RG" selected>RG</option>';
                                                } else {
                                                    echo '<option value="RG">RG</option>';
                                                }
                                                if ($docuemnto_tipo == "CTPS") {
                                                    echo '<option value="CTPS" selected>CTPS</option>';
                                                } else {
                                                    echo '<option value="CTPS">CTPS</option>';
                                                }
                                                if ($docuemnto_tipo == "PRONT. CIVIL") {
                                                    echo '<option value="PRONT. CIVIL" selected>PRONT. CIVIL</option>';
                                                } else {
                                                    echo '<option value="PRONT. CIVIL">PRONT. CIVIL</option>';
                                                }
                                                if ($docuemnto_tipo == "RESERVISTA") {
                                                    echo '<option value="RESERVISTA" selected>RESERVISTA</option>';
                                                } else {
                                                    echo '<option value="RESERVISTA">RESERVISTA</option>';
                                                }
                                                ?>
                                            </select>
                                            <input name="docuemnto_numero" class="col-md-3" type="text" value="<?php echo $docuemnto_numero; ?>" placeholder="nº" required>
                                            <input name="docuemnto_orgao" class="col-md-2" type="text" value="<?php echo $docuemnto_orgao; ?>" placeholder="Orgão" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                            <input name="docuemnto_uf" class="col-md-1" type="text" value="<?php echo $docuemnto_uf; ?>" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                        </div>
                                        <div class="col-md-12 well">
                                            <label class="col-md-4">Observações </label>
                                            <textarea name="observacoes" class="col-md-8" onChange="javascript:this.value=this.value.toUpperCase();"><?php echo $observacoes; ?></textarea>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                                <div class="grid1">
                                    <button type="submit" class="btn btn-1 btn-success">Editar</button>
                                    <a href="listaDocumentos.php?pageDoc=<?php echo ($protocolo - 1); ?>"><button type="button" class="btn btn-1 btn-danger">Voltar</button></a>
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <!--inner block end here-->
                <?php include 'footer.php'; ?>
            </div>
        </div>
        <?php include 'menu.php'; ?>
        <div class="clearfix"> </div>
    </div>
    <!--slide bar menu end here-->

</body>

</html>