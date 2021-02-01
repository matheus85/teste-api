<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Tutorial
<pre>
1 - git clone https://github.com/matheus85/teste-api.git

2 - composer install

3 - Configure o banco de dados no .env

4 - php artisan migrate --seed

5 - Todos os endpoints foram salvos em uma collection do postman e está na raiz do projeto.
Arquivo: Spoten.postman_collection.json
Alterar as variáveis url_test e token_bearer da collection para as suas informações.

Basicamente o projeto é:

Autenticação
POST - /signup
POST - /login
DELETE - /logout

Movies
GET - /movies
GET - /movies/{id}

Ratings
GET - /ratings
GET - /ratings{id}
POST - /ratings

Foram criadas 2 tabelas Movies e Ratings
Ao listar os filmes também mostra suas avaliações e uma média das avaliações.


Em caso de dúvidas entrar em contato.
</pre>