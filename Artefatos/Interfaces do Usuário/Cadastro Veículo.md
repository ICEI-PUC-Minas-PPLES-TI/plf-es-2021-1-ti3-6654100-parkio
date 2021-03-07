##### 1.1.1.4 Interface de usuário Cadastro Veículo

---

###### 1.1.1.4.1 Leiaute sugerido
Página onde poderão ser vistas informações mais detalhadas de véiculo visitante cadastrado, como placa, modelo, cor, bloco, APTO de destino, status (Automaticamente), horário de chegada (Automaticamente), e a classificação (Se trata um visitante ou um prestador de serviço).
Possuirá uma navbar um pequeno navbar na parte superior da tela, no qual o lado esquerdo Informará a logo do condominío e a um texto informando em qual portaria a conta está logada, e no lado direito terá o nome do usuário informado na criação da conta pelo administrador.
No corpo terá os campos com os dados para serem preenchidos, e para enviar os dados terá um botão de Cadastrar.

---

###### 1.1.1.4.2 Relacionamentos com outras interfaces
Registrará os veículos para a página de Veículos Visitantes (1.1.1.2).

---

###### 1.1.1.4.3 Campos
| Número | Nome | Descrição | Valores válidos | Formato | Tipo | Restrições |
| :----: | :--: | --------- | --------------- | :-----: | :--: | ---------- |
|    1    |   ID cadastro   |      Identificador único do veículo visitante cadastrado     |        ID         |     ID.    |   *   |     Obrigatório.       |
|    2    |   Placa   |     Informa a placa do véiculo visitante cadastrado.      |     *   |    Placa     |   Text.   |     Obrigatório       |
|    3    |   Tempo dentro   |     Tempo no qual o veículo está ou esteve dentro do condomínio      |     *            |    Difereça entre o tempo de chegada e atual ou saída     |   Time   |     Obrigatório.       |
|    4    |   Status   |     Status se o veículo visitante permanece ou já saiu do condomínio      |        Dentro/Fora         |    *     |   *   |      Obrigatório.      |
|    5    |   Modelo   |     Informa o modelo do veículo visitante cadastrado.      |     *   |    Modelo     |   *   |     Não obrigatório       |
|    6    |   Cor   |     Informa a cor do veículo visitante cadastrado.      |     *   |    Cor     |   *   |     Não obrigatório.       |
|    7    |   Bloco   |     Informa o bloco que o veículo visitante foi.      |     *   |    Bloco     |   Text.   |     Obrigatório.       |
|    8    |   Apto   |     Informa o apto que o veículo visitante foi.      |     *   |    Apto     |   Text.   |     Obrigatório.       |
|    9    |   Horário de chegada   |     Informa o horário de chegada do veículo visitante.      |     *   |    Horário     |   Time.   |     Obrigatório.       |
|    10    |   Classificação   |     Se veículo visitante é visitante ou prestador de serviço.      |     *   |    Classificação     |   Classificação.   |     Não obrigatório.       |

---

###### 1.1.1.4.4 Comandos
| Número | Nome | Ação | Restrições |
| :----: | :--: | ---- | ---------- |
|   1    | Cadastrar | Botão para cadastrar dados informados. | Todos os campos *s devem estar preenchidos. |