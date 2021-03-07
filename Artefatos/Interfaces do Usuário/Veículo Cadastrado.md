##### 1.1.1.3 Interface de usuário Veículo Cadastrado

---

###### 1.1.1.3.1 Leiaute sugerido
Página onde poderão ser vistas informações mais detalhadas de véiculo visitante cadastrado, como placa, modelo, cor, bloco, APTO de destino, status (Automaticamente), horário de chegada (Automaticamente), e a classificação (Se trata um visitante ou um prestador de serviço).
Possuirá uma navbar um pequeno navbar na parte superior da tela, no qual o lado esquerdo apresentará a logo do condominío e a um texto informando em qual portaria a conta está logada, e no lado direito terá o nome do usuário informado na criação da conta pelo administrador.
No corpo terá os campos com os dados preenchidos e o botão para marcar que o veículo saiu do condomínio.

---

###### 1.1.1.3.2 Relacionamentos com outras interfaces
Será possível acessar um cadastro de um veículo por meio da visão/página de Veículos Visitante (1.1.1.2).

---

###### 1.1.1.3.3 Campos
| Número | Nome | Descrição | Valores válidos | Formato | Tipo | Restrições |
| :----: | :--: | --------- | --------------- | :-----: | :--: | ---------- |
|    1    |   ID cadastro   |      Identificador único do veículo visitante cadastrado     |        ID         |     Não nulo.    |   ID.   |     Todos os cadastros devem possuir um.       |
|    2    |   Placa   |     Apresenta a placa do véiculo visitante cadastrado.      |     Não nulos.   |    Placa     |   Text.   |     *       |
|    3    |   Tempo dentro   |     Tempo no qual o veículo está ou esteve dentro do condomínio      |     Não nulo.            |    Difereça entre o tempo de chegada e atual ou saída     |   Time   |     Tempo válido.       |
|    4    |   Status   |     Status se o veículo visitante permanece ou já saiu do condomínio      |        Dentro/Fora         |    *     |   *   |      Apenas essas duas opções, não terá como voltar atrás após marcar como fora.      |
|    5    |   Modelo   |     Apresenta o modelo do veículo visitante cadastrado.      |     *   |    Modelo     |   Text.   |     *       |
|    6    |   Cor   |     Apresenta a cor do veículo visitante cadastrado.      |     *   |    Cor     |   Text.   |     *       |
|    7    |   Bloco   |     Apresenta o bloco que o veículo visitante foi.      |     Não nulos.   |    Bloco     |   Text.   |     *       |
|    8    |   Apto   |     Apresenta o apto que o veículo visitante foi.      |     Não nulos.   |    Apto     |   Text.   |     *       |
|    9    |   Horário de chegada   |     Apresenta o horário de chegada do veículo visitante.      |     Não nulos.   |    Horário     |   Time.   |     *       |
|    10    |   Classificação   |     Se veículo visitante é visitante ou prestador de serviço.      |     Não nulos.   |    Classificação     |   Classificação.   |     Apenas visitante ou prestador de serviço.       |

---

###### 1.1.1.3.4 Comandos
| Número | Nome | Ação | Restrições |
| :----: | :--: | ---- | ---------- |
|    1    |   Saída de veículo    |   Marcar que veículo visitante saiu do condomínio.   |      Somente veículos que ainda não sairam.      |