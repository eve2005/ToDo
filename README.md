# 📝 To DO

Sistema de gerenciamento de tarefas desenvolvido com **Nuxt** no front-end e **Laravel** no back-end.


## 🚀 Como Rodar o Projeto

### 1. Pré-requisitos
* PHP >= 8.2
* Node.js >= 18.x
* Composer
* MySQL ou SQLite
---

### 🐘 Back-end (Laravel)

Abra o terminal na pasta do servidor( /api ):

1. **Instalar dependências:**
   ```bash
   composer install
   ```
2. **Configurar o ambiente:**
  Duplique o arquivo .env.example e renomeie para .env
   ```bash
      cp .env.example .env
      # ou
      copy .env.example .env
    ```
   Configure a conexão com seu banco de dados no .env
   
   Gerar chave da aplicação:
    ```bash
      php artisan key:generate
    ```
3. **Rodar as migrações:**
   ```bash
    php artisan migrate
   ```
4. **Iniciar o servidor:**
   ```bash
    php artisan serve
    ```
    O servidor rodará em: http://localhost:8000
---
###  🖥 Front-end (Nuxt )
  Abra outro terminal na pasta do frontend ( /frontend):
1. **Instalar dependências:**
   ```bash
   npm install
    ```
2. **Iniciar o ambiente de desenvolvimento:**
    ```bash
      npm run dev
    ```
    O projeto abrirá em: http://localhost:3000

###  ⚠️ Como acessar a aplicação:
Para utilizar o sistema, você deve acessar o endereço do Nuxt no seu navegador:

👉 **Acesso principal:** [http://localhost:3000](http://localhost:3000)

> **Nota:** O servidor do Laravel (`http://localhost:8000`) deve permanecer ligado em segundo plano para que a API funcione, mas a interação com o usuário acontece exclusivamente pela interface do Nuxt no endereço acima.


 
