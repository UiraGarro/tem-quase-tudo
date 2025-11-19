#  Tem Quase Tudo

##  Escopo do Projeto

O presente projeto tem como objetivo o desenvolvimento de um site de **e-commerce** denominado **“Tem Quase Tudo”**, voltado à venda de produtos diversos em um ambiente virtual simples, funcional e acessível.  

---

##  Objetivos do Sistema

O sistema permitirá que os usuários:
- Naveguem entre diferentes categorias de produtos;
- Visualizem informações detalhadas de cada item;
- Adicionem produtos ao carrinho;
- Realizem pedidos.

Além disso, haverá uma **área administrativa** destinada ao gerenciamento de produtos, categorias e usuários, possibilitando o **cadastro**, **edição** e **exclusão** de registros.

---

##  Funcionalidades Principais

-  **Cadastro e login de usuários** (clientes e administradores);
-  **Exibição de produtos** com nome, descrição, preço e imagem;
-  **Busca de produtos** por palavra-chave;
-  **Carrinho de compras** e registro de pedidos;
-  **Painel administrativo** para gerenciamento de produtos e usuários;
-  **Integração com banco de dados relacional**, responsável pelo armazenamento seguro das informações do sistema.

---

## Tecnologias Utilizadas

| Camada | Tecnologias |
|---------|--------------|
| **Front-end** | HTML, CSS, JavaScript **(se possível)** |
| **Back-end** | PHP |
| **Banco de Dados** | MySQL |

O projeto terá foco na **usabilidade**, **organização do código** e no funcionamento básico das operações **CRUD (Create, Read, Update, Delete)**.

---
## Código SQL para criar o banco de dados do projeto
```
CREATE DATABASE tem_quase_tudo_db;
USE tem_quase_tudo_db;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    desconto DECIMAL(5,2) NOT NULL DEFAULT 0, -- porcentagem de desconto
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  senha VARCHAR(100) NOT NULL,
  telefone VARCHAR(50),
  endereco VARCHAR(255),
  cidade VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
---

## Equipe

- Matheus Henrique de Lima Mendonça;
- William Aguiar Barreto;
- Rodrigo Ono Galvão;
- Uirá Xavier de Medeiros Garro;
- Victor Daniel da Silva Balbino;

---

