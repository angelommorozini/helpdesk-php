CREATE TABLE IF NOT EXISTS chamados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT,
  status ENUM('aberto','em_andamento','fechado') NOT NULL DEFAULT 'aberto',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
