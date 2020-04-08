# Pull Request

Para mais informações entre em contato com [digeti@itep.rn.gov.br](mail:digeti@itep.rn.gov.br).

## Seu primeiro Pull Request

Está trabalhando em sua primeira Pull Request? Você pode aprender como desta série de vídeos:

[How to Contribute to an Open Source Project on Git](https://egghead.io/courses/how-to-contribute-to-an-open-source-project-on-github)

Para ajudá-lo a molhar e a se familiarizar com nosso processo de contribuição, verifique contribuições já finalizadas, ou visite nossa equipe.

Se você decidir corrigir um problema, verifique o tópico de comentários caso alguém já esteja trabalhando em uma correção. Se ninguém estiver trabalhando no momento, deixe um comentário informando que você começou a trabalhar para que outras pessoas não dupliquem seu esforço acidentalmente.

Se alguém reivindicar um problema, mas não acompanhar por mais de uma semana, não há problema em assumi-lo, mas você ainda deve deixar um comentário e enviar um e-mail para esta pessoa solicitando informações.

## Enviando um Pull Request

O Sistema Chamador de Senhas - ITEP RN é um projeto da comunidade, portanto, as solicitações Pull Request são sempre bem-vindas, mas, antes de trabalhar em uma grande mudança, é melhor abrir um problema primeiro para discuti-lo com os mantenedores.

Em caso de dúvida, mantenha suas Pull Request pequenas. A melhor chance de ser aceito um Pull Request é não agrupando mais de um recurso ou correção de bug por Pull Request. Geralmente, é melhor criar duas Pull Request's menores do que uma grande.

1. Fork o repositório.

2. Clone o fork à sua máquina local e adicione o controle remoto upstream:

```sh
git clone git@github.com:<seu_usuário_git>/chamador.git
cd chamador
git remote add upstream git@git.sesed.interno:itep/chamador.git
```

3. Sincronize seu local `master` branch com o upstream:

```sh
git checkout master
git pull upstream master
```

4. Instale as dependências:

```sh
npm install
```

5. Crie uma nova branch:

```sh
git checkout -b my-topic-branch
```

6. Faça alterações, confirme e envie para o seu fork:

```sh
git push -u
```

7. Vá para [o repositório](http://git.sesed.interno/itep/chamador) e faça um Pull Request.

A equipe principal está monitorando solicitações de recebimento. Analisaremos sua solicitação de recebimento e a mesclaremos, solicitaremos alterações ou fecharemos com uma explicação.