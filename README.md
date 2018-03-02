**Caro Framework - A php open source flexible and high performance base on Phalcon PHP**

![alt text](./public/Screenshot.png?raw=true "Caro Framework")

Feature
- Complete PhalconPHP structure
- Structure Frontend - Backend independence
- Module structure
- ACL
- Module builder
- Auto CRUD

Contact me
- Skype: tdhungit

Require:
- PHP 5.4 or higher
- Phalcon PHP Framework 2.0 or higher

Install Phalcon PHP:
- Ubuntu
    - `curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash`
    - `sudo apt-get install php5-phalcon`
    
- Compilation 
    - Require
        - Ubuntu
            - `sudo apt-get install php5-dev php5-mysql gcc libpcre3-dev`
        - Centos | Fedora
            - `sudo yum install php-devel php-mysqlnd gcc libtool pcre-devel`
        - RHEL
            - `sudo yum install php-devel php-mysql gcc libtool pcre-devel`
        - Suse
            - `yast2 -i php5-pear php5-devel php5-mysql gcc libtool pcre-devel`
        - Mac OS
            - `brew tap homebrew/dupes`
            - `brew tap homebrew/versions`
            - `brew tap homebrew/php`
            - `brew install php5x php5x-phalcon` # Where "x" - minor number of PHP
    - Compilation
        - `git clone --depth=1 git://github.com/phalcon/cphalcon.git`
        - `cd cphalcon/build`
        - `sudo ./install`
        - `extension=phalcon.so` # add to php.ini or add to con.d/phalcon.ini
- Restart web-server

**Get Caro Framework**
- git clone https://github.com/teamcarodev/Caro-Framework.git
- Create database
- Go to browser: /install (http://example.com/install)
- Enter info
- Go to backend: /admin -> setting -> repair database
- If error menu table when first access to admin page please refresh

Get document: /documents (http://example.com/documents)