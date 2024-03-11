#!/bin/bash

# Alterando o grupo para www-data e definindo permissões de escrita para o grupo
echo "Alterando o grupo para www-data e definindo permissões de escrita para o grupo"
chgrp -R www-data bootstrap/ storage/ storage/logs/
if [ $? -eq 0 ]; then
    echo "Grupo alterado com sucesso."
else
    echo "Erro ao alterar grupo."
    exit 1
fi

# Definindo permissões de escrita para o grupo
echo "Definindo permissões de escrita para o grupo"
chmod -R g+w bootstrap/ storage/ storage/logs/
if [ $? -eq 0 ]; then
    echo "Permissões definidas com sucesso."
else
    echo "Erro ao definir permissões."
    exit 1
fi

# Definindo o bit setgid em todos os diretórios dentro de bootstrap/, storage/ e storage/logs/
echo "Definindo o bit setgid em todos os diretórios dentro de bootstrap/, storage/ e storage/logs/"
find bootstrap/ storage/ storage/logs/ -type d -exec chmod g+s {} +
if [ $? -eq 0 ]; then
    echo "Bit setgid definido com sucesso."
else
    echo "Erro ao definir bit setgid."
    exit 1
fi

DIR="/var/www/html/storage/framework/cache/data/"
if [ -d "$DIR" ]; then
    echo "Alterando o grupo e definindo permissões em $DIR"
    chgrp -R www-data $DIR
    chmod -R g+w $DIR
    echo "Grupo e permissões definidos com sucesso em $DIR"
else
    echo "Diretório $DIR não encontrado. Continuando sem alterar."
fi

echo "Permissões e propriedades de grupo atualizadas com sucesso."
