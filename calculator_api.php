<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$rota = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

if ($rota === '/health') {
    resposta(200, ['status' => 'ok']);
    return;
}

if ($rota === '/calculate') {
    if ($metodo !== 'POST') {
        resposta(405, ['error' => 'Metodo nao permitido']);
        return;
    }

    $entrada = file_get_contents('php://input') ?: '';

    try {
        $dados = json_decode($entrada, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        resposta(400, ['error' => 'JSON invalido']);
        return;
    }

    if (!isset($dados['operation'], $dados['a'], $dados['b'])) {
        resposta(422, ['error' => 'Campos operation, a e b sao obrigatorios']);
        return;
    }

    if (!is_numeric($dados['a']) || !is_numeric($dados['b'])) {
        resposta(422, ['error' => 'Valores de a e b devem ser numericos']);
        return;
    }

    try {
        $resultado = calcular(
            $dados['operation'],
            (float) $dados['a'],
            (float) $dados['b']
        );
    } catch (InvalidArgumentException $erro) {
        resposta(422, ['error' => $erro->getMessage()]);
        return;
    }

    resposta(200, ['result' => $resultado]);
    return;
}

resposta(404, ['error' => 'Rota nao encontrada']);

function calcular(string $operacao, float $a, float $b): float
{
    switch ($operacao) {
        case 'soma':
            return $a + $b;
        case 'subtracao':
            return $a - $b;
        case 'multiplicacao':
            return $a * $b;
        case 'divisao':
            if ($b === 0.0) {
                throw new InvalidArgumentException('Divisao por zero nao permitida');
            }
            return $a / $b;
        default:
            throw new InvalidArgumentException('Operacao desconhecida');
    }
}

function resposta(int $status, array $corpo): void
{
    http_response_code($status);
    echo json_encode($corpo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
