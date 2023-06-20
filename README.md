
# Workshop
A primeira etapa é a criacao do projeto:
```bash
composer create-project laravel/laravel workshop
```
Após isso, acessaremos o projeto `cd workshop`.

Agora podemos rodar a instalacao de dependencias rodando o comando `composer install`

Nessa etapa temos que criar o banco de dados, isso será feito manualmente. E entao vamos acessar o arquivo .env e modificarmos os dados de acesso ao banco:
```bash
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=workshop
DB_USERNAME=root
DB_PASSWORD=
```

E após rodamos o comando `php artisan key:generate` para gerar as chaves do projeto e depois `php artisan migrate` para criar as tabelas no banco de dados

Pronto! Agora já temos uma aplicacao funcional e podemos acessar ela no navegador.

A partir disso vamos comecar a criar a nossa API!

Devemos alterar a migration users e deixar somente os campos que julgamos necessarios, após isso rodar o comando `php artisan migrate:fresh` para limpar o banco e criar as tabelas novamente.

Usaremos o comando `php artisan make:controller UserController` para geramos o controlador da nossa api de usuarios, é nesse arquivo onde teremos os métodos que as rotas irão acessar.

Dentro do **UserController** o código fonte ficará dessa forma:

````
    public function index()
    {
        return response()->json(User::all());
    }

    public function show($id)
    {
        return response()->json(User::find($id));
    }

    public function store(Request $data)
    {
        try {
            return response()->json(User::create($data->toArray()));
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function update($id, Request $data)
    {
        User::find($id)->update($data->toArray());

        return response()->json(User::find($id));
    }

    public function delete($id)
    {
        $deletedUser = User::find($id)->delete();

        if($deletedUser){
            return response("success");
        }else{
            return response("error");
        }
    }
````
Após configurarmos o controlador, precisaremos colar o código fonte das rotas dentro da pasta "routes/api.php", assim conseguiremos fazer as requisições para a API.  

````
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function (){
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'delete']);
});
````

## Documentação da API

#### Retorna todos os usuários

```http
  GET /api/users
```

#### Retorna um usuário

```http
  GET /api/users/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `integer` | **Obrigatório**. O ID do usuário que você quer buscar|

#### Cria um novo usuário

```http
  POST /api/users/
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `name`      | `string` | **Obrigatório**. O nome do usuário|
| `email`      | `string` | **Obrigatório**. O email do usuário|
| `phone`      | `integer` | **Obrigatório**. O telefone do usuário|

#### Atualiza um usuário

```http
  PUT /api/users/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `integer` | **Obrigatório**. O ID do usuário que você quer atualizar |
| `name`      | `string` | **Opcional**. O nome do usuário|
| `email`      | `string` | **Opcional**. O email do usuário|
| `phone`      | `integer` | **Opcional**. O telefone do usuário|

#### Deleta um usuário

```http
  DELETE /api/users/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `integer` | **Obrigatório**. O ID do usuário que você quer deletar |
