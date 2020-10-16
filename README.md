# Cadastro de clientes!

##### Para rodar o projeto basta ter instalado o php em sua maquina com a versão minima 7.3, instalar o composer e a biblioteca php-sqlite,clonar o projeto em um diretorio de sua escolha ou baixar o arquivo zip, abrir um console ou terminal dentro da pasta do projeto e executar  o comando :

composer install

##### Caso use windows baixe o sqlite no link abaixo, 
https://www.sqlite.org/download.html

**descomente essas linhas no seu php.ini**
extension=php_pdo.dll
extension=php_sqlite.dll

##### após a conclusão do processo,  dentro da mesma janela, basta executar
php -S localhost:8000 -t public/
##### feito isso o projeto estará rodando e voce pode acessa-lo em seu navegador através do link :
http://localhost:8000/base.php


# Arquiterura
## Frontend

O frontend foi escrito em Vue.js, consumindo os dados do backend.

## Backend

Foi criada uma api, que de forma simples, gerencia os dados e direciona cada informação baseada na requisição do cliente.

## Bibliotecas

Neste projeto foram utilizadas as bibliotecas:

        "monolog/monolog" => para criar e gerenciar os logs da aplicação
        "nikic/fast-route" => para fazer o roteamento ( dizer o que aparece quando você deleta ou busca um cliente)
        "illuminate/database" => para "modelar" o banco de dados e as queries, é o mesmo ORM do laravel :)
        "guzzlehttp/guzzle" => para fazer as requisições remotas

## Organização

##### Dentro da pasta src/Controllers/

Temos o controle do cliente, onde dizemos o que acontece em todas as rotas da aplicação, desde o mockup de quando não houver clientes, até a listagem dos clientes

##### Dentro da pasta src/Models/

Aqui temos um modelo de cliente, seguindo o mesmo padrão do laravel, ditado pelo *'illuminate/database'*

##### Dentro da pasta src/Repositorios/

Aqui temos o repositório do cliente, ele contem os métodos de busca, remoção, atualização e consulta de clientes, centralizamos aqui essas funções, pois padrões de projetos convém a usar esses métodos dentro do *model*, mas com um repositório organizamos melhor as chamadas.

##### Dentro da pasta src/Services/

Aqui mantemos nossos Helpers, desde validação de CPF até Inicialização do banco de dados e Log.
Nessa pasta vão todas as funções que podem/vão alterar a aplicação em durante as requisições
![Tela do sistema](https://i.imgur.com/lNd172X.png)

