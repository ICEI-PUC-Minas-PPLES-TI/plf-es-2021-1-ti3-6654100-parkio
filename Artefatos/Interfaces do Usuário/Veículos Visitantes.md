##### 1.1.1.2 Interface de usuário Veículos Visitantes

---

###### 1.1.1.2.1 Leiaute sugerido
Só terá acesso à essa página usuários já logados. Toda vez quando um usuário logar deverá ser redirecionado para o modal dessa página solicitando selecionar qual portaria ele está. Essa página possuirá um pequeno navbar na parte superior da tela, no qual o lado esquerdo apresentará a logo do condominío e a um texto informando em qual portaria a conta está logada, e no lado direito terá o nome do usuário informado na criação da conta pelo administrador.
No corpo da página existirá uma lista com todos os veículos visitantes registrados por todos os porteiros portaria selecionada, ordenados inicialmente pelos últimos cadastrados. Essa lista deverá ser atualizada constantemente e possuir um filtro e busca para facilitar pesquisas.
Pouco acima do filtro dessa lista, antes da navbar deverá existir um botão consideravelmente grande para cadastrar um novo veículo visitante.
Para marcar que o veículo saiu do condomínio, o cadastro dele deverá ser selecionado e clicar no botão de Saiu.

---

###### 1.1.1.2.2 Relacionamentos com outras interfaces
Botão de cadastrar novo veículo se relaciona com a visão/página de formulário para Cadastrar Novo Veículo (1.1.1.3) visitante.

---

###### 1.1.1.2.3 Campos
| Número | Nome | Descrição | Valores válidos | Formato | Tipo | Restrições |
| :----: | :--: | --------- | --------------- | :-----: | :--: | ---------- |
|        |      |           |                 |         |      |            |
|    1    |   Busca   |     Campos de busca para pesquisar qualquer dado de veículos visitantes cadastrados anteriormente.      |        Placa, modelo ou cor.         |    Texto     |   Textarea   |      *      |
|    2    |   ID cadastro   |      Identificador único do veículo visitante cadastrado     |        ID         |     Não nulo.    |   ID.   |     Todos os cadastros devem possuir um.       |
|    3    |   Placa   |     Apresenta a placa do veículo na lista de veículos visitantes cadastrados      |     Não nulos.   |    Placa     |   Text.   |     *       |
|    4    |   Tempo dentro   |     Tempo no qual o veículo está ou esteve dentro do condomínio      |     Não nulo.            |    Difereça entre o tempo de chegada e atual ou saída     |   Time   |     Tempo válido.       |
|    5    |   Status   |     Status se o veículo visitante permanece ou já saiu do condomínio      |        Dentro/Fora         |    *     |   *   |      Apenas essas duas opções, não terá como voltar atrás após marcar como fora.      |

---

###### 1.1.1.2.4 Comandos
| Número | Nome | Ação | Restrições |
| :----: | :--: | ---- | ---------- |
|        |      |      |            |
|    1    |   Filtro por período.   |     Filtrar veículos cadastrados em um certo período de tempo definido.      | Que seja um período válido.       |
|    2    |   Ordenar por últimos cadastrados    |   Ordenar a lista de veículos cadastrados pelos últimos cadastrados por todos os usuários na portaria logada.   |      *      |
|    3    |   Ordenar por mais tempo dentro    |   Ordenar a lista de veículos cadastrados veículos cadastrados que estão a mais tempo dentro do condomínio.   |      *      |
|    4    |   Saída de veículo    |   Marcar que veículo visitante saiu do condomínio.   |      Somente veículos que ainda não sairam.      |