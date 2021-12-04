<h1>
    <a href="hurb.com"><img src="https://avatars1.githubusercontent.com/u/7063040?v=4&s=200.jpg" alt="Logo Hurb" width="24" /></a>
    <a href="https://github.com/hurbcom/challenge-bravo">Desafio Bravo</a>
</h1>

<p>
    <img alt="Made with go lang" src="https://img.shields.io/badge/Made%20with-php-6582ba.svg">
    <img alt="License" src="https://img.shields.io/badge/license-MIT-brightgreen">
</p>

<br />

## 💻 Descrição

Desenvolvimento de uma API que realiza conversão monetária de diferentes moedas com cotações de verdade e atuais.

<br />

## 🚀 Como rodar a aplicação


### Pré-requisitos

Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas:
[Git](https://git-scm.com), [Docker](https://docs.docker.com/), [Docker Compose](https://docs.docker.com/compose/)


####  Configurando com o docker

```bash

# Clone este repositório
$ git clone https://github.com/gustavowiller/challenge-bravo2.git

# Acesse a pasta do projeto no terminal/cmd
$ cd challenge-bravo2

# Comando para copiar o arquivo template de configuração de variaveis de ambiente
$ cp .env-example .env

# Comando para inicializar os containers através do docker-compose
$ docker-compose up -d

# Comando para executar a aplicação
$ docker-compose run app sh -c 'cd /usr/share/nginx && composer run-script start'

# Por padrão o servidor iniciará na porta :8085

```
<br />

## 🛠 Tecnologias

As principais ferramentas utilizadas no desenvolvimento:
- [Laravel](https://laravel.com/)
- [Mysql](https://dev.mysql.com/)
- [Redis](https://redis.io/)

<br />

## 🗃️ Arquivos Framework

O código gerado pela estrutura do laravel foi adicionado no commit de hash c05d6f74 <br />
Os commits a seguir não contém boilerplate code. <br />
Os principais arquivos e diretórios manipulados estão listados a seguir

```bash
app/Console/Commands/UpdateExchangeRates.php
app/Http/Controllers/CurrencyController.php
app/Http/Requests/*
app/Model/Currency.php
app/Services/*
database/migrations/*
database/seeders/*
tests/Feature/*
```
<br />

## 📖 Documentação API
<br />

### Cria uma nova moeda

Http Request
`POST /currency`

Parâmetros Body:
```
{
  "code": string,
  "is_real": boolean,
  "exchange_rate": float
}
```

Descrição dos parâmetros:
 - `code` Representa o código monetário da moeda. Ex: BTC, BRL, USD
 - `is_real` Valor booleano para representar se a moeda é de cotação verdadeira ou ficticia.
 - `exchange_rate` Taxa de conversão de acordo com a moeda de lastro informada na aplicação.

Respostas: <br />
HTTP Code: 422 / Contém a descrição do erro devido aos parâmetros de request.

```
{
  "errors": {
      "field": [
          string
      ]
      ...
  }
}
```
HTTP Code: 201 Contém os dados de inserção de uma nova moeda
```
{
  "code": string,
  "is_real": boolean,
  "exchange_rate": float
}
```
<br />

### Exclui uma moeda

Http Request
`DELETE /currency/{code}`


Descrição dos parâmetros:
 - `code` Representa o código monetário da moeda. Ex: BTC, BRL, USD


<br />
Respostas: <br />
HTTP Code: 404 / Não encontrado

```
{
  "message": "Not Found"
}
```
HTTP Code: 204 / Representa o status de exclusão de moeda.
```
{}
```
<br />

### Realiza uma conversão monetária
Http Request
`GET /currency/convert/`

Parâmetros da query string:
```
{
  "from": string,
  "to": string,
  "amount": float
}
```

Descrição dos parâmetros:
 - `from` Representa o código monetário da moeda de origem para realizar a conversão.
 - `to` Representa o código monetário da moeda de destino para realizar a conversão.
 - `amount` Representa a quantidade monetária a ser convertida.

Respostas: <br />
HTTP Code: 422 / Contém a descrição do erro devido aos parâmetros de request.

```
{
  "errors": {
      "field": [
          string
      ]
      ...
  }
}
```
HTTP Code: 404 / Não encontrado

```
{
  "message": "Not Found"
}
```

HTTP Code: 200 / Retorna o resultado da conversão monetária
```
{
  "result": float
}
```
