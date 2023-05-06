# Questao 1

 No contexto da programação orientada a objetos, explique o que é uma "interface"

 ## Resposta
 De uma maneira geral, interfaces ajudam a especificar métodos que as classes devem implementar. Elas não podem ser instanciadas e seus métodos não possuem corpo, sendo a classe que implementará a interface especificará as operações.

# Questao 2

O que são "traits" no PHP?

## Resposta

Traits são usados para declarar métodos que podem ser usados em múltiplas classes, independente de sua herança, são semelhantes a classes abstratas, visando a reutilização de código e resolvendo o problema de falta de herança múltipla.

# Questao 3

No código aparece o método "bindValue" do PDO para definir o valor que será utilizado na execução da instrução SQL. No PDO, também existe o método "bindParam". Qual(is) a(s) diferença(s) entre eles?

## Resposta

O método bindParam() precisa receber uma referência, ou seja, uma variável. Caso queremos informar um valor de maneira direta, ele não funcionará
	Já o método bindValue() para realizar a definição do valor de um parâmetro, esse método pode receber como argumento tanto uma referência como um valor direto.






