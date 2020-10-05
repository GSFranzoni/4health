DROP DATABASE IF EXISTS FORHEALTH;
CREATE DATABASE FORHEALTH;
USE FORHEALTH;
CREATE TABLE TIPO_USUARIO (
    id INT NOT NULL AUTO_INCREMENT,
    descricao VARCHAR(255) NOT NULL,
    CONSTRAINT pk PRIMARY KEY(id)
);
INSERT INTO TIPO_USUARIO (id, descricao) VALUES (1, 'ADMINISTRADOR');
INSERT INTO TIPO_USUARIO (id, descricao) VALUES (2, 'MÉDICO');
INSERT INTO TIPO_USUARIO (id, descricao) VALUES (3, 'PACIENTE');
CREATE TABLE USUARIO (
    id INT NOT NULL AUTO_INCREMENT,
    cpf VARCHAR(20) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    tipo_usuario INT NOT NULL,
    CONSTRAINT unique_cpf UNIQUE(cpf),
    CONSTRAINT pk_usr PRIMARY KEY(id),
    CONSTRAINT fk_usr_tipo FOREIGN KEY(tipo_usuario) REFERENCES TIPO_USUARIO(id)
);
INSERT INTO USUARIO (id, cpf, senha, ativo, tipo_usuario) VALUES (1, '140.526.066.12', '12345678', 1, 1);
INSERT INTO USUARIO (id, cpf, senha, ativo, tipo_usuario) VALUES (2, '281.701.480-49', '12345678', 1, 2);
INSERT INTO USUARIO (id, cpf, senha, ativo, tipo_usuario) VALUES (3, '841.243.640-75', '12345678', 1, 3);
CREATE TABLE PACIENTE (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    uf VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    logradouro VARCHAR(255) NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    numero_casa VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    usuario INT NOT NULL,
    CONSTRAINT unique_paciente_usuario UNIQUE(usuario),
    CONSTRAINT pk_pac PRIMARY KEY(id),
    CONSTRAINT fk_pac_usr FOREIGN KEY(usuario) REFERENCES USUARIO(id)
);
INSERT INTO PACIENTE (id, nome, uf, cidade, logradouro, bairro, numero_casa, telefone, usuario) VALUES(
    1, 'José', 'MG', 'Ubá', 'Rua Maria', 'Santana', '159', '6561561651', 3
);
CREATE TABLE MEDICO (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    crm VARCHAR(20) NOT NULL,
    especialidade VARCHAR(255) NOT NULL,
    usuario INT NOT NULL,
    CONSTRAINT unique_crm UNIQUE(crm),
    CONSTRAINT unique_medico_usuario UNIQUE(usuario),
    CONSTRAINT med_pk PRIMARY KEY(id),
    CONSTRAINT fk_med_usr FOREIGN KEY(usuario) REFERENCES USUARIO(id)
);
INSERT INTO MEDICO (id, nome, crm, especialidade, usuario) VALUES (1, 'Dr. Luis', '234524', 'Neurologista', 2);
CREATE TABLE ATENDIMENTO_SOLICITACAO (
	id INT NOT NULL AUTO_INCREMENT,
    paciente INT NOT NULL,
	medico INT NOT NULL,
    aceito BOOLEAN DEFAULT NULL,
    data_atendimento DATETIME NOT NULL,
    CONSTRAINT pk_ats PRIMARY KEY(id),
    CONSTRAINT fk_ats_pac FOREIGN KEY(paciente) REFERENCES PACIENTE(id),
    CONSTRAINT fk_ats_med FOREIGN KEY(medico) REFERENCES MEDICO(id)
);
INSERT INTO ATENDIMENTO_SOLICITACAO (paciente, medico, data_atendimento) VALUES (1, 1, '2020-10-06 20:00:00');
CREATE TABLE ATENDIMENTO (
	id INT NOT NULL AUTO_INCREMENT,
    atendimento_solicitacao INT NOT NULL,
    finalizado DATETIME DEFAULT NULL,
    CONSTRAINT pk_ate PRIMARY KEY(id),
    CONSTRAINT fk_ate_ats FOREIGN KEY(atendimento_solicitacao) REFERENCES ATENDIMENTO_SOLICITACAO(id)
);
CREATE TABLE EXAME (
	id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    resultado VARCHAR(800) NOT NULL,
    paciente INT NOT NULL,
    laudo VARCHAR(800),
    data DATETIME NOT NULL,
    CONSTRAINT pk_exa PRIMARY KEY(id),    
    CONSTRAINT fk_exa_pac FOREIGN KEY(paciente) REFERENCES PACIENTE(id)
);
INSERT INTO EXAME(nome, resultado, paciente, laudo, data) VALUES (
    'Exame de sangue', 'Exame de sangueExame de sangueExame de sangue', 1, 'O paciente tem aids', '2020-10-06 20:00:00'
);