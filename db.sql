
-- Tabla de Estudiantes
CREATE TABLE estudiantes (
                             id SERIAL PRIMARY KEY,
                             nombre varchar(100) NOT NULL,
                             correo varchar(150) UNIQUE NOT NULL,
                             nctrl varchar(100) UNIQUE NOT NULL,
                             created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                             updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Certificaciones
CREATE TABLE certificaciones (
                                 id SERIAL PRIMARY KEY,
                                 nombre varchar(100) NOT NULL,
                                 puntaje_total INT NOT NULL,
                                 created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                                 updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE resultados (
                            id_resultado SERIAL PRIMARY KEY,
                            resultado varchar(100)
);

-- Tabla intermedia de Estudiantes - Certificaciones
CREATE TABLE estudiantes_cert (
                                  id_estudiante INT NOT NULL,
                                  id_certificacion INT NOT NULL,
                                  estado_cert INT null DEFAULT 0,
                                  fecha_eval TIMESTAMP WITH TIME ZONE NULL,
                                  puntaje INT NULL,
                                  id_resultado int NULL,
                                  PRIMARY KEY (id_estudiante, id_certificacion),
                                  FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id) ON DELETE CASCADE,
                                  FOREIGN KEY (id_resultado) references resultados(id_resultado) ON DELETE CASCADE,
                                  FOREIGN KEY (id_certificacion) REFERENCES certificaciones(id) ON DELETE CASCADE
);
