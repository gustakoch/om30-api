<p align="center">
<img src="public/logo-om30.png" alt="Logo OM30" width="200" />
</p>

# Desafio back-end PHP Laravel


## Objetivo
Desenvolver uma API RestFull de cadastro de pacientes com seu devido endereço.

## Recursos disponibilizados 
- Listagem de registros de pacientes e endereços com filtro por CPF e/ou nome do paciente.
- Listagem de um só registro de paciente com seu endereço.
- Criação de pacientes e endereços contendo os seguintes dados:
    - Foto do Paciente;
    - Nome Completo do Paciente;
    - Nome Completo da Mãe;
    - Data de Nascimento;
    - CPF;
    - CNS;
    - Endereço completo, (CEP, Endereço, Número, Complemento, Bairro, Cidade e Estado)*;
- Remoção de paciente e seu respectivo endereço.
- Consulta de CEP utilizando a API do ViaCEP.
- Importação de dados de pacientes em arquivo no formato .csv.
- Paginação da listagem de pacientes.

## Observações
- O versionamento do código do projeto foi feito baseado no padrão do [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/).
- A consulta do CEP está sendo mantida em cache com Redis.
- Foram criadas Factories e Seeders para popular as tabelas do banco de dados de forma simples e rápida.
- Criada função de validação do CPF do paciente. A função está disponível no arquivo `App\Helpers\Helpers.php`.
- Criadas funções de validação do CNS do paciente. Os algoritmos fornecidos no material de apoio foram transcritos para a linguagem PHP e utilizados na verificação do número informado na criação do registro e importação dos dados via arquivo .csv. As funções estão disponíveis em `App\Traits`.
- Os endpoints do projeto foram disponibilizados na raíz do projeto, você pode localizá-los pelo nome `endpoints.json`.
- O arquivo modelo de importação de dados em `.csv` foi disponibilizado na raíz do projeto, você pode localizá-lo pelo nome `import.csv`.

## Rodando o projeto
A aplicação foi desenvolvida utilizando o Docker, conforme recomendação. Na raíz do projeto, existe um arquivo chamado **docker-compose.yml** o qual contém os containers do php com apache, redis e postgres. Estando dentro da pasta do projeto, no terminal, basta rodar o comando `docker-compose up -d` para subir os containers da aplicação. As configurações de banco de dados, tanto do postgres quanto do redis são as padrões e você pode encontrá-las no arquivo `.env-example`.
