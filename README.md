## Projeto Damásio Motopeças - API
* versão 0.0.0

# Antes de começar
Tenha certeza que o servidor de produção possui:
- Instalar php 7.3 no servidor.
- Instalar composer.
- Instalar git.

# Configurações
Execute os comandos abaixo dentro do diretório do projeto, no servidor:
``` composer install ``` <br>
``` npm run dev ``` <br>
``` php artisan cache:clear ``` <br>
``` php artisan config:clear ``` <br>
``` php artisan migrate ``` <br>
``` php artisan key:generate ``` <br>
``` php artisan passport:install ``` <br>
``` php artisan passport:keys ``` <br>
``` php artisan vendor:publish --tag=passport-config ``` <br>
``` php artisan storage:link ``` <br>

## Como executar testes
``` .\vendor\bin\phpunit .\tests\Feature\ ```