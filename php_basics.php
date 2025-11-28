<?php
declare(strict_types=1);

function section(string $title): void
{
    echo "\n{$title}\n";
}

function line(string $label, mixed $value): void
{
    $output = is_bool($value) ? ($value ? 'true' : 'false') : $value;
    echo "{$label}: ";
    print_r($output);
    echo "\n";
}

section('Variaveis e tipos escalares');
$inteiro = 42;
$decimal = 3.14;
$booleano = true;
$texto = 'PHP';
$textoInterpolado = "Trabalhando com {$texto} 8.2";
line('inteiro', $inteiro);
line('decimal', $decimal);
line('booleano', $booleano);
line('texto', $texto);
line('textoInterpolado', $textoInterpolado);

section('Arrays e estruturas');
$lista = ['azul', 'verde', 'vermelho'];
$associativo = ['linguagem' => 'PHP', 'versao' => 8.2];
$matriz = [
    ['id' => 1, 'nome' => 'Ana'],
    ['id' => 2, 'nome' => 'Bruno'],
];
line('lista[1]', $lista[1]);
line('associativo["versao"]', $associativo['versao']);
line('matriz', $matriz);

section('Funcoes e closures');
function saudacao(string $nome = 'Visitante'): string
{
    return "Ola, {$nome}";
}
$duplicador = fn(int $numero): int => $numero * 2;
line('saudacao', saudacao('Gabriela'));
line('duplicador', $duplicador(7));

section('Controle de fluxo');
$temperatura = 32;
$aviso = $temperatura > 30 ? 'Calor' : 'Agradavel';
$periodo = match (true) {
    $temperatura >= 35 => 'Muito quente',
    $temperatura >= 25 => 'Quente',
    default => 'Fresco',
};
line('aviso', $aviso);
line('periodo', $periodo);

section('Objetos e tipos modernos');
class Produto
{
    public function __construct(
        public string $nome,
        private float $preco,
        private ?float $desconto = null
    ) {
    }

    public function precoFinal(): float
    {
        $fator = 1 - ($this->desconto ?? 0);
        return round($this->preco * $fator, 2);
    }
}

$item = new Produto('Teclado', 199.9, 0.1);
line('Produto', ['nome' => $item->nome, 'precoFinal' => $item->precoFinal()]);

section('Nullsafe e coalescencia');
$perfil = ['email' => 'pessoa@exemplo.com', 'telefone' => null];
$telefone = $perfil['telefone'] ?? 'indisponivel';
$endereco = $perfil['endereco'] ?? null;
$complemento = $endereco?->complemento ?? 'sem complemento';
line('telefone', $telefone);
line('complemento', $complemento);

section('Tratamento de excecoes');
try {
    $resultado = intdiv(10, 2);
    line('divisao segura', $resultado);
    intdiv(5, 0);
} catch (DivisionByZeroError $erro) {
    line('erro', $erro->getMessage());
}

section('Funcoes de array uteis');
$numeros = range(1, 5);
$dobrados = array_map(fn(int $valor): int => $valor * 2, $numeros);
$pares = array_filter($dobrados, fn(int $valor): bool => $valor % 2 === 0);
$soma = array_reduce($numeros, fn(int $ac, int $valor): int => $ac + $valor, 0);
line('dobrados', $dobrados);
line('pares', $pares);
line('soma', $soma);
