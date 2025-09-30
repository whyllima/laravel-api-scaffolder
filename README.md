# whyl/laravel-api-scaffolder

Um pacote Laravel que fornece comandos Artisan para gerar classes de Service e Repository, seguindo uma estrutura de API padrão, e também comandos para instalar as classes base de Service e Repository.

## Funcionalidades

Este pacote adiciona os seguintes comandos Artisan ao seu projeto Laravel:

-   `make:service <NomeDoServico>`: Cria uma nova classe de Service que estende `App\Http\Services\Service`.
-   `make:repository <NomeDoRepositorio>`: Cria uma nova classe de Repository que estende `App\Http\Repositories\Repository` e injeta o modelo correspondente.
-   `service:install`: Instala a classe base `App\Http\Services\Service.php` no seu projeto.
-   `repository:install`: Instala a classe base `App\Http\Repositories\Repository.php` no seu projeto.

## Instalação

Siga os passos abaixo para instalar o pacote no seu projeto Laravel.

### 1. Adicionar o Repositório ao `composer.json`

Como este pacote ainda não está no Packagist, você precisa informar ao Composer onde encontrá-lo. Adicione a seguinte seção `repositories` ao seu `composer.json` principal (geralmente na raiz do seu projeto Laravel):

```json
// composer.json
{
    // ...
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/whyllima/laravel-api-scaffolder.git"
        }
    ],
    // ...
}
```

### 2. Requerer o Pacote

Agora você pode requerer o pacote usando o Composer. Como ele está em desenvolvimento, especifique a branch `dev-main`:

```bash
composer require whyl/laravel-api-scaffolder:dev-main
```

### 3. Registrar o Service Provider (Passo Manual Essencial)

Devido a conflitos de auto-descoberta, a auto-descoberta de pacotes para este pacote está desabilitada. Você precisará registrar manualmente o Service Provider do pacote no seu projeto.

Abra o arquivo `bootstrap/providers.php` e adicione a classe do Service Provider ao array de retorno:

```php
// bootstrap/providers.php

return [
    App\Providers\AppServiceProvider::class,
    Whyl\ApiScaffolder\ApiScaffolderServiceProvider::class, // Adicione esta linha
];
```

### 4. Instalar as Classes Base (Opcional, mas Recomendado)

Para que os comandos `make:service` e `make:repository` funcionem corretamente, você precisará das classes base `Service.php` e `Repository.php` no seu projeto. Você pode instalá-las usando os comandos fornecidos pelo pacote:

```bash
php artisan service:install
php artisan repository:install
```

Estes comandos criarão os arquivos:
- `app/Http/Services/Service.php`
- `app/Http/Repositories/Repository.php`

## Uso

Após a instalação, você pode usar os comandos para gerar suas classes:

### Gerar um Service

```bash
php artisan make:service UserService
```

Isso criará `app/Http/Services/UserService.php` estendendo `App\Http\Services\Service`.

### Gerar um Repository

```bash
php artisan make:repository UserRepository
```

Isso criará `app/Http/Repositories/UserRepository.php` estendendo `App\Http\Repositories\Repository` e injetando o modelo `App\Models\User`.

## Publicando Stubs (Opcional)

Se você quiser personalizar os stubs usados pelos comandos `make:service` e `make:repository`, você pode publicá-los:

```bash
php artisan vendor:publish --tag=stubs
```

Isso copiará os stubs para o diretório `stubs/` na raiz do seu projeto Laravel, onde você poderá modificá-los.

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests no repositório do GitHub.

## Licença

Este pacote é open-source e licenciado sob a [MIT License](LICENSE.md).
