# Развернуть проект 

 - docker-compose build
 - docker-compose up
 - в корне проекта на локальной машине - composer install --ignore-platform-reqs
 - развернуть базу - docker exec phpapp php /var/www/html/createDb.php

# Структура базы

См. файл createDb.php

**Таблица кошельков wallet**  
wallet_id | currency_id | balance  
100         1             150  
101         1             0  
102         1             -10  
103         2             150  
104         2             0  
105         2             10  

**валюты currency**. 
id | currency.  
1, rub. 
2, usd. 

**курсы валют currency_rate**  
доллар к рублю 70  
рубль к доллару 0.014  

**история транзакций history**

# API
### получить баланс кошелька
GET http://localhost:8080/balance/{walletId}

### получить сумму refund за последние 7 дней
GET http://localhost:8080/last/{days}/{reason}

### пополнить (списать) 
POST http://localhost:8080/fill  
params - wallet_id, type (debit|credit), amount, currency (rub|usd), reason (stock|refund)


