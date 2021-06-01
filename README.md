# Teste para o suporte do curso FullCycle

## O que você deverá fazer:

A seguir estão questões dos mais variados tópicos passados no curso. O objetivo é que você:

* Entenda o que o aluno pediu na dúvida
* Investigue o problema relatado pelo aluno
* Se necessário, acesse o código-fonte compartilhado por ele e rode a aplicação com problema na sua máquina
* Crie uma resposta para o aluno usando toda formalidade de um suporte, sendo educado e cordial, além de ser claro e objetivo na resposta
* Quanto mais dúvida você responder de forma correta contará mais pontos para sua classificação.

Bom trabalho!

## Dúvidas

<br><br>

### Docker

<br><br>

1. O playground do GraphQL da aplicação Golang não está funcionando direito. Quando digito http://localhost:8080 o browser diz que não tem conteúdo.

    Repositório [docker-question1](../../tree/main/repositories/docker-question1)

<br><br>

2. Olá,

    Fiz o segundo desafio do módulo de Docker e  esta tudo certo, porém percebi que ocorria erro no momento de subir a aplicação node, pois a mesma se conecta ao Mysql antes dele estar de pé.

    A solução foi usar o dockerize dentro do Dockerfile que cria o container node, e no docker-compose.yaml, usei a diretiva:

    entrypoint: dockerize -wait tcp://database:3306 docker-entrypoint.sh

    O problema é que a partir dai  quando acesso http://localhost:8080/ o nginx  retorna 502 Bad Gateway

    Repositório [docker-question2](../../tree/main/repositories/docker-question2)

<br><br>

3. Olá, 

    Estou no vídeo Nginx como proxy reverso e estou com algum problema no meu Nginx container(acho), pois não tenho o mesmo resultado do final com a aplicação rodando e estou com dificuldades para ver os logs somente desse container do nginx.

    Fiz muitos testes de exclusão e criação das imagens(laravel e Nginx) e dos containers.

    Revisei erros de digitação tanto nos arquivos(copiei todos do Git por garantia) quanto nos comandos.

    Revi os recursos do Docker, pois pensei que pudesse ser uma falta de memória que impedia os containers de rodar devidamente, aumentei, mas sem sucesso. Inclusive para tirar essa dúvida de alocação de recursos executei todo processo em outra máquina com mais memória e tive o mesmo resultado.

    Tentei dar uma investigada por conta para entender o motivo de não conseguir acessas os logs só do container, tentei olhar tutoriais na internet mas mesmo assim estou meio sem rumo de como devo verificar.

    Recriei a imagem do nginx, rodei o container e tentei ver os logs do container do nginx, o terminal só vai para linha seguinte sem mostrar nada.

    Da pra ver que os arquivos de logs existem dentro do container, mas se tento abrir o de erro o terminal fica com o cursor da linha seguinte piscando e não sai disso.

    Vale colocar aqui que não sou usuária padrão de ambos os computadores, serra que isso pode ter alguma relação com permissão do docker na máquina e por consequência isso impacta neste container?

    Para exemplificar essa questão, não consigo executar o brew no meu usuário, sempre preciso fazer localmente.

    Testei em dois MacOs

<br><br>

4. Em ambiente local, normalmente vamos criar volumes para desenvolver a aplicação. 

    Em ambiente de produção, nós copiamos o que temos no ambiente local e removemos os volumes? 

    Se sim, por quê? Ao que entendi um volume é um 'two-way-data-binding' que espelha alterações dos dois lados, mas, uma vez que arquivos de prod não sofrem alterações, seria possível usar volumes em prod também em vez de copiar?

    Não que seja aconselhavel ou encorajado, apenas uma dúvida mesmo.

    É um app bem simples com typescript, express e typeorm. As config. do banco estão no ormconfig.json.

    Em princípio é só rodar o "docker-compose up -d", depois da uma olhada nos logs do container "appteste".

    Duas rotas pra teste:

    Criar usuario:

        /users -> recebe "name", "email" e "password"

    Authenticar:

        /sessions -> recebe "email" e "password".

    Repositório [docker-question4](../../tree/main/repositories/docker-question4)

<br><br>

5. Opa!

    Segui as aulas do docker e consegui criar os containers através do Dockerfile e docker-compose com node. Porém fui fazer o mesmo com minha aplicação pessoal, e vi que o container ficava restartando, então fui verificar os logs e nos logs havia alguma situação relacionada a permission denied. Procurei bastante no google sobre isso, mas não achei uma solução. Estranho que com o app de teste do curso deu certo, pode ser alguma lib que eu esteja usando quem sabe. 

    Eis: [https://i.imgur.com/OBBVlyZ.png](/https://i.imgur.com/OBBVlyZ.png)

<br><br>

### PHP

<br><br>

1. (Sobre o microsserviço do catálogo de vídeo com Laravel)

    Olá, bom dia

    Acabei me perdendo no relacionamento entre gênero e categoria.

    Há uma tabela para isso, e nos models há os métodos, mas não há seeder e nem model para essa tabela.

    Como faço para que no seed já venha gêneros com categorias?

<br><br>

2. Boa tarde,

    Preciso de ajuda!!!!
    Estou recebendo um erro estranho ao rodar o phpunit no build do GCP, localmente também ocorre o mesmo erro, usando  env TESTING_PROD=true
    Log:

```sh
Already have image (with digest): gcr.io/cloud-builders/docker


stty: standard input


PHPUnit 8.5.14 by Sebastian Bergmann and contributors.

............................................................... 63 / 108 ( 58%)

........................................EEEEE 108 / 108 (100%)

Time: 59.79 seconds, Memory: 40.00 MB

There were 5 errors:

1) Tests\Prod\Models\Traits\UploadFilesProdTest::testUploadFile


Error: Call to undefined method Illuminate\Support\Facades\Config::set()


/var/www/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:261


/var/www/tests/Prod/Models/Traits/UploadFilesProdTest.php:25


2) Tests\Prod\Models\Traits\UploadFilesProdTest::testUploadFiles


Error: Call to undefined method Illuminate\Support\Facades\Config::set()


/var/www/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:261


/var/www/tests/Prod/Models/Traits/UploadFilesProdTest.php:25


3) Tests\Prod\Models\Traits\UploadFilesProdTest::testDeleteFile


Error: Call to undefined method Illuminate\Support\Facades\Config::set()

/var/www/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:261


/var/www/tests/Prod/Models/Traits/UploadFilesProdTest.php:25


4) Tests\Prod\Models\Traits\UploadFilesProdTest::testDeleteFiles


Error: Call to undefined method Illuminate\Support\Facades\Config::set()


/var/www/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:261


/var/www/tests/Prod/Models/Traits/UploadFilesProdTest.php:25


5) Tests\Prod\Models\Traits\UploadFilesProdTest::testDeleteOldFiles


Error: Call to undefined method Illuminate\Support\Facades\Config::set()


/var/www/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:261


/var/www/tests/Prod/Models/Traits/UploadFilesProdTest.php:25


ERRORS!


Tests: 108, Assertions: 602, Errors: 5.
```

Repositório [php-question2](../../tree/main/repositories/php-question2)

<br><br>

3. Baixei o repo do microsserviço de catálogo e vídeo e tento instalar 'barryvdh/laravel-ide-helper' e retorna esse erro:

```sh
/workspace$ composer require --dev barryvdh/laravel-ide-helper
Using version ^2.10 for barryvdh/laravel-ide-helper
./composer.json has been updated
Running composer update barryvdh/laravel-ide-helper
Loading composer repositories with package information
Updating dependencies
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - Root composer.json requires barryvdh/laravel-ide-helper ^2.10 -> satisfiable by barryvdh/laravel-ide-helper[v2.10.0].
    - barryvdh/laravel-ide-helper v2.10.0 requires illuminate/console ^8 -> found illuminate/console[v8.0.0, ..., 8.x-dev] but these were not loaded, likely because it conflicts with another require.

Installation failed, reverting ./composer.json and ./composer.lock to their original content.
```

<br><br>

4. Boa noite, estou tendo um problema no teste testSyncCategories() ao executar o mesmo apresenta o seguinte erro 

    **Invalid JSON was returned from the route**

    já conferi o model e seus fields, a rota pelo que entendi está correto.
    pode me apontar onde está o problema nesse caso.

Repositório [php-question4](../../tree/main/repositories/php-question4)

<br><br>

### Node.js/JavaScript

<br><br>

1. Ao implementar o método UpdateOrCreate, ele não está criando. Ele continua tentando fazer um update, pelo que o log aparece.

    [https://ibb.co/xY8DL7g](https://ibb.co/xY8DL7g)

    Ele aparenta estar atualizando mas ele não cria caso não existe.

    Tem alguma ideia?

    Repositório [node-question1](../../tree/main/repositories/node-question1)

<br><br>

2. Ao rodar a aplicação Loopback, está apresentando este erro: [https://ibb.co/17CN56X](https://ibb.co/17CN56X)

    Repositório [node-question2](../../tree/main/repositories/node-question2)

<br><br>

3. Essa é uma dúvida conceitual. Tem como eu atualizar um objeto com outro menor, sem que alguns atributos do objeto maior suma?

    Por exemplo:

    Tenho um objeto de erros para validação

```js
errors: {

name:

email:

password:

}
```

Eu retorno a validação do Laravel, mas nem sempre Laravel vai retornar todos os atributos, até porque, o Laravel só envia os dados que estão errados. Nesse exemplo, o Laravel retorna email e password como errados:

```json
response: {
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "O campo e-mail é obrigatório."
        ],
        "password": [
            "O campo senha é obrigatório."
        ]
    }
}
```

Quando eu faço uma atribuição do errors = response.errors, ele "apaga" o atributo "name"

Tem como fazer essa atribuição e manter o campo "name" como o estado vazio, como era inicialmente?

Pergunto isso pq não estou usando o yup. Tentei usar o spread operator, mas ele não é feito para essa ação né.

Também pergunto se não tem um jeito mais fácil sem fazer um laço tipo for e verificar se existe o atributo.

<br><br>

4. Bom dia estou seguindo a primeira aula de reacthooks e estou tendo problemas, acontece q meu anchorEl sempre fica false, nunca da true, podem me ajudar?

```ts
import { AppBar, Button, IconButton, makeStyles, Menu, MenuItem, Theme, Toolbar, Typography } from '@material-ui/core';
import * as React from 'react';
import logo from '../../static/img/logo.jpeg'
import MenuIcon from '@material-ui/icons/Menu'; 

const useStyles = makeStyles((theme: Theme) => ({
    toolbar: {
        backgroundColor: '#000000'
    },
    logo: {
        width: 100,
        [theme.breakpoints.up('sm')] : {
            width: 170
        }
    },
    title: {
        flexGrow: 1,
    textAlign: 'center'
    }
}));


export const Navbar: React.FC = () => {

const classes = useStyles();
const teste = React.useState(null);
const [anchorEl, setAnchorEl] = React.useState(null);

console.log(anchorEl);

const open = Boolean(anchorEl);
const handleOpen = (event: any) => setAnchorEl(event.CurrentTarget);
const handleClose = () => setAnchorEl(null);

return (


<AppBar>


<Toolbar className={classes.toolbar}>


<IconButton


color="inherit"


aria-label="open drawer"


aria-controls="menu-appbar"


aria-haspopup="true"


onClick={handleOpen}


>


<MenuIcon/>


</IconButton>


<Menu


id="menu-appbar"


open={open}


anchorEl={anchorEl}


onClose={handleClose}


anchorOrigin={{vertical: 'center', horizontal:'center'}}


transformOrigin={{vertical: "top", horizontal: "center"}}


getContentAnchorEl={null}


>


<MenuItem onClick={handleClose}>


Categorias


</MenuItem>


</Menu>


<Typography className={classes.title}>


<img className={classes.logo} src={logo} alt="NOWVI"></img>


</Typography>


<Button color="inherit">Login</Button>


</Toolbar>


</AppBar>


);


}; 
```

<br><br>

5. Olá a todos da SON,

Tenho uma pequena dúvida a respeito do useEffect nos formulários da SPA.

Nos nossos forms, o useEffect, está da seguinte maneira:

useEffect(() => {

        if(!id){
            return;
        }

        (async function getCastMember() {
            setLoading(true);
            try {
                const {data} = await castMemberHttp.get(id);
                setCastMember(data.data);
                reset(data.data);

                setLoading(false);
            } catch (e) {
                console.log(e);
                snackbar.enqueueSnackbar("Não foi possível carregar as informações", {variant: "error"});
            } finally {
                setLoading(false);
            }
        })();


    }, []);
Porém, o react dá alertas das dependencias vazias do hook, pedindo para que seja inserido o id, o reset e o snackbar, porém, caso eu coloque eles como dependências, em alguns casos, posso ter um loop infinito, por que o hook é executado devido a mudanças de estado.

O Loop ocorre, principalmente se inserir o snackbar nas dependências.

Neste caso, a dúvida é:

Se eu deixo as dependencias do hook vazias, o react me notifica como se fosse algo errado, porém se eu preencher as deps, vou ter um loop infinito.

Existe uma maneira de resolver isso com o useEffect? Ou seria o caso de usar um componente com classe?

Desde já, muito obrigado a todos.

<br><br>

### Kubernetes

<br><br>

1. Olá!

    Fiquei com algumas dúvida no funcionamento do Liveness:

    1) Por exemplo, se tenho 10 pods rodando e apenas um pod está com problemas. O Liveness é inteligente o suficiente pra reiniciar apenas o pod "instável" ou os 10 serão reiniciados?

    2) Se tenho os mesmos 10 pods, o Liveness irá testar os 10 pods a cada x tempo ou irá selecionar um pod de forma aleatória? 

    Obrigado pela atenção.

<br><br>

2. Olá, tudo bem?!

    Em relação aos volumes dinâmicos em aplicações statefulset (embora acho ser mais viável utilizar um serviço de banco de dados gerenciado), ainda fiquei com a seguinte dúvida:

    Nas aulas, foi falado por exemplo dos volumes "ReadWriteOnce" onde somente os pods que estão rodando no node, gravam nesse volume.

    Mas como o autoscaling, poderia ter vários pods distribuídos em mais de um node. Nesse caso, os volumes são replicados entre os nodes? Seria isso?

<br><br>

3. Olá boa noite

    Minha dúvida seria sobre caso eu tenha que atualizar um arquivo de secret ou de map-config. Seria necessário a atualização dos pods ou ele identifica automaticamente?

    Isso num ambiente de produção

    Obrigado

<br><br>

### RabbitMQ

<br><br>

1. Gostaria de saber se serão publicadas mais aulas de RabbitMQ mostrando a utilização dele na pratica. Minha principal dúvida está sendo entender o que devo considerar uma mensagem no momento de estrutura um sistema assincrono. Por exemplo em um sistema de faturamento eu entendo que cada tipo de tarefa tipo gerar nota fiscal, baixar estoque, gerar financeiro, gerar pedido de compra, etc cada um deve ser uma fila, entretanto existem interdependencia entre eles, por exemplo o financeiro precisa saber a chave da nota fiscal que foi gerada, como lidar com isso. Entenda que venho de um mundo transacional daí estou tendo dificuldade de fazer essa abstração.

    Desde já agradeço.