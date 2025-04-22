<?php
// Configurações do banco de dados
$host = 'localhost';      // Endereço do banco de dados
$user = 'root';           // Nome de usuário do banco (padrão do XAMPP é 'root')
$pass = '';               // Senha do banco (padrão do XAMPP é vazio)
$db = 'eleicao2024';      // Nome do banco de dados que você criou

// Conectando ao banco de dados
$conn = new mysqli($host, $user, $pass, $db);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
// Recebe os dados enviados pelo JavaScript através do fetch
$id_candidato = $_POST['id_candidato'];  // Número do candidato
$cargo_votado = $_POST['cargo_votado'];  // Cargo (Prefeito ou Vereador)

// Verifica o tipo de voto
$tipo_voto = 'candidato'; // Por padrão, assume que é um voto válido em um candidato

// Se o número do candidato estiver vazio, é um voto em branco
if ($id_candidato == '') {
    $tipo_voto = 'branco';
} elseif (!in_array($id_candidato, ['69', '26', '69666', '26132'])) {
    // Se o número do candidato não está na lista de candidatos válidos, é voto nulo
    $tipo_voto = 'nulo';
}

// Insere o voto na tabela 'votos' do banco de dados
$sql = "INSERT INTO votos (cargo, candidato_id, tipo_voto) VALUES ('$cargo_votado', '$id_candidato', '$tipo_voto')";
if ($conn->query($sql) === TRUE) {
    echo "Voto registrado com sucesso!";
} else {
    echo "Erro ao registrar voto: " . $conn->error;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
