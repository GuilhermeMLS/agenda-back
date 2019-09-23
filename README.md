
## Configurar a API
- Coloque a pasta do projeto da API no diretório`/usr/local/var/www/` no macOS ou equivalente no Linux (localhost), ou crie um `VirtualHost` no Apache;
- No arquivo `agenda-back/Config/db.php`, edite e insira usuário e senha do seu banco de dados;
- Crie um banco de dados chamado `agenda`;
- Execute as SQLs presentes no arquivo `database.sql`, que está na raíz do projeto. Estas queries criarão a estrutura do banco de dados e alguns dados de teste;
## Configurar o cliente web
- Coloque a pasta do projeto do cliente web no diretório `/usr/local/var/www/` no macOS ou equivalente no Linux (localhost);
- No arquivo `settings.js` edite a URL da API previamente configurada;
- Acesse o cliente no navegador via `http://localhost/agenda-front`
