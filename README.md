## Projeto Damásio Motopeças - API
* versão 0.0.0

# Antes de começar
Tenha certeza que o servidor de produção possui:
- Instalar php 7.3 no servidor.
- Instalar composer.
- Instalar git.

# Configurações no servidor
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

* Configurações do DomPDF
``` php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider" ``` <br>

É necessário instalar um supervisor para que possa ser realizado os processamentos de geração
dos PDF's das categorias. Para isso, em ambiente linux, execute o comando abaixo:
``` sudo apt-get install supervisor ```

Para configurações mais detalhadas, [acesse o link.](https://laravel.com/docs/8.x/queues#supervisor-configuration) na sessão 'Configurando o Supervisor'.

## Configurações do php
Deve manipulados as seguintes variáveis de ambiente do arquivo php.ini:
``` post_max_size = 40M ```
``` upload_max_filesize = 10M ```
``` memory_limit = 1024M ```

* OBS1: Em caso de atualização em massa das imagens dos produtos ou das marcas, seguindo novos produtos inseridos através da planilha, as atualizações devem ser feitas diretamente do diretório 'storage/app/public/'. Aqui está armazenado os dois diretórios 'marcas/' que armazena todas as imagens das marcas e 'produtos/' que armazena todas as imagens dos produtos.

* OBS2: No diretório 'storage/' há o diretório 'fonts/'. É nesse diretório onde é inserido as fontes que poderão ser usadas na geração do PDF.

## Como executar testes
``` .\vendor\bin\phpunit .\tests\Feature\ ```