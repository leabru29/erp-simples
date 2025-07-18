# ERP Simples

Sistema ERP modular desenvolvido com Laravel 12, usando Laravel Sail para ambiente em Docker. Foco em gestão de produtos com variações, controle de estoque e pedidos.

## ⚙️ Tecnologias Utilizadas

- **Laravel 12**
- **PHP 8.3**
- **Laravel Sail** (Docker)
- **MySQL**
- **jQuery + Bootstrap**
- **AdminLTE**
- **Datatables**
- **API ViaCEP**
- **UUIDs**
- **Padrão RESTful**

## 🧩 Funcionalidades

### 🛍️ Produtos
- Cadastro de produtos com múltiplas variações (ex: tamanho, cor)
- Relacionamento com fornecedores
- Interface com modais (AJAX) para criação e edição

### 📦 Estoque
- Controle de estoque por variação
- Atualização automática ao realizar pedidos

### 🛒 Carrinho de Compras
- Adição e edição de itens com variações
- Validação de estoque
- Persistência na sessão (sem necessidade de login)
- Cálculo de frete via ViaCEP

### 🧾 Pedidos
- Finalização de pedidos a partir do carrinho
- Aplicação de cupons de desconto
- Cálculo de total com frete

### 🎫 Cupons
- Cadastro de cupons por código
- Validação por data de validade e quantidade disponível

## 🚀 Como Executar

### 1. Clonar o projeto

```bash
git clone https://github.com/leabru29/erp-simples.git
cd erp-simples
```

### 2. Subir o ambiente com o Sail

```bash
./vendor/bin/sail up -d
```

### 3. Instalar dependências e configurar

```bash
composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

### 4. Acessar no navegador

```bash
http://localhost
```

### 🧪 Testes
O projeto conta com testes automatizados de funcionalidades principais:

```bash
./vendor/bin/sail artisan test
```

## ✍️ Autor

**Leandro Bezerra da Silva**  
🔗 [LinkedIn](https://www.linkedin.com/in/leandro-bezerra-da-silva-740064145/)  
🐙 [GitHub](https://github.com/leabru29)
