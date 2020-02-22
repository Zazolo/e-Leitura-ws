<?php

/*
 * Script para execução no crontab =)
 * 
 * select uvt.paragrafo, COUNT(uvt.id) as votos from eleitura.paragrafo as p RIGHT JOIN eleitura.usuariovtparagrafo as uvt ON uvt.paragrafo = p.id where p.historia_id = 9 group by paragrafo;
 */
