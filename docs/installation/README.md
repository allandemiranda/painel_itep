
# Instalação

![enter image description here](https://img.shields.io/badge/php-v7.3.11-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/node-v12.16.1-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/mariadb-v15.1-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/apache2-v2.4.41-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/git-v2.20.1-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/npm-v6.14.4-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/make-v4.2.1-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/gcc-v9.2.1-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/g++-v9.2.1-green`?style=for-the-badge&logo=appveyor`) ![enter image description here](https://img.shields.io/badge/vim-v8.1.1401-green`?style=for-the-badge&logo=appveyor`)  ![enter image description here](https://img.shields.io/badge/openssl-v1.1.1c-green`?style=for-the-badge&logo=appveyor`)  

Este documento de instalação somente da suporte a ambiente Linux. Para instalação em um ambiente [Windows Server](https://www.microsoft.com/pt-br/cloud-platform/windows-server) procurar adequar as funcionalidades Linux ao sistema [ISS do Windows](https://support.microsoft.com/pt-br/help/323972/how-to-set-up-your-first-iis-web-site).

Utilizaremos o [Ubuntu Server 19.10 amd64](https://wiki.ubuntu.com/EoanErmine/ReleaseNotes?_ga=2.86681755.288333837.1586266337-2121572757.1584959049) para fins de documentação. Está disponível no site da Ubuntu o [download](https://ubuntu.com/download/server/thank-you?version=19.10&architecture=amd64)  deste sistema operacional e sua [documentação](https://assets.ubuntu.com/v1/0032cef9-ubuntu-server-guide.pdf).

## Instalando componentes necessários

Certifique que seu usuário possui permissão sudo de instalação e manipulação a nível root.

### Preparando o ambiente
1. Atualize o ambiente
```
:~$ sudo apt update
:~$ sudo apt full-upgrade
```

### Repositório Git
2. Será necessário clonar o repositório do projeto para instalação usando o git. Verifique se ele está instalado.
```
:~$ sudo apt install git
```

### Editor de texto: Vim
3. Usaremos o editor vim para modificações em arquivos de texto posteriormente. Caso já esteja familiarizado com outro editor, não será necessário a instalação deste editor.
```
:~$ sudo apt install vim
```

### Opcionais: make, gcc e g++
4. Para uma melhor performasse do seu sistema aconselhamos a instalação dos seguintes programas.
```
:~$ sudo apt install make gcc g++
```

### Instalando o PHP 7.3, Apache2 e SSL
5. Toda a API do projeto foi feita em php7.3, portanto deveremos instalar esta versão, nunca uma inferior. Junto com ela é necessário instalar o apache2 e para podermos navegar com segurança em uma conexão https também é necessário instalar o ssl-cert e openssl.
```
:~$ sudo apt install php7.3 apache2 php7.3-json php-mysqlnd php7.3-mysql ssl-cert openssl
```
6. Verifique o status do funcionamento do apache2 digitando o endereço ip do servidor em um navegador de internet. Deve aparecer a seguinte tela:

<img src="img/Captura de tela de 2020-04-07 11-15-57.png" width="600" height="400">

### Instalando e configurando o Banco de Dados: MariaDB
7. MariaDB é um fork do MySQL. Usaremos o banco de dados MariaDB neste projeto. Para instalar use:
```
:~$ sudo apt install mariadb-server
```
8. Execute um script de segurança simples que vem pré-instalado com o MariaDB. Este removerá algumas configurações padrão inseguras e bloqueará o acesso ao seu sistema de banco de dados.
```
:~$ sudo mysql_secure_installation
```
Será solicitado a senha do banco, como não tem nada configurado ainda apenas tecle **< ENTER >**

O próximo prompt perguntará se você deseja configurar uma senha de root do banco de dados. Digite **n** e pressione **< ENTER >**.

Agora você pode pressionar **Y** e depois **< ENTER >** para aceitar os padrões para todas as perguntas subsequentes. Isso removerá alguns usuários anônimos e o banco de dados de teste, desabilitará logins de root remoto e carregará essas novas regras para que MariaDB respeite imediatamente as alterações que você fez.

> Caso tenha dado algum comando errado, você pode reiniciar as configurações digitando no terminal o comando `: ~$ sudo mysql_secure_installation`

9. Vamos criar um usuário para o banco de dados. Entre no banco:
```
:~$ sudo mariadb
```
Digite tudo em uma única linha, lembrando de substituir o usuário `admin` e a senha `password` para de sua preferência:
```
MariaDB [(none)]> GRANT ALL ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;
```
> Por padrão a API do projeto já está configurado para conectar ao banco de dados com o login `admin` e senha `password`. Lembre-se de alterar no código da API este valores.
> Usaremos durante toda a documentação o login `admin` e senha `password` para o banco de dado.

Limpe os privilégios para garantir que eles sejam salvos e estejam disponíveis na sessão atual:
```
MariaDB [(none)]> FLUSH PRIVILEGES;
```
Saia do prompt do MariaDB:
```
MariaDB [(none)]> exit;
```
Verifique se a configuração foi correta ou sempre que precisar acessar o BD digite o comando:
```
:~$ sudo mariadb -u admin -p
```

> Substituir o usuário `admin` pelo criado por você


### Instalando o NodeJS e NPM

Normalmente os repositórios do Ubuntu não possuem a atualização mais recente do NodeJS usada no projeto, portanto vamos importar o repositório correto e instalar. A versão sempre tem de ser a superior a 10.x, como já está disponível a versão 12.x iremos instalar ela.

10. Ative o repositório NodeSource com o seguinte comando curl:
```
:~$ curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -
```
11. Quando o repositório NodeSource estiver ativado, instale o Node.js e o npm digitando:
```
:~$ sudo apt-get install -y nodejs
:~$ sudo npm install -g npm
```

### Clonando o projeto do GitLab
12.  Entre na pasta onde ficam os projetos que rodam no apache:
```
:~$ cd /var/www/
```
13. Agora clone o [projeto](http://git.sesed.interno/itep/chamador/):
```
:/var/www$ sudo git clone http://git.sesed.interno/itep/chamador.git
```
> Este GitLab está hospedado em uma máquina de domínio privado da rede intranet do Governo do Estado do RN. Portanto é necessário que seu computador esteja nesta intranet e que o serviço DNS de sua rede responda ao domínio git.sesed.interno no ip 10.9.192.36. Para resolver este problema você deve:
> 
> Modificar as informações no serviço DNS de sua rede para para que responda a:
> `git.sesed.interno	A	10.9.192.36`
>
> Ou, adicione ao final do arquivo `/etc/hosts` do seu servidor a linha `10.9.192.36 git.sesed.interno`. Você pode utilizar o vim para esta operação abrindo `sudo vim /etc/hosts`, pressiona **i** para iniciar a edição, escreve o texto `10.9.192.36 git.sesed.interno` no final do arquivo, aperta **Esc**, digita **wq** e aperta **ENTER**.

14. Agora renomeie a pasta `chamador` para `chamador.itep.govrn`: 
```
:/var/www$ sudo mv chamador chamador.itep.govrn 
```
> A renomeação é uma forma de organização, onde o melhor modelo é colocando o domínio do site como nome da pasta, portanto, caso o domínio do sistema seja diferente de `chamador.itep.govrn`, digite outro nome de pasta de sua escolha. Durante toda esta documentação será usado como domínio do sistema `chamador.itep.govrn`.

15. Agora temos a estrutura de diretórios para nosso projeto, mas ele é de propriedade de nosso usuário root. Se quisermos que nosso usuário regular esteja apto a modificar arquivos em nossos diretórios web, podemos alterar o proprietário fazendo isto:
 ```
:/var/www$ sudo chown -R $USER:$USER chamador.itep.govrn/
```
16. Devemos também modificar um pouco nossas permissões para garantir que o acesso de leitura é permitido para o diretório web geral e todos os arquivos e pastas que ele contém de modo que a páginas possam ser servidas corretamente:
```
:/var/www$ sudo chmod -R 755 /var/www
```

### Compilando o projeto
17. Entre na pasta do projeto:
```
:/var/www$ cd chamador.itep.govrn
```
> O sistema de local storage usa uma chave de criptografia. Por padrão setamos a chave `19d2d126356c88a9eac92f6a31345f62`. Essa chave pode ser modificada para a de sua preferência. Para fazer isso acesse o arquivo `src/store/index.js` do projeto e modifique a chave na linha 506. Você pode está utilizando o vim para isso `vim src/store/index.js`.

18. Instalando os módulos node:
```
:/var/www/chamador.itep.govrn$ npm install
```
19. O próximo será compilar o projeto:
```
:/var/www/chamador.itep.govrn$ npm rum build
```
> Caso o processo de copilação apresente erro na lib módulo `./node_modules/react-voice-components/lib/...` o desenvolvedor [Allan de Miranda](allandemiranda.eti.br/) preparou em seu [github](https://github.com/allandemiranda/) um [fork do componente](https://github.com/allandemiranda/react-voice-components) `react-voice-components` com as correções. Delete a pasta `react-voice-components` e clone o novo módulo:
> 
> `:/www/chamador.itep.govrn$ rm -r node_modules/react-voice-components/`
> 
> `:/www/chamador.itep.govrn$ cd node_modules/`
> 
> `:/www/chamador.itep.govrn/node_modules$ git clone https://github.com/allandemiranda/react-voice-components.git`
> 
> `:/var/www/chamador.itep.govrn/node_modules$ cd ..`
> 
>`:/var/www/chamador.itep.govrn$ npm rum build`

20. Agora temos de verificar as credenciais de acesso ao banco de dados. Para isso acesse o arquivo `build/api/ClassConnection.php` do projeto e edite as linhas 28 (domínio ou ip do servidor de banco de dados), 29 (usuário do banco de dados), 30 (senha do usuário) e 31(nome do banco de dados) se necessário:
```
28:	$this->set_servername("localhost"); //! Host do servidor
29:	$this->set_username("admin"); //! Usuário do banco de dados
30:	$this->set_password("password"); //! Senha do usuário do banco de dados
31:	$this->set_dbname("chamador"); //! Nome do banco de dados
```

### Importando banco de dados
21. Agora iremos importar um banco de dados inicial do sistema. para isso temos que criar um novo banco de dados no MariaDB. Iremos chamar ele de `chamador`:
```
:/var/www/chamador.itep.govrn$ mariadb -u admin -p
MariaDB [(none)]> CREATE DATABASE chamador;
MariaDB [(none)]> exit;
:/var/www/chamador.itep.govrn$ mariadb -u admin -p chamador < build/api/chamador.sql
```
> Você pode suar outro nome de banco de dados de sua preferência no lugar de `chamador`, porem lembre-se de alterar no código da API este valor.
> 
> Se não tiver familiaridade com linha de comando SQL uma dica é usar o gerenciado de banco de dados [DBeaver Community](https://dbeaver.io/download/) em seu computador para acesso remoto ao banco de dados.

### Criando o certificado SSL
22. O TLS/SSL funciona usando uma combinação de um certificado público e uma chave privada. A chave SSL é mantida em segredo no servidor. Ela é usada para criptografar o conteúdo enviado para clientes. O certificado SSL é compartilhado publicamente com qualquer um que solicitar o conteúdo. Ele pode ser usado para decifrar o conteúdo assinado pela chave SSL associada. Podemos criar um par chave autoassinada e certificado com o OpenSSL em um único comando:
```
:/var/www/chamador.itep.govrn$ cd
:~$ sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt
```
>Algumas perguntas sobre nosso servidor serão feitas para incorporar as informações corretamente no certificado. Preencha os prompts devidamente. **A linha mais importante é aquela que solicita o `Nome comum (por exemplo, o servidor FQDN ou o SEU nome)`. Você precisa digitar o nome do domínio associado ao seu servidor ou, mais provável, o endereço IP público do seu servidor.**

### Configurando o Apache2 Virtual Hosts com certificado SSL autoassinado
23. Por segurança, vamos bloquear o acesso para outras redes fora do nosso setor. Para isso verifique qual a rede e mascara (ou redes e mascaras) vamos permitir o acesso ao sistema. Abra o arquivo `build/.htaccess` do projeto e modifique a linha 3 para a rede desejada:
```
1:	order deny,allow
2:	deny from all
3:	allow from 10.9.9.0/24
```
> Com esta configuração computadores com ip de 10.9.9.1 a 10.9.9.255 terão acesso ao sistema, todos os outros ip's serão bloqueados.

24. Arquivos de virtual host são arquivos que especificam a configuração real do nosso virtual host e determina como o servidor web Apache irá responder às várias requisições de domínio. Precisamos criar um arquivo de virtual host para nosso domínio `chamador.itep.govrn`:
```
:~$ sudo vim /etc/apache2/sites-available/chamador.itep.govrn.conf
```
Copie este conteúdo para o arquivo:
```
<VirtualHost *:80>
ServerName chamador.itep.govrn
ServerAlias www.chamador.itep.govrn
Redirect permanent "/"  "https://chamador.itep.govrn/"
ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined  
</VirtualHost> 
<IfModule mod_ssl.c>
<VirtualHost _default_:443>
ServerName chamador.itep.govrn
ServerAlias www.chamador.itep.govrn
ServerAdmin digeti@itep.rn.gov.br
DocumentRoot /var/www/chamador.itep.govrn/build
<Directory /var/www/chamador.itep.govrn/build>
Options Indexes FollowSymLinks MultiViews
AllowOverride All
Order allow,deny
allow from all
</Directory>
ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined
SSLEngine on
SSLCertificateFile /etc/ssl/certs/apache-selfsigned.crt
SSLCertificateKeyFile /etc/ssl/private/apache-selfsigned.key
<FilesMatch "\.(cgi|shtml|phtml|php)$">
SSLOptions +StdEnvVars
</FilesMatch>
<Directory /usr/lib/cgi-bin>
SSLOptions +StdEnvVars
</Directory>
</VirtualHost>
</IfModule>
```

> Caso seja necessário você pode alterar os campos `ServerName` (são dois), `ServerAlias`(são dois), `Redirect permanent` para o domínio desejado, assim como o local do projeto nos locais `DocumentRoot /var/www/<nome da pasta do projeto>/build` e `<Directory /var/www/<nome da pasta do projeto>/build>`. Também pode modificar o `ServerAdmin` para um e-mail válido. Caso você também tenha alterado o destino das chaves do certificado SSl modifique os campos `SSLCertificateFile` e `SSLCertificateKeyFile`.

Salve e feche o arquivo quando você terminar.

25. Vamos criar um snippet de configuração do Apache que defina algumas configurações do SSL. Isso irá configurar o Apache com uma série de criptografia SSL forte e habilitar algumas funcionalidades avançadas que irão ajudar a manter nosso servidor seguro. Crie um novo snippet no diretório `/etc/apache2/conf-available`:
```
:~$ sudo vim /etc/apache2/conf-available/ssl-params.conf
```
Copie este conteúdo para o arquivo:
```
SSLCipherSuite EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH
SSLProtocol All -SSLv2 -SSLv3 -TLSv1 -TLSv1.1
SSLHonorCipherOrder On
# Disable preloading HSTS for now.  You can use the commented out header line that includes
# the "preload" directive if you understand the implications.
# Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload"
Header always set X-Frame-Options DENY
Header always set X-Content-Type-Options nosniff
# Requires Apache >= 2.4
SSLCompression off
SSLUseStapling on
SSLStaplingCache "shmcb:logs/stapling-cache(150000)"
# Requires Apache >= 2.4.11
SSLSessionTickets Off
```
Salve e feche o arquivo quando você terminar.

26. Vamos agora habilitar alguns módulos:
```
:~$ sudo a2enmod ssl
:~$ sudo a2enmod headers
:~$ systemctl restart apache2
```
27. Agora vamos habilitar nosso Host Virtual SSL
```
:~$ sudo a2ensite chamador.itep.govrn
:~$ sudo a2enconf ssl-params
:~$ systemctl restart apache2
```
> Use o comando `sudo apache2ctl configtest` para verificar o status das novas configurações. Se tudo for bem-sucedido, você receberá um resultado que se parecerá com este:
>
> AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.1.1. Set the 'ServerName' directive globally to suppress this message
> Syntax OK

28. Agora é hora de abrir o sistema em seu navegador e testar. 

>Lembre-se de configurar o serviço DNS de sua rede apontando o domínio `chamador.itep.govrn` para o ip deste servidor.
>
>Lembre-se também que este servidor não pode possuir um ip dinâmico, portanto certifique-se que a maquina está configurada com um ip fixo ou, caso a politica de segurança não permita isso, que no serviço DHCP de sua rede o MAC desta máquina está com um ip fixo.

### Painel Monitor do Chamador

Caso o Painel Monitor do Chamador não esteja abrindo e aparecendo a mensagem de página não encontrada, execute o seguinte comando no terminal:

```
:~$ cp /var/www/chamador.itep.govrn/build/index.html /var/www/chamador.itep.govrn/build/painel.htm
```

Verifique se agora está carregando o painel digitando na barra de endereço do navegador o site `https://chamador.itep.govrn/painel`