###################################
#### Sistema de pagamento Stripe
###################################

-Inicialmente temos a forma de pagamento "checkout" que é uma forma onde devemos adicionar o formulário do stripe para chamar a ação de pagamento.

-Nela temos a opção de gerar somente o pagamento ou gerar o pagamento criando um "customer". Com o customer criado podemos associar os detalhes do pagamento com os próximos pagamentos desse usuário.

-OBS1: Uma observação interessante é que caso o usuário perca o seu cartão, ele seja substituído etc o stripe automaticamente recebe informações das operadoras e automaticamente a informação de pagamento salva é atualizada.

-OBS2: Outra informação é que quando é feito um refund para um cartão expirado o valor é credito para o novo cartão associado ao customer.


##############################
#### Subscriptions
##############################

-Primeiramente devemos criar um "produto". No caso o produto será um "service" como a API descreve (pois existem os services and goods caracterizados como serviços). 