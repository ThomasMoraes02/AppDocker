# Meu Projeto PHP com Docker e Slim Framework v4

Este é um projeto PHP básico que utiliza Docker para facilitar o ambiente de desenvolvimento e Slim Framework v4 para construir aplicativos web.

## Requisitos

- Docker
- Docker Compose

## Configuração do Ambiente

1. Clone este repositório:

    ```bash
    git clone https://github.com/seu-usuario/seu-projeto.git
    cd seu-projeto
    ```

2. Inicie os contêineres Docker:

    ```bash
    docker-compose up -d
    ```

3. Aguarde até que os contêineres sejam inicializados.

## Acesso ao Aplicativo

O aplicativo estará disponível em http://localhost:40 (ou a porta que você configurou no arquivo docker-compose.yml).

## Executando Testes

Você pode executar os testes PHPUnit sem entrar no contêiner usando o seguinte comando:

    ```bash
    docker exec -it id_do_seu_container vendor/bin/phpunit --colors tests
    ```

    Certifique-se de substituir "id_do_seu_container" pelo id real do seu contêiner.

## Estrutura do Projeto

- `src/`: Contém o código-fonte do seu aplicativo Slim.
- `tests/`: Diretório para testes PHPUnit.
- `docker-compose.yml`: Configuração do Docker Compose para os serviços Apache, MySQL e PHPMyAdmin.

## Contribuição

Se você quiser contribuir para este projeto, sinta-se à vontade para criar issues, pull requests ou entrar em contato.

## Dicas
Crie um "alias" para simplificar a utilização do phpunit para executar os testes:
- `alias tests="docker exec -it id_do_seu_container vendor/bin/phpunit"`

Certifique-se de substituir "id_do_seu_container" pelo id real do seu contêiner.

No final poderá ser executado assim:
tests --colors tests