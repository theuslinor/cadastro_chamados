# 🛠️ Sistema de Chamados Técnicos

Este projeto consiste em uma aplicação web simples para **registro e gerenciamento de chamados técnicos**, com foco em ambientes corporativos ou escolares. A aplicação permite o cadastro de chamados, visualização por administradores e atualização de status com base na prioridade.

## 🚀 Tecnologias Utilizadas

- **HTML5** & **CSS3** – Estrutura e estilização da interface
- **Bootstrap 5** – Layout responsivo e componentes modernos
- **PHP** – Lógica de backend
- **MySQL** – Banco de dados relacional
- **XAMPP** – Ambiente de desenvolvimento local

## ⚙️ Funcionalidades

- 📌 **Cadastro de Chamados**  
  Os usuários podem registrar novos chamados, incluindo título, descrição, tipo de problema e nível de prioridade.

- 📋 **Listagem e Gerenciamento** (Admin)  
  Visualização de todos os chamados com filtros por status, ordenação por prioridade e opções de:
  - Atualizar status (`Aberto`, `Em andamento`, `Concluído`)
  - Excluir chamados

- 🧠 **Matriz de Prioridade**  
  A ordenação dos chamados utiliza uma lógica baseada na urgência (Alta, Média, Baixa).

## 💡 Observações Técnicas

- As páginas `header.php` e `footer.php` são incluídas dinamicamente para reutilização de layout.
- A conexão com o banco de dados é feita via `mysqli`.
- A interface utiliza **modais Bootstrap** para exibir a descrição completa de cada chamado.
- A aplicação é 100% local, sendo executada por meio do `XAMPP`.

## 📝 Autor

Desenvolvido por **Matheus** como parte do projeto acadêmico da disciplina de Imersão Profissional.

---