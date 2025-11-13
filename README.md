# whyl/laravel-api-scaffolder

Um pacote Laravel que fornece comandos Artisan para gerar classes de Service, Repository e Resources, seguindo uma estrutura de API padrão com filtros genéricos e respostas padronizadas.

## 🚀 Quick Start

```bash
# 1. Instalar o pacote
composer require whyl/laravel-api-scaffolder:dev-main

# 2. Instalar todos os componentes (o Laravel auto-descobre o pacote!)
php artisan scaffolder:install

# 3. Criar seu primeiro Repository e Service
php artisan make:repository UserRepository
php artisan make:service UserService
```

Pronto! Seu scaffolding de API está configurado com filtros genéricos e respostas padronizadas. ✨

**Nota:** O pacote usa auto-discovery do Laravel, não sendo necessário registrar manualmente o ServiceProvider.

## Funcionalidades

Este pacote adiciona os seguintes comandos Artisan ao seu projeto Laravel:

### Comando Principal (Recomendado)
-   `scaffolder:install`: **Instala todos os componentes** (Repositories, Services e Resources) de uma vez.

### Comandos Individuais
-   `make:service <NomeDoServico>`: Cria uma nova classe de Service que estende `App\Services\Service`.
-   `make:repository <NomeDoRepositorio>`: Cria uma nova classe de Repository que estende `App\Repositories\Repository` e injeta o modelo correspondente.
-   `service:install`: Instala apenas a classe base `App\Services\Service.php`.
-   `repository:install`: Instala apenas a classe base `App\Repositories\Repository.php`.
-   `resource:install`: Instala apenas as classes base de Resources.

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

### 3. Instalar Todos os Componentes (Recomendado)

O pacote usa **auto-discovery do Laravel**, então após instalar via Composer, os comandos já estarão disponíveis automaticamente.

Execute o comando de instalação único que configura tudo automaticamente:

```bash
php artisan scaffolder:install
```

Este comando instalará automaticamente:

**Repositories:**
- `app/Repositories/Repository.php` - Classe base com filtros genéricos

**Services:**
- `app/Services/Service.php` - Classe base para lógica de negócios

**Resources (HTTP):**
- `app/Http/Resources/Resource.php` - Resource para respostas de sucesso
- `app/Http/Resources/ErrorResource.php` - Resource para erros padronizados
- `app/Http/Resources/ResourceCollection.php` - Resource para coleções paginadas

#### Instalação Individual (Opcional)

Se preferir instalar apenas componentes específicos:

```bash
php artisan repository:install  # Apenas Repository
php artisan service:install     # Apenas Service
php artisan resource:install    # Apenas Resources
```

**Output do comando `scaffolder:install`:**

```
╔══════════════════════════════════════════════════════════════╗
║           Laravel API Scaffolder - Installation             ║
╚══════════════════════════════════════════════════════════════╝

📁 Installing Base Repository...
✓ Directory created: /path/to/app/Repositories
✓ Base Repository class installed successfully

⚙️  Installing Base Service...
✓ Directory created: /path/to/app/Services
✓ Base Service class installed successfully

📦 Installing Base Resources...
✓ Resource.php installed successfully
✓ ErrorResource.php installed successfully
✓ ResourceCollection.php installed successfully

╔══════════════════════════════════════════════════════════════╗
║                 ✅ Installation Complete!                    ║
╚══════════════════════════════════════════════════════════════╝

📝 Next steps:
   1. Start creating your APIs:
      • php artisan make:repository UserRepository
      • php artisan make:service UserService
```

## Uso

Após a instalação, você pode usar os comandos para gerar suas classes:

### Gerar um Service

```bash
php artisan make:service UserService
```

Isso criará `app/Services/UserService.php` estendendo `App\Services\Service`.

### Gerar um Repository

```bash
php artisan make:repository UserRepository
```

Isso criará `app/Repositories/UserRepository.php` estendendo `App\Repositories\Repository` e injetando o modelo `App\Models\User`.

## Resources Base

O pacote instala três classes de Resources base para padronizar as respostas da sua API:

### 1. Resource.php
Resource padrão que retorna respostas de sucesso formatadas:

```json
{
  "status": "success",
  "users": { /* dados do resource */ }
}
```

### 2. ErrorResource.php
Resource para tratamento de erros que retorna mensagens contextualizadas baseadas no método HTTP:

```json
{
  "status": "error",
  "message": "An error occurred while creating the users"
}
```

### 3. ResourceCollection.php
Resource para coleções paginadas que mantém a estrutura de paginação do Laravel:

```json
{
  "status": "success",
  "data": [ /* array de recursos */ ],
  "meta": { /* metadados de paginação */ },
  "links": { /* links de navegação */ }
}
```

## Filtros Genéricos no Repository Base

A classe base `Repository` inclui filtros genéricos que podem ser usados em todas as suas consultas de listagem (método `index`). Os seguintes filtros estão disponíveis via query parameters:

### Filtros Disponíveis

#### 1. Paginação
```
GET /api/users?per_page=20
```
Define quantos registros por página (padrão: 10)

#### 2. Filtros por Campo
```
GET /api/users?status=active
GET /api/users?role=admin&status=active
```
Filtra por qualquer campo do modelo usando igualdade simples

#### 3. Filtros por Range de Datas
```
GET /api/users?created_at=01/01/2024,31/01/2024
GET /api/users?updated_at=01/12/2024,31/12/2024
```
Filtra registros entre duas datas (formato: `dd/mm/yyyy,dd/mm/yyyy`)

#### 4. Ordenação
```
GET /api/users?sort=recent        # Mais recentes (created_at desc)
GET /api/users?sort=oldest        # Mais antigos (created_at asc)
GET /api/users?sort=name_asc      # Por nome ascendente
GET /api/users?sort=name_desc     # Por nome descendente
GET /api/users?sort=email:asc     # Ordenação customizada (campo:direção)
```

### Sobrescrevendo Filtros

Se você precisar de filtros mais complexos (com relacionamentos, por exemplo), pode sobrescrever o método `index` no seu repository específico:

```php
public function index(object $model)
{
    $filters = request()->query();
    $query = $model::query();
    
    // Seus filtros customizados aqui
    if (!empty($filters['custom_field'])) {
        $query->whereHas('relation', function ($q) use ($filters) {
            $q->where('field', $filters['custom_field']);
        });
    }
    
    // Chame os filtros base se desejar
    $this->applyDateRangeFilter($query, $filters);
    $this->applySorting($query, $filters);
    
    $perPage = $filters['per_page'] ?? 10;
    return $query->paginate($perPage);
}
```

## Publicando Stubs (Opcional)

Se você quiser personalizar os stubs usados pelos comandos `make:service` e `make:repository`, você pode publicá-los:

```bash
php artisan vendor:publish --tag=stubs
```

Isso copiará os stubs para o diretório `stubs/` na raiz do seu projeto Laravel, onde você poderá modificá-los.

## 🔧 Troubleshooting

### Comandos não encontrados após instalação

Se após instalar o pacote os comandos não estiverem disponíveis, siga estes passos:

**1. Limpar caches:**
```bash
composer dump-autoload
php artisan optimize:clear
```

**2. Verificar se o pacote foi instalado:**
```bash
composer show whyl/laravel-api-scaffolder
```

**3. Laravel 12 - Registrar manualmente (se necessário):**

Se o auto-discovery não funcionar, adicione ao `bootstrap/app.php`:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withProviders([
        Whyl\ApiScaffolder\ApiScaffolderServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

**4. Verificar comandos disponíveis:**
```bash
php artisan list | grep -E "(scaffolder|repository|service)"
```

Você deve ver:
- `scaffolder:install`
- `repository:install`
- `service:install`
- `resource:install`
- `make:repository`
- `make:service`

## 📖 Exemplo Completo de Uso

Aqui está um exemplo completo de como usar o pacote em um projeto Laravel:

### 1. Instalar e Configurar

```bash
# Instalar o pacote
composer require whyl/laravel-api-scaffolder:dev-main

# Instalar os componentes base (Repository, Service, Resources)
php artisan scaffolder:install
```

### 2. Criar Repository e Service

```bash
php artisan make:repository ProductRepository
php artisan make:service ProductService
```

### 3. Implementar o Repository (app/Repositories/ProductRepository.php)

```php
<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends Repository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Product();
    }
    
    // Os filtros genéricos já estão disponíveis!
    // Você pode adicionar métodos customizados aqui se precisar
}
```

### 4. Implementar o Service (app/Services/ProductService.php)

```php
<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductService extends Service
{
    protected $model;
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->model = new Product();
        $this->repository = $repository;
    }
    
    // Métodos base já herdados: index, show, store, update, destroy
    // Adicione métodos customizados conforme necessário
}
```

### 5. Usar no Controller (app/Http/Controllers/ProductController.php)

```php
<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        // Filtros automáticos via query params:
        // ?per_page=20
        // ?status=active
        // ?created_at=01/01/2024,31/12/2024
        // ?sort=recent
        return $this->service->index();
    }

    public function show(Product $product)
    {
        return $this->service->show($product);
    }

    public function store(Request $request)
    {
        $product = new Product($request->all());
        return $this->service->store($product);
    }

    public function update(Request $request, Product $product)
    {
        $newData = new Product($request->all());
        return $this->service->update($product, $newData);
    }

    public function destroy(Product $product)
    {
        return $this->service->destroy($product);
    }
}
```

### 6. Exemplos de Requisições e Respostas

**GET /api/products?per_page=20&status=active&sort=recent**

Resposta de sucesso (200):
```json
{
  "status": "success",
  "data": [
    {"id": 1, "name": "Product 1", "status": "active"},
    {"id": 2, "name": "Product 2", "status": "active"}
  ],
  "meta": {
    "current_page": 1,
    "per_page": 20,
    "total": 50
  },
  "links": {...}
}
```

**POST /api/products**

Resposta de sucesso (200):
```json
{
  "status": "success",
  "products": {
    "id": 3,
    "name": "New Product",
    "status": "active"
  }
}
```

Resposta de erro (404):
```json
{
  "status": "error",
  "message": "An error occurred while creating the products"
}
```

## ✨ Principais Funcionalidades

### 🔍 Filtros Genéricos Automáticos
- Paginação configurável
- Filtros por qualquer campo do modelo
- Range de datas (created_at, updated_at)
- Ordenação flexível (recent, oldest, custom)

### 📦 Resources Padronizados
- Respostas de sucesso formatadas
- Tratamento de erros contextualizado
- Coleções com paginação automática

### 🚀 Geração Rápida de Código
- Repository com filtros prontos
- Service com CRUD completo
- Resources para API RESTful

### 🎯 Compatibilidade
- Laravel 11.x e 12.x
- PHP 8.1+ e 8.2+
- Auto-discovery habilitado

## 📊 Estrutura de Resposta da API

Todas as respostas da API seguem um padrão consistente:

**Sucesso (200 OK):**
```json
{
  "status": "success",
  "table_name": { /* dados */ }
}
```

**Coleção (200 OK):**
```json
{
  "status": "success",
  "data": [ /* itens */ ],
  "meta": { /* paginação */ },
  "links": { /* navegação */ }
}
```

**Erro (404 Not Found):**
```json
{
  "status": "error",
  "message": "An error occurred while [action] the [table]"
}
```

## 🤝 Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests no repositório do GitHub.

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Changelog

### v1.0.0 (Atual)
- ✅ Comando único de instalação (`scaffolder:install`)
- ✅ Filtros genéricos no Repository base
- ✅ Resources padronizados (Resource, ErrorResource, ResourceCollection)
- ✅ Auto-discovery do Laravel
- ✅ Suporte para Laravel 11 e 12

## 📄 Licença

Este pacote é open-source e licenciado sob a [MIT License](LICENSE.md).

---

Desenvolvido com ❤️ por [Whylgher Lima](https://github.com/whyllima)
