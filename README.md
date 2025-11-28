# Guia rapido de PHP e API de calculadora

- Requisitos: PHP 8.1+ instalado e acessivel no terminal.
- Arquivos incluidos: `php_basics.php` (demonstra recursos da linguagem) e `calculator_api.php` (API JSON de calculadora).
- Uso sem frameworks para destacar sintaxe e boas praticas da base do PHP.

## Executar o roteiro de fundamentos

```bash
php php_basics.php
```

Saida esperada: exibicao de variaveis, tipos, funcoes, estruturas de controle, objetos, nullsafe operator, excecoes e funcoes de array.

## Subir a API da calculadora

```bash
php -S localhost:8000 calculator_api.php
```

### Endpoints
- `GET /health` retorna status basico da API.
- `POST /calculate` recebe JSON com operacao e dois operandos numericos.

### Payload aceito para `/calculate`
```json
{
  "operation": "soma",
  "a": 10,
  "b": 5
}
```

Operacoes disponiveis: `soma`, `subtracao`, `multiplicacao`, `divisao`.

### Exemplo de chamada com curl
```bash
curl -X POST http://localhost:8000/calculate ^
  -H "Content-Type: application/json" ^
  -d "{\"operation\":\"divisao\",\"a\":21,\"b\":3}"
```

Resposta
```json
{"result":7}
```

### Erros comuns
- JSON invalido ou campos ausentes: status 400 ou 422 com `error`.
- Metodo diferente de POST em `/calculate`: status 405.
- Divisao por zero: status 422.
