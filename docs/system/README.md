# Manual

Aqui você encontra toda a descrição de funcionalidades e campos do sistema.

É aconselhado o uso somente dos navegadores ***Google Chrome*** versão 80.0.3987.163 ou superior, ou ***Mozilla Firefox*** versão 74.0.1 ou superior, para este sistema.

> Por padrão, após a instalação do sistema, é criado um usuário administrador de login `itep.digeti` e senha `senha123`. Utilize este usuário para acessar e configurar o ambiente inicial, deletando este usuário assim que possível.

## Painel Monitor do Chamador

Aconselhamos somente o uso do ***Google Chrome*** para a visualização do Painel Monitor do Chamador.

### Acessar o painel
Para acessar o [painel do chamador](https://chamador.itep.govrn/painel) digite na barra de endereço do navegador ***Google Chrome*** `https://chamador.itep.govrn/painel`
> O chamador sempre inicia zerado. A medida que as fichas são chamadas por cada setor, ele irá preenchendo seus espaços.

## Logs do Sistema
No menu principal, na aba `Configurações`, na opção `Logs`, você terá acesso a lista de todos os registros de eventos relevantes do sistema.  

>Esta função somente é visível para usuários que o setor seja do tipo Administrador.

### Pesquisar informações
É possível fazer a pesquisa global da tabela de qualquer informação de qualquer coluna utilizando a barra de `Procurar`. 

### Exportar informações
Também é possível fazer o download das informações da tabela clicando no botão `Exportar`.  

## Fichas do Sistema
No menu principal, na aba `Configurações`, na opção `Fichas`, você terá acesso a lista de todas as fichas registras no sistema e seu último status.  

>Esta função somente é visível para usuários que o setor seja do tipo Administrador.

>**Dados de usuários de atendimento armazenados no sistema são de uso interno e exclusivo da instituição, não podendo ser usados para fins externos a esta pela Instituição ou por qualquer outro usuário o qual manipule estes dados.** Verifique as políticas de segurança da Instituição para mais detalhes.

### Pesquisar informações
É possível fazer a pesquisa global da tabela de qualquer informação de qualquer coluna utilizando a barra de `Procurar`. 

### Exportar informações
Também é possível fazer o download das informações da tabela clicando no botão `Exportar`.  

## Setores do Sistema
No menu principal, na aba `Configurações`, na opção `Setores`, você terá acesso a lista de todos os setores registras no sistema e suas configurações.  

>Esta função somente é visível para usuários que o setor seja do tipo Administrador.

### Adicionar
1. Para adicionar um novo setor ao sistema clique no botão `Adicionar`.
2. Preencha o nome do novo Setor.
3. Indique se este setor será do tipo `Gerador de Fichas`.
> Um setor do tipo `Gerador de Fichas` é aquele setor responsável pelo atendimento ao usuário que irá preencher os dados e entregar uma ficha ao usuário, que irá aguardar ser chamado.
4. Indique se este setor será do tipo `Administrador` .
> Um setor do tipo `Administrador` é responsável pelo gerenciamento do sistema da criação, edição e remoção de Setores ou Usuários do sistema e verificações de informações globais do sistema.
5. Clique em `Salvar`.

### Editar
1. Para editar um setor específico do sistema, selecione a opção `Editar` da coluna Ação correspondente ao setor desejado.  
2. Edite as informações que deseja.
3. Clique em `Salvar`.
> A edição do tipo `Gerador de Fichas` não surte o efeito imediato em usuários do setor o qual já estão logados no sistema, sendo necessário que estes façam logout para que as modificações surtam o efeito.

### Deletar
1. Para deletar um setor específico do sistema, selecione a opção `Deletar` da coluna Ação correspondente ao setor desejado. 
2. Confirme a operação.
> Ao deletar um setor, caso este ainda exista usuários vinculados, visualmente na [lista de usuários do sistema](##Usuários_do_sistema) ele aparecerá sem setor (campo em branco) , porem estes usuários ainda permaneceram com as mesmas credenciais do setor setadas antes dele ser deletado, assim como continuarão ativos no sistema.

### Pesquisar informações
É possível fazer a pesquisa global da tabela de qualquer informação de qualquer coluna utilizando a barra de `Procurar`.   

## Usuários do Sistema
No menu principal, na aba `Configurações`, na opção `Usuários`, você terá acesso a lista de todos os usuários registras no sistema e suas configurações.  

>Esta função somente é visível para usuários que o setor seja do tipo Administrador.

### Adicionar
1. Para adicionar um novo usuário ao sistema clique no botão `Adicionar`.
2. Preencha o nome do novo Usuário.
3. Indique a qual Setor este Usuário irá pertencer.
> Lembre-se que as funcionalidades de um usuário herda de seu setor.
4. Clique em `Salvar`.
> Ao salvar será gerado um Login e Senha para o usuário que ficará visível em uma notificação de sucesso. Ex: **Sucesso!** Usuário **allan.miranda** com senha **KGNBR**

### Editar
1. Para editar um usuário específico do sistema, selecione a opção `Editar` da coluna Ação correspondente ao usuário desejado.  
2. Edite as informações que deseja.
3. Clique em `Salvar`.
> A edição do `Setor` surte o efeito imediato no usuários mesmo que este esteja logados no sistema.

### Deletar
1. Para deletar um usuário específico do sistema, selecione a opção `Deletar` da coluna Ação correspondente ao usuário desejado. 
2. Confirme a operação.
> O deletar de um usuário surte o efeito imediato, mesmo que este esteja logado no sistema. Se este usuário estiver em operação, em seu terminal, apresentará falhas críticas levando ao logout automático, podendo gerar operações não finalizadas por este usuário. Ex: Usuário chamou uma ficha, mas nunca finalizou ou encaminhou para atendimento aquela ficha.

### Modificar senha
1. Para modificar a senha de um usuário específico do sistema, selecione a opção `Modificar Senha` da coluna Ação correspondente ao usuário desejado. 
> Esta operação somente é permitido para demais usuários. Para você, usuário logado, modificar a senha, utilize as configurações do seu [`Perfil`](##Perfil) 
2. Confirme a operação.
> Ao `Modificar Senha` será gerado uma nova senha para o usuário que ficará visível em uma notificação de sucesso. Ex: **Sucesso!** Usuário **ALLAN DE MIRANDA** restaurou a senha para **C0FCN**

> ***Solicite ao usuário que no primeiro acesso ao sistema sempre modifique a senha.***

> ***A senha é um bem de uso pessoal e intransferível***, todas as operações efetuadas neste sistemas estão sendo gravadas e poderá ser usados para fins de investigação e apuração de ocorrências.

> O `Modificar Senha` de um usuário surte o efeito imediato, mesmo que este esteja logado no sistema. Se este usuário estiver em operação, em seu terminal, apresentará falhas críticas levando ao logout automático.

### Pesquisar informações
É possível fazer a pesquisa global da tabela de qualquer informação de qualquer coluna utilizando a barra de `Procurar`.   

## Perfil
No canto superior direito da tela, sobre o nome e setor do usuário, é possível acessar um menu secundário do sistema, neste terá a opção `Perfil`. 

Aqui é possível o usuário verificar todas as informações de sua credencial e modificar sua senha.

> ***No primeiro acesso ao sistema sempre modifique a senha.***

> ***A senha é um bem de uso pessoal e intransferível, todas as operações efetuadas neste sistemas estão sendo gravadas e poderá ser usados para fins de investigação e apuração de ocorrências.***

> ***Caso descubra que sua senha está sendo utilizada por outro usuário, modifique sua senha imediatamente e contacte o responsável pelo seu setor.***

### Modificar senha
1. Para modificar a senha digite a nova senha no campo `Senha` do formulário do usuário.
2. Clique em modificar.
> Em um futuro login utilize sua nova senha.

> Caso tenha perdido sua senha, contacte um administrador do sistema para que ele crie uma nova senha.

## Logout
Esta opção irá fazer seu usuário sair do sistema, apagando sua credencial armazenada na seção ativa.
> Nunca deixe sua seção ativa quando não estiver presente no computador.

> Caso tenha deixado sua seção ativa e não tem certeza de que a seção não foi manipulada por outro usuário, modifique sua senha em [perfil](##Perfil) e contacte o responsável pelo seu setor. 

## Login Chamador
Esta tela te dará acesso ao sistema.

Digite sua senha e login e clique em Entrar para acessar o sistema.
> Nunca deixe seu login e senha salvos em um computador compartilhado.

> ***No primeiro acesso ao sistema sempre modifique a senha.***

> ***A senha é um bem de uso pessoal e intransferível, todas as operações efetuadas neste sistemas estão sendo gravadas e poderá ser usados para fins de investigação e apuração de ocorrências.***

> ***Caso descubra que sua senha está sendo utilizada por outro usuário, modifique sua senha imediatamente e contacte o responsável pelo seu setor.***
 
##  Dashboard
Este é o painel principal do sistema onde iremos gerenciar as fichas do sistema. Dependendo do tipo do seu setor está tela pode apresentar o gerenciador para chamar fichas ou o gerenciador de criação de fichas.

> ***Dados de usuários de atendimento armazenados no sistema são de uso interno e exclusivo da instituição, não podendo ser usados para fins externos a esta pela Instituição ou por qualquer outro usuário o qual manipule estes dados.*** Verifique as políticas de segurança da Instituição para mais detalhes.

> ***Todas as fichas do sistemas tem validade diária***, isso significa que ao virar das 0 horas do dia, todos os indicadores e listas de fichas desta tela são zerados também, portanto ***atenção ao manipular fichas entre dias***.

### Gerenciador de criação de ficha
Este painel é dedicado a criação de fichas para o sistema. Nele também é possível verificar o status de todas as fichas criadas. 

#### Criar
1. Para criar uma nova ficha clique em `Criar`.
2. Digite o nome do usuário a ser atendido.
3. Digite o telefone dele.
4. Selecione para qual setor ele será direcionado.
5. Se o usuário é do tipo prioridade.
> O atendimento Prioritário é lei. ![Qual o termo correto? Atendimento Prioritário ou Preferencial ...](https://sindepat.com.br/wp-content/uploads/2019/10/placa-tamanho-certo-2-1200x480.jpg)
6. Clique em `Salvar` para gerar a ficha.

### Imprimir
Para imprimir uma ficha de um usuário específico, selecione a opção `Imprimir` da coluna Ação correspondente a ficha desejada. 

### Pesquisar
É possível fazer a pesquisa global da tabela de qualquer informação de qualquer coluna utilizando a barra de `Procurar`. 

### Gerenciador para chamar fichas
Este painel é dedicado ao gerenciador de chamadas de fichas do setor do usuário.

#### Indicadores
Quantificadores do status das fichas sobre responsabilidade do setor.

>>##### Não Atendidos
>> Quantifica a quantidade de usuário em espera pelo setor que que nunca foram atendidos.

>> ##### Encaminhados
>> Quantifica a quantidade de usuário em espera pelo setor que já foram atendidos, porem encaminhado por outro setor.

>>##### Em Atendimento
>>Quantifica a quantidade de usuário sendo atendido pelo usuário.

>>##### Atendidos
>>Quantifica a quantidade de usuário finalizados pelo setor.

#### Painel do Setor
Aqui é possível verificar as fichas que estão associadas ao setor, chamando, finalizando ou encaminhando a ficha para outro setor.

>>##### Não Atendidos
>>Fichas que estão em espera por atendimento no setor.

>>##### Em Atendimento
>>Fichas que estão em atendimento pelo usuário.
>>> É possível que um usuário do sistema esteja atendendo mais de uma ficha ao mesmo tempo. 

>>##### Atendidos
>>Fichas que foram atendidas pelo setor.

#### Atendimento individual
É possível atender a uma ficha individualmente, que não seja a próxima da fila, na aba `Não Atendidos` clicando na opção `Chamar` da coluna Ação da respectiva ficha a ser chamada.

#### Chamar próximo da fila
Para chamar a próxima ficha clique no botão `CHAMAR PRÓXIMO`. O sistema irá verificar quem é o próximo da fila e chamar automaticamente.

#### Encaminhar ficha para outro setor
1. Com a ficha em atendimento clique em `Editar`
2. Selecione para qual setor ela será encaminhada.
3. Clique em `Salvar` a edição para finalizar o encaminhamento da ficha.

#### Finalizar atendimento da ficha
Com a ficha em atendimento clique em `Finalizar`.

## Erros e soluções

Aqui temos a solução para alguns erros que possa ocorrer no sistema devido ao navegador.

### Painel não reproduz o som da ficha ao chamar uma nova ficha
Por medidas de segurança os navegadores desabilitam por padrão a reprodução de conteúdos. 

Portanto é necessário ativar a reprodução de áudio automática no seu navegador.  

1. Abra o [painel](https://chamador.itep.govrn/painel)

2. Clique em `Não seguro` depois em `Configurações do site`:

<img src="img/Captura de tela de 2020-04-07 18-31-20.png">

3. Em `Permissões` procure a opção `Som` e defina o tipo `Permitir`:

<img src="img/Captura de tela de 2020-04-07 18-31-35.png">

### Navegador não faz login ou não carrega nenhuma informação
Normalmente isso ocorre quando o navegador possui informações salvas e que o sistema não consegue mais ler, gerando incompatibilidade. Por segurança o sistema do chamador bloqueia qualquer incompatibilidade.

Para solucionar este problema limpe todas as informações do `https://chamador.itep.govrn/` que houver salvo em seu navegador, principalmente o de ***Local Storage*** visto que esta ferramenta é usada para manipulação da página e de informação do sistema.

A limpeza do ***Local Storage*** pode ser facilmente feita pelas ferramentas de desenvolvedor disponíveis nos navegadores.

### Demora ao chamar uma ficha
Para que a ficha chamada apareça no aba `Em Atendimento` é necessário que ela seja chamada no [Monitor Painel](##Painel_Monitor_do_Chamador). 

Pode ocorrer de haver várias fichas sendo chamadas ao mesmo tempo e este processo demorar alguns segundos a mais do tempo usual. 

Certifique-se que o [Monitor Painel](##Painel_Monitor_do_Chamador) esteja habilitado com o responsável pelo setor caso a ficha não venha a aparecer na aba `Em Atendimento`.

### Notificações de novas fichas disponível não aparece em meu navegador
Por medidas de segurança os navegadores desabilitam por padrão a reprodução de conteúdos. 

Portanto é necessário ativar a reprodução de notificações automática no seu navegador.  

#### Google Chrome v80.0.3987.163
1. Abra o [sistema](https://chamador.itep.govrn/)

2. Clique em `Não seguro` depois em `Configurações do site`:

<img src="img/Captura de tela de 2020-04-07 18-31-20a.png">

3. Em `Permissões` procure a opção `Notificações` e defina o tipo `Permitir`:

<img src="img/Captura de tela de 2020-04-07 21-12-43.png">

#### Mozilla Firefox v74.0.1
1. Abra o [sistema](https://chamador.itep.govrn/)

2. Clique com o botão direito sobre a página e selecione a opção `Ver informações da página`:

3. Navegue até a aba `Permissões` procure a opção `Enviar Notificações` e defina o tipo `Permitir`:

<img src="img/Captura de tela de 2020-04-07 21-23-50.png">

### Ficha não abre aba de impressão
Por medidas de segurança os navegadores desabilitam por padrão a reprodução de conteúdos. 

Portanto é necessário ativar a abertura de janelas automática no seu navegador.  

#### Google Chrome v80.0.3987.163
1. Abra o [sistema](https://chamador.itep.govrn/)

2. Clique em `Não seguro` depois em `Configurações do site`:

<img src="img/Captura de tela de 2020-04-07 18-31-20a.png">

3. Em `Permissões` procure a opção `Notificações` e defina o tipo `Permitir`:

<img src="img/Captura de tela de 2020-04-07 21-32-25.png">

#### Mozilla Firefox v74.0.1
1. Abra o [sistema](https://chamador.itep.govrn/)

2. Clique com o botão direito sobre a página e selecione a opção `Ver informações da página`:

3. Navegue até a aba `Permissões` procure a opção `Enviar Notificações` e defina o tipo `Permitir`:

<img src="img/Captura de tela de 2020-04-07 21-30-44.png">

### Erro de certificado
Por medidas de segurança os navegadores bloqueiam certificados SSL não registrados em CA's. 
>Em sistemas internos, geralmente, a equipe de suporte não registra este tipo de certificado.

> Verifique a política de segurança com a equipe de suporte.

Verifique com a equipe de suporte qual procedimento você deve tomar neste caso.

#### Google Chrome v80.0.3987.163
<img src="img/Captura de tela de 2020-04-07 18-30-55.png">

#### Mozilla Firefox v74.0.1
<img src="img/Captura de tela de 2020-04-07 16-23-36.png">
