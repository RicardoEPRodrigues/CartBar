CREATE TABLE Carrinho(
clienteID VARCHAR(120) NOT NULL UNIQUE,
produtosNome VARCHAR(80) NOT NULL UNIQUE,
produtosCategoria VARCHAR(40) NOT NULL,
produtosQTD INTEGER DEFAULT 0,
CONSTRAINT carrinhoKey PRIMARY KEY(clienteID, produtosNome, produtosCategoria),
CONSTRAINT clienteFK FOREIGN KEY(clienteID)
	REFERENCES Clientes(email) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT produtosFK FOREIGN KEY(produtosCategoria, produtosNome)
	REFERENCES Produtos(categoria, nome) ON DELETE CASCADE ON UPDATE CASCADE
	);