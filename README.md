# wallet_transactions
<img width="721" alt="Screenshot at Apr 04 15-09-28" src="https://user-images.githubusercontent.com/36973335/113519931-f33c8f80-9565-11eb-8b3c-282e5aa299aa.png">



## Funcionalidades
1. CRUD para cadastro de usuários
2. Transações entre usuários ( Lojistas só recebem transações )

## Como executar o projeto
1. docker compose up -d --build
2. docker exec -it php composer install
3. docker exec -it php php artisan migrate
4. docker exec -it php php artisan db:seed