##### 1.1.1.1 Interface de usuário Login

---

###### 1.1.1.1.1 Leiaute sugerido
Página inicial do site para usuários que ainda não se conectaram em suas contas. Possuirá uma divisão centralizada com os campos de email e senha e os botões de logar e esqueci a senha (Abre um modal pedindo para inserir o email com um botão para enviar uma nova senha). Responsiva e o mais simples possível para se utilizar. Não existirá a opção de 'Criar conta', pois todas as contas só poderão ser geradas pelo usuário de administração.

---

###### 1.1.1.1.2 Relacionamentos com outras interfaces
Com o sucesso no login, será direcionado para a interface/página de Veículos Visitantes (1.1.1.2), exibindo um modal solicitando para selecionar a portaria na qual o usuário irá trabalhar.

---

###### 1.1.1.1.3 Campos
| Número | Nome | Descrição | Valores válidos | Formato | Tipo | Restrições |
| :----: | :--: | --------- | --------------- | :-----: | :--: | ---------- |
|   1    |   Email    |     Campo do formulário onde o usuário irá informar seu email.      |        Cadastrados no banco.         |    usuario@example.com     |   email   |     Deve estar dentro de um formulário.       |
|   2    |   Senha    |     Senha correspondente para o email informado.      |        Com mais de seis caracteres.         |     *    |   password   |      Deve estar dentro de um formulário.      |

---

###### 1.1.1.1.4 Comandos
| Número | Nome | Ação | Restrições |
| :----: | :--: | ---- | ---------- |
|    1    |   Botão de logar   |   Conferir com a API se os dados inseridos são válidos   |      Os campos estejam preenchidos      |
|    2    |   Botão de esqueci a senha   |   Abrir modal de solicitar nova senha por email.   |      Email do usuário seja válido e esteja preenchido.      |
