CREATE TABLE IF NOT EXISTS presences (
  rowid SERIAL PRIMARY KEY,
  matricula INT NOT NULL,
  timestamp TIMESTAMP NOT NULL,
  singularity FLOAT NOT NULL,
  state INT NOT NULL
);