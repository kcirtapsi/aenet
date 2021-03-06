# Projeto NFe AENET

## FASE 2

### Objetivo:

Baixar automaticamente todas as NFe e outros documentos fiscais destinados aos clientes cadastrados na tabela cadastro.

### Pré-Requisitos:

Certificado digital A1 (via software) para cada empresa usuária
Tabela com cadastro completo da empresa usuária

### Funcionamento:

Usando o [CRONTAB](Cron.md) será executado um script periodicamente, em intervalos de tempo de aproximadamente 2 horas.

Esse intervalo de tempo é limitado devido a restrições de acesso por parte da Receita Federal.

> NOTA: Esse sistema DFe da Receita, não possui dados em "REAL TIME", é um processo em "batch" com sincronismo a determinados intervalos, as primeiras consultas irão retornar documentos emitidos até os 3 meses anteriores e não antes disso, mas buscas posteriores somente serão retornadas os documentos mais recentes.

> NOTA: O processo de distribuição de documentos fiscais pela Receita, funciona dando um numero de identificação próprio para cada documento, a pesquisa retorna os dados por esse numero (NSU), mas são fornecidos apenas resumos desses documentos. A partir desses resumos, temos informações suficientes para realizar a "MANIFESTAÇÃO DE DESTINATÁRIO", e apenas a "ciência da operação" pode ser executada de forma automática. Após a manifestação, em buscas posteriores, estará disponível o XML do documento fiscal para download, portanto poderá haver um intervalo de horas entre a descoberta do documento e sua disponibilização.

> NOTA: A cada chamada SOAP podem ser retornados de ZERO até 50 resumos de documentos por vez, mas isso é estabelecido pela Receita e não por nós. Como o processo roda em um loop de até 50 chamadas consecutivas, então a cada duas horas podem ser retornados de ZERO até 2500 documentos (50 chamadas com 50 docs retornados por chamada).

Esse script (processo) irá:

* buscar os clientes da tabela cadastro, e para cada um deles irá:
* buscar o numero do ultimo NSU -- na base tabela dfe_nsus
* realizar uma busca no webservice (a busca é iterativa em um loop de até 10 chamadas SOAP a cada processamento)
* gravar os dados recebidos dos resumos ou dos XML na tabela dfe_nsus

Outro script (processo) irá:

* varrer a tabela da base de dados dos resumos retornados
* identificar os casos que requerem manifestação, dentre os resumos recebidos e ainda não manifestados
* realizar a manifestação de "ciência da operação" no webservice da Receita

Tarefas:

1. <s>[Estabelecer tabelas necessárias na base de dados](Fase2/Tarefa1.md)</s> FINALIZADO
2. <s>[Montar os scripts e classes para a realização das tarefas e tratamento das exceções](Fase2/Tarefa2.md)</s> FINALIZADO
3. [Montar testes unitários para garantir funcionamento em atualizações futuras](Fase2/Tarefa3.md)
4. [Definir e montar as interfaces de administração](Fase2/Tarefa4.md)
5. [Definir e montar as interfaces de usuário](Fase2/Tarefa5.md)

> Para cada FASE do projeto, devem ser documentadas as tarefas e ações realizadas para que possam ser reproduzidas, desfeitas ou analisadas.
> Outra coisa importante é estabelecer como serão registrados, recuperados e eliminados  os LOGS das operações, sejam elas automáticas ou não.
> E importante também realizar medições de carga, desde o inicio do projeto pois existe a previsão de entrada de muitos outros "players" que irão afetar essas cargas. O sistema é leve, em principio mas essa "leveza" deve ser avaliada.

