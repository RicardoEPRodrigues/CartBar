USE grouptest;

ALTER DATABASE grouptest CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS Produtos;

CREATE TABLE Produtos (
  categoria     VARCHAR(40) NOT NULL,
  nome          VARCHAR(80) NOT NULL UNIQUE,
  preco         REAL NOT NULL,
  descricao     VARCHAR(400),
  pathImg       VARCHAR(200),  -- path da imagem do produto
  PRIMARY KEY(categoria, nome)
);

CREATE TABLE Clientes (
  email         VARCHAR(120) NOT NULL UNIQUE,
  nome          VARCHAR(80) NOT NULL,
  pass          VARCHAR(80) NOT NULL,
  confirmado    BOOLEAN NOT NULL,
  confirmacao   VARCHAR(4) NOT NULL,
  PRIMARY KEY(email)
);

-- ALTER TABLE Produtos CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
